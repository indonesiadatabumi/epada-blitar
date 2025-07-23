<?php
class print_acceptance_report_resources
{
	public static $_TBL_NAME = "transaksi_pajak";
	public static $_PK = "transaksi_id";
	public static $_SQL_LIST = "SELECT a.no_urut_sts,to_char(a.tgl_bayar,'yyyy-mm-dd') as tgl_bayar,
									b.npwpd,b.nama_wp,to_char(a.masa_pajak1,'mm') as bulan_pajak,a.tahun_pajak,
									a.pokok_pajak,a.denda,a.total_bayar,c.created_by FROM transaksi_pajak as a 									
									LEFT JOIN v_spt as b ON (a.kode_billing=b.kode_billing)
									LEFT JOIN spt as c ON (a.kode_billing=c.kode_billing)";
	public static $_ORDER_FIELD = array('transaksi_id');
	public static $_ORDER_METHOD = 'DESC';
}
