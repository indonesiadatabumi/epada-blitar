<?php

	$html = "<!DOCTYPE html><html><head>
			<title>".$this->config->item('sys_name_acr').' '.$system_params[7].' '.$system_params[6]." | Daftar Formulir Pendaftaran</title>
			<link rel='stylesheet' type='text/css' href='".$this->config->item('css_path')."report-style.css'/>
			<style type='text/css'>@import ".$this->config->item('css_path')."report-table-style.css</style>
			</head>
			<body>			
			<h3 align='center'><u>DAFTAR FORMULIR PENDAFTARAN</u><br />
			<font style='font-weight:normal'>".$tax_name."</font>
			</h3><br />
			<table class='report' cellpadding='0' cellspacing='0'>
			<thead>
			<tr>
			<th>No.</th><th>No. Formulir</th><th>Nama</th><th>Keg. Usaha</th>
			<th>Alamat Lengkap</th><th>Tgl. Dikirim</th><th>Tgl. Kembali</th><th class='bor-right'>Keterangan</th>
			</tr>
			</thead>
			<tbody>";

	$no=0;
	$n_rows = count($rows);
	foreach($rows as $row){
		$no++;
		$border_bottom = ($no==$n_rows?'bor-bottom':'');
		$html .= "<tr><td align='center' class='".$border_bottom."'>".$no."</td>
				  <td align='center' class='".$border_bottom."'>".$row['no_form']."</td>
				  <td class='".$border_bottom."'>".$row['nama']."</td>
				  <td class='".$border_bottom."'>".$row['nama_kegus']."</td>
				  <td class='".$border_bottom."'>".$row['alamat']."</td>
				  <td align='center' class='".$border_bottom."'>".$row['tgl_dikirim']."</td>
				  <td align='center' class='".$border_bottom."'>".$row['tgl_kembali']."</td>
				  <td class='bor-right ".$border_bottom."'></td>
				  </tr>";
	}

	$html .= "</tbody></table><br /><br />
			  <table class='signiture'>
			  <tr>
			  <td align='center' width='38%'>
			  Mengetahui<br />";
	
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

	$html .= "</td><td>
			  <br />
			  Tanggal dibuat : ".indo_date_format($print_date,'longDate')."
			  <br />
			  Nama : ".$this->session->userdata('fullname')."
			  <br /><br />Tanda Tangan : </td></tr></table></body></html>";

	$mpdf->SetTitle('Daftar Formulir Pendaftaran');
	$mpdf->WriteHTML($html);
	$mpdf->Output('daftar_formulir_pendaftaran.pdf','I');
?>