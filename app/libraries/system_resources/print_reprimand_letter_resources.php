<?php

class print_reprimand_letter_resources
{

    public static $_TBL_NAME = "surat_teguran2";
    public static $_PK = "st_id";
    public static $_SQL_LIST = "SELECT a.*, b.npwpd, b.nama_wp, b.pajak FROM surat_teguran2 AS a
                                LEFT JOIN v_spt2 AS b ON a.st_kode_billing=b.kode_billing";
    public static $_ORDER_FIELD = array('st_id');
    public static $_ORDER_METHOD = 'DESC';
}
