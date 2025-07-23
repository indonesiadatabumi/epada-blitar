<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekapitulasi Realisasi $tax_name.xls");
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | Daftar Rekapitulasi <?= strtoupper($tax_name); ?></title>
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
					<h3 align="center">DAFTAR REKAPITULASI <?= strtoupper($determination_name) . " DAN REALISASI " . strtoupper($tax_name); ?><br />
						<?= strtoupper($periode_desc); ?></h3>
				</td>
			</tr>
		</table>

		<table class="report" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td align="center" rowspan="2"><b>NO.</b></td>
					<td align="center" colspan="3"><b>WAJIB PAJAK</b></td>
					<td align="center" colspan="<?= ($determination_id == '8' ? '5' : '4'); ?>"><b><?= strtoupper($determination_name); ?></b></td>
					<td align="center" colspan="3"><b>STS</b></td>
					<td align="center" rowspan="2"><b>TUNGGAKAN (Rp.)</b></td>
				</tr>
				<tr>
					<td align="center"><b>NAMA WP</b></td>
					<td align="center"><b>NPWPD</b></td>
					<td align="center"><b>ALAMAT</b></td>
					<td align="center"><b>MASA PAJAK</b></td>
					<td align="center"><b>TANGGAL</b></td>
					<td align="center"><b>NOMOR</b></td>
					<?php
					if ($determination_id == '8') {
						echo "<td align='center'><b>OMZET (Rp.)</b></td>
								<td align='center'><b>PAJAK (Rp.)</b></td>";
					} else {
						echo "<td align='center'><b>KETETAPAN (Rp.)</b></td>";
					}
					?>
					<td align="center"><b>NOMOR</b></td>
					<td align="center"><b>TANGGAL</b></td>
					<td align="center" class="nobor-right"><b>SETORAN (Rp.)</b></td>
				</tr>
				<tr>
					<?php
					for ($i = 1; $i <= 7; $i++) {
						echo "<td align='center' class='nobor-bottom'><b>" . $i . "</b></td>";
					}
					$no = 0;
					if ($determination_id == '8') {
						echo "<td align='center' class='nobor-bottom'><b>8</b></td>
								<td align='center' class='nobor-bottom'><b>9</b></td>";
						$no = 9;
					} else {
						echo "<td align='center' class='nobor-bottom'><b>8</b></td>";
						$no = 8;
					}
					for ($i = 1; $i <= 4; $i++) {
						$no += $i;
						echo "<td align='center' class='nobor-bottom'><b>" . $no . "</b></td>";
					}
					$colspan = ($determination_id == '8' ? 19 : 18);
					?>
				</tr>
			</thead>
			<tbody>
				<?php
				$grand_tax = 0;
				$grand_payment = 0;
				$grand_arrears = 0;

				foreach ($rows1 as $row1) {

					echo "<tr>
							<td colspan='" . $colspan . "'><b>KECAMATAN " . strtoupper($row1['nama_kecamatan']) . "</b></td>
							</tr>";
					$no = 0;
					$total_tax = 0;
					$total_payment = 0;
					$total_arrears = 0;

					foreach ($rows2[$row1['kecamatan_id']] as $row2) {
						$no++;
						echo "<tr>
								<td align='center'>" . $no . "</td>
								<td>" . $row2['nama_wp'] . "</td>
								<td align='center'>P.2." . $row2['npwpd'] . "</td>
								<td>" . $row2['alamat'] . "</td>
								<td align='center'>" . get_monthName($row2['bulan_pajak']) . "</td><td align='center'>" . $row2['tgl_proses'] . "</td>
								<td align='center'>" . $row2['nomor_spt'] . "</td>";
						if ($determination_id == '8') {
							echo "<td align='right'>" . number_format($row2['nilai_terkena_pajak'], 0, ',', '.') . "</td>";
						}
						echo "<td align='right'>" . number_format($row2['pajak'], 0, ',', '.') . "</td>
								<td align='center'>" . $row2['no_urut_sts'] . "</td>
								<td align='center'>" . $row2['tgl_bayar'] . "</td>
								<td align='right'>" . number_format($row2['total_bayar'], 0, ',', '.') . "</td>";

						$arrears = abs($row2['total_bayar'] - $row2['pajak']);
						echo "<td align='right'>" . number_format($arrears, 0, ',', '.') . "</td>
								</tr>";

						$total_tax += $row2['pajak'];
						$total_payment += $row2['total_bayar'];
						$total_arrears += $arrears;
					}
					$grand_tax += $total_tax;
					$grand_payment += $total_payment;
					$grand_arrears += $total_arrears;

					echo "
							<tr>
								<td colspan='" . ($determination_id == '8' ? 8 : 7) . "' align='center'><b>TOTAL</b></td>
								<td align='right'><b>" . number_format($total_tax, 0, ',', '.') . "</b></td><td colspan='2'></td>
								<td align='right'><b>" . number_format($total_payment, 0, ',', '.') . "</b></td>
								<td align='right'><b>" . number_format($total_arrears, 0, ',', '.') . "</b></td>
							</tr>";
				}
				echo "
							<tr>
								<td colspan='" . ($determination_id == '8' ? 8 : 7) . "' align='center'><b>GRAND TOTAL</b></td>
								<td align='right'><b>" . number_format($grand_tax, 0, ',', '.') . "</b></td><td colspan='2'></td>
								<td align='right'><b>" . number_format($grand_payment, 0, ',', '.') . "</b></td>
								<td align='right'><b>" . number_format($grand_arrears, 0, ',', '.') . "</b></td>
							</tr>";

				?>
			</tbody>
			<tfoot>
			</tfoot>
		</table>


	</div>
</body>

</html>