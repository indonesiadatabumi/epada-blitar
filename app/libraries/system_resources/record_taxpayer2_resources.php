<?php
	
	class record_taxpayer2_resources{

		public static $_TBL_NAME = "wp_wr";
		public static $_PK = "wp_wr_id";
		public static $_SQL_LIST = "SELECT a.wp_wr_id,a.npwprd,a.nama,a.alamat,a.kelurahan,a.kecamatan,a.kabupaten,a.kode_pos,a.no_telepon,
								   to_char(a.tgl_pendaftaran,'dd-mm-yyyy') as tgl_pendaftaran,b.nama_kegus,c.wp_wr_detil_id FROM wp_wr as a 
								   LEFT JOIN ref_kegiatan_usaha as b ON (a.kegus_id=b.ref_kegus_id) 
								   LEFT JOIN (SELECT wp_wr_detil_id,wp_wr_id FROM wp_wr_detil WHERE utama=TRUE) as c ON (a.wp_wr_id=c.wp_wr_id)";


	}
?>