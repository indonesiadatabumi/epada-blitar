<?php

$html = "<!DOCTYPE html><html><head>
			<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Daftar SPTPD " . strtoupper($tax_name) . "</title>
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
			<h4><u>DAFTAR SPTPD " . strtoupper($tax_name) . "</u><br />";

if ($search_type == '1') {
	$html .= "<font style='font-weight:normal'>TAHUN : " . $header_attr['tax_year'] . "</font><br />
				<font style='font-weight:normal'>MASA PAJAK : " . get_monthName($header_attr['tax_period']) . "</font>";
} else {
	$html .= "<font style='font-weight:normal'>" . $header_attr['date_period'] . "</font>";
	if (!empty($header_attr['district'])) {
		$html .= "<br /><font style='font-weight:normal'>" . $header_attr['district'] . "</font>";
	}
}
$html .= "</h4><br /></td><td></td></tr></table>";

if ($search_type == '1' and count($district_row) > 0) {
	$html .= "<div style='margin-top:5px;'>Kecamatan : " . $district_row['nama_kecamatan'] . "</div>";
}
$html .= "<table class='report' cellpadding='0' cellspacing='0'>
			<thead>
			<tr>
			<th rowspan='2'>No.</th><th colspan='2'>SPTPD</th><th rowspan='2'>Wajib Pajak/Pemilik</th>
			<th rowspan='2'>Alamat</th><th rowspan='2'>NPWPD</th><th rowspan='2'>Masa Pajak</th>
			<th rowspan='2'>Tarif (%)</th><th rowspan='2'>Omzet (Rp.)</th>
			<th rowspan='2' class='bor-right'>Pajak</th></tr>
			<tr><th>Tanggal</th><th style='border-right:none'>No. Urut</th></tr>
			</thead>
			<tbody>";

$no = 0;
$n_rows = count($rows);
$total1 = 0;
$total2 = 0;
foreach ($rows as $row) {
	$no++;
	if ($search_type == '1') {
		$masa_pajak = get_monthName($header_attr['tax_period']) . ' ' . $header_attr['tax_year'];
	} else {
		$x_date = explode('-', $row['masa_pajak1']);
		$masa_pajak = get_monthName($x_date[1]) . ' ' . $x_date[2];
	}
	$total1 += $row['nilai_terkena_pajak'];
	$total2 += $row['pajak'];
	$bor_bottom = ($no == $n_rows ? 'bor-bottom' : '');
	$html .= "<tr>
			<td align='center' class='" . $bor_bottom . "'>" . $no . "</td>
			<td align='center' align='center' class='" . $bor_bottom . "'>" . $row['tgl_proses'] . "</td>
			<td align='center' class='" . $bor_bottom . "'>" . $row['nomor_spt'] . "</td>
			<td class='" . $bor_bottom . "'>" . $row['nama'] . "</td>
			<td class='" . $bor_bottom . "'>" . $row['alamat'] . "</td>
			<td align='center' class='" . $bor_bottom . "'>P.2." . $row['npwprd'] . "</td>
			<td align='center' class='" . $bor_bottom . "'>" . $masa_pajak . "</td>
			<td align='right' class='" . $bor_bottom . "'>" . $row['persen_tarif'] . "</td>
			<td align='right' class='" . $bor_bottom . "'>" . (!empty($row['nilai_terkena_pajak']) ? number_format($row['nilai_terkena_pajak']) : '') . "</td>
			<td align='right' class='bor-right " . $bor_bottom . "'>" . (!empty($row['pajak']) ? number_format($row['pajak']) : '') . "</td>
			</tr>";
}

$html .= "</tbody>
			<tfoot>			
			<tr><td colspan='8' align='right' style='border-top:none' class='bor-bottom'><b>TOTAL : </b></td>
			<td align='right' style='border-top:none' class='bor-bottom'><b>" . number_format($total1) . "</b></td>
			<td align='right' style='border-top:none' class='bor-bottom bor-right'><b>" . number_format($total2) . "</b></td></tr>			
			</tfoot>
			</table><br /><br />
			<table class='signiture'>
			<tr>
			<td align='center' width='38%'>
			Mengetahui<br />";

if (count($legalitator_row) > 0) {
	$html .= $legalitator_row['nama_jabatan'] . "
				<br /><br /><br /><br /><br />
				<b><u>" . $legalitator_row['nama'] . "</u></b>
				<br />" . $legalitator_row['pangkat'] . "
				<br />NIP. " . $legalitator_row['nip'];
}

$html .= "</td><td align='center' width='38%'>Diperiksa Oleh<br />";

if (count($evaluator_row) > 0) {
	$html .= $evaluator_row['nama_jabatan'] . "
					<br /><br /><br /><br /><br />
					<b><u>" . $evaluator_row['nama'] . "</u></b>
					<br />" . $evaluator_row['pangkat'] . "
					<br />NIP. " . $evaluator_row['nip'];
}

$html .= "</td><td><br />" . $system_params[6] . ", " . indo_date_format($print_date, 'longDate') . "
			<table>
			<tr><td>Nama</td><td>: " . $this->session->userdata('fullname') . "</td></tr>
			<tr><td>Jabatan</td><td>: " . $this->session->userdata('user_type') . "</td></tr>
			<tr><td colspan='2'>&nbsp;<br /><br /><br /></td></tr>
			<tr><td>Tanda Tangan</td><td>:</td></tr>
			</table>
			</td></tr></table></div></body></html>";

$mpdf->SetTitle('Daftar SPTPD ' . strtoupper($tax_name));
$mpdf->WriteHTML($html);
$mpdf->Output('daftar_sptpd_' . $tax_name . '.pdf', 'I');
