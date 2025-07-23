<?php
	
	class record_reg_form_resources{

		public static $_TBL_NAME = "wp_wr_formulir";
		public static $_PK = "wp_wr_form_id";
		public static $_SQL_LIST = "SELECT a.wp_wr_form_id,a.no_form,a.nama,a.alamat,a.kecamatan,a.kelurahan,
									to_char(a.tgl_kirim,'dd-mm-yyyy') as tgl_kirim, 
									to_char(a.tgl_kembali,'dd-mm-yyyy') as tgl_kembali, 
									(CASE a.status WHEN '0' THEN 'Dikirim' WHEN '1' THEN 'Kembali' ELSE 'Tidak Kembali' END) as status,
									b.nama_kegus FROM wp_wr_formulir as a 
									LEFT JOIN ref_kegiatan_usaha as b ON (a.kegus_id=b.ref_kegus_id)";


	}
?>