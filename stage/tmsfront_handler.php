<?php

set_include_path(implode(PATH_SEPARATOR,array(get_include_path(), $_SERVER['DOCUMENT_ROOT'] . '/view', $_SERVER['DOCUMENT_ROOT'] . '/stage')));

spl_autoload_register();

$config = require_once('tmsconfig.php');

$is_handle_requested = false;
$user_info = array();
$auth_hierarchy = '';

if(isset($_POST['controller']) && isset($_POST['handle'])) {
		$controller = $_POST['controller'];
		$handle = $_POST['handle'];
		$is_handle_requested = true;
	} 
	
try {
		$authorise = new tmsauth;
		if(!$auth_hierarchy = $authorise -> get_auth_hierarchy()) {
				$auth_hierarchy = 'tmspublic';
			} else {
					$user_info = $authorise -> get_user_info();
				}
		
if($auth_hierarchy != 'tmspublic') {
		$view = $auth_hierarchy;
	}
	
if($is_handle_requested) {
		//echo $handle . '<br/>';echo $controller . '<br/>';
		if(isset($_POST['data'])) {
				$data = $_POST['data'];
				//echo $data;
				$controller = 'tms' . $controller;
				//echo $controller;
				if(isset($view)) {
					$return_value = array($data);
					$view .= '-' . call_user_func_array(array($controller,$handle),array(explode('#',$data),&$return_value));
					//var_dump($ret);
				} else {
						throw new Exception('Error: Auth-View not set');
					}
			} else {
					throw new Exception ('Error: Data expected is not send');
				}
	}
	
if(isset($view)) {
	$view .= '.php';
	require_once($view);
}

	} catch(Exception $e) {
			echo 'Caught Exception: ', $e->getMessage(), "\n";
		}
?>