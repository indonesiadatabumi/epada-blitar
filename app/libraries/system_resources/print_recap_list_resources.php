<?php	
	class print_recap_list_resources{
		public static $_TBL_NAME = "v_spt";
		public static $_PK = "spt_id";
		public static $_SQL_LIST = "SELECT spt_id,npwpd,wp_wr_detil_id,nama_wp,alamat,kelurahan,kecamatan,to_char(masa_pajak1,'mm') bulan_pajak,
									to_char(tgl_proses,'dd-mm-yyyy') as tgl_proses,nomor_spt,nilai_terkena_pajak,pajak FROM v_spt";
		public static $_ORDER_FIELD = array('spt_id');
		public static $_ORDER_METHOD = 'ASC';
	}
?>