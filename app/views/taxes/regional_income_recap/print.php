<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | Laporan Target dan Realisasi Pendapatan Pajak Daerah</title>
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>report-style.css" />
	<style type="text/css">
		@import "<?= $this->config->item('css_path'); ?>report-table-style.css";
	</style>
</head>

<body>
	<div style="margin:10px;">
		<table border=0 width="100%">
			<tr>
				<td>
					<table class="noborder" style="font-weight:bold">
						<tr>
							<td align="right">
								<h3>LAPORAN :</h3>
							</td>
							<td>&nbsp;TARGET DAN REALISASI PENDAPATAN PAJAK DAERAH <?= strtoupper($system_params[7] . " " . $system_params[6]); ?></td>
						</tr>
						<tr>
							<td></td>
							<td>&nbsp;TAHUN ANGGARAN <?= $tax_year; ?></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<table class="noborder">
									<tr>
										<td width="10%">MINGGU KE</td>
										<td>: <?= NumToRomawi($curr_week) . " (S.D " . strtoupper($process_date2) . ")"; ?></td>
									</tr>
									<tr>
										<td>BULAN</td>
										<td>: <?= strtoupper($periode_report); ?></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<table class="report" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td align="center" rowspan="2"><b>KODE REKENING</b></td>
					<td align="center" rowspan="2"><b>URAIAN</b></td>
					<td align="center" rowspan="2"><b>TARGET (Rp.)</b></td>
					<td align="center" colspan="2"><b>REALISASI S.D MINGGU LALU</td>
					<td align="center" colspan="2"><b>REALISASI MINGGU INI</td>
					<td align="center" colspan="2"><b>REALISASI S.D MINGGU INI</td>
					<td align="center" rowspan="2"><b>SISA TARGET (Rp.)</b></td>
					<td align="center" rowspan="2"><b>KETERANGAN</b></td>
				</tr>
				<tr>
					<td align="center"><b>Rp.</td>
					<td align="center"><b>%</td>
					<td align="center"><b>Rp.</td>
					<td align="center"><b>%</td>
					<td align="center"><b>Rp.</td>
					<td align="center" style="border-right:none"><b>%</td>
				</tr>
				<tr>
					<td align="center"><b>1</b></td>
					<td align="center"><b>2</b></td>
					<td align="center"><b>3</b></td>
					<td align="center"><b>4</b></td>
					<td align="center"><b>5</b></td>
					<td align="center"><b>6</b></td>
					<td align="center"><b>7</b></td>
					<td align="center"><b>8</b></td>
					<td align="center"><b>9</b></td>
					<td align="center"><b>10</b></td>
					<td align="center"><b>11</b></td>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($rows1 as $row1) {
					echo "<tr>
								<td colspan='11'><b>KELURAHAN " . strtoupper($row1['nama_kelurahan']) . "</b></td>
							</tr>";

					$sql = "SELECT a.bundel_id as pajak_id,a.nama_paret as nama_pajak,
					a.kode_rekening,b.tot_pajak,COALESCE(c.tot_realisasi1,'0') as tot_realisasi1,COALESCE(d.tot_realisasi2,'0') as tot_realisasi2
					FROM bundel_pajak_retribusi as a 
					LEFT JOIN (SELECT SUM(pajak) as tot_pajak,pajak_id FROM v_spt 
								WHERE tahun_pajak='" . $tax_year . "' AND kelurahan_id = '" . $row1['kelurahan_id'] . "' GROUP BY pajak_id) as b ON (a.bundel_id=b.pajak_id) 
					LEFT JOIN (SELECT SUM(total_bayar) as tot_realisasi1, a.pajak_id 
								FROM transaksi_pajak as a 
								LEFT JOIN wp_wr_detil AS b ON a.wp_wr_detil_id=b.wp_wr_detil_id
								WHERE (tgl_bayar<=to_date('" . $process_date . "','dd-mm-yyyy')-cast(extract(dow from to_date('" . $process_date . "','dd-mm-yyyy')) as int)) AND b.kelurahan_id='" . $row1['kelurahan_id'] . "' GROUP BY a.pajak_id) as c ON (a.bundel_id=c.pajak_id) 
					LEFT JOIN (SELECT SUM(total_bayar) as tot_realisasi2, a.pajak_id 
								FROM transaksi_pajak as a
								LEFT JOIN wp_wr_detil AS b ON a.wp_wr_detil_id=b.wp_wr_detil_id
								WHERE (tgl_bayar BETWEEN 
									to_date('" . $process_date . "','dd-mm-yyyy')-cast(extract(dow from to_date('" . $process_date . "','dd-mm-yyyy')) as int) 
									AND to_date('" . $process_date . "','dd-mm-yyyy')) AND b.kelurahan_id='" . $row1['kelurahan_id'] . "' GROUP BY a.pajak_id) as d ON (a.bundel_id=d.pajak_id) 
					WHERE (a.bundel_id BETWEEN 1 AND 11) AND a.aktif=TRUE ORDER BY a.bundel_id ASC";

					$rows2 = $dao->execute(0, $sql)->result_array();

					foreach ($rows2 as $row2) {
						$tot_tax1 = $row2['tot_pajak'];
						$tot_realisasi1_3 = $row2['tot_realisasi1'] + $row2['tot_realisasi2'];

						$progress1_1 = ($tot_tax1 > 0 ? $row2['tot_realisasi1'] / $tot_tax1 * 100 : 0);
						$progress1_2 = ($tot_tax1 > 0 ? $row2['tot_realisasi2'] / $tot_tax1 * 100 : 0);
						$progress1_3 = ($tot_tax1 > 0 ? $tot_realisasi1_3 / $tot_tax1 * 100 : 0);

						$remains1 = $tot_tax1 - $tot_realisasi1_3;

						echo "<tr>
							<td align='center'><b>" . $row2['kode_rekening'] . "</b></td>
							<td><b>" . $row2['nama_pajak'] . "</b></td>
							<td align='right'><b>" . number_format($row2['tot_pajak'], 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($row2['tot_realisasi1'], 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($progress1_1, 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($row2['tot_realisasi2'], 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($progress1_2, 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($tot_realisasi1_3, 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($progress1_3, 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($remains1, 2, ',', '.') . "</b></td>
							<td align='right'></td>
							</tr>";
					}
				}
				?>
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
</body>

</html>