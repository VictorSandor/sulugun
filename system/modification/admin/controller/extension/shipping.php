<?php
class ControllerExtensionShipping extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/extension');

		$this->getList();
	}

	public function install() {
		$this->load->language('extension/shipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/extension');

		if ($this->validate()) {
			$this->model_extension_extension->install('shipping', $this->request->get['extension']);

			$this->load->model('user/user_group');

			$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'shipping/' . $this->request->get['extension']);
			$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'shipping/' . $this->request->get['extension']);

			// Call install method if it exsits
			$this->load->controller('shipping/' . $this->request->get['extension'] . '/install');

            //d_opencart_patch.xml 1
            $this->load->model('extension/d_opencart_patch/user');
            $this->model_user_user_group->addPermission($this->model_extension_d_opencart_patch_user->getGroupId(), 'access', 'extension/shipping/' . $this->request->get['extension']);
            $this->model_user_user_group->addPermission($this->model_extension_d_opencart_patch_user->getGroupId(), 'modify', 'extension/shipping/' . $this->request->get['extension']);
            $this->load->controller('extension/shipping/' . $this->request->get['extension'] . '/install');
            

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	public function uninstall() {
		$this->load->language('extension/shipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/extension');

		if ($this->validate()) {
			$this->model_extension_extension->uninstall('shipping', $this->request->get['extension']);

			$this->load->model('setting/setting');

			$this->model_setting_setting->deleteSetting($this->request->get['extension']);

			// Call uninstall method if it exsits
			$this->load->controller('shipping/' . $this->request->get['extension'] . '/uninstall');

            //d_opencart_patch.xml 2
            $this->load->controller('extension/shipping/' . $this->request->get['extension'] . '/uninstall');
            

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	public function getList() {
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
		);
				
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_install'] = $this->language->get('button_install');
		$data['button_uninstall'] = $this->language->get('button_uninstall');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$this->load->model('extension/extension');

		$extensions = $this->model_extension_extension->getInstalled('shipping');

		foreach ($extensions as $key => $value) {
			
                //d_opencart_patch.xml 3
                if (!file_exists(DIR_APPLICATION . 'controller/shipping/' . $value . '.php')
                && !file_exists(DIR_APPLICATION . 'controller/extension/shipping/' . $value . '.php')) { 
				$this->model_extension_extension->uninstall('shipping', $value);

				unset($extensions[$key]);
			}
		}

		$data['extensions'] = array();

		$files = glob(DIR_APPLICATION . 'controller/shipping/*.php');

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');


                //d_opencart_patch.xml 5
                if($extension == 'd_opencart_patch'){
                    continue;
                } 
				$this->load->language('shipping/' . $extension);

				
                //d_opencart_patch.xml 4
                $data['extensions'][$extension] = array( 
					'name'       => $this->language->get('heading_title'),
					'status'     => $this->config->get($extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'sort_order' => $this->config->get($extension . '_sort_order'),
					'install'    => $this->url->link('extension/shipping/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL'),
					'uninstall'  => $this->url->link('extension/shipping/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL'),
					'installed'  => in_array($extension, $extensions),
					'edit'       => $this->url->link('shipping/' . $extension . '', 'token=' . $this->session->data['token'], 'SSL')
				);
			}
		}


        //d_opencart_patch.xml 6
        $files = glob(DIR_APPLICATION . 'controller/extension/shipping/*.php');
        if ($files) {
            foreach ($files as $file) {
                $extension = basename($file, '.php');
                if($extension == 'd_opencart_patch'){
                    continue;
                }
                $this->load->language('extension/shipping/' . $extension);
                $module_data = array();
                if(VERSION > "2.0.0.0"){
                    $this->load->model('extension/module');
                    $modules = $this->model_extension_module->getModulesByCode($extension);
                    foreach ($modules as $module) {
                        $module_data[] = array(
                            'module_id' => $module['module_id'],
                            'name'      => $this->language->get('heading_title') . ' &gt; ' . $module['name'],
                            'edit'      => $this->url->link('extension/shipping/' . $extension, 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL'),
                            'delete'    => $this->url->link('extension/shipping/delete', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL')
                        );
                    }
                }
                $data['extensions'][$extension] = array(
                    'name'      => $this->language->get('heading_title'),
                    'status'    => $this->config->get($extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                    'sort_order' => $this->config->get($extension . '_sort_order'),
                    'module'    => $module_data,
                    'install'   => $this->url->link('extension/shipping/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL'),
                    'uninstall' => $this->url->link('extension/shipping/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL'),
                    'installed' => in_array($extension, $extensions),
                    'edit'      => $this->url->link('extension/shipping/' . $extension, 'token=' . $this->session->data['token'], 'SSL')
                );
            }
        }
        $sort_order = array();
        foreach ($data['extensions'] as $key => $value) {
            $sort_order[$key] = $value['name'];
        }
        array_multisort($sort_order, SORT_ASC, $data['extensions']);
            
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}