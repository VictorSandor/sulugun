<?php
class ModelCatalogCategory extends Model {
	public function addCategory($data) {
		$this->event->trigger('pre.admin.category.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this category
		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.add', $category_id);

		return $category_id;
	}

	public function editCategory($category_id, $data) {
		$this->event->trigger('pre.admin.category.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE path_id = '" . (int)$category_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
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
		
		$sug_log->write(2, 'model/category.php :: editCategory() is called');
		
		$this->load->model('module/seo_url_generator');
		
		$sug_set_backend_autoredirects = false;
		$keyword_new = false;
		
		if (isset($data['seo_url_generator_front_works'])) {
			$sug_front_ok = true;
			$sug_log->write(4, 'ISSET', 'model/category.php :: editCategory() : $data["seo_url_generator_front_works"]');
		} else {
			$sug_front_ok = false;
			$sug_log->write(4, 'NULL', 'model/category.php :: editCategory() : $data["seo_url_generator_front_works"]');
		}
		
		$data['keyword'] = trim($data['keyword']);	
		
		$sug_log->write(2, $data['keyword'], 'model/category.php :: editCategory() : form $data["keyword"]');
		
		$sug_data = array(
			'name'        => $data['category_description'][$this->config->get('seo_url_generator_language')]['name'],
			'primary_key' => 'category_id',
			'essence'     => 'category',
			'essence_id'  => $this->request->get['category_id'],
		);
		
		$sug_log->write(4, $sug_data, 'model/category.php :: editCategory() : $sug_data');
		
		$keyword_old = $this->model_module_seo_url_generator->getURL($sug_data['primary_key'], $sug_data['essence_id']);

		$sug_log->write(4, $keyword_old, 'model/category.php :: editCategory() : $keyword_old');

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
			$sug_log->write(4, 'model/category.php :: editCategory() : Actualization by delimeter BEGIN');
			
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
		$sug_log->write(4, 'model/category.php :: editCategory() : sug_redirects BEGIN');
		
		$sug_log->write(4, $sug_set_backend_autoredirects, 'model/category.php :: editCategory() : $sug_set_backend_autoredirects');
		
		$sug_log->write(4, $keyword_new, 'model/category.php :: editCategory() : $keyword_new');
			
		// Удаляем все существующие редиректы из базы для данной сущности - на фронте предупреждение было выдано, чтобы не убирали из формы
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'category_id=" . (int)$category_id . "'");
		
		// Обрабатываем редиректы из формы - все управление редриректами у пользователя на фронте!
		if (isset($data['seo_url_generator_redirects']) && $data['keyword']) {
			$sug_log->write(4, $data['seo_url_generator_redirects'], 'model/category.php :: editCategory() : $data["seo_url_generator_redirects"]');
		
			$data['seo_url_generator_redirects'] = array_unique($data['seo_url_generator_redirects']); // на всякий случай...
			
			foreach ($data['seo_url_generator_redirects'] as $redirect) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url_generator_redirects SET seo_url_old = '" . $this->db->escape($redirect) . "', seo_url_actual = '" . $this->db->escape($data['keyword']) . "', query = 'category_id=" . (int)$category_id . "'");
				}
			}
			
		if ($sug_set_backend_autoredirects) {
			$sug_log->write(3, 'model/category.php :: editCategory() : Autoredirect was created on backend');
				
			// setRedirect() кроме того, что просто записывет текущий редирект, также обновляет новый ЧПУ для всех старый редиректов
			$this->model_module_seo_url_generator->setRedirect($keyword_new, $keyword_old, $sug_data['primary_key'], $sug_data['essence_id']);
			$this->cache->delete('seo_pro');
			}
		// SEO URL Generator . end

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.edit', $category_id);
	}

	public function deleteCategory($category_id) {
		$this->event->trigger('pre.admin.category.delete', $category_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		// SEO URL Generator . begin
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'category_id=" . (int)$category_id . "'");
		// SEO URL Generator . end
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.delete', $category_id);
	}

	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category['category_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$category['category_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($category['category_id']);
		}
	}

	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "') AS keyword FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCategories($data = array()) {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.category_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $category_description_data;
	}

	public function getCategoryFilters($category_id) {
		$category_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_filter_data[] = $result['filter_id'];
		}

		return $category_filter_data;
	}

	public function getCategoryStores($category_id) {
		$category_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}

		return $category_store_data;
	}

	public function getCategoryLayouts($category_id) {
		$category_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $category_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");

		return $query->row['total'];
	}
	
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
