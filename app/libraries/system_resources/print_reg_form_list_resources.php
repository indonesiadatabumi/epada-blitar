<?php
	
	class print_reg_form_list_resources{

		public static $_TBL_NAME = "wp_wr_formulir";
		public static $_PK = "wp_wr_formulir_id";
		public static $_SQL_LIST = "SELECT a.no_form,a.nama,a.alamat,a.kelurahan,a.kecamatan,b.nama_paret,c.nama_kegus,
									to_char(a.tgl_kirim,'dd-mm-yyyy') as tgl_dikirim,to_char(a.tgl_kembali,'dd-mm-yyyy') as tgl_kembali
									FROM wp_wr_formulir as a LEFT JOIN bundel_pajak_retribusi as b ON (a.pajak_id=b.bundel_id) 
									LEFT JOIN ref_kegiatan_usaha as c ON (a.kegus_id=c.ref_kegus_id)";


	}
?>