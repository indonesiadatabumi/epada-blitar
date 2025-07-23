<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class bundle extends CI_Controller{
		

		function __construct(){
			
			parent::__construct();
			
		}		

		function taxes($bundle_item_type,$menu='general_info'){

			$item_bundle = 'tax_'.$bundle_item_type;

			require_once APPPATH.'controllers'.DIRECTORY_SEPARATOR.$item_bundle.'.php';
			
			$item_bundle = new $item_bundle(__FUNCTION__,$bundle_item_type,$menu);

			$item_bundle->{$menu}();		
		}		
		
	}
