<?php

$html = "<!DOCTYPE html><html><head>
			<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Kartu NPWPD</title>
			<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
			<style type='text/css'>@import " . $this->config->item('css_path') . "report-table-style.css</style>
			<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "npwpd-card-style.css'/>
			</head>
			<body>";


foreach ($rows as $row) {

	$html .= "<div class='card'>
					<div style='float:left;text-align:center;width:20%'>
						<img src='assets/img/logo_pemda.jpg' style='width:42px;'/>						
					</div>
					<div style='text-align:center;padding-bottom:5px;float:left;width:78%;'>
						<h5>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "</h5>
						<h4>" . strtoupper($system_params[2]) . "</h4>
						<h5>KARTU N P W P D</h5>						
						<div style='font-size:0.7em;text-align:center;border-top:1px solid #000'>No. Reg : " . $row['no_reg'] . "</div>
					</div>
					<div style='clear:both'></div>					
					<div style='padding-left:10px'>
						<table class='card-content'>
							<tr><td valign='top' width='20%'>Nama</td><td width='3%' valign='top'>:</td><td>" . strtoupper($row['nama']) . "</td></tr>
							<tr><td valign='top'>Alamat</td><td valign='top'>:</td><td>" . strtoupper($row['alamat']) . "</td></tr>
							<tr><td valign='top'>NPWPD</td><td valign='top'>:</td><td>" . strtoupper($row['jenis']) . '.' . $row['golongan'] . '.' . $row['npwprd'] . "</td></tr>
						</table>
					</div>
					<table class='card-footer'>
						<tr>
							<td width='40%'>&nbsp;</td>
							<td align='center'>
							" . $system_params[6] . ", " . indo_date_format($row['tgl_pendaftaran'], 'longDate') . "<br />
							a.n " . (strtolower($system_params[7]) == 'kota' ? 'Walikota' : 'Bupati') . " " . $system_params[6] . "<br />
							Kepala " . $system_params[2] . "<br /><br /><br /><br />
							<b><u>" . $system_params[10] . "</u></b><br />
							" . $system_params[11] . "<br />
							NIP. " . $system_params[12] . "
							</td>
						</tr>
					</table>
				</div>";
}

$html .= "</body></html>";

$mpdf->SetTitle('Kartu NPWPD');
$mpdf->WriteHTML($html);

//$mpdf->AddPage();

$html = "";
foreach ($rows as $row) {
	// $html .= "<div class='card'>
	// 			  <table class='card-content'>
	// 			  <tr><td colspan='2' align='center' style='font-size: 12;'><b>PERHATIAN</b><br /><br /></td></tr>
	// 			  <tr>
	// 			  <td valign='top' width='15'>1.</td>
	// 			  <td>Kartu ini harap disimpan baik-baik dan apabila hilang agar segera melaporkan ke " . $system_params[2] . "</td>
	// 			  </tr>
	// 			  <tr>
	// 			  <td valign='top'>2.</td>
	// 			  <td>Kartu ini hendaknya dibawa apabila saudara akan membayar pajak, melakukan transaksi dan berhubungan dengan instansi-instansi</td>
	// 			  </tr>
	// 			  <tr>
	// 			  <td valign='top'>3.</td>
	// 			  <td>Dalam hal wajib pajak pindah domisili, supaya melaporkan ke " . $system_params[2] . " " . $system_params[7] . " " . $system_params[6] . "</td>
	// 			  </tr></table>";

	// $html .= "</div>";

	$html .= "<div class='card' >
				  <table class='card-content'>
				  <tr><td colspan='2' align='center' style='font-size: 12;'><b>PERHATIAN</b><br /><br /></td></tr>
<br><br>
				  <tr >
				  <td valign='top' width='15' style='font-size:10;'>1.</td>
				  <td style='font-size:10;'>Kartu ini harap disimpan baik-baik dan apabila hilang agar segera melaporkannya ke Badan Pendapatan Daerah Kabupaten Blitar.</td>
				  </tr>
				  <tr>
				  <td valign='top' style='font-size:10;'>2.</td>
				  <td style='font-size:10;'>Kartu ini hendaknya dibawa apabila saudara akan membayar pajak, melakukan transaksi dan berhubungan dengan instansi-instansi lainnya.</td>
				  </tr>
				  <tr>
				  <td valign='top' style='font-size:10;'>3.</td>
				  <td style='font-size:10;'>Dalam hal wajib pajak pindah domisilisupaya melaporkan diri ke Badan Pendapatan Kabupaten Blitar.</td>
				  </tr>
				  </table>";

	$html .= "</div>";
}

$mpdf->WriteHTML($html);


$mpdf->Output('kartu_npwpd.pdf', 'I');
