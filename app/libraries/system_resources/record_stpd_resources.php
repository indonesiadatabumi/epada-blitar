<?php

class record_stpd_resources
{

	public static $_TBL_NAME = "stpd";
	public static $_PK = "stpd_id";
	public static $_SQL_LIST = "SELECT a.*, b.npwpd, b.nama_wp, b.pajak FROM stpd AS a
                                LEFT JOIN v_spt2 AS b ON a.stpd_kode_billing=b.kode_billing";
	public static $_ORDER_FIELD = array('stpd_id');
	public static $_ORDER_METHOD = 'DESC';
}
