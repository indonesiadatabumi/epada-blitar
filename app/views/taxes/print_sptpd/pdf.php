<?php

$html = "<!DOCTYPE html><html>
	<head>
			<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Surat Pemberitahuan Tagihan Pajak Daerah</title>
			<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
			<style type='text/css'>@import " . $this->config->item('css_path') . "report-table-style.css</style>
			<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "sptpd-style.css'/>
				
	</head>
	<body>";

// $i = 0;

// $n_row = count($rows);

// foreach($rows as $row){
// 	$i++;

$html .= "<div style='margin:10px;'' >			
			
			<div style='border-bottom:1px solid #000;margin-bottom:5px;padding:5px;text-align:center;position:relative;'>
					<td><img src='" . $this->config->item('img_path') . "logo_pemda.png' style='width:42px;'/>
				<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "</h4>
				<h3>" . strtoupper($system_params[2]) . "</h3>
				<small>" . $system_params[3] . " Telp. " . $system_params[4] . " Fax " . $system_params[5] . "<br />
				<b>" . strtoupper($system_params[19]) . "</b></small>
				
			</div>

			<div style='border:1px solid #000'>
				<table class='report' cellpadding='0' cellspacing='0'>
					<tbody>
						<tr>
							<td align='center' width='100%''>
								SURAT PEMBERITAHUAN PAJAK DAERAH
								<br /><br />
								(SPTPD)<br />
								" . strtoupper($row['nama_pajak']) . "
								<br />
								<table class='noborder'>
									<tr><td width='25%'>Masa Pajak</td><td>: " . $tax_month . "</td></tr>
									<tr><td>Tahun Pajak</td><td>: " . $row['tahun_pajak'] . "</td></tr>
								</table>
							</td>
							<td>
								<br />
								<table class='noborder'>
									<tr>
										<td colspan='3' valign='right' align='right'>No Urut/Berkas :" . $row['nomor_spt'] . "</td>
									</tr>
									<tr>
										<td colspan='3' valign='right' align='right'>Nomor/Tgl Ijin :" . $row['tgl_proses'] . "</td>
									</tr>
									<tr>
										<td rowspan ='4' valign='middle' align='right'>Yth.</td>
										<td>Kepada</td>
									</tr>
									
									<tr><td>Kepala " . $system_params[1] . "</td></tr>
									<tr><td>" . $system_params[7] . " " . $system_params[6] . "</td></tr>
									<tr><td>di -</td></tr>
									<tr><td></td><td><span style='margin-left:30px'>" . $system_params[19] . "</span></td></tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table class='report' cellpadding='0' cellspacing='0'>
					<tbody>
						<tr>
							<td colspan='5' class='nobor-top'><b>Perhatian :</b></td>
						</tr>
						<tr>
							<td width='3%'>1.</td><td colspan='4' class='nobor-left'>Harap diisi dalam rangkap 2 dengan huruf cetak.</td>
						</tr>
						<tr>
							<td>2.</td><td colspan='4' class='nobor-left'>Beri tanda  <span style='border:1px solid '>&radic;&nbsp;</span>atau  <span style='border:1px solid '>&#32;&#32;&#88;&nbsp;</span> yang tersedia untuk jawaban yang diberikan.</td>
						</tr>
						<tr>
							<td>3.</td><td colspan='4' class='nobor-left'>Setelah diisi dan ditandatangani harap diserahkan kembali kepada Badan Pendapatan Daerah " . $system_params[7] . ' ' . $system_params[6] . " paling lambat tanggal 10 bulan berikutnya.</td>
						</tr>
						<tr>
							<td>4.</td><td colspan='4' class='nobor-left'>Keterlambatan penyerahan SPTPD dikenakan sanksi sesuai ketentuan yang berlaku.</td>							
						</tr>
						<tr>
							<td colspan='5'><b>I. Identitas Wajib Pajak :</b></td>
						</tr>
						<tr>							
							<tr><td>a.</td><td width='20%' class='nobor-left'>Nama Wajib Pajak</td><td colspan='3' class='nobor-left'>: " . $row['nama_pemilik'] . "</td></tr>
							<tr><td class='nobor-top'>b.</td><td class='nobor-left nobor-top'>Alamat</td><td colspan='3' class='nobor-left nobor-top'>: " . $row['alamat_pemilik'] . "</td></tr>
							<tr><td class='nobor-top'>c.</td><td class='nobor-left nobor-top'>Nama Objek/Usaha</td><td colspan='3' class='nobor-left nobor-top'>: " . $row['nama_wp'] . "</td></tr>
							<tr><td class='nobor-top'>d.</td><td class='nobor-left nobor-top'>Alamat</td><td colspan='3' class='nobor-left nobor-top'>: " . $row['alamat'] . "</td></tr>
							<tr><td class='nobor-top'>e.</td><td class='nobor-left nobor-top'>NPWPD</td><td colspan='3' class='nobor-left nobor-top'>: P.2." . $row['npwpd'] . "</td></tr>
						</tr>
						<tr>
							<td colspan='5'><b>II. Diisi Oleh Pengusaha :</b></td>
						</tr>

						
						<tr>	";
if ($row['pajak_id'] == '1') {
	$html .= "<tr>
								<td valign='top'>a.</td><td valign='top' class='nobor-left'>Klasifiksi Usaha</td>

								<td valign='top' class='nobor-left'>
								<ol type='1'>";
	foreach ($business_rows as $row2) {
		$html .= "<li style='font-weight:'" . ($row2['ref_kegus_id'] == $row['kegus_id'] ? 'bold' : 'normal') . "';'>'" . $row2['nama_kegus'] . "'</li>";
	}
	$html .= "</ol></td>
								<td colspan='6' valign='top' class='nobor-right'>Jumlah Kamar : '" . $row['jumlah_kamar'] . "'</td>
														
								
								
								</tr>";
} else if ($row['pajak_id'] == '2') {
	$html .= "<tr>
								<td valign='top'>a.</td><td valign='top' class='nobor-left'>Klasifiksi Usaha</td>

								<td valign='top' class='nobor-left'>
								<ol type='1'>";
	foreach ($business_rows as $row2) {
		$html .= "<li style='font-weight:'" . ($row2['ref_kegus_id'] == $row['kegus_id'] ? 'bold' : 'normal') . "';'>'" . $row2['nama_kegus'] . "'</li>";
	}
	$html .= "</ol></td>
								<td colspan='6' valign='top' class='nobor-right'>Jumlah Meja : '" . $row['jumlah_meja'] . "'
								<br><br>Jumlah Kursi : '" . $row['jumlah_kursi'] . "'</td>						
								
								
								</tr>";
} else if ($row['pajak_id'] == '4') {
	$html .= "<tr>
								<td valign='top'>a.</td><td valign='top' class='nobor-left'>Klasifiksi Usaha</td>

								<td valign='top' class='nobor-left'>
								<ol type='1'>";
	foreach ($business_rows as $row2) {
		$html .= "<li style='font-weight:'."($row2['ref_kegus_id'] == $row['kegus_id'] ? 'bold' : 'normal') . "';'>'" . $row2['nama_kegus'] . "'</li>";
	}
	$html .= "</ol></td>
								<td colspan='6' valign='top' class='nobor-right'>Jumlah Meja : 
								<br><br>Jumlah Kursi : </td>						
								
								
								</tr>";
} else if ($row['pajak_id'] == '5') {
	$html .= "<tr><td>a.</td><td colspan='4' class='nobor-left'>Penggunaan Tenaga Listrik Periode " . $tax_month . " '" . $row['tahun_pajak'] . "'</td></tr>
								<tr><td class='nobor-top'>&nbsp;</td>
								<td colspan='4' class='nobor-top nobor-left'>
								<table class='report' cellspacing='0'>									
									<tbody>
										<tr><td align='center'>Uraian</td><td align='center'>Penggunaan Daya (kwh)</td>
										<td align='center'>Harga Satuan/kwh</td><td align='center'>Nilai Jual (Rp.)</td></tr>
										<tr><td align='center'>1</td><td align='center'>2</td>
										<td align='center'>3</td><td align='center'>4 = (2x3)</td></tr>
										<tr>
										<td>'" . $row['nama_pemilik'] . "'</td>
										<td align='right'>'" . number_format($row['penggunaan_daya']) . "'</td>
										<td align='right'>'" . number_format($row['tarif_dasar']) . "'</td>
										<td align='right'>'" . number_format($row['nilai_terkena_pajak']) . "'</td>
										</tr>
									</tbody>
								</table>
								</td>
								</tr>";
} else if ($row['pajak_id'] == '6') {
	$html .= "<tr><td>a.</td><td colspan='4' class='nobor-left'>Penggunaan Mineral Bukan Logam dan Batuan</td></tr>
								<tr><td class='nobor-top'>&nbsp;</td>
								<td colspan='4' class='nobor-top nobor-left'>
								<table class='report' cellspacing='0'>
									<tbody>
										<tr><td align='center' colspan='2'>Jenis</td><td align='center'>Volume (m<sup>3</sup>)</td><td colspan='3' align='center'>Nilai Pasar (Rp.)</td><td align='center'>Nilai Jual (Rp.)</td></tr>";
	$no = 0;
	foreach ($mblb_rows as $row2) {
		$no++;
		$html .= "
											<tr>
											<td align='center'>'" . $no . "'</td>
											<td class='nobor-left'>'" . $row2['jenis_mblb'] . "'</td>
											<td align='right'>'" . number_format($row2['volume']) . "'</td>
											<td align='center'>x</td>
											<td align='right'>'" . number_format($row2['tarif_dasar']) . "'</td>
											<td align='center'>=</td>
											<td align='right'>'" . number_format($row2['nilai_jual']) . "'</td>
											</tr>";
	}
	$html .= "</tbody>
								</table>
								</td>
								</tr>";
}
$html .= "</tr>";

if ($row['pajak_id'] == '1') {
	$html .= "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Pembayaran Sewa Kamar</td><td width='4%'>Rp.</td><td width='20%' align='right' class='nobor-left'>'" . number_format($row['nilai_terkena_pajak']) . "'</td>
							</tr>
							<tr>
								<td>c.</td><td colspan='2' class='nobor-left'>Pembayaran Makan dan Minum</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>
							<tr>
								<td>d.</td><td colspan='2' class='nobor-left'>Pembayaran Fasilitas Lainnya</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>";
	$orderNumb = 'd';
} else if ($row['pajak_id'] == '2') {
	$html .= "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Pembayaran Makan dan Minuman</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>'" . number_format($row['nilai_terkena_pajak']) . "'</td>
							</tr>
							<tr>
								<td>c.</td><td colspan='2' class='nobor-left'>Pembayaran Lain-lain</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>";
	$orderNumb = 'c';
} else if ($row['pajak_id'] == '4') {
	$html .= "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Pembayaran Tiket Masuk</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>'" . number_format($row['nilai_terkena_pajak']) . "'</td>
							</tr>
							<tr>
								<td>c.</td><td colspan='2' class='nobor-left'>Pembayaran Lain-lain</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>";
	$orderNumb = 'c';
} else if ($row['pajak_id'] == '5') {
	$html .= "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Nilai Jual Tenaga Listrik</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>'" . number_format($row['nilai_terkena_pajak']) . "'</td>
							</tr>";
	$orderNumb = 'b';
} else if ($row['pajak_id'] == '6') {
	$html .= "
							<tr>
								<td>b.</td><td colspan='2' class='nobor-left'>Nilai Jual Mineral Bukan Logam dan Batuan</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>'" . number_format($row['nilai_terkena_pajak']) . "'</td>
							</tr>";
	$orderNumb = 'b';
}


$orderNumb++;
$html .= "<tr><td>'" . $orderNumb . "'</td><td colspan='2' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td>Rp.</td><td align='right' class='nobor-left'>'" . number_format($row['nilai_terkena_pajak']) . "'</td></tr>";
$orderNumb++;
$html .= "<tr><td>'" . $orderNumb . "'</td><td colspan='2' class='nobor-left'>Pajak Terutang ('" . $row['persen_tarif'] . "'% x DPP)</td><td>Rp.</td><td align='right' class='nobor-left'>'" . number_format($row['pajak']) . "'</td></tr>";
$orderNumb++;
$html .= "<tr><td>'" . $orderNumb . "'</td><td colspan='2' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td>Rp.</td><td align='right' class='nobor-left'>-</td></tr>";
$orderNumb++;
$html .= "<tr><td>'" . $orderNumb . "'</td><td colspan='2' class='nobor-left'>Sanksi Administrasi</td><td>Rp.</td><td align='right' class='nobor-left'>-</td></tr>";
$orderNumb++;
$html .= "<tr><td>'" . $orderNumb . "'</td><td colspan='2' class='nobor-left'>Jumlah Pajak yang Dibayar</td><td>Rp.</td><td align='right' class='nobor-left'>'" . number_format($row['pajak']) . "'</td></tr>";

$html .= "
						<tr>
							<td colspan='5'><b>III. Data Pendukung :</b></td>
						</tr>
						<tr>
							<td>a).</td><td colspan='2' class='nobor-left'>Surat Setoran Pajak Daerah (SSPD)</td><td colspan='2' align='center'><input type='checkbox' value='' ></input></td>
						</tr>";

if ($row['pajak_id'] == '1' or $row['pajak_id'] == '2' or $row['pajak_id'] == '4') {
	$html .= "							
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
	$html .= "
							<tr>
								<td>b).</td><td colspan='2' class='nobor-left'>Laporan Penggunaan Tenaga Listrik</td><td colspan='2' align='center'>Ada/Tidak ada</td>
							</tr>
							<tr>
								<td>c).</td><td colspan='2' class='nobor-left'>................................................</td><td colspan='2' align='center'><input type='checkbox' value='' ></input></td>
							</tr>";
} else if ($row['pajak_id'] == '6') {
	$html .= "
							<tr>
								<td>b).</td><td colspan='2' class='nobor-left'>Laporan Produksi</td><td colspan='2' align='center'>Ada/Tidak ada</td>
							</tr>
							<tr>
								<td>c).</td><td colspan='2' class='nobor-left'>................................................</td><td colspan='2' align='center'><input type='checkbox' value='' ></input></td>
							</tr>";
}
$html .= "
					</tbody>
				</table>
				<table class='report' cellspacing='0'>					
					<tr>
						<td width='3%'></td>
						<td colspan='3' class='nobor-left'>
							<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian formulir diisi dengan sebenar-benarnya dan 
								apabila terdapat ketidakbenaran dalam memenuhi kewajiban pengisian SPTPD ini, saya bersedia
								dikenakan sanksi-sanksi sesuai dengan Peraturan Daerah yang berlaku.</p>
								<br />
						</td>
						<td width='3%' class='nobor-left'></td>
					</tr>
					<tr>
					<td class='nobor-top'></td>
					<td width='30%' class='nobor-top nobor-left'>
						Diterima oleh Petugas,<br />
						Tanggal " . indo_date_format($curr_date, 'longDate') . "
						<br /><br /><br /><br />
						..............................................<br />
						Nip.						
					</td>
					<td class='nobor-top nobor-left'>&nbsp;</td>
					<td width='30%' class='nobor-top nobor-left'>";
$html .= "
						 " . $system_params[6] . ", " . indo_date_format($curr_date, 'longDate') . "<br />
						WP/Penanggung Pajak/Kuasa,
						<br /><br /><br /><br />" . $row['nama_pemilik'] . "<br />&nbsp;";
$html .= "
					</td>
					<td width='5%' class='nobor-left nobor-top'></td>
					</tr>					
				</table>
			</div>

		</div>

	
	</body></html>";
// $mpdf->AddPage();

$mpdf->WriteHTML($html);
$html = "";

// 			if($i==$n_row){
// 		$html .= "</body></html>";
// 	}

// 	if($i>1){
// 		$mpdf->AddPage();
// 	}

// 	$mpdf->WriteHTML($html);
// 	$html = "";
// }


$mpdf->SetTitle('Surat Pemberitahuan Tagihan Pajak Daerah' . strtoupper($tax_name));
$mpdf->Output('surat_pemberitahuan_tagihan_pajak_daerah.pdf', 'I');
