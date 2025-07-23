<?php	
	class print_bpps_resources{
		public static $_TBL_NAME = "transaksi_pajak";
		public static $_PK = "transaksi_id";
		public static $_SQL_LIST = "SELECT to_char(a.tgl_bayar,'yyyy-mm-dd') as tgl_bayar,b.kode_rekening,b.nama_rekening,
									b.npwpd,b.nama_wp,a.total_bayar FROM transaksi_pajak as a 
									LEFT JOIN v_spt as b ON (a.spt_id=b.spt_id)";
		public static $_ORDER_FIELD = array('transaksi_id');
		public static $_ORDER_METHOD = 'DESC';
	}
?>