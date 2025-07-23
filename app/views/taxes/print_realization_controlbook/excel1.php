<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Realisasi $tax_name.xls");
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | Realisasi <?= strtoupper($tax_name); ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>report-style.css" />
	<style type="text/css">
		@import "<?= $this->config->item('css_path'); ?>report-table-style.css";
	</style>
</head>

<body>
	<div style="margin:10px;">
		<table border=0 width="100%">
			<tr>
				<td width="40%">
					<h3>REALISASI <?= strtoupper($tax_name); ?></h3>
				</td>
			</tr>
		</table>

		<table class="report" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td align="center" rowspan="2"><b>NO.</b></td>
					<td align="center" rowspan="2"><b>NAMA</b></td>
					<td align="center" rowspan="2"><b>NPWPD</b></td>
					<?php
					$district_total = array();
					$grand_total = array();

					$diff_month = 0;
					for ($i = 1; $i <= $diff_tax_periode + 1; $i++) {
						$times = mktime(0, 0, 0, $month1 + $diff_month, 1, $year1);
						$month_name = get_monthName(date('m', $times));
						echo "<td colspan='3' align='center'><b>" . $month_name . " " . date('Y', $times) . "</b></td>";
						$grand_total[$diff_month] = 0;
						$diff_month++;
					}

					echo "</tr>";
					echo "<tr>";
					for ($i = 1; $i <= $diff_tax_periode + 1; $i++) {
						echo "<td align='center' class='nobor-bottom'><b>MP</b></td>
							<td align='center' class='nobor-bottom'><b>Tgl.</b></td>
							<td align='center' class='nobor-bottom'><b>Rp.</b></td>";
					}

					echo "</tr>";

					$colspan = 3 + (($diff_tax_periode + 1) * 3);
					?>
			</thead>
			<tbody>
				<?php
				foreach ($rows1 as $row1) {
					echo "<tr>
								<td colspan='" . $colspan . "'><b>KECAMATAN " . strtoupper($row1['nama_kecamatan']) . "</b></td>
							</tr>";
					$no = 0;
					if (isset($rows2[$row1['kecamatan_id']])) {
						foreach ($rows2[$row1['kecamatan_id']] as $row2) {
							// if (isset($row2['kelurahan'])) {
							// 	echo "<tr>
							// 	<td colspan='" . $colspan . "'><b>KELURAHAN " . strtoupper($row2['kelurahan']) . "</b></td>
							// </tr>";
							// }
							$no++;
							echo "<tr>
									<td align='center'>" . $no . "</td>
									<td>" . $row2['nama_wp'] . "</td>
									<td align='center'>P.2." . $row2['npwprd'] . "</td>";

							$diff_month = 0;
							$district_total = array();
							$total = 0;
							for ($j = 1; $j <= $diff_tax_periode + 1; $j++) {
								$times = mktime(0, 0, 0, $month1 + $diff_month, 1, $year1);
								$month = date('m', $times);
								$year = date('Y', $times);
								if ($diff_tax_periode == 0) {
									$sql = "SELECT to_char(masa_pajak1,'mm/yy') as masa_pajak,to_char(tgl_bayar,'dd/mm/yy') as tgl_bayar,
												total_bayar FROM transaksi_pajak WHERE wp_wr_detil_id='" . $row2['wp_wr_detil_id'] . "' AND 
												tgl_bayar BETWEEN '" . $masa_pajak1 . "' AND '" . $masa_pajak2 . "' AND jenis_spt_id='" . $determination_type . "'";

									$row3 = $dao->execute(0, $sql)->row_array();
								} else {
									$sql = "SELECT to_char(masa_pajak1,'mm/yy') as masa_pajak,to_char(tgl_bayar,'dd/mm/yy') as tgl_bayar,
												total_bayar FROM transaksi_pajak WHERE wp_wr_detil_id='" . $row2['wp_wr_detil_id'] . "' AND 
												to_char(masa_pajak1,'mm-yyyy')='" . $month . "-" . $year . "' AND jenis_spt_id='" . $determination_type . "'";

									$row3 = $dao->execute(0, $sql)->row_array();
								}

								$tax_period = '';
								$tax_payment = '';
								$total_tax = '';
								if (is_array($row3)) {
									$tax_period = $row3['masa_pajak'];
									$tax_payment = $row3['tgl_bayar'];
									$total_tax = number_format($row3['total_bayar'], 0, ',', '.');
									if (isset($district_total[$diff_month])) {
										$district_total[$diff_month] += $row3['total_bayar'];
									} else {
										$district_total[$diff_month] = $row3['total_bayar'];
									}
									$grand_total[$diff_month] += $row3['total_bayar'];
								}

								echo "<td align='center'>" . $tax_period . "</td>
										<td align='center'>" . $tax_payment . "</td>
										<td align='right'>" . $total_tax . "</td>";
								$diff_month++;
							}
							echo "</tr>";
						}
						// echo "
						// 		<tr>
						// 		<td colspan='3' align='center'><b>TOTAL</b></td>";
						// $diff_month = 0;
						// for ($j = 1; $j <= $diff_tax_periode + 1; $j++) {
						// 	$total = (isset($district_total[$diff_month]) ? $district_total[$diff_month] : 0);
						// 	echo "<td></td><td></td>
						// 			<td align='right'><b>" . number_format($total, 0, ',', '.') . "</b></td>";
						// 	$grand_total[$diff_month] += $total;
						// 	$diff_month++;
						// }
						// echo "</tr>";
					}
				}
				echo "<tr>
								<td colspan='3' align='center'><b>TOTAL</b></td>";
				$diff_month = 0;
				for ($j = 1; $j <= $diff_tax_periode + 1; $j++) {
					echo "<td></td><td></td>
									<td align='right'><b>" . number_format($grand_total[$diff_month], 0, ',', '.') . "</b></td>";
					$diff_month++;
				}
				echo "</tr>";
				?>
			</tbody>
			<tfoot>
			</tfoot>
		</table>


	</div>
</body>

</html>