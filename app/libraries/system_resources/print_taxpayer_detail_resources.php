<?php
	
	class print_taxpayer_detail_resources{

		public static $_TBL_NAME = "wp_wr_detil";
		public static $_PK = "wp_wr_detil_id";
		public static $_SQL_LIST = "SELECT a.wp_wr_detil_id,b.npwprd,b.no_reg,
									(CASE b.golongan WHEN '1' THEN 'Perorangan' ELSE 'Badan Usaha' END) as golongan,
									a.nama,a.alamat,a.kelurahan,a.kecamatan,a.kabupaten,a.kode_pos,
									a.no_telepon,c.nama_kegus,a.status FROM wp_wr_detil as a 
									LEFT JOIN wp_wr as b ON (a.wp_wr_id=b.wp_wr_id)
								   LEFT JOIN ref_kegiatan_usaha as c ON (a.kegus_id=c.ref_kegus_id) ";

	}
?>