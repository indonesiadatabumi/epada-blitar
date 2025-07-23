<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan Penerimaan $tax_name.xls");
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | Laporan Penerimaan</title>
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
					<h3 align="center">LAPORAN PENERIMAAN <?= strtoupper($tax_name); ?><br />
						<font style="font-weight:normal"><?= $periode_desc; ?></font>
					</h3><br />
				</td>
			</tr>
			<tr>
				<td>
					<?php
					if (count($judul_kegus) > 0) {
						echo "Kegiatan Usaha: " . $judul_kegus['nama_kegus'];
					}
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
					if (count($judul_kecamatan) > 0) {
						echo "Kecamatan: " . $judul_kecamatan['nama_kecamatan'];
					}
					?>
				</td>
			</tr>

		</table>


		<table class="report" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>NO.</th>
					<th>NO. STS</th>
					<th>TGL. SETORAN</th>
					<th>NAMA WP</th>
					<th>N.P.W.P.D</th>
					<?php
					if (count($judul_kegus) > 0) {
						if ($judul_kegus['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
							echo "<th>Nama Pelapor</th>";
						}
					}
					?>
					<th>MASA PAJAK</th>
					<th>POKOK PAJAK (Rp.)</th>
					<th>DENDA (Rp.)</th>
					<th>JUMLAH (Rp.)</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$total_pokok_pajak = 0;
				$total_denda = 0;
				$total = 0;
				foreach ($rows as $row) {
					$no++;
					if (count($judul_kegus) > 0) {
						if ($judul_kegus['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
							echo "<tr>
								<td align='center'>" . $no . "</td>
								<td align='center'>" . $row['no_urut_sts'] . "</td>								
								<td align='center'>" . indo_date_format($row['tgl_bayar'], 'shortDate') . "</td>
								<td>" . $row['nama_wp'] . "</td>
								<td align='center'>P.2." . $row['npwpd'] . "</td>
								<td>" . $row['created_by'] . "</td>
								<td align='center'>" . get_monthName($row['bulan_pajak']) . " " . $row['tahun_pajak'] . "</td>
								<td align='right'>" . number_format($row['pokok_pajak'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['denda'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>
							</tr>";
						} else {
							echo "<tr>
								<td align='center'>" . $no . "</td>
								<td align='center'>" . $row['no_urut_sts'] . "</td>								
								<td align='center'>" . indo_date_format($row['tgl_bayar'], 'shortDate') . "</td>
								<td>" . $row['nama_wp'] . "</td>
								<td align='center'>P.2." . $row['npwpd'] . "</td>
								<td align='center'>" . get_monthName($row['bulan_pajak']) . " " . $row['tahun_pajak'] . "</td>
								<td align='right'>" . number_format($row['pokok_pajak'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['denda'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>
							</tr>";
						}
					} else {
						echo "<tr>
								<td align='center'>" . $no . "</td>
								<td align='center'>" . $row['no_urut_sts'] . "</td>								
								<td align='center'>" . indo_date_format($row['tgl_bayar'], 'shortDate') . "</td>
								<td>" . $row['nama_wp'] . "</td>
								<td align='center'>P.2." . $row['npwpd'] . "</td>
								<td align='center'>" . get_monthName($row['bulan_pajak']) . " " . $row['tahun_pajak'] . "</td>
								<td align='right'>" . number_format($row['pokok_pajak'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['denda'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>
							</tr>";
					}

					$total_pokok_pajak += $row['pokok_pajak'];
					$total_denda += $row['denda'];
					$total += $row['total_bayar'];
				}
				?>
			</tbody>
			<tfoot>
				<?php
				if (count($judul_kegus) > 0) {
					if ($judul_kegus['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
						echo "<tr>
					<td colspan='7' align='center'><b>JUMLAH</b></td>
					<td align='right'><b>" . number_format($total_pokok_pajak, 0, ',', '.') . "</b></td>
					<td align='right'><b>" . number_format($total_denda, 0, ',', '.') . "</b></td>
					<td align='right'><b>" . number_format($total, 0, ',', '.') . "</b></td>
				</tr>";
					} else {
						echo "<tr>
					<td colspan='6' align='center'><b>JUMLAH</b></td>
					<td align='right'><b>" . number_format($total_pokok_pajak, 0, ',', '.') . "</b></td>
					<td align='right'><b>" . number_format($total_denda, 0, ',', '.') . "</b></td>
					<td align='right'><b>" . number_format($total, 0, ',', '.') . "</b></td>
				</tr>";
					}
				} else {
					echo "<tr>
					<td colspan='6' align='center'><b>JUMLAH</b></td>
					<td align='right'><b>" . number_format($total_pokok_pajak, 0, ',', '.') . "</b></td>
					<td align='right'><b>" . number_format($total_denda, 0, ',', '.') . "</b></td>
					<td align='right'><b>" . number_format($total, 0, ',', '.') . "</b></td>
				</tr>";
				}

				?>

			</tfoot>
		</table><br /><br />
		<?php
		echo "
			<table border=0 width='100%'>
				<tr>
					<td align='center' valign='top' width='50%'>";
		if ($show_signature) {
			if (count($legalitator_row) > 0) {
				echo "&nbsp;<br />
							Mengetahui,<br />";
				echo $legalitator_row['nama_jabatan'] . "
								<br /><br /><br /><br /><br />
								<b><u>" . $legalitator_row['nama'] . "</u></b>								
								<br />NIP. " . $legalitator_row['nip'];
			}
		}
		echo "</td>
					<td align='center' valign='top' width='50%'>
						<p>" . $system_params[6] . ", " . indo_date_format($tgl_cetak, 'longDate') . "</p><br /><br />";
		// if ($show_signature) {
		// 	echo "BENDAHARA PENERIMAAN 
		// 					<br />
		// 					<br />
		// 					<br />
		// 					<br />
		// 					<br />								
		// 					<b><u>" . strtoupper($treasurer_official_row['nama']) . "</u></b><br />
		// 					NIP. : " . $treasurer_official_row['nip'] . "<br />";
		// }
		if ($show_signature) {
			echo "BENDAHARA PENERIMAAN 
							<br />
							<br />
							<br />
							<br />
							<br />								
							<b><u>SEGER</u></b><br />
							NIP. : 19751115 201407 1 002<br />";
		}
		echo "</td>
				</tr>
			</table>";
		?>
	</div>
</body>

</html>