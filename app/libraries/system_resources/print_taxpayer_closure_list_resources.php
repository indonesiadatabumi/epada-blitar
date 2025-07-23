<?php
	
	class print_taxpayer_closure_list_resources{

		public static $_TBL_NAME = "wp_wr_penutupan";
		public static $_PK = "wp_wr_penutupan_id";
		public static $_SQL_LIST = "SELECT b.npwprd,b.nama,b.alamat,b.nama_kegus,b.kelurahan,b.kecamatan,
									to_char(a.tgl_tutup,'dd-mm-yyyy') as tgl_tutup,b.pajak_id
									FROM wp_wr_penutupan as a 
									LEFT JOIN (SELECT x.wp_wr_detil_id,x.nama,x.alamat,x.kelurahan,x.kecamatan,
												x.kecamatan_id,y.npwprd,z.nama_kegus,x.pajak_id 
												FROM wp_wr_detil as x LEFT JOIN wp_wr as y ON (x.wp_wr_id=y.wp_wr_id) 
												LEFT JOIN ref_kegiatan_usaha as z ON (x.kegus_id=z.ref_kegus_id)) as b ON (a.wp_wr_detil_id=b.wp_wr_detil_id)";


	}
?>