<?php
	
	class record_lhp_resources{

		public static $_TBL_NAME = "laporan_hasil_pemeriksaan";
		public static $_PK = "lhp_id";
		public static $_SQL_LIST = "SELECT a.lhp_id,a.no_pemeriksaan,to_char(a.tgl_pemeriksaan,'dd-mm-yyyy') as tgl_pemeriksaan,
									a.wp_wr_detil_id,d.singkatan as singkatan_spt,c.npwprd,b.nama as nama_wp,e.kode_rekening,e.nama_rekening,a.pajak
									FROM laporan_hasil_pemeriksaan as a 
									LEFT JOIN wp_wr_detil as b ON (a.wp_wr_detil_id=b.wp_wr_detil_id) 
									LEFT JOIN wp_wr as c ON (a.wp_wr_id=c.wp_wr_id) 									
									LEFT JOIN ref_jenis_spt as d ON (a.jenis_spt_id=d.ref_jenspt_id) 
									LEFT JOIN v_rekening as e ON (a.rekening_id=e.rekening_id)";

		public static $_ORDER_FIELD = array('a.lhp_id');
		public static $_ORDER_METHOD = 'DESC';
	}
?>