<?php
	
	class print_stpd_list_resources{

		public static $_TBL_NAME = "penetapan_pajak";
		public static $_PK = "penetapan_id";
		public static $_SQL_LIST = "SELECT a.nama,a.alamat,b.npwprd,c.persen_tarif,c.nilai_terkena_pajak,
									c.pajak,c.nomor_spt,to_char(c.tgl_proses,'dd-mm-yyyy') as tgl_proses,
									to_char(c.masa_pajak1,'dd-mm-yyyy') as masa_pajak1,to_char(c.masa_pajak2,'dd-mm-yyyy') as masa_pajak2
									FROM wp_wr_detil as a 
									LEFT JOIN wp_wr as b ON (a.wp_wr_id=b.wp_wr_id) 
									LEFT JOIN spt as c ON (a.wp_wr_detil_id=c.wp_wr_detil_id) ";


	}
