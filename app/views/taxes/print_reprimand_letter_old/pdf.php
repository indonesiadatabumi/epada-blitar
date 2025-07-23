<?php

$html = "<!DOCTYPE html>
<html>
	<head>
		<title>'" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Surat Teguran </title>
		<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
		<style type='text/css'>@import '" . $this->config->item('css_path') . "surat_teguran-style.css'</style>
	</head>
	<body>";
$html .= "
		<div style='margin:10px;'>			
			
			<div style='border-bottom:1px solid #000;margin-bottom:5px;padding:5px;text-align:center;position:relative;'>
				<img style='position:absolute;left:0;top:0' src='" . $this->config->item('img_path') . "logo_pemda.png' width='6%'/>";
$html .= "<h1>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "</h1>
				<h2>" . strtoupper($system_params[2]) . "</h2>
				<p>" . $system_params[3] . " Telp. " . $system_params[4] . " Fax " . $system_params[5] . "<br />
				<p>email : bapenda@blitarkab.go.id<br />website : bapenda.blitarkab.go.id<br />
				<b>" . strtoupper($system_params[19]) . "</b></p>";
$html .= "
			</div>

			<div>
				<table class='report noborder' cellpadding='0' cellspacing='0'>
					<tbody>
						<tr>
							<td align='left' width='50%'>
								NPWPD
								<br /><br />
								(" . $rows['npwprd'] . ")<br />
								<br />
							</td>
							<td>
								<br />
								<table class='noborder' valign='right'>
									<tr>
										<td rowspan ='4' valign='middle' align='right'>Yth.</td>
										<td>Kepada</td>
									</tr>
									
									<tr><td> " . $rows['nama'] . "</td></tr>
									<tr><td></td></tr>
									<tr><td>di -</td></tr>
									<tr><td></td><td><span style='margin-left:30px'>" . $system_params[19] . "</span></td></tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table class='report noborder' cellpadding='0' cellspacing='0'>
					<tbody>
						<tr><td colspan='4'></td></tr>
						<tr><td colspan='4'></td></tr>
						<tr><td colspan='4'></td></tr>
						<tr><td colspan='4'></td></tr>
						<tr><td colspan='4'></td></tr>
						<tr>
							<td align='center'><h1>Surat Teguran</h1></td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td align='center'><h2>UNTUK MEMASUKKAN SPTPD</h2></td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td>
								<p>Berdasarkan catatan kami, ternyata sampai saat ini saudara belum melaporkan Surat Pemberitahuan Pajak Daerah (SPTPD) kepada Bapenda Kabupaten Blitar. Maka, dengan ini kami ninta agar Saudara segera menyerahkan laporan SPTPD dimaksud, paling lambat 5 (lima) hari setelah menerima surat ini.</p><br><br>
							<p>Apabila Surat Teguran ini tidak juga Saudara indahkan, maka akan dilaksanakan pemeriksaan lapangan dan / atau akan dilaksanakan penetapan besaran pajak daerah secara jabatan sesuai ketentuan perundang - undangan.</p><br><br>
							<p>Demikian untuk menjadi perhatian, agar kewajiban Saudara dapat dipenuhi sebagaimana mestinya.</p>
							</td> 
						</tr>
					</tbody>
					<tfoot>
						<td></td>
					</tfoot>
				</table>
				<table class='report noborder' cellspacing='0'>					
					<tr>
						<td class='nobor-top nobor-left'>&nbsp;</td>
						<td width='30%' class='nobor-top nobor-left'>";
$html .= "Blitar, " . indo_date_format($tgl_cetak, 'longDate') . " <br>
							Mengetahui
							<br><br><br><br>";
$html .= ".$system_params[10].";
$html .= "<br />
							" . $system_params[11] . "<br />
							" . $system_params[12] . "";
$html .= "
						</td>
						<td width='5%' class='nobor-left nobor-top'></td>
					</tr>				
				</table>
			</div>

		</div>
	</body>
</html>";


$mpdf->WriteHTML($html);
$html = "";

$mpdf->SetTitle('Surat Teguran  ' . strtoupper($tax_name));
$mpdf->Output('surat_teguran.pdf', 'I');
