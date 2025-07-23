<?php

class record_surat_paksa_resources
{

	public static $_TBL_NAME = "surat_paksa";
	public static $_PK = "srt_paksa_id";
	public static $_SQL_LIST = "SELECT a.*, b.npwpd, b.nama_wp, b.pajak FROM surat_paksa AS a
                                LEFT JOIN v_spt2 AS b ON a.srt_paksa_kode_billing=b.kode_billing";
	public static $_ORDER_FIELD = array('srt_paksa_id');
	public static $_ORDER_METHOD = 'DESC';
}
