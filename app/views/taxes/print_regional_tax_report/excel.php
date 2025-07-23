<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan $tax_name.xls");
?>
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
										<td>: <?= NumToRomawi($curr_week) . " (S.D " . strtoupper($process_date) . ")"; ?></td>
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
				$grand_tax = 0;
				$grand_realisasi1 = 0;
				$tot_progress1 = 0;

				$grand_realisasi2 = 0;
				$tot_progress2 = 0;

				$grand_realisasi3 = 0;
				$tot_progress3 = 0;

				$grand_remains = 0;

				$n_rows1 = count($rows1);

				foreach ($rows1 as $row1) {
					$tot_tax1 = $row1['tot_pajak'];
					$tot_realisasi1_3 = $row1['tot_realisasi1'] + $row1['tot_realisasi2'];

					$progress1_1 = ($tot_tax1 > 0 ? $row1['tot_realisasi1'] / $tot_tax1 * 100 : 0);
					$progress1_2 = ($tot_tax1 > 0 ? $row1['tot_realisasi2'] / $tot_tax1 * 100 : 0);
					$progress1_3 = ($tot_tax1 > 0 ? $tot_realisasi1_3 / $tot_tax1 * 100 : 0);

					$remains1 = $tot_tax1 - $tot_realisasi1_3;

					echo "<tr>
							<td align='center'><b>" . $row1['kode_rekening'] . "</b></td>
							<td><b>" . $row1['nama_pajak'] . "</b></td>
							<td align='right'><b>" . number_format($row1['tot_pajak'], 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($row1['tot_realisasi1'], 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($progress1_1, 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($row1['tot_realisasi2'], 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($progress1_2, 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($tot_realisasi1_3, 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($progress1_3, 2, ',', '.') . "</b></td>
							<td align='right'><b>" . number_format($remains1, 2, ',', '.') . "</b></td>
							<td align='right'></td>
							</tr>";

					foreach ($rows2[$row1['pajak_id']] as $row2) {

						$tot_tax2 = $row2['tot_pajak'];
						$tot_realisasi2_3 = $row2['tot_realisasi1'] + $row2['tot_realisasi2'];

						$progress2_1 = ($tot_tax2 > 0 ? $row2['tot_realisasi1'] / $tot_tax2 * 100 : 0);
						$progress2_2 = ($tot_tax2 > 0 ? $row2['tot_realisasi2'] / $tot_tax2 * 100 : 0);
						$progress2_3 = ($tot_tax2 > 0 ? $tot_realisasi1_3 / $tot_tax2 * 100 : 0);

						$remains2 = $tot_tax2 - $tot_realisasi2_3;

						echo "<tr>
								<td align='center'>" . $row2['kode_rekening'] . "</td>
								<td>" . $row2['nama_rekening'] . "</td>
								<td align='right'>" . number_format($row2['tot_pajak'], 2, ',', '.') . "</td>
								<td align='right'>" . number_format($row2['tot_realisasi1'], 2, ',', '.') . "</td>
								<td align='right'>" . number_format($progress2_1, 2, ',', '.') . "</td>
								<td align='right'>" . number_format($row2['tot_realisasi2'], 2, ',', '.') . "</td>
								<td align='right'>" . number_format($progress2_2, 2, ',', '.') . "</td>
								<td align='right'>" . number_format($tot_realisasi2_3, 2, ',', '.') . "</td>
								<td align='right'>" . number_format($progress2_3, 2, ',', '.') . "</td>
								<td align='right'>" . number_format($remains2, 2, ',', '.') . "</td>
								<td align='right'></td>
								</tr>";
					}
					echo "<tr><td colspan='11'>&nbsp;</td></tr>";

					$grand_realisasi1 += $row1['tot_realisasi1'];
					$grand_realisasi2 += $row1['tot_realisasi2'];
					$grand_realisasi3 += $tot_realisasi1_3;
					$grand_tax += $tot_tax1;
					$grand_remains += $remains1;

					$tot_progress1 += $progress1_1;
					$tot_progress2 += $progress1_2;
					$tot_progress3 += $progress1_3;
				}

				$average_progress1 = $tot_progress1 / $n_rows1;
				$average_progress2 = $tot_progress2 / $n_rows1;
				$average_progress3 = $tot_progress3 / $n_rows1;

				echo "<tr>
						<td colspan='2' align='center'><b>TOTAL HASIL PAJAK DAERAH</b></td>
						<td align='right'><b>" . number_format($grand_tax, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($grand_realisasi1, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($average_progress1, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($grand_realisasi2, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($average_progress2, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($grand_realisasi3, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($average_progress3, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($grand_remains, 0, ',', '.') . "</b></td>
						<td></td>
						</tr>";
				?>
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
</body>

</html>