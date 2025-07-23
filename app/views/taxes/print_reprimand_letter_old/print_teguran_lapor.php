<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | Surat Teguran</title>
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>report-style.css" />
	<style type="text/css">
		@import "<?= $this->config->item('css_path'); ?>report-table-style.css";
	</style>
	<style type="text/css">
		.card {
			width: 320px;
			float: left;
			margin-right: 5px;
			margin-bottom: 5px;
			padding: 10px;
			border: 1px solid #000;
		}

		table.card-content {
			width: 100%;
			border: none;
		}

		table.card-content td {
			font-size: 1.2em;
		}

		ol li {
			line-height: 20px;
		}
	</style>
</head>

<body>
	<div style="margin:10px;">

		<div style="border-bottom:1px solid #000;margin-bottom:5px;padding:5px;text-align:center;position:relative;">
			<img style="position:absolute;left:0;top:0" src="<?= $this->config->item('img_path'); ?>logo_pemda.png" width="5%" />
			<?php
			echo "<h1>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "</h1>
				<h2>" . strtoupper($system_params[2]) . "</h2>
				<p>" . $system_params[3] . " Telp. " . $system_params[4] . " Fax " . $system_params[5] . ", email : bapenda@blitarkab.go.id, website : bapenda.blitarkab.go.id<br />
				<b>" . strtoupper($system_params[19]) . "</b></p>";
			?>
		</div>

		<div>
			<table class="report noborder" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td align="center" width="50%">
							NPWPD
							<br /><br />
							(<?= $rows['npwprd']; ?>)<br />
							<br />
						</td>
						<td>
							<br />
							<table class="noborder">
								<tr>
									<td rowspan="4" valign="middle" align="right">Yth.</td>
									<td>Kepada</td>
								</tr>

								<tr>
									<td> <?= $rows['nama']; ?></td>
								</tr>
								<tr>
									<td></td>
								</tr>
								<tr>
									<td>di -</td>
								</tr>
								<tr>
									<td></td>
									<td><span style="margin-left:30px"><?= $system_params[19]; ?></span></td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="report noborder" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td align="center">
							<h1>Surat Teguran</h1>
						</td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td align="center">
							<h2>UNTUK MEMASUKKAN SPTPD</h2>
						</td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td>
							<p align="justify">
								Berdasarkan catatan kami, sampai dengan batas waktu pelaporan SPTPD (Surat Pemberitahuan Pajak Daerah) yaitu 15 (lima belas) hari kerja setelah masa pajak, Saudara belum melaporkan SPTPD kepada Bapenda Kabupaten Blitar. Maka bersama ini kami menghimbau agar Saudara segera menyerahkan laporan SPTPD dimaksud paling lambat 5 (lima ) hari setelah menerima surat ini.
								Apabila surat teguran ini tidak juga Saudara indahkan maka dapat dilaksanakan pemeriksaan lapangan dan / atau akan dilaksanakan penetapan besaran pajak daerah secara jabatan sesuai ketentuan perundang undangan.
							</p><br><br>
							<p align="justify">
								Berdasarkan Peraturan Bupati Nomor 80 tahun 2024 tentang Ketentuan Umum dan Tata Cara Pemungutan Pajak Barang dan Jasa Tertentu dan Pajak Mineral Bukan Logam dan Batuan <br>
								1. Pasal 27 ayat 1 bahwa wajib pajak Pajak Barang dan Jasa Tertentu dan Pajak Mineral Bukan Logam dan Batuan wajib mengisi SPTPD <br>
								2. Pasal 28 ayat 2 bahwa jangka waktu penyampaian SPTPD paling lama 15 (lima belas) hari kerja setelah berakhirnya masa pajak <br>
								3. Pasal 46 ayat 2 bahwa wajib pajak orang pribadi yang tidak melaksanakan kewajiban pelaporan SPTPD dikenakan sanksi administrative berupa denda sebesar Rp. 10.000,- (sepuluh ribu rupiah ) dengan STPD untuk tiap SPTPD <br>
								4. Pasal 46 ayat 3 bahwa wajib pajak badan usaha yang tidak melaksanakan kewajiban pelaporan SPTPD dikenakan sanksi administrative berupa denda sebesar Rp. 20.000,- (sepuluh ribu rupiah ) dengan STPD untuk tiap SPTPD
							</p><br><br>
							<p align="justify">
								Demikian untuk menjadi perhatian agar kewajiban Saudara dapat dipenuhi sebagaimana mestinya.
							</p>
						</td>
					</tr>
				</tbody>
				<br />
				<br />

			</table>
			<br />
			<br />
			<br />
			<table class="report noborder" cellspacing="0">
				<tr>
					<td class="nobor-top nobor-left">&nbsp;</td>
					<td width="30%" class="nobor-top nobor-left">
						<?php
						echo "Blitar, " . indo_date_format($tgl_cetak, 'longDate') ?> <br>
						KEPALA BADAN PENDAPATAN DAERAH<br />
						KABUPATEN BLITAR
						<br><br><br><br><br><br>
						<?php
						echo $system_params[10] . "<br />
							" . $system_params[11] . "<br />
							" . $system_params[12] . "&nbsp;";
						?>
					</td>
					<td width="5%" class="nobor-left nobor-top"></td>
				</tr>
			</table>
		</div>

	</div>
</body>

</html>