<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | LHP</title>
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>report-style.css" />
	<style type="text/css">
		@import "<?= $this->config->item('css_path'); ?>report-table-style.css";
	</style>
</head>

<body>
	<div class="container">
		<div class="row">
			<div style="border-bottom:1px solid #000;margin-bottom:5px;padding:5px;text-align:center;position:relative;">
				<img style="position:absolute;left:0;top:0" src="<?= $this->config->item('img_path'); ?>logo_pemda.png" width="48px" />
				<?php
				echo "<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "</h4>
				<h3>" . strtoupper($system_params[2]) . "</h3>
				<small>" . $system_params[3] . "<br /> Telp. " . $system_params[4] . " Fax " . $system_params[5] . ", email : bapenda@blitarkab.go.id, website : bapenda.blitarkab.go.id<br />
				<b>" . strtoupper($system_params[19]) . "</b></small>";
				?>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p style="text-align: center;"><b><u>LAPORAN HASIL PEMERIKSAAN</u></b></p>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p style="text-align: center;"><b><?= $row['keterangan'] ?></b></p>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p style="text-align: center;">Nomor : <?= $row['no_pemeriksaan'] ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p>Berdasarkan pemeriksaan kantor dan di lapangan, sesuai surat tugas:</p>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p>Nomor : <?= $row['no_pemeriksaan'] ?> Tanggal <?= $row['tgl_pemeriksaan'] ?> telah dilakukan pemeriksaan di kantor dapat diuraikan sebagai berikut:</p>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<table class="noborder" width="100%">
					<tbody>
						<tr>
							<td width="2%"><b>I</b></td>
							<td width="20%"><b>UMUM</b></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td>1. Npwpd</td>
							<td>: <?= $row['npwprd'] ?></td>
						</tr>
						<tr>
							<td></td>
							<td>2. Nama Wajib Pajak</td>
							<td>: <?= $row['nama_pemilik'] ?></td>
						</tr>
						<tr>
							<td></td>
							<td>3. Jenis Pajak</td>
							<td>: <?= $row['nama_paret'] ?></td>
						</tr>
						<tr>
							<td></td>
							<td>4. Alamat Objek Pajak</td>
							<td>: <?= $row['alamat'] ?></td>
						</tr>
						<tr>
							<td width="2%"><b>II</b></td>
							<td width="20%"><b>DASAR HUKUM</b></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2">1. Undang - undang 28 Tahun 2009 tentang Pajak Daerah dan Retribusi Daerah</td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2">2. Peraturan Daerah Kabupaten Blitar 2 Tahun 2017 tentang Pajak Daerah sebagaimana diubah dengan Perda No. 7 Tahun 2020</td>
						</tr>
						<tr>
							<td width="2%"><b>III</b></td>
							<td colspan="2"><b>HASIL PEMERIKSAAN</b></td>
						</tr>
						<tr>
							<td></td>
							<?php if (isset($row['hasil_pemeriksaan'])) : ?>
								<td colspan="2"><?= $row['hasil_pemeriksaan'] ?></td>
							<?php endif ?>
						</tr>
						<tr>
							<td width="2%"><b>IV</b></td>
							<td width="20%"><b>KESIMPULAN</b></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<?php if (isset($row['kesimpulan'])) : ?>
								<td colspan="2"><?= $row['kesimpulan'] ?></td>
							<?php endif ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<br>
		<br>
		<div class="row">
			<div class="col">
				<table cellspacing="0">
					<tr>
						<td class="nobor-top"></td>
						<td width="30%" class="nobor-top nobor-left" style="text-align: center;">
							Petugas Peneliti II
							<br /><br /><br /><br />
							<p><b>ZUNAIDI, S.Sos. MM</b></p>
							<p style="text-align: center;">Penata</p>
							<p>NIP. 19760105 200312 1 007</p>
						</td>
						<td class="nobor-top nobor-left">&nbsp;</td>
						<td width="30%" class="nobor-top nobor-left">
							<?php
							echo $system_params[6] . ", " . indo_date_format(date('Y-m-d'), 'longDate');
							?>
							<br />
							<p style="text-align: center;">Petugas Peneliti I</p>
							<br /><br /><br />
							<p style="text-align: center;"><b>ASMADI</b></p>
							<p style="text-align: center;">Penata Muda Tk. I</p>
							<p style="text-align: center;">NIP. 196404301992101001</p>
						</td>
						<td width="5%" class="nobor-left nobor-top"></td>
					</tr>
					<tr>
						<td colspan="5" style="text-align: center;"><br />Mengetahui,</td>
					</tr>
					<tr>
						<td colspan="2" width="30%" class="nobor-top nobor-left" style="text-align: center;">
							<p style="text-align: center;">Plt. Kepala Badan Pendapatan Daerah Kabupaten Blitar</p>
							<br /><br /><br />
							<p style="text-align: center;"><b>Drs. MAHADHIN C.U., MM</b></p>
							<p style="text-align: center;">Pembina Utama Muda</p>
							<p style="text-align: center;">NIP. 19621201 199003 1 009</p>
						</td>
						<td width="30%" class="nobor-top nobor-left" style="text-align: center;">
							<p style="text-align: center;">Kepala Bidang Penagihan dan Keberatan</p>
							<br /><br /><br />
							<p style="text-align: center;"><b>SUHARIANTO, S.Sos, MM</b></p>
							<p style="text-align: center;">Pembina</p>
							<p style="text-align: center;">NIP. 19691007 199603 1 005</p>
						</td>
						<td width="30%" class="nobor-top nobor-left" style="text-align: center;">
							<p style="text-align: center;">KASUBID PEMERIKSAAN</p>
							<br /><br /><br />
							<p style="text-align: center;"><b>IMAM ASYROFI, S.Sos,MM</b></p>
							<p style="text-align: center;">Pembina</p>
							<p style="text-align: center;">NIP. 19720309 199303 1 007</p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
<script>
	window.print();
</script>

</html>