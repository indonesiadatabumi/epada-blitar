<?php
	
	class print_taxpayer_list_resources{

		public static $_TBL_NAME = "wp_wr_formulir";
		public static $_PK = "wp_wr_formulir_id";
		public static $_SQL_LIST = "SELECT a.npwprd,a.nama,a.alamat,b.nama_kegus,a.kelurahan,a.kecamatan,
									to_char(a.tgl_pendaftaran,'dd-mm-yyyy') as tgl_pendaftaran
									FROM wp_wr as a 
									LEFT JOIN ref_kegiatan_usaha as b ON (a.kegus_id=b.ref_kegus_id)";


	}
?>