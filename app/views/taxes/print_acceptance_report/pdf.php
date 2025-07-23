<?php

$html = "<!DOCTYPE html>
<html>
	<head>
		<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Laporan Penerimaan</title>
		<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
		<style type='text/css'>@import " . $this->config->item('css_path') . "report-table-style.css</style>
	</head>
	<body>";
$html .= "<div style='margin:10px;'>
			<table border='0' width='100%'>
				<tr>					
					<td>
						<h3 align='center'>LAPORAN PENERIMAAN " . strtoupper($tax_name) . "<br />							
							<font style='font-weight:normal'>" . $periode_desc . "</font>
						</h3><br />
					</td>					
				</tr>
				<tr>
					<td>";
if (count($judul_kegus) > 0) {
	$html .= "Kegiatan Usaha: " . $judul_kegus['nama_kegus'];
}

$html .= "</td>
				</tr>
				<tr>
					<td>";
if (count($judul_kecamatan) > 0) {
	$html .= "Kecamatan: " . $judul_kecamatan['nama_kecamatan'];
}

if (count($judul_kegus) > 0) {
	if ($judul_kegus['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
		$html .= "</td>
				</tr>		
				
			</table>


			<table class='report' cellpadding='0' cellspacing='0'>
				<thead>
					<tr>
						<th>NO.</th><th>NO. STS</th><th>TGL. SETORAN</th><th>NAMA WP</th><th>N.P.W.P.D</th><th>Nama Pelapor</th>
						<th>MASA PAJAK</th><th>POKOK PAJAK (Rp.)</th><th>DENDA (Rp.)</th><th>JUMLAH (Rp.)</th>
					</tr>
				</thead>
				<tbody>";
	} else {
		$html .= "</td>
				</tr>		
				
			</table>


			<table class='report' cellpadding='0' cellspacing='0'>
				<thead>
					<tr>
						<th>NO.</th><th>NO. STS</th><th>TGL. SETORAN</th><th>NAMA WP</th><th>N.P.W.P.D</th>
						<th>MASA PAJAK</th><th>POKOK PAJAK (Rp.)</th><th>DENDA (Rp.)</th><th>JUMLAH (Rp.)</th>
					</tr>
				</thead>
				<tbody>";
	}
} else {
	$html .= "</td>
				</tr>		
				
			</table>


			<table class='report' cellpadding='0' cellspacing='0'>
				<thead>
					<tr>
						<th>NO.</th><th>NO. STS</th><th>TGL. SETORAN</th><th>NAMA WP</th><th>N.P.W.P.D</th>
						<th>MASA PAJAK</th><th>POKOK PAJAK (Rp.)</th><th>DENDA (Rp.)</th><th>JUMLAH (Rp.)</th>
					</tr>
				</thead>
				<tbody>";
}

$no = 0;
$total_pokok_pajak = 0;
$total_denda = 0;
$total = 0;
foreach ($rows as $row) {
	$no++;
	if (count($judul_kegus) > 0) {
		if ($judul_kegus['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
			$html .= "'<tr>
								<td align='center'>" . $no . "</td>
								<td align='center'>" . $row['kode_sts'] . "</td>								
								<td align='center'>" . indo_date_format($row['tgl_bayar'], 'shortDate') . "</td>
								<td>" . $row['nama_wp'] . "</td>
								<td align='center'>P.2." . $row['npwpd'] . "</td>
								<td>" . $row['created_by'] . "</td>
								<td align='center'>" . get_monthName($row['bulan_pajak']) . " " . $row['tahun_pajak'] . "</td>
								<td align='right'>" . number_format($row['pokok_pajak'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['denda'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>
							</tr>'";
		} else {
			$html .= "'<tr>
								<td align='center'>" . $no . "</td>
								<td align='center'>" . $row['kode_sts'] . "</td>								
								<td align='center'>" . indo_date_format($row['tgl_bayar'], 'shortDate') . "</td>
								<td>" . $row['nama_wp'] . "</td>
								<td align='center'>P.2." . $row['npwpd'] . "</td>
								<td align='center'>" . get_monthName($row['bulan_pajak']) . " " . $row['tahun_pajak'] . "</td>
								<td align='right'>" . number_format($row['pokok_pajak'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['denda'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>
							</tr>'";
		}
	} else {
		$html .= "'<tr>
								<td align='center'>" . $no . "</td>
								<td align='center'>" . $row['kode_sts'] . "</td>								
								<td align='center'>" . indo_date_format($row['tgl_bayar'], 'shortDate') . "</td>
								<td>" . $row['nama_wp'] . "</td>
								<td align='center'>P.2." . $row['npwpd'] . "</td>
								<td align='center'>" . get_monthName($row['bulan_pajak']) . " " . $row['tahun_pajak'] . "</td>
								<td align='right'>" . number_format($row['pokok_pajak'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['denda'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>
							</tr>'";
	}

	$total_pokok_pajak += $row['pokok_pajak'];
	$total_denda += $row['denda'];
	$total += $row['total_bayar'];
}

if (count($judul_kegus) > 0) {
	if ($judul_kegus['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
		$html .= "
				</tbody>
				<tfoot>
					<tr>
						<td colspan='7' align='center'><b>JUMLAH</b></td>
						<td align='right'><b>" . number_format($total_pokok_pajak, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($total_denda, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($total, 0, ',', '.') . "</b></td>
					</tr>
				</tfoot>
			</table><br /><br />
			
			<table border=0 width='100%'>
				<tr>
					<td align='center' valign='top'>";
	} else {
		$html .= "
				</tbody>
				<tfoot>
					<tr>
						<td colspan='6' align='center'><b>JUMLAH</b></td>
						<td align='right'><b>" . number_format($total_pokok_pajak, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($total_denda, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($total, 0, ',', '.') . "</b></td>
					</tr>
				</tfoot>
			</table><br /><br />
			
			<table border=0 width='100%'>
				<tr>
					<td align='center' valign='top'>";
	}
} else {
	$html .= "
				</tbody>
				<tfoot>
					<tr>
						<td colspan='6' align='center'><b>JUMLAH</b></td>
						<td align='right'><b>" . number_format($total_pokok_pajak, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($total_denda, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($total, 0, ',', '.') . "</b></td>
					</tr>
				</tfoot>
			</table><br /><br />
			
			<table border=0 width='100%'>
				<tr>
					<td align='center' valign='top'>";
}
if ($show_signature) {
	$html .= "&nbsp;<br />
							Mengetahui,<br />";
	if (count($legalitator_row) > 0) {
		$html .= $legalitator_row['nama_jabatan'] . "
								<br /><br /><br /><br /><br />
								<b><u>" . $legalitator_row['nama'] . "</u></b>								
								<br />NIP. " . $legalitator_row['nip'];
	}
}
$html .= "</td>
					<td align='center' valign='top'>
						<p align='right'>" . $system_params[6] . ", " . indo_date_format(date('Y-m-d'), 'longDate') . "</p><br /><br />";
if ($show_signature) {
	$html .= "BENDAHARA PENERIMAAN 
							<br />
							<br />
							<br />
							<br />
							<br />								
							<b><u>SEGER</u></b><br />
							NIP. : 19751115 201407 1 002<br />";
}
$html .= "</td>
				</tr>
			</table>";


$html .= "</div></body></html>";

$mpdf->SetTitle('Laporan Penerimaaan');
$mpdf->WriteHTML($html);
$mpdf->Output('laporan_penerimaan.pdf', 'I');
