<?php
final class Loader {
	private $registry;

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function controller($route, $args = array()) {

        //d_opencart_patch.xml 1
        if(strpos($route, 'module/') === 0){
            if(file_exists(DIR_APPLICATION . 'controller/extension/' . $route . '.php')){
                $route = 'extension/'.$route;
            }
        }
        if(strpos($route, 'total/') === 0){
            if(file_exists(DIR_APPLICATION . 'controller/extension/' . $route . '.php')){
                $route = 'extension/'.$route;
            }
        }
        if(strpos($route, 'analytics/') === 0){
            if(file_exists(DIR_APPLICATION . 'controller/extension/' . $route . '.php')){
                $route = 'extension/'.$route;
            }
        }
        if(strpos($route, 'fraud/') === 0){
            preg_match("/(\/)/", $route, $match);
            $test_route = (count($match) > 1) ? preg_replace("/(\/)[a-z0-9_\-]+$/", "", $route) : $route;
            if(file_exists(DIR_APPLICATION . 'controller/extension/' . $test_route . '.php')){
                $route = 'extension/'.$route;
            }
        }
        if(strpos($route, 'payment/') === 0){
            preg_match("/(\/)/", $route, $match);
            $test_route = (count($match) > 1) ? preg_replace("/(\/)[a-z0-9_\-]+$/", "", $route) : $route;
            if(file_exists(DIR_APPLICATION . 'controller/extension/' . $test_route . '.php')){
                $route = 'extension/'.$route;
            }
        }
        if(strpos($route, 'captcha/') === 0){
            preg_match("/(\/)/", $route, $match);
            $test_route = (count($match) > 1) ? preg_replace("/(\/)[a-z0-9_\-]+$/", "", $route) : $route;
            if(file_exists(DIR_APPLICATION . 'controller/extension/' . $test_route . '.php')){
                $route = 'extension/'.$route;
            }
        }
		$action = new Action($route, $args);

		return $action->execute($this->registry);
	}

	public function model($model) {
		$file = DIR_APPLICATION . 'model/' . $model . '.php';
		$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);

		if (file_exists($file)) {
			include_once(modification($file));

			$this->registry->set('model_' . str_replace('/', '_', $model), new $class($this->registry));
		} else {
			trigger_error('Error: Could not load model ' . $file . '!');
			exit();
		}
	}

	public function view($template, $data = array()) {

            //d_twig_manager.xml 1
            $output = $this->controller('event/d_twig_manager/support', array('route' => $template, 'data' => $data));
            if($output || !file_exists( DIR_TEMPLATE . $template)){
                return $output;
            }
            
		$file = DIR_TEMPLATE . $template;

		if (file_exists($file)) {
			extract($data);

			ob_start();

			require(modification($file));

			$output = ob_get_contents();

			ob_end_clean();

			return $output;
		} else {
			trigger_error('Error: Could not load template ' . $file . '!');
			exit();
		}
	}

	public function library($library) {
		$file = DIR_SYSTEM . 'library/' . $library . '.php';

		if (file_exists($file)) {
			include_once(modification($file));
		} else {
			trigger_error('Error: Could not load library ' . $file . '!');
			exit();
		}
	}

	public function helper($helper) {
		$file = DIR_SYSTEM . 'helper/' . $helper . '.php';

		if (file_exists($file)) {
			include_once(modification($file));
		} else {
			trigger_error('Error: Could not load helper ' . $file . '!');
			exit();
		}
	}

	public function config($config) {
		$this->registry->get('config')->load($config);
	}

	public function language($language) {
		return $this->registry->get('language')->load($language);
	}
}