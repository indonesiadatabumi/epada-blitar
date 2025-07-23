<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | SPTPD</title>
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
			font-size: 0.9em;
		}

		ol li {
			line-height: 20px;
		}
	</style>
</head>

<body>
	<div style="margin:10px;">

		<div style="border-bottom:1px solid #000;margin-bottom:5px;padding:5px;text-align:center;position:relative;">
			<img style="position:absolute;left:0;top:0" src="<?= $this->config->item('img_path'); ?>logo_pemda.png" width="48px" />
			<?php
			echo "<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "</h4>
				<h3>" . strtoupper($system_params[2]) . "</h3>
				<small>" . $system_params[3] . " Telp. " . $system_params[4] . " Fax " . $system_params[5] . ", email : bapenda@blitarkab.go.id, website : bapenda.blitarkab.go.id<br />
				<b>" . strtoupper($system_params[19]) . "</b></small>";
			?>
		</div>

		<div style="border:1px solid #000">
			<table class="report" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td align="center" width="50%">
							SURAT PEMBERITAHUAN PAJAK DAERAH
							<br /><br />
							(SPTPD)<br />
							<?= strtoupper($row['nama_pajak']); ?>
							<br />
							<table class="noborder">
								<tr>
									<td width="25%">Masa Pajak</td>
									<td>: <?= indo_date_format($row['masa_pajak1'], 'longDate'); ?> - <?= indo_date_format($row['masa_pajak2'], 'longDate'); ?></td>
								</tr>
								<tr>
									<td>Tahun Pajak</td>
									<td>: <?= $row['tahun_pajak']; ?></td>
								</tr>
							</table>
						</td>
						<td>
							<br />
							<table class="noborder">
								<tr>
									<td colspan="3" valign="right" align="right">No Urut/Berkas :<?= $row['nomor_spt']; ?></td>
								</tr>
								<tr>
									<td rowspan="4" valign="middle" align="right">Yth.</td>
									<td>Kepada</td>
								</tr>

								<tr>
									<td>Kepala <?= $system_params[1]; ?></td>
								</tr>
								<tr>
									<td><?= $system_params[7] . " " . $system_params[6]; ?></td>
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
			<table class="report" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td colspan="5" class="nobor-top"><b>Perhatian :</b></td>
					</tr>
					<tr>
						<td width="1%">1.</td>
						<td colspan="4" class="nobor-left">Harap diisi dalam rangkap 2 dengan huruf cetak.</td>
					</tr>
					<tr>
						<td>2.</td>
						<td colspan="4" class="nobor-left">Beri tanda <span style="border:1px solid ">&radic;&nbsp;</span>atau <span style="border:1px solid ">&#32;&#32;&#88;&nbsp;</span> yang tersedia untuk jawaban yang diberikan.</td>
					</tr>
					<tr>
						<td>3.</td>
						<td colspan="4" class="nobor-left">Setelah diisi dan ditandatangani harap diserahkan kembali kepada Badan Pendapatan Daerah <?= $system_params[7] . " " . $system_params[6]; ?> paling lambat tanggal 10 bulan berikutnya.</td>
					</tr>
					<tr>
						<td>4.</td>
						<td colspan="4" class="nobor-left">Keterlambatan penyerahan SPTPD dikenakan sanksi sesuai ketentuan yang berlaku.</td>
					</tr>
					<tr>
						<td colspan="5"><b>I. Identitas Wajib Pajak :</b></td>
					</tr>
					<tr>
					<tr>
						<td>a.</td>
						<td width="20%" class="nobor-left">Nama Wajib Pajak</td>
						<td colspan="3" class="nobor-left">: <?= $row['nama_pemilik']; ?></td>
					</tr>
					<tr>
						<td class="nobor-top">b.</td>
						<td class="nobor-left nobor-top">Alamat</td>
						<td colspan="3" class="nobor-left nobor-top">: <?= $row['alamat_pemilik']; ?></td>
					</tr>
					<tr>
						<td class="nobor-top">c.</td>
						<td class="nobor-left nobor-top">Nama Objek/Usaha</td>
						<td colspan="3" class="nobor-left nobor-top">: <?= $row['nama_wp']; ?></td>
					</tr>
					<tr>
						<td class="nobor-top">d.</td>
						<td class="nobor-left nobor-top">Alamat</td>
						<td colspan="3" class="nobor-left nobor-top">: <?= $row['alamat']; ?></td>
					</tr>
					<tr>
						<td class="nobor-top">e.</td>
						<td class="nobor-left nobor-top">NPWPD</td>
						<td colspan="3" class="nobor-left nobor-top">: P.2.<?= $row['npwpd']; ?></td>
					</tr>
					<tr>
						<td class="nobor-top">f.
						</td>
						<td class="nobor-left nobor-top">Nomor Ijin Usaha</td>
						<td colspan="3" class="nobor-left nobor-top">: <?= $row['ijin_usaha'] ?></td>
					</tr>
					<tr>
						<td class="nobor-top">g.
						</td>
						<td class="nobor-left nobor-top">Kode Billing</td>
						<td colspan="3" class="nobor-left nobor-top">: 3505<?= $kode_pajak['rek_bank'] ?><?= $row['kode_billing'] ?></td>
					</tr>

					</tr>
					<tr>
						<td colspan="5"><b>II. Diisi Oleh Pengusaha :</b></td>
					</tr>
					<?php
					echo "
						<tr>";
					if ($row['pajak_id'] == '1') {
						echo "<tr>
								<td valign='top'>a.</td><td valign='top' class='nobor-left'>Klasifiksi Usaha</td>

								<td valign='top' class='nobor-left'>
								<ol type='1'>";
						foreach ($business_rows as $row2) {
							echo "<li style='font-weight:" . ($row2['ref_kegus_id'] == $row['kegus_id'] ? 'bold' : 'normal') . ";'>" . $row2['nama_kegus'] . "</li>";
						}
						echo "</ol></td>
								<td colspan='6' valign='top' class='nobor-right'>Jumlah Kamar : " . $row['jumlah_kamar'] . "</td>
														
								
								
								</tr>";
					} else if ($row['pajak_id'] == '2') {
						echo "<tr>
								<td valign='top'>a.</td><td valign='top' class='nobor-left'>Klasifiksi Usaha</td>

								<td valign='top' class='nobor-left'>
								<ol type='1'>";
						foreach ($business_rows as $row2) {
							echo "<li style='font-weight:" . ($row2['ref_kegus_id'] == $row['kegus_id'] ? 'bold' : 'normal') . ";'>" . $row2['nama_kegus'] . "</li>";
						}
						echo "</ol></td>
								<td colspan='6' valign='top' class='nobor-right'>Jumlah Meja : " . $row['jumlah_meja'] . "
								<br><br>Jumlah Kursi : " . $row['jumlah_kursi'] . "</td>						
								
								
								</tr>";
					} else if ($row['pajak_id'] == '4') {
						echo "<tr>
								<td valign='top'>a.</td><td valign='top' class='nobor-left'>Klasifiksi Usaha</td>

								<td valign='top' class='nobor-left'>
								<ol type='1'>";
						foreach ($business_rows as $row2) {
							echo "<li style='font-weight:" . ($row2['ref_kegus_id'] == $row['kegus_id'] ? 'bold' : 'normal') . ";'>" . $row2['nama_kegus'] . "</li>";
						}
						echo "</ol></td>			
								</tr>";
					} else if ($row['pajak_id'] == '11') {
						echo "<tr>
								<td valign='top'>a.</td><td valign='top' class='nobor-left'>Klasifiksi Usaha</td>

								<td valign='top' class='nobor-left'>
								<ol type='1'>";
						foreach ($business_rows as $row2) {
							echo "<li style='font-weight:" . ($row2['ref_kegus_id'] == $row['kegus_id'] ? 'bold' : 'normal') . ";'>" . $row2['nama_kegus'] . "</li>";
						}
						echo "</ol></td>
								<td colspan='6' valign='top' class='nobor-right'>Roda Empat : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/Hari
								<br><br>Roda Dua : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/Hari</td>			
								</tr>";
					} else if ($row['pajak_id'] == '5') {
						echo "<tr><td>a.</td><td colspan='4' class='nobor-left'>Penggunaan Tenaga Listrik Periode " . $tax_month . " " . $row['tahun_pajak'] . "</td></tr>
								<tr><td class='nobor-top'>&nbsp;</td>
								<td colspan='4' class='nobor-top nobor-left'>
								<table class='report' cellspacing='0'>									
									<tbody>
										<tr><td align='center'>Uraian</td><td align='center'>Penggunaan Daya (kwh)</td>
										<td align='center'>Harga Satuan/kwh</td><td align='center'>Nilai Jual (Rp.)</td></tr>
										<tr><td align='center'>1</td><td align='center'>2</td>
										<td align='center'>3</td><td align='center'>4 = (2x3)</td></tr>
										<tr>
										<td>" . $row['nama_pemilik'] . "</td>
										<td align='right'>" . number_format($row['penggunaan_daya'], 0, '.', ',') . "</td>
										<td align='right'>" . number_format($row['tarif_dasar'], 0, '.', ',') . "</td>
										<td align='right'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td>
										</tr>
									</tbody>
								</table>
								</td>
								</tr>";
					} else if ($row['pajak_id'] == '6') {
						echo "<tr><td>a.</td><td colspan='4' class='nobor-left'>Penggunaan Mineral Bukan Logam dan Batuan</td></tr>
								<tr><td class='nobor-top'>&nbsp;</td>
								<td colspan='4' class='nobor-top nobor-left'>
								<table class='report' cellspacing='0'>
									<tbody>
										<tr><td align='center' colspan='2'>Jenis</td><td align='center'>Volume</td><td colspan='3' align='center'>Nilai Pasar (Rp.)</td><td align='center'>Nilai Jual (Rp.)</td></tr>";
						$no = 0;
						foreach ($mblb_rows as $row2) {
							$no++;
							echo "
											<tr>
											<td align='center'>" . $no . "</td>
											<td class='nobor-left'>" . $row2['jenis_mblb'] . "</td>
											<td align='right'>" . number_format($row2['volume'], 0, '.', ',') . "</td>
											<td align='center'>x</td>
											<td align='right'>" . number_format($row2['tarif_dasar'], 0, '.', ',') . "</td>
											<td align='center'>=</td>
											<td align='right'>" . number_format($row2['nilai_jual'], 0, '.', ',') . "</td>
											</tr>";
						}
						echo "</tbody>
								</table>
								</td>
								</tr>";
					}
					echo "</tr>";

					if ($row['pajak_id'] == '1') {
						echo "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Pembayaran Sewa Kamar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td>
							</tr>
							<tr>
								<td>c.</td><td colspan='2' class='nobor-left'>Pembayaran Makan dan Minum</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>
							<tr>
								<td>d.</td><td colspan='2' class='nobor-left'>Pembayaran Fasilitas Lainnya</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>";
						$orderNumb = "d";
					} else if ($row['pajak_id'] == '2') {
						echo "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Pembayaran Makan dan Minuman</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td>
							</tr>
							<tr>
								<td>c.</td><td colspan='2' class='nobor-left'>Pembayaran Lain-lain</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>";
						$orderNumb = "c";
					} else if ($row['pajak_id'] == '4') {
						echo "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Pembayaran Tiket Masuk</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td>
							</tr>
							<tr>
								<td>c.</td><td colspan='2' class='nobor-left'>Pembayaran Lain-lain</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>";
						$orderNumb = "c";
					} else if ($row['pajak_id'] == '5') {
						echo "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Nilai Jual Tenaga Listrik</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td>
							</tr>";
						$orderNumb = "b";
					} else if ($row['pajak_id'] == '6') {
						echo "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Nilai Jual Mineral Bukan Logam dan Batuan</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td>
							</tr>";
						$orderNumb = "b";
					} else if ($row['pajak_id'] == '11') {
						echo "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Nilai Omset Parkir</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td>
							</tr>";
						$orderNumb = "b";
					} else if ($row['pajak_id'] == '14') {

						$orderNumb = "";
					}

					$orderNumb++;

					if ($row['pajak_id'] == '6') {
						$pajak = (20/100)*$row['nilai_terkena_pajak'];
						$opsen_mblb = (25/100)*$pajak;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td>Rp.</td><td align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td></tr>";
						$orderNumb++;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Pajak Terutang (20% x DPP)</td><td>Rp.</td><td align='right' class='nobor-left'>" . number_format($pajak, 0, '.', ',') . "</td></tr>";
						$orderNumb++;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Opsen MBLB (25% x Pajak Terhutang)</td><td>Rp.</td><td align='right' class='nobor-left'>" . number_format($opsen_mblb, 0, '.', ',') . "</td></tr>";
						$orderNumb++;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td>Rp.</td><td align='right' class='nobor-left'>-</td></tr>";
						$orderNumb++;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Sanksi Administrasi</td><td>Rp.</td><td align='right' class='nobor-left'>-</td></tr>";
						$orderNumb++;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Jumlah Pajak yang Dibayar</td><td>Rp.</td><td align='right' class='nobor-left'>" . number_format($row['pajak'], 0, '.', ',') . "</td></tr>";
					}else{
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td>Rp.</td><td align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td></tr>";
						$orderNumb++;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Pajak Terutang (" . $row['persen_tarif'] . "% x DPP)</td><td>Rp.</td><td align='right' class='nobor-left'>" . number_format($row['pajak'], 0, '.', ',') . "</td></tr>";
						$orderNumb++;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td>Rp.</td><td align='right' class='nobor-left'>-</td></tr>";
						$orderNumb++;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Sanksi Administrasi</td><td>Rp.</td><td align='right' class='nobor-left'>-</td></tr>";
						$orderNumb++;
						echo "<tr><td>" . $orderNumb . "</td><td colspan='2' class='nobor-left'>Jumlah Pajak yang Dibayar</td><td>Rp.</td><td align='right' class='nobor-left'>" . number_format($row['pajak'], 0, '.', ',') . "</td></tr>";
					}
					?>

					<tr>
						<td colspan="5"><b>III. Data Pendukung :</b></td>
					</tr>
					<tr>
						<td>a).</td>
						<td colspan="2" class="nobor-left">Surat Setoran Pajak Daerah (SSPD)</td>
						<td colspan="2" align="center"><input type='checkbox' value=''></input></td>
					</tr>
					<?php
					if ($row['pajak_id'] == '1' or $row['pajak_id'] == '2' or $row['pajak_id'] == '4' or $row['pajak_id'] == '11') {
						echo "							
							<tr>
								<td>b).</td><td colspan='2' class='nobor-left'>Rekapitulasi Penjualan/Omzet</td><td colspan='2' align='center'><input type='checkbox' value=''> </input></td>
							</tr>
							<tr>
								<td>c).</td><td colspan='2' class='nobor-left'>Rekapitulasi Penggunaan Bon/Bill</td><td colspan='2' align='center'><input type='checkbox' value='' ></input></td>
							</tr>
							<tr>
								<td>d).</td><td colspan='2' class='nobor-left'>Jumlah Harian</td><td colspan='2' align='center'><input type='checkbox' value='' ></input></td>
							</tr>
							<tr>
								<td>e).</td><td colspan='2' class='nobor-left'>................................................</td><td colspan='2' align='center'><input type='checkbox' value='' ></input></td>
							</tr>";
					} else if ($row['pajak_id'] == '5') {
						echo "
							<tr>
								<td>b).</td><td colspan='2' class='nobor-left'>Laporan Penggunaan Tenaga Listrik</td><td colspan='2' align='center'><input type='checkbox' value='' ></td>
							</tr>
							<tr>
								<td>c).</td><td colspan='2' class='nobor-left'>................................................</td><td colspan='2' align='center'><input type='checkbox' value='' ></input></td>
							</tr>";
					} else if ($row['pajak_id'] == '6') {
						echo "
							<tr>
								<td>b).</td><td colspan='2' class='nobor-left'>Laporan Produksi</td><td colspan='2' align='center'><input type='checkbox' value='' ></td>
							</tr>
							<tr>
								<td>c).</td><td colspan='2' class='nobor-left'>................................................</td><td colspan='2' align='center'><input type='checkbox' value='' ></input></td>
							</tr>";
					}
					?>
				</tbody>
			</table>
			<table class="report" cellspacing="0">
				<tr>
					<td width="3%"></td>
					<td colspan="3" class="nobor-left">
						<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian formulir diisi dengan sebenar-benarnya dan
							apabila terdapat ketidakbenaran dalam memenuhi kewajiban pengisian SPTPD ini, saya bersedia
							dikenakan sanksi-sanksi sesuai dengan Peraturan Daerah yang berlaku.</p>
						<br />
					</td>
					<td width="3%" class="nobor-left"></td>
				</tr>
				<tr>
					<td class="nobor-top"></td>
					<td width="30%" class="nobor-top nobor-left">
						Diterima oleh Petugas,<br />
						Tanggal
						<br /><br /><br /><br />
						..............................................<br />
						Nip.
					</td>
					<td class="nobor-top nobor-left">&nbsp;</td>
					<td width="30%" class="nobor-top nobor-left">
						<?php
						echo $system_params[6] . ", " . indo_date_format($tgl_cetak, 'longDate') . "<br />
						WP/Penanggung Pajak/Kuasa,
						<br /><br /><br /><br />" . $row['nama_pemilik'] . "<br />&nbsp;";
						?>
					</td>
					<td width="5%" class="nobor-left nobor-top"></td>
				</tr>
			</table>
		</div>

	</div>
</body>

</html>