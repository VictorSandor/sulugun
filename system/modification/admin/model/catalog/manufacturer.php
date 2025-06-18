<?php
class ModelCatalogManufacturer extends Model {
	public function addManufacturer($data) {
		$this->event->trigger('pre.admin.manufacturer.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$manufacturer_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// SEO URL Generator . begin
		// manufacturer_id not exist in controller when add() manufacturer
		
		$this->load->model('module/seo_url_generator');
		
		if(empty($data['keyword']) && false !== strpos($this->config->get('seo_url_generator_manufacturer_formula'), '[manufacturer_id]')) {
			$sug_data = array(
				'name'       => $data['name'],
				'essence'    => 'manufacturer',
				'essence_id' => $manufacturer_id,
			);

			$data['keyword'] = $this->load->controller('module/seo_url_generator/generateSeoUrl', $sug_data);
			
			$this->cache->delete('seo_pro');
		}
		// SEO URL Generator . end

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('manufacturer');

		$this->event->trigger('post.admin.manufacturer.add', $manufacturer_id);

		return $manufacturer_id;
	}

	public function editManufacturer($manufacturer_id, $data) {
		$this->event->trigger('pre.admin.manufacturer.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// SEO URL Generator . begin
		// Создание автоматических редиректов
		
		// В случае редактирования из админки мы имеем сразу 3 ЧПУ
		// 1 - $keyword_old - тот, который есть в базе на момент до редактирования - именно для него нужен редирект (!)
		// 2 - $data['keyword'] - тот, который введен в форму - он может совпадать с $keyword_old, быть введенным вручную или вообще отсутствовать
		// 3 - $keyword_new - тот, который генерируется автоматически, в случае, когда это необходимо
				
		$sug_log = new StdeLog('seo_url_generator');
		$sug_log->setDebug($this->config->get('seo_url_generator_debug'));
		
		$sug_log->write(2, 'model/manufacturer.php :: editManufacturer() is called');
		
		$this->load->model('module/seo_url_generator');
		
		$sug_set_backend_autoredirects = false;
		$keyword_new = false;
		
		if (isset($data['seo_url_generator_front_works'])) {
			$sug_front_ok = true;
			$sug_log->write(4, 'ISSET', 'model/category.php :: editManufacturer() : $data["seo_url_generator_front_works"]');
		} else {
			$sug_front_ok = false;
			$sug_log->write(4, 'NULL', 'model/category.php :: editManufacturer() : $data["seo_url_generator_front_works"]');
		}
		
		$data['keyword'] = trim($data['keyword']);	
		
		$sug_log->write(2, $data['keyword'], 'model/manufacturer.php :: editManufacturer() : form $data["keyword"]');
		
		$sug_data = array(
			'name'        => $data['name'],
			'primary_key' => 'manufacturer_id',
			'essence'     => 'manufacturer',
			'essence_id'  => $this->request->get['manufacturer_id'],
		);
		
		$sug_log->write(4, $sug_data, 'model/manufacturer.php :: editManufacturer() : $sug_data');
		
		$keyword_old = $this->model_module_seo_url_generator->getURL($sug_data['primary_key'], $sug_data['essence_id']);

		$sug_log->write(4, $keyword_old, 'model/manufacturer.php :: editManufacturer() : $keyword_old');

		if (!$keyword_old && !$data['keyword']) {
			// Все понятно: старого ЧПУ нет, просто генерим новый. Редиректы не нужны.
			$data['keyword'] = $this->load->controller('module/seo_url_generator/generateSeoUrl', $sug_data);
			$this->cache->delete('seo_pro');
			goto sug_edit_end;
		}

		if (!$keyword_old && $data['keyword']) {
			// Снова все понятно: старого ЧПУ в базе нет, соглашаемся с ЧПУ из формы
			
			// Q?
			// А транлитировать этот ЧПУ надо или нет?..
			
			$this->cache->delete('seo_pro');
			goto sug_edit_end;
		}

		if ($keyword_old && !$data['keyword']) {
			// Просто используем существующий ЧПУ из базы
			$data['keyword'] = $keyword_old;
		}
		
		if ($keyword_old && $data['keyword'] && $keyword_old != $data['keyword']) {
			// Запускаем механизм редиректов, только если на фронте не работает
			if (!$sug_front_ok) {
				$sug_set_backend_autoredirects = true;
			}
			
			$keyword_new = $data['keyword'];
			
			// Q?
			// А транлитировать этот ЧПУ надо или нет?..
			
			// Минуем актуализацию, итак понятно, что $keyword_old != $data['keyword']
			goto sug_edit_end;
		}
		
    if ($keyword_old && $data['keyword'] && $keyword_old == $data['keyword'] && $this->config->get('seo_url_generator_rewrite_on_save')) {
			// Актуализация по данным сущности - название, другая формула
			// ставить ли редирект, будет понятно лишь после сравнения старого и нового ЧПУ
			
			$keyword_new = $this->load->controller('module/seo_url_generator/generateSeoUrl', $sug_data);
		}
		
		// Make unique
		if ($keyword_new && !$this->model_module_seo_url_generator->isUnique($keyword_new, $sug_data['primary_key'], $sug_data['essence_id'])) {
			$keyword_new = $this->model_module_seo_url_generator->makeUniqueUrl($keyword_new);
		}

		// Актуализация по разделителю
		if ($this->config->get('seo_url_generator_rewrite_on_save')) {
			$sug_log->write(4, 'model/manufacturer.php :: editManufacturer() : Actualization by delimeter BEGIN');
			
			if ('donot' != $this->config->get('seo_url_generator_change_delimiter_char')) {
				// Compare without delimiters
				$keyword_old_without_delimiters = preg_replace(array('|_+|', '|-+|'), array('', ''), $keyword_old);
				$keyword_new_without_delimiters = preg_replace(array('|_+|', '|-+|'), array('', ''), $keyword_new);

				$sug_log->write(3, $keyword_old_without_delimiters, 'generateSeoUrl() : $keyword_old_without_delimiters');
				$sug_log->write(3, $keyword_new_without_delimiters, 'generateSeoUrl() : $keyword_new_without_delimiters');

				if ($keyword_old_without_delimiters != $keyword_new_without_delimiters) {
					$sug_set_backend_autoredirects = true;
					$data['keyword'] = $keyword_new;
				}
			} else {
				// Compare with delimiters
				if ($keyword_old != $keyword_new) {
					$sug_set_backend_autoredirects = true;
					$data['keyword'] = $keyword_new;
				}
			}		
		}
		
		// Write Redirect
		sug_edit_end:
		$sug_log->write(4, 'model/manufacturer.php :: editManufacturer() : sug_redirects BEGIN');
		
		$sug_log->write(4, $sug_set_backend_autoredirects, 'model/manufacturer.php :: editManufacturer() : $sug_set_backend_autoredirects');
		
		$sug_log->write(4, $keyword_new, 'model/manufacturer.php :: editManufacturer() : $keyword_new');
		
		// Удаляем все существующие редиректы из базы для данной сущности - на фронте предупреждение было выдано, чтобы не убирали из формы
			$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "'");
		
		// Обрабатываем редиректы из формы - все управление редриректами у пользователя на фронте!
		if (isset($data['seo_url_generator_redirects']) && $data['keyword']) {
			$sug_log->write(4, $data['seo_url_generator_redirects'], 'model/manufacturer.php :: editManufacturer() : $data["seo_url_generator_redirects"]');
			
			$data['seo_url_generator_redirects'] = array_unique($data['seo_url_generator_redirects']); // на всякий случай...
		
			foreach ($data['seo_url_generator_redirects'] as $redirect) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url_generator_redirects SET seo_url_old = '" . $this->db->escape($redirect) . "', seo_url_actual = '" . $this->db->escape($data['keyword']) . "', query = 'manufacturer_id=" . (int)$manufacturer_id . "'");
			}
		}
		
		if ($sug_set_backend_autoredirects) {
			$sug_log->write(3, 'model/manufacturer.php :: editManufacturer() : Autoredirect was created on backend');

			// setRedirect() кроме того, что просто записывет текущий редирект, также обновляет новый ЧПУ для всех старый редиректов
			$this->model_module_seo_url_generator->setRedirect($keyword_new, $keyword_old, $sug_data['primary_key'], $sug_data['essence_id']);
			$this->cache->delete('seo_pro');
		}
		// SEO URL Generator . end

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('manufacturer');

		$this->event->trigger('post.admin.manufacturer.edit');
	}

	public function deleteManufacturer($manufacturer_id) {
		$this->event->trigger('pre.admin.manufacturer.delete', $manufacturer_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		// SEO URL Generator . begin
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "'");
		// SEO URL Generator . end
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "'");

		$this->cache->delete('manufacturer');

		$this->event->trigger('post.admin.manufacturer.delete', $manufacturer_id);
	}

	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "') AS keyword FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row;
	}

	public function getManufacturers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getManufacturerStores($manufacturer_id) {
		$manufacturer_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		foreach ($query->rows as $result) {
			$manufacturer_store_data[] = $result['store_id'];
		}

		return $manufacturer_store_data;
	}

	public function getTotalManufacturers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturer");

		return $query->row['total'];
	}
}