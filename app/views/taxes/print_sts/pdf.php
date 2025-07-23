<?php

	$html = "<!DOCTYPE html>
		<html>
	<head>
		<title>'" . $this->config->item('sys_name_acr') . '  ' . $system_params[7] . ' ' . $system_params[6]." | STS</title>
		<link rel='stylesheet' type='text/css' href='". $this->config->item('css_path') . "report-style.css'/>
		<style type='text/css'>@import '" . $this->config->item('css_path') . "report-table-style.css'</style>
		<link rel='stylesheet' type='text/css' href='" . $this->config->item('css_path') . "sts-style.css'/>
	</head>
	<body>";
	$html .="
		<div style='margin:10px;'>
			<div style='border:1px solid #000;padding:1px;'>
				<div style='border:1px solid #000;'>
					<div style='border-bottom:2px solid #000;padding:5px;text-align:center'>";
						$html .="<h2>PEMERINTAH ".strtoupper($system_params[7]." ".$system_params[6])."<br />
							<span style='font-family:times;font-weight:normal;'>SURAT TANDA SETORAN<br />(STS)</span>";
						$html .="
					</div>
					<div style='margin-top:10px;'>
						<div class='fluid'>
							<div class='grid8'>
								<table class='noborder'>
									<tr><td width='40%'>STS No.</td><td>: ".$row['nomor_spt']."</td></tr>
									<tr><td>Harap diterima uang sebesar</td><td>: Rp. ".number_format($row['total_bayar'],2,',','.')."</td></tr>
									<tr><td valign='top'>(dengan huruf)</td><td><i>".ucwords(NumToWords($row['total_bayar']))."Rupiah</i></td></tr>
								</table>
							</div>
							<div class='grid4'>
								<table class='noborder'>
									<tr><td>Bank</td><td>: ".$row['loket_pembayaran']."</td></tr>
									<tr><td>No. Rekening</td><td>: ".$bundle_row['kode_rekening']."</td></tr>
								</table>
							</div>
						</div>
						<p style='margin-top:10px!important;margin-left:4px!important;'>Dengan rincian penerimaan sebagai berikut : </p><br />
						<table class='report' cellspacing='0'>
							<tbody>
								<tr>
									<td class='nobor-left' align='center'><b>NO.</b></td>
									<td align='center'><b>KODE REKENING</b></td>
									<td align='center' colspan='7'><b>URAIAN RINCIAN OBJEK</b></td>
									<td class='nobor-right' align='center' colspan='2'><b>JUMLAH (Rp)</b></td>
								</tr>";
																	
									$main_detail_row = $detail_rows[0];									
									
									$description = $row['nama_pajak']."/".$main_detail_row['nama_rekening'];
									if($row['pajak_id']!='5'){
										$description .= "<br />-".$row['nama_wp'];
									}

									$html .= "
									<tr>
										<td align='center' class='nobor-left'>1</td>
										<td align='center'>".$main_detail_row['kode_rekening']."</td>
										<td colspan='7'>".$description."</td>
										<td>Rp.</td>
										<td align='right' class='nobor-left nobor-right'>".number_format($main_detail_row['jumlah_pajak'])."</td>
									</tr>";

									if($row['pajak_id']=='3'){
										$no=0;
										foreach($ads_rows as $row2){
											$no++;
											$html .="<tr>
											<td class='nobor-left' align='center'>(".$no.")</td>
											<td></td>
											<td colspan='3'>".$row2['jenis_reklame']."</td>
											<td class='nobor-left'>Rp.</td>
											<td align='right' class='nobor-left'>".number_format($row2['nilai_sewa_reklame'],0,',','.')."</td>
											<td align='center' class='nobor-left'>x</td>
											<td align='right' class='nobor-left'>".number_format($row2['persen_tarif'],2,',','.')."%</td>
											<td>Rp.</td>
											<td align='right' class='nobor-left nobor-right'>".number_format($row2['pajak'],0,',','.')."</td>
											</tr>";
										}
									}
									else if($row['pajak_id']=='5'){
										$html .="
										<tr>
										<td class='nobor-left' align='center'>(1)</td>
										<td></td>
										<td>".$row['nama_wp']."</td>
										<td align='right' class='nobor-left'>".number_format($lighting_row['penggunaan_daya'],0,',','.')." kwh</td>
										<td align='center' class='nobor-left'>x</td>
										<td class='nobor-left'>Rp.</td><td align='right' class='nobor-left'>".number_format($lighting_row['tarif_dasar'],0,',','.')."</td>
										<td align='center' class='nobor-left'>x</td>
										<td align='right' class='nobor-left'>".number_format($lighting_row['persen_tarif'],2,',','.')."%</td>
										<td>Rp.</td>
										<td align='right' class='nobor-left nobor-right'>".number_format($lighting_row['pajak'],0,',','.')."</td>
										</tr>";
									}
									else if($row['pajak_id']=='6'){
										$no = 0;
										foreach ($mblb_rows as $row2) {
											$no++;
											$html .= "<tr>
											<td align='center' class='nobor-left'>(".$no.")</td>
											<td></td>
											<td>- ".$row2['jenis_mblb']."</td>
											<td align='right' class='nobor-left'>".number_format($row2['volume'],2,',','.')." m<sup>3</sup></td>
											<td align='center' class='nobor-left'>x</td>
											<td class='nobor-left'>Rp.</td>
											<td align='right' class='nobor-left'>".number_format($row2['tarif_dasar'],0,',','.')."</td>
											<td align='center' class='nobor-left'>x</td>
											<td class='nobor-left' align='right'>".number_format($row['persen_tarif'],2,',','.')."%</td>
											<td>Rp.</td>
											<td align='right' class='nobor-left nobor-right'>".number_format($row2['nilai_jual'],0,',','.')."</td>											
											</tr>";
										}
									}

									//fine row
									if(isset($detail_rows[1])){
										$fine_row = $detail_rows[1];
										$html .= "
										<tr>
											<td align='center' class='nobor-left'>2</td>
											<td align='center'>".$fine_row['kode_rekening']."</td>
											<td colspan='7'>".$fine_row['nama_rekening']."</td>
											<td>Rp.</td>
											<td align='right' class='nobor-left nobor-right'>".number_format($fine_row['jumlah_pajak'])."</td>
										</tr>";
									}
										
								$html .="
								<tr>
									<td colspan='9' class='nobor-left' align='center'><b>Jumlah</b></td>
									<td><b>Rp.</b></td><td class='nobor-left nobor-right' align='right'><b>".number_format($row['total_bayar'])."</b></td>
								</tr>
							</tbody>						
						</table>";
						$html .= "<br />
						<table class='noborder'>
							
							<tr><td colspan='4' align='left'>
							Uang tersebut diterima pada tanggal ".indo_date_format($row['tgl_bayar'],'longDate')."<br /></td></tr>
							
								<td></td>
								<td width='30%'>
									<br />Bendahara Penerimaan<br />
									<br />
									<br />
									<br />
									<br />
									<br />
									<br />
									<b><u>SEGER </u></b><br />	
									Pengatur Muda Tk.I<br />							
									NIP. : 19751115 201407 1 002<br />
									&nbsp;
								</td>
								<td width='5%'></td>
							</tr>
						</table>
						
					</div>
				</div>
			</div>
			<span><i>(Catatan : -STS dilampiri Slip Setoran Bank)</i></span><br />";
			$html .="
		</div>		
	</body>
</html>";
		

		$mpdf->WriteHTML($html);
		$html = "";
	
	$mpdf->SetTitle('Surat Tanda Setoran  '.strtoupper($tax_name));
	$mpdf->Output('surat_tanda_setoran.pdf','I');
?>