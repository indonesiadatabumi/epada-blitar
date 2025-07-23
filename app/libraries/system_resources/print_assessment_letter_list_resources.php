<?php
	
	class print_assessment_letter_list_resources{

		public static $_TBL_NAME = "penetapan_pajak";
		public static $_PK = "penetapan_id";
		public static $_SQL_LIST = "SELECT a.penetapan_id,b.lhp_id,a.kohir,b.nama_paret,a.tahun_pajak,b.npwprd,b.nama_wp,b.no_pemeriksaan,
									to_char(a.tgl_penetapan,'dd-mm-yyyy') as tgl_penetapan,c.keterangan as keterangan_spt,c.singkatan as singkatan_spt,
									to_char(a.tgl_jatuh_tempo,'dd-mm-yyyy') as tgl_jatuh_tempo,b.pajak FROM penetapan_pajak as a 
									LEFT JOIN (SELECT w.lhp_id,x.nama_paret,w.pajak,w.no_pemeriksaan,y.nama as nama_wp,
											   z.npwprd,y.kecamatan_id,y.kelurahan_id FROM laporan_hasil_pemeriksaan as w 
											   LEFT JOIN bundel_pajak_retribusi as x ON (w.pajak_id=x.bundel_id) 
											   LEFT JOIN wp_wr_detil as y ON (w.wp_wr_detil_id=y.wp_wr_detil_id) 
											   LEFT JOIN wp_wr as z ON (w.wp_wr_id=z.wp_wr_id)) as b ON (a.lhp_id=b.lhp_id) 
									LEFT JOIN ref_jenis_spt as c ON (a.jenis_spt_id=c.ref_jenspt_id)";

	}
?>