<?php

/**
 * @category   OpenCart
 * @package    SEO URL Generator FREE
 * @copyright  © Serge Tkach, 2017–2023, http://sergetkach.com/
 */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class ControllerModuleSeoURLGenerator extends Controller {
	private $code = 'seo_url_generator';
	private $errors = array();
	private $stde;
	private $stdelog;

	function __construct($registry) {
		parent::__construct($registry);

    // StdE Require
		// $this->load->library('stde'); autoload
		$this->stde = new StdE($registry);
		$this->registry->set('stde', $this->stde);
		$this->stde->setCode($this->code);
		$this->stde->setType('extension_monolithic');

    // StdeLog require
		$this->stdelog = new StdeLog($this->code);		
		$this->registry->set('stdelog', $this->stdelog);
		$this->stdelog->setDebug($this->config->get($this->code . '_debug'));
	}

	public function install() {
		// -----------------------------------------------------------
		// Права на модуль
		// -----------------------------------------------------------
		
		$this->load->model('user/user_group');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'module/' . $this->code);
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'module/' . $this->code);

		
		// -----------------------------------------------------------
		// Создание страницы для хранение редиректов
		// -----------------------------------------------------------		
		
		$sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "seo_url_generator_redirects` (
			`seo_url_id` int(11) NOT NULL AUTO_INCREMENT,
      `seo_url_old` varchar(255) NOT NULL,
      `seo_url_actual` varchar(255) NOT NULL,
      `query` varchar(100) NOT NULL,
      PRIMARY KEY (`seo_url_id`),
      KEY `seo_url_old` (`seo_url_old`),
      KEY `seo_url_actual` (`seo_url_actual`),
      KEY `query` (`query`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

		$this->db->query($sql);
		
		// -----------------------------------------------------------
		// Боремся с index.php?route=common/home
		// -----------------------------------------------------------
		$sql = "SELECT `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'common/home'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows < 1) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'common/home', `keyword` = ''");
		}

		if ($query->num_rows > 1) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'common/home'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'common/home', `keyword` = ''");
		}
		
		// -----------------------------------------------------------
		// Автоматическое включение ЧПУ при наличии такой возможности
		// -----------------------------------------------------------
		// Автоматически включим человеку SEO URL :)
		$config_seo_url = $this->config->get('config_seo_url');

		if (!$config_seo_url) {
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = '1' WHERE `key` = 'config_seo_url'");
		}

		// Включаем SEO FREE, если такой присутствует
		$sql = "SELECT `value` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_seo_url_type'";
		$query = $this->db->query($sql);

		if ($query->num_rows > 0) {
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = 'seo_pro' WHERE `key` = 'config_seo_url_type'");
		}

		// Автоматически включим .htaccess, если есть права доступа к корню сайта
		$root_dir = str_replace('system/', '', DIR_SYSTEM);

		if (!is_file($root_dir . '.htaccess')) {
			if (is_file($root_dir . 'htaccess.txt')) {
				// ocStore
				@rename($root_dir . 'htaccess.txt', $root_dir . '.htaccess');
			} elseif (is_file($root_dir . '.htaccess.txt')) {
				// OpenCart.PRO & OpenCart pure
				@rename($root_dir . '.htaccess.txt', $root_dir . '.htaccess');
			} else {
				// if file wasn't uploaded on hosting
				if (is_file(DIR_SYSTEM . 'library/seo_url_generator/dist/.htaccess')) {
					$content = file_get_contents(DIR_SYSTEM . 'library/seo_url_generator/dist/.htaccess');
					@file_put_contents($root_dir . '.htaccess', $content, FILE_APPEND | LOCK_EX);
				}
			}
		}
	}

	public function uninstall() {
		$this->load->model('user/user_group');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'module/' . $this->code);
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'module/' . $this->code);

		// Вроде как все чистится автоматом при деинсталляции
		// $this->load->model('setting/setting');
		// $this->model_setting_setting->editSetting($this->code, '');
	}




	/*
	------------------------------------------------------------------------------
	PARTS
	------------------------------------------------------------------------------
	*/

	/* Part Settings */
	public function index() {
		$this->load->language('module/' . $this->code);
		$this->load->model('module/' . $this->code);
		$this->load->model('setting/setting');

		// Save
		$data['text_success'] = '';

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateSettings()) {
			$data['text_success'] = $this->language->get('text_success'); // no redirects if success
//			var_dump($this->request->post);

			// I don't want write extension_code in each field in controller & view too
			// $this->model_setting_setting->editSetting($this->code, $this->request->post);
			
			// Magic for extension code in fields . Begin
			$pseudo_post = array();			
			
			foreach ($this->request->post as $key=> $value) {
				if (false === strpos($key, $this->code . '_')) {
					$pseudo_post[$this->code . '_' . $key] = $value;
				} else {
					$pseudo_post[$key] = $value; // no sense but...
				}
			}

			$this->model_setting_setting->editSetting($this->code, $pseudo_post);
			// Magic for extension code in fields . End
		}

		// Errors
		if (isset($this->errors)) {
			$data['errors'] = $this->errors;
		}

		// Breadcrumbps & Links
		$data['breadcrumbs'] = $this->stde->breadcrumbs();

		$data['action'] = $this->stde->link('action');
		$data['cancel'] = $this->stde->link('cancel');

		$data['link_part_settings'] = $this->stde->link('index'); // A!
		$data['link_part_info'] = $this->stde->link('part_info');

		// Text
		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_author'] = $this->language->get('text_author');
		$data['text_author_support'] = $this->language->get('text_author_support');

		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['text_part_settings'] = $this->language->get('text_part_settings');
		$data['text_part_info'] = $this->language->get('text_part_info');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_available_vars'] = $this->language->get('text_available_vars');
		$data['help_vars'] = $this->language->get('help_vars');
		$data['or'] = $this->language->get('or');

		$data['fieldset_base'] = $this->language->get('fieldset_base');
		$data['entry_licence'] = $this->language->get('entry_licence');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_system'] = $this->language->get('entry_system');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['help_limit'] = $this->language->get('help_limit');
		$data['entry_debug'] = $this->language->get('entry_debug');
		$data['help_debug'] = $this->language->get('help_debug');

		$data['fieldset_translit'] = $this->language->get('fieldset_translit');
		$data['entry_language_id'] = $this->language->get('entry_language_id');
		$data['entry_translit_function'] = $this->language->get('entry_translit_function');
		$data['entry_delimiter_char'] = $this->language->get('entry_delimiter_char');
		$data['help_delimiter_char'] = $this->language->get('help_delimiter_char');
		$data['entry_change_delimiter_char'] = $this->language->get('entry_change_delimiter_char');
		$data['help_change_delimiter_char'] = $this->language->get('help_change_delimiter_char');
		$data['entry_rewrite_on_save'] = $this->language->get('entry_rewrite_on_save');
		$data['help_rewrite_on_save'] = $this->language->get('help_rewrite_on_save');
		$data['title_custom_replace'] = $this->language->get('title_custom_replace');
		$data['help_custom_replace'] = $this->language->get('help_custom_replace');
		$data['entry_custom_replace_from'] = $this->language->get('entry_custom_replace_from');
		$data['entry_custom_replace_to'] = $this->language->get('entry_custom_replace_to');

		$data['fieldset_formulas'] = $this->language->get('fieldset_formulas');
		$data['entry_category_formula'] = $this->language->get('entry_category_formula');
		$data['entry_product_formula'] = $this->language->get('entry_product_formula');
		$data['entry_manufacturer_formula'] = $this->language->get('entry_manufacturer_formula');
		$data['entry_information_formula'] = $this->language->get('entry_information_formula');

		$data['button_save_settings'] = $this->language->get('button_save_settings');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save_licence'] = $this->language->get('button_save_licence');

		$data['error_ajax_response'] = $this->language->get('error_ajax_response');

		// Data
		$data['token'] = $this->session->data['token']; // token need in js ajax

		$data['status'] = $this->stde->field('status');

		$data['debug_levels'] = array(
			0=>$this->language->get('debug_0'),
			1=>$this->language->get('debug_1'),
			2=>$this->language->get('debug_2'),
			3=>$this->language->get('debug_3'),
			4=>$this->language->get('debug_4')
		);

		$data['debug'] = $this->stde->field('debug');

		$data['systems'] = array(
			'OpenCart',
			'ocStore',
			'OpenCart.PRO'
		);

		$data['system'] = $this->stde->field('system');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['config_language_code'] = $this->config->get('config_language');

		$data['language'] = $this->stde->field('language');

		$data['translit_functions'] = $this->model_module_seo_url_generator->getFunctionsList();

		$data['translit_function'] = $this->stde->field('translit_function');

		$data['delimiter_chars'] = array(
			'hyphen'=>$this->language->get('char_hyphen'),
			'underscore'=>$this->language->get('char_underscore')
		);
		
		$data['delimiter_char'] = $this->stde->field('delimiter_char');

		$data['change_delimiter_chars'] = array(
			'donot'=>$this->language->get('change_donot'),
			'underscore_to_hyphen'=>$this->language->get('change_underscore_to_hyphen'),
			'hyphen_to_underscore'=>$this->language->get('change_hyphen_to_underscore')
		);

		$data['change_delimiter_char'] = $this->stde->field('change_delimiter_char', 'donot');
		
		$data['rewrite_on_save'] = $this->stde->field('rewrite_on_save');
		
		$data['custom_replace_from'] = $this->stde->field('custom_replace_from', '');		
		$data['custom_replace_from'] = str_replace(array("\r\n", "\n"), '<br>', $data['custom_replace_from']);
		
//		echo "-----------------------<br>\r\n";
//		echo "\$data['custom_replace_from'] for view<br>\r\n";
//		echo '<pre>';
//		var_dump($data['custom_replace_from']);
//		echo '</pre>';
//		echo "-----------------------<br><br>\r\n\r\n";
		
		$data['custom_replace_from_array'] = explode('<br>', $data['custom_replace_from']);
		
//		echo "-----------------------<br>\r\n";
//		echo "\$data['custom_replace_from_array'] for view<br>\r\n";
//		echo '<pre>';
//		var_dump($data['custom_replace_from_array']);
//		echo '</pre>';
//		echo "-----------------------<br><br>\r\n\r\n";
		
		$data['custom_replace_to'] = $this->stde->field('custom_replace_to', '');
		$data['custom_replace_to'] = str_replace(array("\r\n", "\n"), '<br>', $data['custom_replace_to']);
		
//		echo "-----------------------<br>\r\n";
//		echo "\$data['custom_replace_to'] for view<br>\r\n";
//		echo '<pre>';
//		var_dump($data['custom_replace_to']);
//		echo '</pre>';
//		echo "-----------------------<br><br>\r\n\r\n";
		
		$data['custom_replace_to_array'] = explode('<br>', $data['custom_replace_to']);
		
//		echo "-----------------------<br>\r\n";
//		echo "\$data['custom_replace_to_array'] for view<br>\r\n";
//		echo '<pre>';
//		var_dump($data['custom_replace_to_array']);
//		echo '</pre>';
//		echo "-----------------------<br><br>\r\n\r\n";
		
		// Formulas
		$data['category_formula'] = $this->stde->field('category_formula', '[category_name]');
		$data['product_formula'] = $this->stde->field('product_formula', '[product_name]');
		$data['manufacturer_formula'] = $this->stde->field('manufacturer_formula', '[manufacturer_name]');
		$data['information_formula'] = $this->stde->field('information_formula', '[information_title]');

		// Common
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		// Output
		$this->response->setOutput($this->stde->view('module/' . $this->code, $data));
	}
	
	
	/* Part Info */
	public function part_info() {
		$this->load->language('module/' . $this->code);
		
		// Breadcrumbps & Links
		$data['breadcrumbs'] = $this->stde->breadcrumbs();

		$data['action'] = $this->stde->link('action');
		$data['cancel'] = $this->stde->link('cancel');
		
		$data['link_part_settings'] = $this->stde->link('index'); // A!
		$data['link_part_info'] = $this->stde->link('part_info');

		// Text
		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_author'] = $this->language->get('text_author');
		$data['text_author_support'] = $this->language->get('text_author_support');
		
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['text_part_settings'] = $this->language->get('text_part_settings');
		$data['text_part_info'] = $this->language->get('text_part_info');
		$data['text_about_title'] = $this->language->get('text_about_title');
		$data['text_about'] = $this->language->get('text_about');
		$data['text_about_pro_title'] = $this->language->get('text_about_pro_title');
		$data['text_about_pro'] = $this->language->get('text_about_pro');
		
		// Common
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		// Output
		$this->response->setOutput($this->stde->view('module/' . $this->code, $data));
		
		return false;
	}
	

	/*
	 * Validate Settings
	 *
	 * A!
	 * Not need follow extension_code in post-fields thanks StdE Library & Magic :)
	 */
	protected function validateSettings() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->code)) {
			$this->errors['warning'] = $this->language->get('error_permission');
		}

		// A! Fields of $this->request->post is without extension prefix if follow StdE Library (!)
		
		// Custom Replace
		$custom_replace_from_array = array();
		if ($this->request->post['custom_replace_from']) {
			$this->request->post['custom_replace_from'] = str_replace(array("\r\n", "\n"), '<br>', $this->request->post['custom_replace_from']);
			
			$custom_replace_from_array = explode('<br>', $this->request->post['custom_replace_from']);
			
			// Remove empty values from $this->request->post['custom_replace_from_array']
			foreach ($custom_replace_from_array as $key => $value) {
				$value0 = trim($value);
				if (!$value0) {
					unset($custom_replace_from_array[$key]);
				}
			}
			
//			echo "-----------------------<br>\r\n";
//			echo "\$this->request->post['custom_replace_from'] 1<br>\r\n";
//			echo '<pre>';
//			var_dump($this->request->post['custom_replace_from']);
//			echo '</pre>';
//			echo "-----------------------<br><br>\r\n\r\n";
			
			$this->request->post['custom_replace_from'] = implode("\r\n", $custom_replace_from_array);
			
//			echo "-----------------------<br>\r\n";
//			echo "\$this->request->post['custom_replace_from'] 2<br>\r\n";
//			echo '<pre>';
//			var_dump($this->request->post['custom_replace_from']);
//			echo '</pre>';
//			echo "-----------------------<br><br>\r\n\r\n";
		}
		
		$custom_replace_to_array = array();
		if ($this->request->post['custom_replace_to']) {
			$this->request->post['custom_replace_to'] = str_replace(array("\r\n", "\n"), '<br>', $this->request->post['custom_replace_to']);
			
			$custom_replace_to_array = explode('<br>', $this->request->post['custom_replace_to']);
			
			// Remove empty values from $this->request->post['custom_replace_to']
			foreach ($custom_replace_to_array as $key => $value) {
				$value0 = trim($value);
//				if (!$value0) {
//					unset($custom_replace_to_array[$key]);
//				}
			}
			
			$this->request->post['custom_replace_to'] = implode("\r\n", $custom_replace_to_array);
		}
		
		if (count($custom_replace_from_array) > 0) {
//			echo "\$custom_replace_from_array > 0<br>";			
//			var_dump($custom_replace_from_array);
//			var_dump($custom_replace_to_array);
			
			// If no values at the right column
			if (count($custom_replace_to_array) < 1) {
				$this->request->post['custom_replace_to'] = 'underscore' == $this->request->post['delimiter_char'] ? '_' : '-';
			}
			
			// Corelation between chars from the left and from the right
			if (count($custom_replace_from_array) != count($custom_replace_to_array) & count($custom_replace_to_array) > 1) {
				$this->errors['custom_replace_to'] = $this->language->get('error_custom_replace_to_not_1_char');
			}			
		}

		// Category Formula
		$this->request->post['category_formula'] = trim($this->request->post['category_formula']);

		if (empty($this->request->post['category_formula'])) {
			$this->errors['category_formula'] = $this->language->get('error_formula_empty');
		} else {
			// need be at least 1 variable
			if (false === strstr($this->request->post['category_formula'], '[category_name]') && false === strstr($this->request->post['category_formula'], '[category_id]')) {
				$this->errors['category_formula'] = $this->language->get('error_formula_less_vars');
			} else {
				$str_without_vars = str_replace(array(
					'[category_name]',
					'[category_id]'
					), array(
					'',
					''
					), $this->request->post['category_formula']);

				if (!empty($str_without_vars)) {
					if (!preg_match("/[a-bA-Z\-_]+/", $str_without_vars)) {
						$this->errors['category_formula'] = $this->language->get('error_formula_pattern');
					}
				}
			}
		}

		// Product Formula
		$this->request->post['product_formula'] = trim($this->request->post['product_formula']);

		if (empty($this->request->post['product_formula'])) {
			$this->errors['product_formula'] = $this->language->get('error_formula_empty');
		} else {
			// need be at least 1 variable
			if (false === strstr($this->request->post['product_formula'], '[product_name]') && false === strstr($this->request->post['product_formula'], '[product_id]') && false === strstr($this->request->post['product_formula'], '[model]') && false === strstr($this->request->post['product_formula'], '[sku]')) {

				$this->errors['product_formula'] = $this->language->get('error_formula_less_vars');
			} else {
				$str_without_vars = str_replace(array(
					'[product_name]',
					'[product_id]',
					'[model]',
					'[sku]',
					'[manufacturer_name]'
					), array(
					'',
					'',
					'',
					''
					), $this->request->post['product_formula']);

				if (!empty($str_without_vars)) {
					if (!preg_match("/[a-bA-Z\-_]+/", $str_without_vars)) {
						$this->errors['product_formula'] = $this->language->get('error_formula_pattern');
					}
				}
			}
		}

		// Manufacturer Formula
		$this->request->post['manufacturer_formula'] = trim($this->request->post['manufacturer_formula']);

		if (empty($this->request->post['manufacturer_formula'])) {
			$this->errors['manufacturer_formula'] = $this->language->get('error_formula_empty');
		} else {
			// need be at least 1 variable
			if (false === strstr($this->request->post['manufacturer_formula'], '[manufacturer_name]') && false === strstr($this->request->post['manufacturer_formula'], '[manufacturer_id]')) {
				$this->errors['manufacturer_formula'] = $this->language->get('error_formula_less_vars');
			} else {
				$str_without_vars = str_replace(array(
					'[manufacturer_name]',
					'[manufacturer_id]'
					), array(
					'',
					''
					), $this->request->post['manufacturer_formula']);

				if (!empty($str_without_vars)) {
					if (!preg_match("/[a-bA-Z\-_]+/", $str_without_vars)) {
						$this->errors['manufacturer_formula'] = $this->language->get('error_formula_pattern');
					}
				}
			}
		}

		// Information Formula
		$this->request->post['information_formula'] = trim($this->request->post['information_formula']);

		if (empty($this->request->post['information_formula'])) {
			$this->errors['information_formula'] = $this->language->get('error_formula_empty');
		} else {
			// need be at least 1 variable
			if (false === strstr($this->request->post['information_formula'], '[information_title]') && false === strstr($this->request->post['information_formula'], '[information_id]')) {
				$this->errors['information_formula'] = $this->language->get('error_formula_less_vars');
			} else {
				$str_without_vars = str_replace(array(
					'[information_title]',
					'[information_id]'
					), array(
					'',
					''
					), $this->request->post['information_formula']);

				if (!empty($str_without_vars)) {
					if (!preg_match("/[a-bA-Z\-_]+/", $str_without_vars)) {
						$this->errors['information_formula'] = $this->language->get('error_formula_pattern');
					}
				}
			}
		}

		// If is any errors : common warning
		if ($this->errors && !isset($this->errors['warning'])) {
			$this->errors['warning'] = $this->language->get('error_warning');
		}

		return !$this->errors;
	}



	/*
	------------------------------------------------------------------------------
	Поодиночная генерация
	------------------------------------------------------------------------------
	*/

	/*
	 * Generation by AJAX
	 */

	public function generateSeoUrlByAjax() {
		$this->stdelog->write(2, 'generateSeoUrlByAjax() is called');
		$this->stdelog->write(4, $this->request->post, 'generateSeoUrlByAjax() : $this->request->post');

		$data = ['result' => ''];

		if (!isset($this->request->post)) {
			return false;
		}

		$this->stdelog->write(4, 'generateSeoUrlByAjax() : call $this->generateSeoUrl()');

		$result = $this->generateSeoUrl($this->request->post);

		$this->stdelog->write(4, $result, 'generateSeoUrlByAjax() : $this->generateSeoUrl() returned $result');

		if ($result) {
			$data['result'] = $result;
		}

		$this->stdelog->write(4, $data, 'generateSeoUrlByAjax() : $data defore json_encode($data)');

		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data);
		exit;
	}


	/*
	 * Base method
	 * Это у нас основой метод, который генерирует SEO URL
	 *
	 * Ему все равно, откуда поступают данные о товаре - из формы в админке или из базы при массовом редактировании
	 *
	 * Определить сущность
	 * Определить, какие переменные есть в формуле
	 * Вырезать из формулы лишние - (транслит сам это сделает)
	 * Транлитировать
	 * Запросить уникальность
	 * Если URL не уникален, то использовать индекс N - причем, это не зависит от того, есть ли в формуле генерации доп переменные или нет
	 */

	public function generateSeoUrl($a_data) {
		$this->stdelog->write(4, 'generateSeoUrl() is called');
		
		$this->stdelog->write(4, $a_data, 'generateSeoUrl() : $a_data');

		$this->load->model('module/' . $this->code);
		
		$setting = array(
			'language_id'=>$this->config->get('seo_url_generator_language'),
			'translit_function'=>$this->config->get('seo_url_generator_translit_function'),
			'formula'=>'', // Для каждой сущности будет своя
			'system'=>$this->config->get('seo_url_generator_system'), // it is important for manufacturer name (!) - is need in product gen & manufacturer gen
			'delimiter_char'=>$this->config->get('seo_url_generator_delimiter_char'),
			'change_delimiter_char'=>$this->config->get('seo_url_generator_change_delimiter_char'),
			'rewrite_on_save'=>$this->config->get('seo_url_generator_rewrite_on_save'), // is actual only on manual save, not for massGenerate
			'custom_replace_from'=>$this->config->get('seo_url_generator_custom_replace_from'),
			'custom_replace_to'=>$this->config->get('seo_url_generator_custom_replace_to'),
		);
		
		if ('category' == $a_data['essence']) {
			$setting['formula'] = $this->config->get('seo_url_generator_category_formula');
		} elseif ('product' == $a_data['essence']) {
			$setting['formula'] = $this->config->get('seo_url_generator_product_formula');
		} elseif ('manufacturer' == $a_data['essence']) {
			$setting['formula'] = $this->config->get('seo_url_generator_manufacturer_formula');
		} elseif ('information' == $a_data['essence']) {
			$setting['formula'] = $this->config->get('seo_url_generator_information_formula');
		} else {
			$this->stdelog->write(4, 'generateSeoUrl() : is not system essence');
		}
		
		$this->stdelog->write(4, $a_data['essence'], 'generateSeoUrl() : $a_data["essence"]');
		
		$name = $this->model_module_seo_url_generator->essenceNameFilter($a_data['name'], $a_data['essence'], $setting);

		$this->stdelog->write(4, $name, 'generateSeoUrl() : $name after $this->model_module_seo_url_generator->essenceNameFilter()');

		$keyword = '';
		
		$this->stdelog->write(4, $a_data['essence'], 'generateSeoUrl() : $a_data["essence"]');

		if (isset($a_data['essence']) && $a_data['essence']) {
			if ('category' == $a_data['essence']) {			
				$this->stdelog->write(4, 'generateSeoUrl() : prepare to call to generateOtherSystemsEssenceKeyword() in category essence');
				$keyword = $this->model_module_seo_url_generator->generateOtherSystemsEssenceKeyword($a_data, $setting);
			} elseif ('product' == $a_data['essence']) {
				$this->stdelog->write(4, 'generateSeoUrl() : prepare to call to generateProductKeyword() in product essence');
				$keyword = $this->model_module_seo_url_generator->generateProductKeyword($a_data, $setting);
			} elseif ('manufacturer' == $a_data['essence']) {
				$this->stdelog->write(4, 'generateSeoUrl() : prepare to call to generateOtherSystemsEssenceKeyword() in manufacturer essence');
				$keyword = $this->model_module_seo_url_generator->generateOtherSystemsEssenceKeyword($a_data, $setting);
			} elseif ('information' == $a_data['essence']) {
				$this->stdelog->write(4, 'generateSeoUrl() : prepare to call to generateOtherSystemsEssenceKeyword() in information essence');
				$keyword = $this->model_module_seo_url_generator->generateOtherSystemsEssenceKeyword($a_data, $setting);
			} else {
				$this->stdelog->write(4, 'generateSeoUrl() : prepare to call to generateProductKeyword() in nonsystem essence');
				$keyword = $this->model_module_seo_url_generator->generateNotSystemsEssenceKeyword($a_data, $setting);
			}

			$this->stdelog->write(4, $keyword, 'generateSeoUrl() : $keyword returned from generate function()');
		} else {
			$this->stdelog->write(1, 'generateSeoUrl() : $a_data["essence"] is empty');
		}

		$this->stdelog->write(4, $keyword, 'generateSeoUrl() : call to $this->model_module_seo_url_generator->translit()');

		$keyword = $this->model_module_seo_url_generator->translit($keyword, $setting);

		$this->stdelog->write(4, $keyword, 'generateSeoUrl() : $keyword after $this->model_module_seo_url_generator->translit()');
		
		// Make unique		
		if (!$this->model_module_seo_url_generator->isUnique($keyword, $a_data['essence'] . '_id', $a_data['essence_id'])) {
			$keyword = $this->model_module_seo_url_generator->makeUniqueURL($keyword);
			
			$this->stdelog->write(4, $keyword, 'generateSeoUrl() : $keyword after $this->model_module_seo_url_generator->makeUniqueURL()');
		}
		
		$this->stdelog->write(4, $keyword, 'generateSeoUrl() : return $keyword');

		return $keyword;
	}
	
}
