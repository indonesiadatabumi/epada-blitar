<?php	
	class print_realization_controlbook_resources{
		public static $_TBL_NAME = "v_objek_pajak";
		public static $_PK = "wp_wr_detil_id";
		public static $_SQL_LIST = "SELECT wp_wr_detil_id,npwprd,nama_wp,alamat,kelurahan,kecamatan FROM v_objek_pajak";
		public static $_ORDER_FIELD = array('wp_wr_detil_id');
		public static $_ORDER_METHOD = 'ASC';
	}
?>