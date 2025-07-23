<?php

class tax_determination_resources
{

	public static $_TBL_NAME = "penetapan_pajak";
	public static $_PK = "penetapan_id";
	public static $_SQL_LIST = "SELECT a.penetapan_id,a.kohir,a.tahun_pajak,b.*,
									to_char(a.tgl_penetapan,'dd-mm-yyyy') as tgl_penetapan,c.keterangan as keterangan_spt,c.singkatan as singkatan_spt,
									to_char(a.tgl_jatuh_tempo,'dd-mm-yyyy') as tgl_jatuh_tempo,
									d.nama_paret 
									FROM penetapan_pajak as a 
									LEFT JOIN v_spt as b ON (a.spt_id=b.spt_id) 
									LEFT JOIN ref_jenis_spt as c ON (a.jenis_spt_id=c.ref_jenspt_id) 
									LEFT JOIN bundel_pajak_retribusi as d ON (a.pajak_id=d.bundel_id)";
}
