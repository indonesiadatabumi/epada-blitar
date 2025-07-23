<?php	
	class print_sts_resources{
		public static $_TBL_NAME = "transaksi_pajak";
		public static $_PK = "transaksi_id";
		public static $_SQL_LIST = "SELECT a.transaksi_id,a.spt_id,a.no_transaksi,a.tahun_pajak,to_char(a.masa_pajak1,'yyyy-mm-dd') as masa_pajak1,
									to_char(a.masa_pajak2,'yyyy-mm-dd') as masa_pajak2,b.npwprd,c.nama as nama_wp,d.singkatan as singkatan_spt,
									to_char(a.tgl_bayar,'yyyy-mm-dd') as tgl_bayar,a.pokok_pajak,a.denda,a.total_bayar,a.no_urut_sts FROM transaksi_pajak as a 
									LEFT JOIN wp_wr as b ON (a.wp_wr_id=b.wp_wr_id) 
									LEFT JOIN wp_wr_detil as c ON (a.wp_wr_detil_id=c.wp_wr_detil_id) 
									LEFT JOIN ref_jenis_spt as d ON (a.jenis_spt_id=d.ref_jenspt_id)";
		public static $_ORDER_FIELD = array('transaksi_id');
		public static $_ORDER_METHOD = 'DESC';
	}
