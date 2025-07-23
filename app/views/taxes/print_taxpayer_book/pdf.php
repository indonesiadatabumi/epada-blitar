<?php


$html = "<!DOCTYPE html>
<html>
	<head>
		<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Buku Wajib Pajak</title>
			<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
			<style type='text/css'>@import " . $this->config->item('css_path') . "report-table-style.css</style>
	</head>
	<body>";
$i = 0;

$n_row = count($rows);

foreach ($rows as $row) {
	$i++;

	$html .= "<div style='margin:10px;''>
			<table border=0 width='100%'>
				<tr>
					<td width='30%'>
						<div style='float:left;margin-right:10px;'>
							<img src='" . $this->config->item('img_path') . "logo_pemda.png' style='width:48px;'/>
						</div>
						<div style='float:left'>
							<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "<br />
							" . strtoupper($system_params[2]) . "<br />
							<font style='font-weight:normal'>" . $system_params[3] . "</font><br />
							<font style='font-weight:normal'>Telp. " . $system_params[4] . "</font><br />
							<font style='font-weight:normal'>email : bapenda@blitarkab.go.id</font><br />
							<font style='font-weight:normal'>website : bapenda.blitarkab.go.id</font>
							</h4>";

	$html .= "</div>
						<div style='clear:both'></div>
					</td>
					<td width='40%'>
						<h3 align='center'>BUKU WAJIB PAJAK</h3>
						<table class='noborder'>
							<tr><td>NAMA WAJIB PAJAK</td><td>: " . $taxpayer_row['nama_wp'] . "</td></tr>
							<tr><td>N.P.W.P.D</td><td>: P.2." . $taxpayer_row['npwprd'] . "</td></tr>
							<tr><td>ALAMAT</td><td>: " . $taxpayer_row['alamat'] . "</td></tr>
							<tr><td></td><td>: 'KELURAHAN " . $taxpayer_row['kelurahan'] . " - KECAMATAN " . $taxpayer_row['kecamatan'] . "'</td></tr>
							<tr><td>TAHUN PAJAK</td><td>: " . $tax_year . " (" . strtoupper($taxpayer_row['jenis_pemungutan']) . ")</td></tr>
						</table>
					</td>
					<td>
						
					</td>
				</tr>
			</table>";

	$html .= "<span>Tgl. Proses : " . $print_date . "</span>
			<table class='report' cellpadding='0' cellspacing='0'>
				<thead>
					<tr>
						<th rowspan='2'>NO.</th>
						<th rowspan='2'>REKENING</th>
						<th rowspan='2'>URAIAN</th>
						<th rowspan='2'>MASA PAJAK</th>
						<th colspan='" . ($taxpayer_row['jenis_spt_id'] == '8' ? '4' : '3') . "'> DATA " . strtoupper($taxpayer_row['singkatan_spt']) . "</th>
						<th colspan='4'>PENYETORAN</th>
						<th rowspan='2'>SISA</th>
					</tr>
					<tr>
						<th>TANGGAL</th>
						<th>NO. SPT</th>";

	if ($taxpayer_row['jenis_spt_id'] == '8') {
		$html .= "<th>DASAR OMZET</th><th>PAJAK</th><th>DENDA</th>";
	} else {
		$html .= "<th>KETETAPAN</th>";
	}
	$html .= "
						<th>NO. REG</th>
						<th>TGL. REG</th>
						<th style='border-right:none!important'>JUMLAH SETOR</th>
					</tr>
				</thead>
				<tbody>";

	$no = 0;
	$grand_tax = 0;
	$grand_payment = 0;
	$grand_arrears = 0;
	foreach ($rows as $row) {
		$no++;

		$sql = "SELECT denda,no_transaksi,to_char(tgl_bayar,'dd-mm-yyyy') as tgl_bayar,total_bayar FROM transaksi_pajak WHERE spt_id='" . $row['spt_id'] . "' AND jenis_spt_id='8'";
		$row2 = $dao->execute(0, $sql)->row_array();

		$trans_numb = "";
		$denda = "";
		$payment_date = "";
		$payment = "";
		$_payment = 0;

		if (is_array($row2)) {
			$trans_numb = $row2['no_transaksi'];
			$payment_date = $row2['tgl_bayar'];
			$payment = number_format($row2['total_bayar'], 0, ',', '.');
			$denda = number_format($row2['denda'], 0, ',', '.');
			$_payment = $row2['total_bayar'];
		}
		$arrears = abs($row['pajak'] - $_payment);
		$html .= "<tr>
							<td align='center'>" . $no . "</td>
							<td align='center'>" . $row['kode_rekening_pajak'] . "</td>
							<td>" . $row['nama_pajak'] . "</td>
							<td align='center'>" . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td>
							<td align='center'>" . $row['tgl_proses'] . "</td>
							<td align='center'>" . $row['nomor_spt'] . "</td>";

		if ($taxpayer_row['jenis_spt_id'] == '8') {
			$html .= "<td align='right'>" . number_format($row['nilai_terkena_pajak'], 0, ',', '.') . "</td>";
		}
		$html .= "'<td align='right'>" . number_format($row['pajak'], 0, ',', '.') . "</td>
							<td align='center'>" . $denda . "</td>
							<td align='center'>" . $trans_numb . "</td>
							<td align='center'>" . $payment_date . "</td>
							<td align='right'>" . $payment . "</td>
							<td align='right'>" . number_format($arrears, 0, ',', '.') . "</td>
							</tr>'";

		$grand_tax += $row['pajak'];
		$grand_payment += $_payment;
		$grand_arrears += $arrears;
	}
	$html .= "
				</tbody>
				<tfoot>
					<tr>
						<td colspan='" . ($taxpayer_row['jenis_spt_id'] == '8' ? '7' : '6') . "' align='center'><b>TOTAL</b></td>
						<td align='right'><b>" . number_format($grand_tax, 0, ',', '.') . "</b></td>
						<td colspan='2'></td>
						<td align='right'><b>" . number_format($grand_payment, 0, ',', '.') . "</b></td>
						<td align='right'><b>" . number_format($grand_arrears, 0, ',', '.') . "</b></td>
					</tr>
				</tfoot>
			</table><br /><br />
			
		</div>
	</body>
</html>";
	if ($i == $n_row) {
		$html .= "</body></html>";
	}

	if ($i > 1) {
		$mpdf->AddPage();
	}

	$mpdf->WriteHTML($html);
	$html = "";
}

$mpdf->SetTitle('Buku Wajib Pajak ' . strtoupper($tax_name));
$mpdf->Output('buku_wajib_pajak.pdf', 'I');
