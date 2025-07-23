<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | Daftar SPTPD <?= strtoupper($tax_name); ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>report-style.css" />
	<style type="text/css">
		@import "<?= $this->config->item('css_path'); ?>report-table-style.css";
	</style>
</head>

<body>
	<div style="margin:10px;">
		<table border=0 width="100%">
			<tr>
				<td width="30%">
					<div style="float:left;margin-right:10px;">
						<img src="<?= $this->config->item('img_path'); ?>logo_pemda.png" style="width:48px;" />
					</div>
					<div style="float:left">
						<?php echo "<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "<br />
							" . strtoupper($system_params[2]) . "<br />
							<font style='font-weight:normal'>" . $system_params[3] . "</font><br />
							<font style='font-weight:normal'>Telp. " . $system_params[4] . ", email : bapenda@blitarkab.go.id, website : bapenda.blitarkab.go.id</font>
							</h4>";
						?>
					</div>
					<div style="clear:both"></div>
				</td>
				<td width="40%">
					<h3 align="center"><u>DAFTAR SPTPD <?= strtoupper($tax_name); ?></u><br />
						<?php
						if ($search_type == '1') {
							echo "<font style='font-weight:normal'>TAHUN : " . $header_attr['tax_year'] . "</font><br />
								<font style='font-weight:normal'>MASA PAJAK : " . get_monthName($header_attr['tax_period']) . "</font>";
						} else {

							echo "<font style='font-weight:normal'>" . $header_attr['date_period'] . "</font>";
							if (!empty($header_attr['district'])) {
								echo "<br /><font style='font-weight:normal'>" . $header_attr['district'] . "</font>";
							}
						}
						?>
					</h3><br />
				</td>
				<td>
				</td>
			</tr>
		</table>

		<?php
		if ($search_type == '1' and count($district_row) > 0) {
			echo "<div style='margin-top:5px;'>Kecamatan : " . $district_row['nama_kecamatan'] . "</div>";
		}
		?>
		<table class="report" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th rowspan="2">No.</th>
					<th colspan="2">SPTPD</th>
					<th rowspan="2">Wajib Pajak/Pemilik</th>
					<th rowspan="2">Alamat</th>
					<th rowspan="2">NPWPD</th>
					<th rowspan="2">Masa Pajak</th>
					<th rowspan="2">Tarif (%)</th>
					<th rowspan="2">Omzet (Rp.)</th>
					<th rowspan="2">Pajak</th>
				</tr>
				<tr>
					<th>Tanggal</th>
					<th style="border-right:none">No. Urut</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$total1 = 0;
				$total2 = 0;
				foreach ($rows as $row) {
					$no++;
					if ($search_type == '1') {
						$masa_pajak = get_monthName($header_attr['tax_period']) . ' ' . $header_attr['tax_year'];
					} else {
						$x_date = explode('-', $row['masa_pajak1']);
						$masa_pajak = get_monthName($x_date[1]) . ' ' . $x_date[2];
					}
					$total1 += $row['nilai_terkena_pajak'];
					$total2 += $row['pajak'];
					echo "<tr>
								<td align='center'>" . $no . "</td>
								<td align='center' align='center'>" . $row['tgl_proses'] . "</td>
								<td align='center'>" . $row['nomor_spt'] . "</td>
								<td>" . $row['nama'] . "</td>
								<td>" . $row['alamat'] . "</td>
								<td align='center'>" . $row['npwprd'] . "</td>
								<td align='center'>" . $masa_pajak . "</td>
								<td align='right'>" . $row['persen_tarif'] . "</td>
								<td align='right'>" . (!empty($row['nilai_terkena_pajak']) ? number_format($row['nilai_terkena_pajak']) : '') . "</td>
								<td align='right'>" . (!empty($row['pajak']) ? number_format($row['pajak']) : '') . "</td>
							</tr>";
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="8" align="right"><b>TOTAL : </b></td>
					<td align="right"><b><?= number_format($total1); ?></b></td>
					<td align="right"><b><?= number_format($total2); ?></b></td>
				</tr>
			</tfoot>
		</table><br /><br />

		<table border=0 width="100%">
			<tr>
				<td align="center">
					Mengetahui<br />
					<?php
					if (count($legalitator_row) > 0) {
						echo $legalitator_row['nama_jabatan'] . "
								<br /><br /><br /><br /><br />
								<b><u>" . $legalitator_row['nama'] . "</u></b>
								<br />" . $legalitator_row['pangkat'] . "
								<br />NIP. " . $legalitator_row['nip'];
					}
					?>
				</td>
				<td align="center">
					Diperiksa Oleh<br />
					<?php
					if (count($evaluator_row) > 0) {
						echo $evaluator_row['nama_jabatan'] . "
								<br /><br /><br /><br /><br />
								<b><u>" . $evaluator_row['nama'] . "</u></b>
								<br />" . $evaluator_row['pangkat'] . "
								<br />NIP. " . $evaluator_row['nip'];
					}
					?>
				</td>
				<td>
					<br />
					<?php
					echo $system_params[6] . ", " . indo_date_format($print_date, 'longDate');
					echo "
						<table>
							<tr><td>Nama</td><td>: " . $this->session->userdata('fullname') . "</td></tr>
							<tr><td>Jabatan</td><td>: " . $this->session->userdata('fullname') . "</td></tr>
							<tr><td colspan='2'>&nbsp;<br /><br /><br /></td></tr>
							<tr><td>Tanda Tangan</td><td>:</td></tr>
						</table>";
					?>
				</td>
			</tr>
		</table>
	</div>
</body>

</html>