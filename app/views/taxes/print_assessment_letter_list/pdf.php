<?php

$html = "<!DOCTYPE html><html><head>
			<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Daftar Surat Ketetapan Pajak Daerah</title>
			<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
			<style type='text/css'>@import " . $this->config->item('css_path') . "report-table-style.css</style>
			</head>
			<body>						
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
			<h4><u>DAFTAR SURAT KETETAPAN PAJAK DAERAH</u><br />
			<font style='font-weight:normal'>" . $tax_name . "</font><br />
			<font style='font-weight:normal'>Tgl. Ketetapan " . indo_date_format(date('Y-m-d'), 'longDate') . "</font>
			</h4><br />
			</td><td></td></tr></table>";

if ($zone_searched) {
	if (count($district_row) > 0) {
		$html .= "<div>Kecamatan : " . $district_row['nama_kecamatan'] . "</div>";
	}
}

$html .= "<table class='report' cellpadding='0' cellspacing='0' style='font-size:0.9em'>
			  <thead>";

if ($spt_type_id == '1' && $spt_type_id == '8') {
	if ($bundle_id == '3') {
		$html .= "<tr>
				  <th rowspan='2'>No.</th><th colspan='2'>" . $spt_name . "</th><th rowspan='2'>Nama Wajib Pajak</th>
				  <th rowspan='2'>Naskah Reklame</th><th rowspan='2'>Alamat Wajib Pajak</th><th rowspan='2'>Lokasi Pasang</th>
				  <th rowspan='2'>Jenis Reklame</th><th rowspan='2'>Ketetapan</th><th rowspan='2' class='bor-right'>Jatuh Tempo</th>
				  </tr>
				  <tr><th>Tanggal</th><th>No. Kohir</th></tr>";
	} else {
		$html .= "<tr><th rowspan='2'>No.</th><th colspan='2'>" . $spt_name . "</th><th rowspan='2'>NPWPD</th>
				  <th rowspan='2'>Nama Wajib Pajak</th><th rowspan='2'>Alamat</th><th rowspan='2'>NPA</th>
				  <th rowspan='2'>Ketetapan</th><th rowspan='2' class='bor-right'>Jatuh Tempo</th>
				  </tr>
				  <tr><th>Tanggal</th><th>No. Kohir</th></tr>";
	}
} else {

	$html .= "<tr><th rowspan='2'>No.</th><th colspan='2'>" . $spt_name . "</th><th rowspan='2'>NPWPD</th>
				  <th rowspan='2'>Nama Wajib Pajak</th><th rowspan='2'>Alamat</th><th rowspan='2'>Omset</th>
				  <th rowspan='2'>Ketetapan</th><th rowspan='2'>Masa Pajak</th><th rowspan='2' class='bor-right'>Jatuh Tempo</th>
				  </tr>
				  <tr><th>Tanggal</th><th>No. Kohir</th></tr>";
}

$html .= "</thead><tbody>";

$no = 0;
$n_rows = count($rows);
$tot_tax = 0;
$tot_turnover = 0;

if ($spt_type_id == '1' && $spt_type_id = '8') {
	if ($bundle_id == '3') {
		foreach ($rows as $row) {
			$no++;
			$bor_bottom = ($no == $n_rows ? 'bor-bottom' : '');
			$tot_tax += $row['pajak'];
			$html .= "<tr>
						  <td align='center' class='" . $bor_bottom . "'>" . $no . "</td>
						  <td align='center' class='" . $bor_bottom . "'>" . indo_date_format($row['tgl_penetapan'], 'shortDate') . "</td>
						  <td class='" . $bor_bottom . "' align='center'>" . $row['kohir'] . "</td>
						  <td class='" . $bor_bottom . "'>" . $row['nama_wp'] . "</td>
						  <td class='" . $bor_bottom . "'>" . $row['judul_reklame'] . "</td>
						  <td class='" . $bor_bottom . "'>" . $row['alamat'] . "</td>
						  <td class='" . $bor_bottom . "'>" . $row['lokasi_reklame'] . "</td>
						  <td class='" . $bor_bottom . "'>" . $row['jenis_reklame'] . "</td>
						  <td class='" . $bor_bottom . "' align='right'>" . number_format($row['pajak']) . "</td>
						  <td class='" . $bor_bottom . " bor-right' align='center'>" . indo_date_format($row['tgl_jatuh_tempo'], 'shortDate') . "</td></tr>";
		}
	} else {

		foreach ($rows as $row) {
			$no++;
			$bor_bottom = ($no == $n_rows ? 'bor-bottom' : '');
			$tot_tax += $row['pajak'];
			$tot_turnover += $row['nilai_terkena_pajak'];
			$html .= "<tr>
						  <td align='center' class='" . $bor_bottom . "'>" . $no . "</td>
						  <td align='center' class='" . $bor_bottom . "'>" . indo_date_format($row['tgl_penetapan'], 'shortDate') . "</td>
						  <td class='" . $bor_bottom . "' align='center'>" . $row['kohir'] . "</td>
						  <td class='" . $bor_bottom . "' align='center'>P.2." . $row['npwpd'] . "</td>
						  <td class='" . $bor_bottom . "'>" . $row['nama_wp'] . "</td>
						  <td class='" . $bor_bottom . "'>" . $row['alamat'] . "</td>
						  <td class='" . $bor_bottom . "'>" . number_format($row['nilai_terkena_pajak']) . "</td>
						  <td class='" . $bor_bottom . "' align='right'>" . number_format($row['pajak']) . "</td>
						  <td class='" . $bor_bottom . " bor-right' align='center'>" . indo_date_format($row['masa_pajak1'], 'shortDate') . "</td>
						  <td class='" . $bor_bottom . " bor-right' align='center'>" . indo_date_format($row['tgl_jatuh_tempo'], 'shortDate') . "</td></tr>";
		}
	}
} else {

	foreach ($rows as $row) {
		$no++;
		$bor_bottom = ($no == $n_rows ? 'bor-bottom' : '');
		$tot_tax += $row['pajak'];
		$tot_turnover += $row['nilai_terkena_pajak'];
		$html .= "<tr>
						  <td align='center' class='" . $bor_bottom . "'>" . $no . "</td>
						  <td align='center' class='" . $bor_bottom . "'>" . indo_date_format($row['tgl_penetapan'], 'shortDate') . "</td>
						  <td class='" . $bor_bottom . "' align='center'>" . $row['kohir'] . "</td>
						  <td class='" . $bor_bottom . "' align='center'>P.2." . $row['npwpd'] . "</td>
						  <td class='" . $bor_bottom . "'>" . $row['nama_wp'] . "</td>
						  <td class='" . $bor_bottom . "'>" . $row['alamat'] . "</td>
						  <td class='" . $bor_bottom . "'>" . number_format($row['nilai_terkena_pajak']) . "</td>
						  <td class='" . $bor_bottom . "' align='right'>" . number_format($row['pajak']) . "</td>
						  <td class='" . $bor_bottom . "'>" . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td>
						  <td class='" . $bor_bottom . " bor-right' align='center'>" . indo_date_format($row['tgl_jatuh_tempo'], 'shortDate') . "</td></tr>";
	}
}

$html .= "</tbody>
			<tfoot>";

if ($spt_type_id == '1' && $spt_type_id = '8') {
	if ($bundle_id == '3') {
		$html .= "<tr><td colspan='8' align='right' class='bor-bottom'><b>TOTAL</b></td><td align='right' class='bor-bottom'>" . number_format($tot_tax) . "</td><td class='bor-right bor-bottom'></td></tr>";
	} else {
		$html .= "<tr><td colspan='6' align='right' class='bor-bottom'><b>TOTAL</b></td><td align='right' class='bor-bottom'>" . number_format($tot_tax) . "</td>
					  <td align='right' class='bor-bottom'>" . number_format($tot_turnover) . "</td><td class='bor-right bor-bottom'></td></tr>";
	}
} else {
	$html .= "<tr><td colspan='6' align='right' class='bor-bottom'><b>TOTAL</b></td><td align='right' class='bor-bottom'>" . number_format($tot_turnover) . "</td>
					  <td align='right' class='bor-bottom'>" . number_format($tot_tax) . "</td><td colspan='2' class='bor-right bor-bottom'></td></tr>";
}

$html .= "</tfoot></table><br /><br />";

if ($show_signature) {
	$html .= "<table class='signiture'>
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
						<br />P E M B I N A
						<br />NIP. " . $evaluator_row['nip'];
	}

	$html .= "</td><td><br />" . $system_params[6] . ", " . indo_date_format($print_date, 'longDate') . "
				<table>
				<tr><td>Nama</td><td>: " . $this->session->userdata('fullname') . "</td></tr>
				<tr><td>NIP</td><td>: -</td></tr>
				<tr><td colspan='2'>&nbsp;<br /><br /><br /></td></tr>
				<tr><td>Tanda Tangan</td><td>:</td></tr>
				</table>
				</td></tr></table>";
}

$html .= "</body></html>";

$mpdf->SetTitle('Daftar Surat Ketetapan Pajak');
$mpdf->WriteHTML($html);
$mpdf->Output('daftar_surat_ketetapan_pajak.pdf', 'I');
