<?php

$html = "<!DOCTYPE html>
				<html>
					<head>
			<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | BPPS</title>
			<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "report-style.css'/>
			<style type='text/css'>@import " . $this->config->item('css_path') . "report-table-style.css</style>
					</head>
					<body>";
$html .= "<div style='margin:10px;'>
							<table border=0 width='100%'>
								<tr>
									<td width='30%'>
										<div style='float:left;margin-right:10px;'>
											<img src='" . $this->config->item('img_path') . "logo_pemda.png' style='width:48px;'/>
										</div>
										<div style='float:left'>";
$html .= "<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "<br />
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
										<h3 align='center'><u>BUKU PEMBANTU PENERIMAAN SEJENIS <br />VIA " . strtoupper($media) . "</u><br />
											<font style='font-weight:normal'>" . $tax_name . "</font><br />
											<font style='font-weight:normal'>" . $periode_desc . "</font>
										</h3><br />
									</td>
									<td>
										
									</td>
								</tr>
							</table>


							<table class='report' cellpadding='0' cellspacing='0'>
								<thead>
									<tr>
										<th>NO.</th><th>REKENING</th><th>NAMA REKENING</th><th>TGL. SETORAN</th><th>DITERIMA DARI</th><th>N.P.W.P.D</th>
										<th>JUMLAH (Rp.)</th>
									</tr>
								</thead>
								<tbody>";

$no = 0;
$total = 0;
foreach ($rows as $row) {
	$no++;
	$html .= "<tr>
												<td align='center'>" . $no . "</td>
												<td align='center'>" . $row['kode_rekening'] . "</td>
												<td>" . $row['nama_rekening'] . "</td>
												<td align='center'>" . indo_date_format($row['tgl_bayar'], 'shortDate') . "</td>
												<td>" . $row['nama_wp'] . "</td>
												<td align='center'>P.2." . $row['npwpd'] . "</td>
												<td align='right'>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>
											</tr>";
	$html .= $total += $row['total_bayar'];
}
$html .= "
								</tbody>
								<tfoot>
									<tr>
										<td colspan='6' align='center'><b>JUMLAH</b></td>
										<td align='right'><b>" . number_format($total, 0, ',', '.') . "</b></td>
									</tr>
								</tfoot>
							</table><br /><br />";


$html .= "</div></body></html>";

$mpdf->SetTitle('BUKU PEMBANTU PENERIMAAN SEJENIS');
$mpdf->WriteHTML($html);
$mpdf->Output('buku_pembantu_penerimaan_sejenis.pdf', 'I');
