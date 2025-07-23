<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | Daftar Wajib Pajak Tutup</title>
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
					<h3 align="center"><u>DAFTAR WAJIB PAJAK TUTUP</u><br />
						<font style="font-weight:normal">
							<?php
							echo $tax_name;
							if ($zone_searched) {
								echo " Kec. " . strtolower($district_row['nama_kecamatan']);
							}
							?>
						</font><br />
						<font style="font-weight:normal"><?= $date_period; ?></font>
					</h3><br />
				</td>
				<td>
				</td>
			</tr>
		</table>


		<table class="report" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>No.</th>
					<th>NPWPD</th>
					<th>Nama</th>
					<th>Kegiatan Usaha</th>
					<th>Alamat Lengkap</th>
					<th>Tgl. Tutup</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 0;
				foreach ($rows as $row) {
					$no++;
					echo "<tr>
								<td align='center'>" . $no . "</td>
								<td align='center'>" . $row['npwprd'] . "</td>
								<td>" . $row['nama'] . "</td>
								<td>" . $row['nama_kegus'] . "</td>
								<td>" . $row['alamat'] . "</td>
								<td align='center'>" . $row['tgl_tutup'] . "</td>																
							</tr>";
				}
				?>
			</tbody>
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
			</tr>
		</table>
	</div>
</body>

</html>