<?php

	$html = "<!DOCTYPE html><html><head>
			<title>".$this->config->item('sys_name_acr').' '.$system_params[7].' '.$system_params[6]." | Nota Perhitungan Pajak Daerah</title>
			<link rel='stylesheet' type='text/css' href='".$this->config->item('css_path')."report-style.css'/>
			<style type='text/css'>@import ".$this->config->item('css_path')."report-table-style.css</style>
			</head>
			<body>";

	$i = 0;

	$n_row = count($n_rows);

	foreach($rows as $row){
		$i++;
		$x_date = explode('-',$row['masa_pajak1']);
		$tax_period = get_monthName($x_date[1]);
		$html.= "
				<table cellpadding=0 cellspacing=0 class='report'>
				<tr>
				<td width='32%'>
				<table class='noborder'>
				<tr>
				<td><img src='".$this->config->item('img_path')."logo_pemda.jpg' style='width:42px;'/>
				</td>
				<td>			
				<h6>PEMERINTAH ".strtoupper($system_params[7]." ".$system_params[6])."<br />
				".strtoupper($system_params[2])."<br />
				<font style='font-weight:normal'>".$system_params[3]."</font><br />
				<font style='font-weight:normal'>Telp. ".$system_params[4]. "</font><br />
				<font style='font-weight:normal'>email : bapenda@blitarkab.go.id</font><br />
				<font style='font-weight:normal'>website : bapenda.blitarkab.go.id</font>
				<font style='font-weight:normal'>".$system_params[6]."</font>
				</h6>
				</td></tr></table>
				</td>
				<td width='36%' align='center'>
				<h4>NOTA PERHITUNGAN PAJAK DAERAH<br />
				<font style='font-weight:normal'>".$tax_name."</font><br />
				<font style='font-weight:normal'>Masa Pajak : ".$tax_period." Tahun : ".$row['tahun_pajak']."</font>
				</h4><br />
				</td>
				<td class='bor-right'>Dasar Pengenaan : ".$row['dasar_hukum']."<br />
				No. Nota Perhitungan : ".sprintf('%0'.$system_params[16].'s',$row['kohir'])."</td>
				</tr>
				<tr>
				<td>Nama : ".$row['nama_wp']."</td>
				<td colspan='2' style='border-left:none' class='bor-right'>Alamat : ".$row['alamat'].", Kel. ".$row['kelurahan']."</td>
				</tr>
				</table>";

		$html .= "<table class='report' cellpadding=0 cellspacing=0><thead>
				  <tr><td align='center'>No.</td><td align='center'>Ayat</td><td align='center'>Jenis Reklame</td><td align='center'>Naskah Reklame</td>
				  <td align='center'>Perhitungan</td><td align='center'>Jumlah (Rp.)</td><td align='center' class='bor-right'>Alamat Lokasi Pemasangan</td></tr>
				  <tr><td align='center'>1</td><td align='center'>2</td><td align='center'>3</td><td align='center'>4</td>
				  <td align='center'>5</td><td align='center'>6</td><td align='center' class='bor-right'>7</td></tr>
				  </thead>";

		$ads_type=$row['jenis_reklame_id'];		
		$remark = "";
		if($ads_type>=1 and $ads_type<=15){
			$formula = number_format($row['nilai_tarif'])." x ".number_format($row['luas'])." x ".number_format($row['jumlah'])." x ".number_format($row['lama_pasang'])." x ".$row['persen_tarif']."%";
			$remark = $row['jenis_reklame']." : NSL x Harga Satuan x Ukuran x Jumlah x Jangka Waktu x ".$row['persen_tarif']."%";
		}else if($ads_type==16 or ($ads_type>=20 and $ads_type<=23)){
			$formula = number_format($row['nilai_tarif'])." x ".number_format($row['jumlah'])." x ".number_format($row['lama_pasang'])." x ".$row['persen_tarif']."%";
			$remark = $row['jenis_reklame']." : Harga Satuan x Jumlah x Jangka Waktu x ".$row['persen_tarif']."%";
		}else if($ads_type==17 or $ads_type==18){
			$formula = number_format($row['nilai_tarif'])." x ".number_format($row['luas'])." x ".number_format($row['lama_pasang'])." x ".$row['persen_tarif']."%";
			$remark = $row['jenis_reklame']." : Harga Satuan x Ukuran x Jangka Waktu x ".$row['persen_tarif']."%";
		}

		$html .= "<tbody><tr><td align='center'>1</td><td align='center'>".$row['kode_rekening']."</td><td>".$row['jenis_reklame']."</td><td>".$row['judul']."</td>
				  <td align='center'>".$formula."</td><td align='right'>".number_format($row['pajak'])."</td><td class='bor-right'>".$row['lokasi']."</td></tr></tbody>";

		$total = $row['pajak'];

		$html .= "<tfoot>
				<tr><td colspan='5' align='right'><b>JUMLAH</b></td><td align='right'><b>".number_format($total)."</b></td><td class='bor-right'></td></tr>
				<tr><td colspan='7' class='bor-right bor-bottom'></td></tr>
				<tr>
				<td colspan='2' class='bor-bottom' style='border-top:none;'></td><td colspan='5' style='border-top:none;' class='bor-right bor-bottom'>
				<b>Jumlah dengan huruf : (".NumToWords($total).")</b></td>
				</tr>
				</tfoot>";

		$html .= "</table>";

		$html .= "<p style='font-size:0.7em'>
					Dasar Perhitungan :<br />".$remark;

		$html .= "<br /><br /><table class='signiture'>
			  <tr>
			  <td align='center' width='38%'>
			  Mengetahui<br />a.n Kepala ".$system_params[2]."<br />";
	
		if(count($legalitator_row)>0){
			$html .= $legalitator_row['nama_jabatan'].
					 "<br /><br /><br /><br /><br />
					  <b><u>".$legalitator_row['nama']."</u></b>
					  <br />".$legalitator_row['pangkat']."
					  <br />NIP. ".$legalitator_row['nip'];
		}

		$html .= "</td><td align='center' width='38%'>Diperiksa Oleh<br />";

		if(count($evaluator_row)>0){
			$html .= $evaluator_row['nama_jabatan'].
					 "<br /><br /><br /><br /><br />
					  <b><u>".$evaluator_row['nama']."</u></b>
					  <br />".$evaluator_row['pangkat']."
					  <br />NIP. ".$evaluator_row['nip'];
		}

		$html .= "</td><td valign='top'>
				  <table class='noborder'>
				  <tr><td>Dibuat Tanggal</td><td>: ".indo_date_format($row['tgl_penetapan'],'longDate')."</td></tr>
				  <tr><td>Oleh</td><td>: ".$this->session->userdata('fullname')."</td></tr>
				  <tr><td valign='top'>NIP</td><td valign='top'>: ".$this->session->userdata('nip')."<br /><br />&nbsp;</td></tr>
				  <tr><td colspan='2'>Tanda Tangan </td></tr></table></td></tr></table>";

		if($i==$n_row){
			$html .= "</body></html>";
		}

		if($i>1){
			$mpdf->AddPage();
		}

		$mpdf->WriteHTML($html);
		$html = "";
	}

	$mpdf->SetTitle('Nota Perhitungan Pajak Daerah '.strtoupper($tax_name));
	$mpdf->Output('nota_perhitungan_pajak_daerah.pdf','I');
