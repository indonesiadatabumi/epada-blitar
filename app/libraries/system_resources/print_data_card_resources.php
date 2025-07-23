<!-- <?php
	
	class print_data_card_list_resources{

		public static $_TBL_NAME = "spt";
		public static $_PK = "spt_id";
		public static $_SQL_LIST = "SELECT b.nama,b.alamat,c.npwprd,a.persen_tarif,a.nilai_terkena_pajak,
									a.pajak,a.nomor_spt,to_char(a.tgl_proses,'dd-mm-yyyy') as tgl_proses,
									to_char(a.masa_pajak1,'dd-mm-yyyy') as masa_pajak1,to_char(a.masa_pajak2,'dd-mm-yyyy') as masa_pajak2
									FROM spt as a 
									LEFT JOIN wp_wr_detil as b ON (a.wp_wr_detil_id=b.wp_wr_detil_id) 
									LEFT JOIN wp_wr as c ON (a.wp_wr_id=c.wp_wr_id) ";


	}
?> -->
<?php
	
	class print_npwpd_card_resources{

		public static $_TBL_NAME = "wp_wr";
		public static $_PK = "wp_wr_id";
		public static $_SQL_LIST = "SELECT a.wp_wr_id,a.npwprd,a.no_reg,a.nama,a.alamat,a.kelurahan,a.kecamatan,a.kabupaten,a.kode_pos,a.no_telepon,
								   to_char(a.tgl_pendaftaran,'dd-mm-yyyy') as tgl_pendaftaran,b.nama_kegus,c.wp_wr_detil_id,
								   (CASE golongan WHEN '1' THEN 'Pribadi' ELSE 'Badan Usaha' END) as golongan
								   FROM wp_wr as a 
								   LEFT JOIN ref_kegiatan_usaha as b ON (a.kegus_id=b.ref_kegus_id) 
								   LEFT JOIN (SELECT wp_wr_detil_id,wp_wr_id FROM wp_wr_detil WHERE utama=TRUE) as c ON (a.wp_wr_id=c.wp_wr_id)";


	}
?>