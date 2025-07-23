<?php
$html = "<!DOCTYPE html><html><head>
			<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Surat Ketetapan Pajak Daerah Kurang Bayar</title>
			<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
			<style type='text/css'>@import " . $this->config->item('css_path') . "report-table-style.css</style>
			</head>
			<body>";

$i = 0;

$n_row = count($rows);

foreach ($rows as $row) {
	$i++;
	$x_date = explode('-', $row['masa_pajak1']);
	$tax_period = get_monthName($x_date[1]);
	$html .= "
				<table cellpadding=0 cellspacing=0 class='report'>
				<tr>
				<td>
					<table class='noborder'>
					<tr>
					<td><img src='" . $this->config->item('logo_path') . "logo_pemda.png' style='width:42px;'/>
					</td>
					<td>			
					<h6>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "<br />
					" . strtoupper($system_params[2]) . "<br />
					<font style='font-weight:normal'>" . $system_params[3] . "</font><br />
					<font style='font-weight:normal'>Telp. " . $system_params[4] . "</font><br />
					<font style='font-weight:normal'>email : bapenda@blitarkab.go.id</font><br />
					<font style='font-weight:normal'>website : bapenda.blitarkab.go.id</font>
					<font style='font-weight:normal'>" . $system_params[6] . "</font>
					</h6>
					</td></tr></table>
				</td>
				<td align='center' width='42%'>
					<h4>" . $row['singkatan_spt'] . "<br />
					<font style='font-weight:normal;font-size:" . ($spt_type_id == '15' ? '0.7em' : '0.9em') . "'>(" . $row['keterangan_spt'] . ")</font><br />
					</h4><br />
				</td>
				<td class='bor-right' align='center' width='10%'>
					No. Urut<br />" . sprintf('%0' . $system_params[16] . 's', $row['kohir']) . "
				</td>
				</tr>";


	$html .= "<tr>
				<td colspan='3' class='bor-right'>
					<table class='noborder nopadding'>
						<tr><td style='font-size:12px'>Nama</td><td style='font-size:12px'>: " . $row['nama_wp'] . "</td></tr>
						<tr><td style='font-size:12px'>Alamat</td><td style='font-size:12px'>: " . $row['alamat'] . ", Kel. " . $row['kelurahan'] . "</td></tr>
						<tr><td style='font-size:12px'>NPWPD</td><td style='font-size:12px'>: P.2." . $row['npwpd'] . "</td></tr>
						<tr><td style='font-size:12px'>Masa Pajak</td><td style='font-size:12px'>: " . indo_date_format($row['masa_pajak1'], 'longDate') . " - " . indo_date_format($row['masa_pajak2'], 'longDate') . " </td></tr>
						<tr><td style='font-size:12px'>Tgl. Jatuh Tempo</td><td style='font-size:12px'>: " . indo_date_format($row['tgl_jatuh_tempo'], 'longDate') . "</td></tr>
						<tr><td style='font-size:12px'>Kode Billing</td><td style='font-size:12px'>: 3505" . $kode_pajak['rek_bank'] . $row['kode_billing'] . "</td></tr>
					</table>
				</td>
			</tr>";

	$tot_credit = $row['kompensasi'] + $row['setoran'] + $row['kredit_pajak_lain'];
	$insufficient_pay = $row['pajak_terhutang'] - $tot_credit;
	$tot_sanctions = $row['bunga'] + $row['diskon'];
	$tot_payment = $insufficient_pay + $tot_sanctions;
	$leb_pay = $row['setoran'] - $row['pajak_terhutang'];
	if ($spt_type_id != '3') {
		// $html .= "<tr>
		// 			<td colspan='3' class='bor-right'>
		// 				<table class='noborder nopadding' style='font-size:0.9em!important'>
		// 					<tr>
		// 						<td valign='top' width='2%' style='font-size:12px'>I.</td><td valign='top' colspan='2' style='font-size:12px'>Berdasarkan Pasal 170 Undang-Undang No. 28 Tahun 2009 telah dilakukan pemeriksaan atau keterangan lain atas pelaksanaan kewajiban:</td>
		// 					</tr>";

		$html .= "<tr>
					<td colspan='3' class='bor-right'>
						<table class='noborder nopadding' style='font-size:0.9em!important'>
							<tr>
								<td valign='top' width='2%' style='font-size:12px'>I.</td><td valign='top' colspan='2' style='font-size:12px'>Berdasarkan pasal 37 peraturan bupati Blitar Nomor 80 tahun 2024 tentang ketentuan umum dan tata cara pemungutan pajak barang dan jasa tertentu dan pajak mineral bukan logam dan batuan telah dilakukan pemeriksaan atau keterangan lain atas pelaksanaan kewajiban :</td>
							</tr>";
	} else {
		$html .= "<tr>
					<td colspan='3' class='bor-right'>
						<table class='noborder nopadding' style='font-size:0.9em!important'>
							<tr>
								<td valign='top' width='2%' style='font-size:12px'>I.</td><td valign='top' colspan='2' style='font-size:12px'>Berdasarkan Pasal 100 dan Pasal 101 Undang-Undang No. 28 Tahun 2009 telah dilakukan pemeriksaan atau keterangan lain atas pelaksanaan kewajiban:</td>
							</tr>";
	}

	$html .= "<tr>
				<td></td>
				<td width='25%' style='font-size:12px'>Kode Rekening</td><td style='font-size:12px'>: " . $row['kode_rekening'] . "</td>
			</tr>
			<tr>
				<td></td>
				<td style='font-size:12px'>Nama Pajak</td><td style='font-size:12px'>: " . $row['nama_pajak'] . "</td>
			</tr>";

	if ($spt_type_id == '12') {
		$html .= "<tr>
						<td valign='top' width='2%' style='font-size:12px'>II.</td><td valign='top' colspan='2' style='font-size:12px'>Dan pemeriksaan atau keterangan lain tersebut di atas, perhitungan jumlah kelebihan bayar adalah sebagai berikut : </td></tr>
							<tr>
								<td></td>";
	} else {
		$html .= "<tr>
						<td valign='top' width='2%' style='font-size:12px'>II.</td><td valign='top' colspan='2' style='font-size:12px'>Dan pemeriksaan atau keterangan lain tersebut di atas, perhitungan jumlah yang masih harus dibayar adalah sebagai berikut : </td></tr>
							<tr>
								<td></td>";
	}

	$html .= "<td colspan='2'>
				<table class='noborder nopadding'>";

	if ($spt_type_id != '3') {
		$html .= "
							<tr>
								<td style='font-size:12px'>1.</td>
								<td colspan='3' style='font-size:12px'>Dasar Pengenaan</td>
								<td width='5%' style='font-size:12px'>Rp.</td>
								<td align='right' width='14%' style='font-size:12px'>" . number_format($row['nilai_terkena_pajak']) . "</td>
							</tr>
							<tr>
								<td style='font-size:12px'>2.</td>
								<td colspan='3' style='font-size:12px'>Pajak yang terhutang</td>
								<td style='font-size:12px'>Rp.</td><td align='right' style='font-size:12px'>" . number_format($row['pajak_terhutang']) . "</td>
							</tr>
							<tr>
								<td style='font-size:12px'>3.</td>
								<td colspan='5' style='font-size:12px'>Kredit Pajak :</td>
							</tr>
							<tr>
								<td colspan='6'></td>
							</tr>
							<tr>
								<td></td>
								<td style='font-size:12px'>a. Kompensasi kelebihan dari tahun sebelumnya</td>
								<td colspan='2'></td>
								<td style='font-size:12px'>Rp.</td>
								<td align='right' style='font-size:12px'>" . number_format($row['kompensasi']) . "</td>
							</tr>
							<tr>
								<td></td>
								<td style='font-size:12px'>b. Setoran yang dilakukan</td>
								<td colspan='2'></td>
								<td style='font-size:12px'>Rp.</td>
								<td align='right' style='font-size:12px'>" . number_format($row['setoran']) . "</td>
							</tr>
							<tr>
								<td></td>
								<td style='font-size:12px'>c. Lain-lain</td>
								<td colspan='2'></td>
								<td style='font-size:12px'>Rp.</td>
								<td align='right' style='font-size:12px'>" . number_format($row['kredit_pajak_lain']) . "</td>
							</tr>
							<tr>
								<td></td>
								<td style='font-size:12px'>d. Jumlah yang dapat dikreditkan (a+b+c)/ Total </td>
								<td colspan='2' ></td>
								<td style='font-size:12px'>Rp.</td>
								<td align='right' style='font-size:12px'>" . number_format($tot_credit) . "</td>
							</tr>";
	} else {
		$html .= "
							<tr>
								<td style='font-size:12px'>1.</td>
								<td colspan='3' style='font-size:12px'>Pajak belum bayar</td>
								<td style='font-size:12px'>Rp.</td><td align='right' style='font-size:12px'>" . number_format($insufficient_pay) . "</td>
							</tr>";
	}

	if ($spt_type_id == '3') {
		$html .= "<tr>
					<td style='font-size:12px'>2.</td>
					<td colspan='5' style='font-size:12px'>Sanksi Administrasi :</td>
				</tr>
				<tr>
					<td colspan='6'></td>
				</tr>
				<tr>
					<td></td>
					<td style='font-size:12px'>a. Bunga/DENDA</td>
					<td></td>
					<td></td>
				 	<td style='font-size:12px'>Rp.</td>
					<td align='right' style='font-size:12px'>" . number_format($row['bunga']) . "</td>
					<td colspan='2'></td>
				</tr>
				<tr>
					<td colspan='3'></td>
					<td></td><td colspan='2' class='bor-bottom'></td>
				</tr>
				<tr>
					<td style='font-size:12px'>3.</td>
					<td colspan='3' style='font-size:12px'>Jumlah yang masih harus dibayar (1+2a)</td>
					<td style='font-size:12px'>Rp.</td><td align='right' style='font-size:12px'>" . number_format($tot_payment) . "</td>
				</tr>";
	} elseif ($spt_type_id == '12') {
		$html .= "<tr>
					<td colspan='4'></td>
					<td colspan='2' class='bor-bottom'></td>
				</tr>
				<tr>
					<td style='font-size:12px'>4.</td>
					<td colspan='3' style='font-size:12px'>Jumlah kelebihan pembayaran Pokok Pajak (2-3d)</td>
					<td style='font-size:12px'>Rp.</td><td align='right' style='font-size:12px'>" . number_format($leb_pay) . "</td>
				</tr>
				<tr>
					<td style='font-size:12px'>5.</td>
					<td colspan='3' style='font-size:12px'>Jumlah yang dikembalikan/kompensasi (3-2c)</td>
					<td style='font-size:12px'>Rp.</td><td align='right' style='font-size:12px'>" . number_format($leb_pay) . "</td>
				</tr>";
	} elseif ($spt_type_id == '14') {
		$html .= "<tr>
					<td style='font-size:12px'>4.</td>
					<td colspan='3' style='font-size:12px'>Jumlah yang masih harus dibayar (2-3d)</td>
					<td style='font-size:12px'>Rp.</td>
					<td align='right' style='font-size:12px'>" . number_format($tot_payment) . "</td>
				</tr>";
	} else {
		$html .= "<tr>
					<td colspan='4'></td><td colspan='2' class='bor-bottom'></td>
				</tr>
				<tr>
					<td style='font-size:12px'>4.</td>
					<td colspan='3' style='font-size:12px'>Jumlah kekurangan pembayaran Pokok Pajak (2-3d)</td>
					<td style='font-size:12px'>Rp.</td>
					<td align='right' style='font-size:12px'>" . number_format($insufficient_pay) . "</td>
				</tr>
				<tr>
					<td style='font-size:12px'>5.</td>
					<td colspan='5' style='font-size:12px'>Sanksi Administrasi :</td>
				</tr>
				<tr>
					<td colspan='6'></td>
				</tr>
				<tr>
					<td></td>
					<td style='font-size:12px'>a. Bunga/DENDA</td>
					<td colspan='2'></td>
				 	<td style='font-size:12px'>Rp.</td><td align='right' style='font-size:12px'>" . number_format($row['bunga']) . "</td>
				</tr>
				<tr>
					<td></td>
					<td style='font-size:12px'>b. Kenaikan</td>
					<td colspan='2'></td>
				 	<td style='font-size:12px'>Rp.</td>
					<td align='right' style='font-size:12px'>" . number_format($row['diskon']) . "</td>
				</tr>
				<tr>
					<td></td>
					<td style='font-size:12px'>c. Jumlah sanksi administrasi (a+b)</td>
					<td colspan='2' ></td>
					<td style='font-size:12px'>Rp.</td>
					<td align='right' style='font-size:12px'>" . number_format($tot_sanctions) . "</td>
				</tr>
				<tr>
					<td colspan='4'></td>
					<td colspan='2' class='bor-bottom'></td>
				</tr>
				<tr>
					<td style='font-size:12px'>6.</td>
					<td colspan='3' style='font-size:12px'>Jumlah yang masih harus dibayar (4+5c)</td>
					<td style='font-size:12px'>Rp.</td>
					<td align='right' style='font-size:12px'>" . number_format($tot_payment) . "</td>
				</tr>";
	}

	$html .= "</table>
						</td>
						</tr>";

	if ($spt_type_id != '12') {
		$html .= "<tr>
					<td colspan='3'>
						<table class='noborder' style='font-size:0.9em'>
							<tr>
								<td align='right' >Dengan huruf :</td>
								<td style='border:1px solid #000'>" . ($tot_payment > 0 ? ucwords(NumToWords($tot_payment)) . " Rupiah" : "NIHIL") . "</td>
							</tr>
						</table>
					</td>
				</tr>";
	} else {
		$html .= "<tr>
					<td colspan='3'>
						<table class='noborder' style='font-size:0.9em'>
							<tr>
								<td align='right'>Dengan huruf :</td>
								<td style='border:1px solid #000'>" . ($leb_pay > 0 ? ucwords(NumToWords($leb_pay)) . " Rupiah" : "NIHIL") . "</td>
							</tr>
						</table>
					</td>
				</tr>";
	}

	$html .= "</table>
			</td>
			</tr>";

	if ($spt_type_id != '14') {
		$html .= "<tr>
					<td colspan='3' class='bor-right'>
						<h5><u>PERHATIAN :</u></h5>
						<table class='noborder nopadding' style='font-size:0.8em'>";
		if ($spt_type_id != '12') {
			$html .= "<tr>
						<td valign='top'>1.</td>
						<td valign='top'>Harap penyetoran dilakukan melalui Bendahara Penerimaan atau Kas Daerah dengan menggunakan Surat Setoran Pajak Daerah (SSPD).</td>
					</tr>
					<tr>
						<td valign='top'>2.</td>
						<td valign='top'>Apabila " . $row['singkatan_spt'] . " ini tidak atau Kurang Dibayar setelah lewat paling lama 1 bulan sejak " . $row['singkatan_spt'] . " ini diterbitkan dikenakan sanksi administrasi beruba bunga sebesar 1% per bulan.</td>
					</tr>";
		} else {
			$html .= "<tr>
						<td valign='top'>1.</td>
						<td valign='top'>Pengembalian kelebihan pajak dilakukan pada Kas Daerah dengan menggunakan Surat Perintah Membayar Kelebihan Pajak (SPMKP) dan Surat Perintah Mengeluarkan Uang (SPMU).</td>
					</tr>";
		}

		$html .= "</table>
				</td>
				</tr>";
	}

	$html .= "<tr>
				<td colspan='3' style='font-size:0.9em' class='bor-right bor-bottom'>
					<table class='noborder'>
					<tr>
					<td align='center'>Scan Me <br>
						<img src='" . $this->config->item('img_path') . "barcode_payment_blitar.png'/>
					</td>
					<td width='40%' align='center' style='font-size:12px'>
						" . $system_params[6] . ", " . indo_date_format($row['tgl_penetapan'], 'longDate') . "<br />
						Kepala " . $system_params[2] . "<br />
						" . $legalitator_row['nama_jabatan'] . "<br /><br /><br /><br />
						<b><u>" . $legalitator_row['nama'] . "</u></b>
						<br />" . $legalitator_row['pangkat'] . "
						<br />NIP. " . $legalitator_row['nip'] . "
					</td>
					</tr>
					</table>
				</td>
				</tr>
				</table>
				<p style='font-style:italic;font-size:0.8em;margin-bottom:10px;'>" . str_repeat(".", 88) . " potong di sini " . str_repeat(".", 88) . "</p>
				<table class='report' cellpadding='0' cellspacing='0'>
				<tr>
				<td class='bor-right bor-bottom'>
					<table class='noborder nopadding smallfont'>
						<tr><td align='center'>No. " . $row['singkatan_spt'] . " : " . sprintf('%0' . $system_params[16] . 's', $row['kohir']) . "</td></tr>
						<tr><td align='center'><b>TANDA TERIMA</b></td></tr>
					</table>
					<table class='noborder nopadding smallfont'>
						<tr><td>NPWPD</td><td>: P.2." . $row['npwpd'] . "</td></tr>
						<tr><td>Nama</td><td>: " . $row['nama_wp'] . "</td></tr>
						<tr><td>Alamat</td><td>: " . $row['alamat'] . ", Kel. " . $row['kelurahan'] . ", Kec. " . $row['kecamatan'] . "</td></tr>
						<tr><td>Masa Pajak</td><td>: " . indo_date_format($row['masa_pajak1'], 'longDate') . " - " . indo_date_format($row['masa_pajak2'], 'longDate') . "</td></tr>
						<tr><td>Nominal</td><td>: " . number_format($tot_payment, 0, '.', ',') . "</td></tr>
					</table>
					<table class='noborder nopadding smallfont'>
					<tr><td width='75%'>&nbsp;</td><td align='center'>
					" . str_repeat('.', 20) . " Tahun ......<br />
					Yang menerima<br /><br /><br />
					(" . str_repeat('.', 30) . ")
					</td></tr>
					</table>
				</td>
				</tr>";

	$html .= "</table>";

	if ($i == $n_row) {
		$html .= "</body></html>";
	}

	if ($i > 1) {
		$mpdf->AddPage();
	}

	$mpdf->WriteHTML($html);
	$html = "";
}

$mpdf->SetTitle('Surat Ketetapan Pajak Daerah' . strtoupper($tax_name));
$mpdf->Output('surat_ketetapan_pajak_daerah_kurang_bayar.pdf', 'I');
?>
<!-- Jumlah yang dikembalikan/ dikomponesasikan
	Jumlah kelebihan bayar 
	Jumlah yang 