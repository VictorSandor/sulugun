<?php
class ModelCatalogInformation extends Model {
	public function addInformation($data) {
		$this->event->trigger('pre.admin.information.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "information SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "'");

		$information_id = $this->db->getLastId();

		foreach ($data['information_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['information_store'])) {
			foreach ($data['information_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_store SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['information_layout'])) {
			foreach ($data['information_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_layout SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		// SEO URL Generator . begin
		// information_id not exist in controller when add() information
		
		$this->load->model('module/seo_url_generator');
		
		if(empty($data['keyword']) && false !== strpos($this->config->get('seo_url_generator_information_formula'), '[information_id]')) {
			$sug_data = array(
				'name'       => $data['information_description'][$this->config->get('seo_url_generator_language')]['title'],
				'essence'    => 'information',
				'essence_id' => $information_id,
			);

			$data['keyword'] = $this->load->controller('module/seo_url_generator/generateSeoUrl', $sug_data);
			
			$this->cache->delete('seo_pro');
		}
		// SEO URL Generator . end

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$information_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('information');

		$this->event->trigger('post.admin.information.add', $information_id);

		return $information_id;
	}

	public function editInformation($information_id, $data) {
		$this->event->trigger('pre.admin.information.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "information SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "' WHERE information_id = '" . (int)$information_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");

		foreach ($data['information_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['information_store'])) {
			foreach ($data['information_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_store SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['information_layout'])) {
			foreach ($data['information_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_layout SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
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
		
		$sug_log->write(2, 'model/information.php :: editInformation() is called');
		
		$this->load->model('module/seo_url_generator');
		
		$sug_set_backend_autoredirects = false;
		$keyword_new = false;
		
		if (isset($data['seo_url_generator_front_works'])) {
			$sug_front_ok = true;
			$sug_log->write(4, 'ISSET', 'model/information.php :: editInformation() : $data["seo_url_generator_front_works"]');
		} else {
			$sug_front_ok = false;
			$sug_log->write(4, 'NULL', 'model/information.php :: editInformation() : $data["seo_url_generator_front_works"]');
		}
		
		$data['keyword'] = trim($data['keyword']);	
		
		$sug_log->write(2, $data['keyword'], 'model/information.php :: editInformation() : form $data["keyword"]');
		
		$sug_data = array(
			'name'        => $data['information_description'][$this->config->get('seo_url_generator_language')]['title'],
			'primary_key' => 'information_id',
			'essence'     => 'information',
			'essence_id'  => $this->request->get['information_id'],
		);
		
		$sug_log->write(4, $sug_data, 'model/information.php :: editInformation() : $sug_data');
		
		$keyword_old = $this->model_module_seo_url_generator->getURL($sug_data['primary_key'], $sug_data['essence_id']);

		$sug_log->write(4, $keyword_old, 'model/information.php :: editInformation() : $keyword_old');

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
			$sug_log->write(4, 'model/information.php :: editInformation() : Actualization by delimeter BEGIN');
			
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
		$sug_log->write(4, 'model/information.php :: editInformation() : sug_redirects BEGIN');
		
		$sug_log->write(4, $sug_set_backend_autoredirects, 'model/information.php :: editInformation() : $sug_set_backend_autoredirects');
		
		$sug_log->write(4, $keyword_new, 'model/information.php :: editInformation() : $keyword_new');
			
		// Удаляем все существующие редиректы из базы для данной сущности - на фронте предупреждение было выдано, чтобы не убирали из формы
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'information_id=" . (int)$information_id . "'");
		
		// Обрабатываем редиректы из формы - все управление редриректами у пользователя на фронте!
		if (isset($data['seo_url_generator_redirects']) && $data['keyword']) {
			$sug_log->write(4, $data['seo_url_generator_redirects'], 'model/information.php :: editInformation() : $data["seo_url_generator_redirects"]');
		
			$data['seo_url_generator_redirects'] = array_unique($data['seo_url_generator_redirects']); // на всякий случай...
			
			foreach ($data['seo_url_generator_redirects'] as $redirect) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url_generator_redirects SET seo_url_old = '" . $this->db->escape($redirect) . "', seo_url_actual = '" . $this->db->escape($data['keyword']) . "', query = 'information_id=" . (int)$information_id . "'");
				}
			}
			
		if ($sug_set_backend_autoredirects) {
			$sug_log->write(3, 'model/information.php :: editInformation() : Autoredirect was created on backend');
				
			// setRedirect() кроме того, что просто записывет текущий редирект, также обновляет новый ЧПУ для всех старый редиректов
			$this->model_module_seo_url_generator->setRedirect($keyword_new, $keyword_old, $sug_data['primary_key'], $sug_data['essence_id']);
			$this->cache->delete('seo_pro');
			}
		// SEO URL Generator . end

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$information_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('information');

		$this->event->trigger('post.admin.information.edit', $information_id);
	}

	public function deleteInformation($information_id) {
		$this->event->trigger('pre.admin.information.delete', $information_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "information WHERE information_id = '" . (int)$information_id . "'");
		// SEO URL Generator . begin
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'information_id=" . (int)$information_id . "'");
		// SEO URL Generator . end
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information_id . "'");

		$this->cache->delete('information');

		$this->event->trigger('post.admin.information.delete', $information_id);
	}

	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information_id . "') AS keyword FROM " . DB_PREFIX . "information WHERE information_id = '" . (int)$information_id . "'");

		return $query->row;
	}

	public function getInformations($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'id.title',
				'i.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id.title";
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
		} else {
			$information_data = $this->cache->get('information.' . (int)$this->config->get('config_language_id'));

			if (!$information_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$information_data = $query->rows;

				$this->cache->set('information.' . (int)$this->config->get('config_language_id'), $information_data);
			}

			return $information_data;
		}
	}

	public function getInformationDescriptions($information_id) {
		$information_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $information_description_data;
	}

	public function getInformationStores($information_id) {
		$information_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_store_data[] = $result['store_id'];
		}

		return $information_store_data;
	}

	public function getInformationLayouts($information_id) {
		$information_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $information_layout_data;
	}

	public function getTotalInformations() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information");

		return $query->row['total'];
	}

	public function getTotalInformationsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}