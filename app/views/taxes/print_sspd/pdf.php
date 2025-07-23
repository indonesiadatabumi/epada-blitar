<?php

$html = "<!DOCTYPE html>
	<html>
	<head>
		<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . "| SSPD</title>
		<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
		<style type='text/css'>@import '" . $this->config->item('css_path') . "report-table-style.css'</style>
		<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "sspd-style.css'/>
		</head>
	<body>";
$html .= "
		<div style='margin:10px;'>
			<div style='border:1px solid #000;margin-bottom:5px;'>
				<table class='report' cellspacing='0'>
					<tbody>
						<tr>
							<td width='50%' class='nobor-top nobor-left'>
								<table class='noborder'>
									<tr>
										<td><img src='" . $this->config->item('img_path') . "logo_pemda.png' style='width:48px;'/></td>
										<td>";
$html .= "<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "</h4>
											<h5>" . strtoupper($system_params[2]) . "<br />
											<font style='font-weight:normal'>" . $system_params[3] . "</font><br />
											<font style='font-weight:normal'>Telp. " . $system_params[4] . "</font><br />
											<font style='font-weight:normal'>email : bapenda@blitarkab.go.id</font><br />
											<font style='font-weight:normal'>website : bapenda.blitarkab.go.id</font>
											</h5>";
$html .= "
										</td>
									</tr>
								</table>
							</td>
							<td class='nobor-top nobor-right'>
								<table class='noborder'>
									<tr><td><b>No. Seri : " . $row['spt_id'] . "</b></td>
									<td><b>No. Urut : " . $row['nomor_spt'] . "</b></td>
									</tr>
									<tr>
										<td align='center'>
											<h1 style='font-family:times'>S S P D</h1>
											<h4>(SURAT SETORAN PAJAK DAERAH)<br />TAHUN " . date('Y') . "</h4>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>";
$html .= "
				<table class='noborder'>
					<tr><td>Nama</td><td colspan='2'>: " . $row['nama_wp'] . "</td></tr>
					<tr><td>Alamat</td><td colspan='2'>: " . $row['alamat'] . "</td></tr>
					<tr><td>NPWPD</td><td colspan='2'>: P.2." . $row['npwpd'] . "</td></tr>
					<tr>
					<td colspan='2' valign='top'>Menyetor berdasarkan *)</td>
					<td>
						<table class='noborder' cellspacing='2'>
							<tr>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '1' ? 'checked' : '') . ">SKPD
								</td>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '3' ? 'checked' : '') . ">STPD
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '99' ? 'checked' : '') . ">Lain-Lain
								</td>
							</tr>
							<tr>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '2' ? 'checked' : '') . ">SKPDT
								</td>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '8' ? 'checked' : '') . ">SPTPD
								<td>									
								</td>
							</tr>
							<tr>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '11' ? 'checked' : '') . ">SKPDKB
								</td>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '16' ? 'checked' : '') . ">SK Pembulatan
								<td></td>
							</tr>
							<tr>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '15' ? 'checked' : '') . ">SKPDKBT
								</td>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '17' ? 'checked' : '') . ">SK Keberatan
								<td></td>
							</tr>
						</table>
					</td>	
					</tr>
				</table>
				<table class='report' cellspacing='0'>
					<tbody>
						<tr>
							<td align='center' class='nobor-left'>No.</td>
							<td align='center'>Rekening</td>
							<td align='center'>Jenis Pajak</td>
							<td align='center'>Kegiatan Usaha</td>
							<td align='center'>Uraian</td>
							<td align='center' class='nobor-right'>Jumlah</td>
						</tr>
						<tr>
							<td align='center' width='5%' class='nobor-left'>1.</td>
							<td align='center'>" . $row['kode_rekening'] . "</td>
							<td align='center'>" . $row['nama_pajak'] . "</td>
							<td align='center' >
								<text type='1'>";
foreach ($business_rows as $row2) {
	$html .= "<li style='font-weight:" . ($row2['ref_kegus_id'] == $row['kegus_id'] ? 'bold' : 'normal') . ";'>" . $row2['nama_kegus'] . "</li>";
}
$html .= "</td>
							<td align='center'>Untuk Pembayaran Pajak Bulan $tax_month Tahun " . $row['tahun_pajak'] . "</td>
							<td align='right' class='nobor-right'>" . number_format($row['pajak']) . "</td>
						</tr>
						<td class='nobor-left nobor-bottom' colspan='4'></td>
						<td><b>Jumlah Setoran Pajak</td>
						<td class='nobor-right' align='right'><b>Rp." . number_format($row['pajak']) . "</td>
						</tr>
						<tr>
							<td colspan='6' class='nobor-left nobor-right' style='padding:3px;'>
								<table class='noborder'>
									<tr>
										<td width='15%'>Dengan huruf</td>
										<td style='border:1px solid #000!important;'><b>" . ucwords(NumToWords($row['pajak'])) . "Rupiah</b></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table class='report' cellspacing='0'>
					<tbody>
						<tr>
							<td width='30%' align='center' class='nobor-left nobor-top nobor-bottom'>
								Ruang untuk teraan<br />
								Kas Register/Tanda Tangan<br />
								Petugas Penerima
								<br />
								<br />
								<br />
								<br />
								<br />
								<br />
							</td>
							<td valign='top' class='nobor-top nobor-bottom'>
								<center>Diterima<br />
								Petugas Tempat Pembayaran</center>
								<table class='noborder'>
								<tr>
									<td width='60%'>Tanggal</td><td>:</td>
								</tr>
								<tr>
									<td>Tanda Tangan</td><td>:</td>
								</tr>
								<tr>
									<td>Nama Terang</td><td>:</td>
								</tr>
								</table>
							</td>
							<td width='30%' align='center' valign='top' class='nobor-right nobor-top nobor-bottom'>
								" . date('F Y') . "<br />
								<br /><br />
								Penyetor
								<br />
								<br />
								<br />
								<br />
								(........................................)
							</td>							
						</tr>
					</tbody>
				</table>";





$html .= "</div>
			<span>*) Beri tanda v pada kotak <span style='border:1px solid #000'>&nbsp;&nbsp;&nbsp;&nbsp;</span> sesuai dengan yang dimiliki<br />
			<b><font style='font-family:times'><!-- MODEL : DPD - 12 --></font></b>
		</div>		</body></html>";


$mpdf->WriteHTML($html);
$html = "";


$mpdf->SetTitle('Surat Setoran Pajak Daerah ' . strtoupper($tax_name));
$mpdf->Output('surat_setoran_pajak_daerah.pdf', 'I');
