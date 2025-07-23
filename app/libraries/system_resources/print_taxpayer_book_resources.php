<?php
class print_taxpayer_book_resources
{
	public static $_TBL_NAME = "v_spt";
	public static $_PK = "spt_id";
	public static $_SQL_LIST = "SELECT a.spt_id,a.jenis_spt_id,a.kode_billing,a.npwpd,a.nama_pajak,a.masa_pajak1,a.masa_pajak2,
									to_char(a.tgl_proses,'dd-mm-yyyy') as tgl_proses,a.nomor_spt,
									a.nilai_terkena_pajak,a.pajak,b.kode_rekening as kode_rekening_pajak 
									FROM v_spt as a LEFT JOIN bundel_pajak_retribusi as b ON (a.pajak_id=b.bundel_id)";
	public static $_ORDER_FIELD = array('spt_id');
	public static $_ORDER_METHOD = 'ASC';
}
