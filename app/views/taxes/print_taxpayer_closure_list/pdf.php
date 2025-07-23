<?php

$html = "<!DOCTYPE html><html><head>
			<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Daftar Wajib Pajak Tutup</title>
			<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
			<style type='text/css'>@import " . $this->config->item('css_path') . "report-table-style.css</style>
			</head>
			<body>			
			<div style='margin:10px;'>
			<table border=0 width='100%'>
			<tr>
			<td width='32%'>
				<table>
				<tr>
				<td><img src='" . $this->config->item('img_path') . "logo_pemda.jpg' style='width:42px;'/>
				</td>
				<td>			
				<h6>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "<br />
				" . strtoupper($system_params[2]) . "<br />
				<font style='font-weight:normal'>" . $system_params[3] . "</font><br />
				<font style='font-weight:normal'>Telp. " . $system_params[4] . "</font><br />
				<font style='font-weight:normal'>email : bapenda@blitarkab.go.id</font><br />
				<font style='font-weight:normal'>website : bapenda.blitarkab.go.id</font>
				</h6>
				</td></tr></table>
			</td>
			<td width='36%' align='center'>
			<h4><u>DAFTAR WAJIB PAJAK TUTUP</u><br />
			<font style='font-weight:normal'>" . $tax_name;
if ($zone_searched) {
	$html .= " Kec. " . strtolower($district_row['nama_kecamatan']);
}

$html .= "</font><br />
			<font style='font-weight:normal'>" . $date_period . "</font>
			</h4><br />
			</td>
			<td></td></tr></table>";

$html .= "<table class='report' cellpadding='0' cellspacing='0'>
			  <thead>
			  <tr>
			  <th>No.</th><th>NPWPD</th><th>Nama</th><th>Kegiatan Usaha</th><th>Alamat Lengkap</th><th class='bor-right'>Tgl. Tutup</th>
			  </tr></thead><tbody>";

$no = 0;
$n_rows = count($rows);
foreach ($rows as $row) {
	$no++;
	$bor_bottom = ($no == $n_rows ? 'bor-bottom' : '');
	$html .= "<tr>
				  <td align='center' class='" . $bor_bottom . "'>" . $no . "</td>
				  <td align='center' class='" . $bor_bottom . "'>" . $row['npwprd'] . "</td>
				  <td class='" . $bor_bottom . "'>" . $row['nama'] . "</td>
				  <td class='" . $bor_bottom . "'>" . $row['nama_kegus'] . "</td>
				  <td class='" . $bor_bottom . "'>" . $row['alamat'] . "</td>
				  <td align='center' class='bor-right " . $bor_bottom . "'>" . $row['tgl_tutup'] . "</td>
				  </tr>";
}

$html .= "</tbody></table><br /><br />
			  <table border=0 width='100%'>
			  <tr>
			  <td align='center'>
			  Mengetahui<br />";

if (count($legalitator_row) > 0) {
	$html .= $legalitator_row['nama_jabatan'] . "
		<br /><br /><br /><br /><br />
		<b><u>" . $legalitator_row['nama'] . "</u></b>
		<br />" . $legalitator_row['pangkat'] . "
		<br />NIP. " . $legalitator_row['nip'];
}

$html .= "</td><td align='center'>Diperiksa Oleh<br />";

if (count($evaluator_row) > 0) {
	$html .= $evaluator_row['nama_jabatan'] . "
		<br /><br /><br /><br /><br />
		<b><u>" . $evaluator_row['nama'] . "</u></b>
		<br />" . $evaluator_row['pangkat'] . "
		<br />NIP. " . $evaluator_row['nip'];
}

$html .= "</td></tr></table></div></body></html>";

$mpdf->SetTitle('Daftar WP Tutup');
$mpdf->WriteHTML($html);
$mpdf->Output('daftar_wp_tutup.pdf', 'I');
