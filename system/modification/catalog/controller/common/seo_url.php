<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}
		
		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);

			// SEO URL Generator FREE . Begin
			$parts = array_filter($parts);
			
			$last_part = end($parts);
			// SEO URL Generator FREE . End
			// remove any empty arrays from trailing
			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}
			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}
					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}
					
					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id') {
						$this->request->get['route'] = $query->row['query'];
					}
					
				} else {
					// SEO URL Generator FREE . Begin
				$new_url = false;

				// Внимание!
				// Иногда пользователи вписывают окончание ЧПУ не в настройках SeoPro, а прямо в ЧПУ конкретного товара
				// В таком случае $parts и $last_part не содержит этого самого .html и поэтому не может ничего найти в редиректах
				// Поэтому нужно дополнительно проверять ЧПУ на наличие окончания .html

				$parts2 = explode('/', trim(utf8_strtolower($this->request->get['_route_']), '/'));

				$last_part2 = str_replace('.html', '', end($parts2));

				$a_parts = $parts;

				if ($last_part != $last_part2) {
					array_push($a_parts, $last_part2);
				}

				// Проверяем все части УРЛа, а не только крайнюю справа!
				$in = '';

				$i = 0;
				foreach ($a_parts as $item) {
					$in .= ($i) ? ', ' : '';
					$in .= '\'' . $this->db->escape($item) . '\'';
					$i++;
				}

				$sql = "SELECT * FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE seo_url_old IN ($in) ORDER BY seo_url_id DESC";

				$query = $this->db->query($sql);

				$keys_with_redirects = array();
				$essence_to_keys = array();
				$res = array();

				if ($query->rows) {
					foreach ($query->rows as $item) {
						$keys_with_redirects[] = mb_strtolower($item['seo_url_old']); // strtolower for SeoPro
						$essence_to_keys[mb_strtolower($item['seo_url_old'])] = $item['query']; // strtolower for SeoPro
					}
				}

				if ($last_part != $last_part2) {
					$last_part = $last_part2;
				}

				// strtolower for SeoPro
				if (in_array(mb_strtolower($last_part), $keys_with_redirects)) {
					// Последний алиас есть в базе редиректов
					$res = explode('=', $essence_to_keys[$last_part]);
				} else {
					// Последнего алиаса нет в базе редиректов, но редирект необходим из-за родительского элемента
					// SEO FREE найдет нужный УРЛ, главное узнать, какой сущности прикреплен данный алиас
					$sql = "SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($last_part) . "' ORDER BY url_alias_id DESC LIMIT 1";

					$query = $this->db->query($sql);

					if ($query->row) {
						$res = explode('=', $query->row['query']);
					}
				}

				// Определяем сущность текущей страницы
				if ($res) {
					if ('product_id' == $res[0]) {
						$new_url = $this->url->link('product/product', 'product_id=' . $res[1]);
					}

					if ('category_id' == $res[0]) {
						$new_url = $this->url->link('product/category', 'path=' . $res[1]);
					}

					if ('manufacturer_id' == $res[0]) {
						$new_url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $res[1]);
					}

					if ('information_id' == $res[0]) {
						$new_url = $this->url->link('information/information', 'information_id=' . $res[1]);
					}
				}

				if ($new_url) {
					$this->response->redirect($new_url, 301);
					exit;
				}
				// SEO URL Generator FREE . End

					$this->request->get['route'] = 'error/not_found';
					break;
				}
			}
			if (!isset($this->request->get['route'])) {
				if (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';
				} elseif (isset($this->request->get['path'])) {
					$this->request->get['route'] = 'product/category';
				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/manufacturer/info';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';
				}
			}
			if (isset($this->request->get['route'])) {
				return new Action($this->request->get['route']);
			}
			
		  // Redirect 301	
		} elseif (isset($this->request->get['route']) && $this->config->get('config_seo_url') && !isset($this->request->get['token'])) {
			$arg = '';
			if ($this->request->get['route'] == 'product/product' && isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product_id=' . $this->request->get['product_id'];
			} elseif ($this->request->get['route'] == 'product/category' && isset($this->request->get['path'])) {
				$categorys_id = explode('_', $this->request->get['path']);
				$category_id = (int)array_pop($categorys_id);
				$this->request->get['route'] = 'category_id=' . $category_id;
			} elseif ($this->request->get['route'] == 'product/manufacturer/info' && isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'manufacturer_id=' . $this->request->get['manufacturer_id'];
			} elseif ($this->request->get['route'] == 'information/information' && isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information_id=' . $this->request->get['information_id'];
			} elseif ($this->request->get['route'] == 'product/search') {
				$args = str_replace("route=product/search", "", $this->request->server['QUERY_STRING']);
				$arg = str_replace('&amp;', '&', $args);
			} elseif ($this->request->get['route'] == 'common/home') {
				$arg = HTTP_SERVER;
			} 

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($this->request->get['route']) . "'");
			
			if ($query->num_rows) {
				$this->response->redirect($query->row['keyword'] . $arg, 301);
			}
		}
	}
	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));
		$url = '';
		$data = array();
		parse_str($url_info['query'], $data);
		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						unset($data[$key]);
					}
				} elseif ($key == 'path') {
					$categories = explode('_', $value);
					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';
							break;
						}
					}
					unset($data[$key]);
				} else  {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($data['route']) . "'");
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						unset($data[$key]);
					}
				}
			}
		}
		if ($url) {
			unset($data['route']);
			$query = '';
			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((string)$value);
				}
				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}
			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}
}