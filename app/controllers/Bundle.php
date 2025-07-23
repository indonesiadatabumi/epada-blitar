<?php
defined('BASEPATH') or exit('No direct script access allowed');

class bundle extends CI_Controller
{


	function __construct()
	{

		parent::__construct();
	}

	function taxes($bundle_item_type, $class = 'general_info', $function = 'index')
	{

		$class_controller = 'tax_' . $bundle_item_type;

		require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . ucfirst($class) . '.php';

		$class_controller = new $class(__FUNCTION__, $bundle_item_type, $class);

		$class_controller->{$function}();
	}
}
