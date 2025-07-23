<?php
class print_sspd_resources
{
	public static $_TBL_NAME = "v_spt";
	public static $_PK = "spt_id";
	public static $_SQL_LIST =
	"SELECT a.spt_id,a.pajak_id,a.nomor_spt,a.tahun_pajak,a.masa_pajak1,a.masa_pajak2,
								a.npwpd,a.nama_wp,a.pajak,a.nilai_terkena_pajak,a.singkatan_spt,a.wp_wr_id,b.tgl_bayar,a.status_bayar,b.total_bayar,c.no_urut_sspd,c.kompensasi, d.hrg_0_50
								FROM v_spt AS a 
								LEFT JOIN (SELECT spt_id, tgl_bayar, total_bayar FROM transaksi_pajak) AS b ON a.spt_id=b.spt_id
								LEFT JOIN (SELECT spt_id, no_urut_sspd, kompensasi FROM spt) AS c ON a.spt_id=c.spt_id
								LEFT JOIN spt_detil_abt AS d ON a.spt_id=d.spt_id";
	public static $_ORDER_FIELD = array('a.spt_id');
	public static $_ORDER_METHOD = 'DESC';
}
