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
						<td colspan="4" align="center">
							<h1>Surat Teguran</h1>
						</td>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td colspan="4" align="center">
							<h2>UNTUK MELAKUKAN PEMBAYARAN PAJAK DAERAH</h2>
						</td>
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
						<td colspan="4"></td>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td style="width: 10%;">
							Berdasarkan :
						</td>
						<td colspan="3">
							<input type="checkbox"> Surat Tagihan Pajak Daerah
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3">
							<input type="checkbox"> Surat Ketetapan Pajak Daerah Kurang Bayar
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3">
							<input type="checkbox"> Surat Ketetapan Pajak Daerah Kurang Bayar Tambahan
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3">
							<input type="checkbox"> SK Pembetulan
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3">
							<input type="checkbox"> SK Keberatan
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3">
							<input type="checkbox"> Putusan Banding
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3">
							<input type="checkbox"> Putusan Peninjauan Kembali
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<p align="justify">
								<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->Sampai dengan saat ini, Saudara belum melakukan pembayaran Pajak Daerah terhutang kepada Bapenda Kab. Blitar. Maka dengan ini kami minta agar Saudara segera melakukan pembayaran melalui Bank yang ditunjuk, paling lambat 21 hari setelah menerima surat ini.
							</p><br><br>
							<p align="justify">
								<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->Apabila Surat Teguran ini tidak juga Saudara indahkan, maka dapat diterbitkan Surat Paksa sesuai ketentuan perundang-undangan.
							</p><br><br>
							<p align="justify">
								<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->Demikian untuk menjadi perhatian, agar kewajiban Saudara dapat dipenuhi sebagaimana mestinya.
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
						<br><br><br><br>
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