<?php
defined('BASEPATH') or exit('No direct script access allowed');

$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://" . $_SERVER['HTTP_HOST'];
$base_url .= preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';

$config['assets_path'] = $base_url . 'assets/';
$config['css_path'] = $base_url . 'assets/css/';
$config['js_path'] = $base_url . 'assets/js/';
$config['img_path'] = $base_url . 'assets/img/';
$config['logo_path'] = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/';
$config['font_path'] = $base_url . 'assets/fonts/';
$config['upload_path'] = $base_url . 'uploads/';
$config['vendor_path'] = $base_url . 'assets/vendor/';

$config['sys_name_acr'] = 'SIPRIDA';
$config['sys_name_full'] = 'Sistem Informasi Pajak dan Retribusi Daerah';
$config['release_year'] = 2018;
$config['version'] = 'v1.0.0';
$config['development_year'] = 2018;
$config['developer'] = 'HBS';

$config['taxes'] = array(
	'hotel' => array('label' => 'Pajak Hotel'),
	'restaurant' => array('label' => 'Pajak Restoran'),
	'advertising' => array('label' => 'Pajak Reklame'),
	'entertainment' => array('label' => 'Pajak Hiburan'),
	'public_lighting' => array('label' => 'Pajak Penerangan Jalan'),
	'non_metalrock_mineral' => array('label' => 'Pajak Mineral Bukan Logam & Batuan'),
	'groundwater' => array('label' => 'Pajak Air Tanah'),
	'property' => array('label' => 'Pajak Bumi & Bangunan'),
	'parking' => array('label' => 'Pajak Parkir'),
);

$config['duties'] = array('bphtb' => array('label' => 'BPHTB'));
