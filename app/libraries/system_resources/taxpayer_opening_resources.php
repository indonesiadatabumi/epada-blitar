<?php
	
	class taxpayer_opening_resources{

		public static $_TBL_NAME = "wp_wr_pembukaan";
		public static $_PK = "wp_wr_pembukaan_id";
		public static $_SQL_LIST = "SELECT a.wp_wr_pembukaan_id,b.npwprd,b.nama as nama_wpwr,
									a.no_berita_acara,to_char(a.tgl_berita_acara,'dd-mm-yyyy') as tgl_berita_acara,
									b.alamat as alamat_op,b.kecamatan,b.kelurahan,b.nama_paret,b.nama_kegus,b.wp_wr_detil_id,
									to_char(a.tgl_buka,'dd-mm-yyyy') as tgl_buka
									FROM wp_wr_pembukaan as a 
									LEFT JOIN (SELECT w.wp_wr_detil_id,w.nama,w.alamat,w.kelurahan,w.kelurahan_id,w.kecamatan,w.kecamatan_id,
									w.pajak_id,x.npwprd,y.nama_paret,z.nama_kegus FROM wp_wr_detil as w 
									LEFT JOIN wp_wr as x ON (w.wp_wr_id=x.wp_wr_id) 
									LEFT JOIN bundel_pajak_retribusi as y ON (w.pajak_id=y.bundel_id) 
									LEFT JOIN ref_kegiatan_usaha as z ON (w.kegus_id=z.ref_kegus_id)) as b ON (a.wp_wr_detil_id=b.wp_wr_detil_id)";


	}
?>