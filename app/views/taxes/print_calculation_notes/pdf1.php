<?php

$html = "<!DOCTYPE html><html><head>
			<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Nota Perhitungan Pajak Daerah</title>
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
				<td width='32%'>
				<table class='noborder'>
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
				<font style='font-weight:normal'>" . $system_params[6] . "</font>
				</h6>
				</td></tr></table>
				</td>
				<td width='36%' align='center'>
				<h4>NOTA PERHITUNGAN PAJAK DAERAH<br />				
				<font style='font-weight:normal'>Masa Pajak : " . $tax_period . " Tahun : " . $row['tahun_pajak'] . "</font><br />
				<font style='font-weight:normal'>" . $row['singkatan_spt'] . "</font>
				</h4><br />
				</td>
				<td class='bor-right'>
				<table class='noborder'>
				<tr><td>No. Nota Perhitungan</td><td>: " . sprintf('%0' . $system_params[16] . 's', $row['kohir']) . "</td></tr>
				<tr><td>No. SPT yang dikirim</td><td>: " . sprintf('%0' . $system_params[16] . 's', $row['no_spt']) . "</td></tr></table>
				</td>
				</tr>
				<tr>
				<td colspan='3' class='bor-right'>
					<table class='noborder'>
					<tr><td width='10%'>Nama</td><td>: " . $row['nama_wp'] . "</td></tr>
					<tr><td>Alamat</td><td>: " . $row['alamat'] . ", Kel. " . $row['kelurahan'] . "</td></tr>
					<tr><td>NPWPD</td><td>: P.2." . $row['npwpd'] . "</td></tr>
					</table>
				</td></tr>
				</table>";

	$html .= "<table class='report' cellpadding=0 cellspacing=0><thead>
				  <tr>
				  <td align='center' rowspan='2'>No.</td>
				  <td align='center' rowspan='2'>Jenis Pajak</td>
				  <td align='center' rowspan='2'>Kode Rekening</td>
				  <td align='center' colspan='2'>Dasar Pengenaan</td>
				  <td align='center' rowspan='2'>Tarif</td>
				  <td align='center' rowspan='2'>" . ($row['pajak_id'] == '8' ? 'NPA (Rp.)' : 'Omset (Rp.)') . "</td>
				  <td align='center' rowspan='2'>Ketetapan Pajak (Rp.)</td>
				  <td colspan='3' align='center'>Sanksi Administrasi (Rp.)</td>
				  <td class='bor-right' rowspan='2' align='center'>Jumlah (Rp.)</td></tr>
				  <tr>
				  <td align='center'>Uraian</td>
				  <td align='center'>Volume (m<sup>3</sup>)</td>
				  <td align='center'>Kenaikan</td>
				  <td align='center'>Denda</td>
				  <td align='center'>Bunga</td>
				  </tr>
				  <tr>
				  <td align='center'>1</td>
				  <td align='center'>2</td>
				  <td align='center'>3</td>
				  <td align='center'>4</td>
				  <td align='center'>5</td>
				  <td align='center'>6</td>
				  <td align='center'>7</td>
				  <td align='center'>8=(6x7)</td>
				  <td align='center'>9</td>
				  <td align='center'>10</td>
				  <td align='center'>11</td>
				  <td align='center' class='bor-right'>12=(8+9+10+11)</td>
				  </tr>
				  </thead>";

	$tax = $row['pajak'];
	$discount = $row['diskon'];
	$fine = $row['denda'];
	$interest = $row['bunga'];

	$total_pay = $tax - $discount + $fine + $interest;

	$html .= "<tbody><tr><td align='center'>1</td><td>" . $tax_name . "</td><td align='center'>" . $row['kode_rekening'] . "</td><td>" . $row['nama_kegus'] . "</td>
				  <td align='right'>" . number_format($row['volume']) . "</td><td align='center'>" . number_format($row['persen_tarif']) . "%</td>
				  <td align='right'>" . number_format($row['nilai_terkena_pajak']) . "</td><td align='right'>" . number_format($tax) . "</td>
				  <td align='right'>" . number_format($discount) . "</td><td align='right'>" . number_format($fine) . "</td><td align='right'>" . number_format($interest) . "</td>
				  <td align='right' class='bor-right'>" . number_format($total_pay) . "</td>
				  </tr></tbody>";

	$grand_tax = $tax;
	$grand_discount = $discount;
	$grand_fine = $fine;
	$grand_interest = $interest;
	$grand_total = $total_pay;

	$html .= "<tfoot>
				<tr><td colspan='7' align='right'><b>JUMLAH</b></td><td align='right'><b>" . number_format($grand_tax) . "</b></td><td align='right'><b>" . number_format($grand_discount) . "</b></td>
				<td align='right'><b>" . number_format($grand_fine) . "</b></td><td align='right'><b>" . number_format($grand_interest) . "</b></td><td align='right' class='bor-right'><b>" . number_format($grand_total) . "</b></td></tr>
				<tr><td colspan='12' class='bor-right bor-bottom'></td></tr>
				<tr>
				<td colspan='2' class='bor-bottom' style='border-top:none;'></td><td colspan='10' style='border-top:none;' class='bor-right bor-bottom'>
				<b>Jumlah dengan huruf : (" . NumToWords($grand_total) . ")</b></td>
				</tr>
				</tfoot>";

	$html .= "</table><br /><br />";

	$html .= "<table class='signiture'>
			  <tr>
			  <td align='center' width='38%'>
			  Mengetahui<br />a.n Kepala " . $system_params[2] . "<br />";

	if (count($legalitator_row) > 0) {
		$html .= $legalitator_row['nama_jabatan'] .
			"<br /><br /><br /><br /><br />
					  <b><u>" . $legalitator_row['nama'] . "</u></b>
					  <br />" . $legalitator_row['pangkat'] . "
					  <br />NIP. " . $legalitator_row['nip'];
	}

	$html .= "</td><td align='center' width='38%'>Diperiksa Oleh<br />";

	if (count($evaluator_row) > 0) {
		$html .= $evaluator_row['nama_jabatan'] .
			"<br /><br /><br /><br /><br />
					  <b><u>" . $evaluator_row['nama'] . "</u></b>
					  <br />P E M B I N A
					  <br />NIP. " . $evaluator_row['nip'];
	}

	$html .= "</td><td valign='top'>
				  <table class='noborder'>
				  <tr><td>Dibuat Tanggal</td><td>: " . indo_date_format($row['tgl_penetapan'], 'longDate') . "</td></tr>
				  <tr><td>Oleh</td><td>: " . $this->session->userdata('fullname') . "</td></tr>
				  <tr><td valign='top'>NIP</td><td valign='top'>: " . $this->session->userdata('nip') . "<br /><br />&nbsp;</td></tr>
				  <tr><td colspan='2'>Tanda Tangan </td></tr></table></td></tr></table>";

	if ($i == $n_row) {
		$html .= "</body></html>";
	}

	if ($i > 1) {
		$mpdf->AddPage();
	}

	$mpdf->WriteHTML($html);
	$html = "";
}

$mpdf->SetTitle('Nota Perhitungan Pajak Daerah ' . strtoupper($tax_name));
$mpdf->Output('nota_perhitungan_pajak_daerah.pdf', 'I');
