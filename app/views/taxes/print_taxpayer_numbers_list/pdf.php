<?php

	$html = "<!DOCTYPE html><html><head>
			<title>".$this->config->item('sys_name_acr').' '.$system_params[7].' '.$system_params[6]." | Daftar Perkembangan Wajib Pajak</title>
			<link rel='stylesheet' type='text/css' href='".$this->config->item('css_path')."report-style.css'/>
			<style type='text/css'>@import ".$this->config->item('css_path')."report-table-style.css</style>
			</head>
			<body><div style='margin:10px;'>
			<table border=0 width='100%'>
			<tr>					
			<td align='center'>
			<h3 align='center'>DAFTAR PERKEMBANGAN WAJIB ".($tax_searched?strtoupper($tax_row['nama_paret']):"PAJAK DAERAH")."<br />
			".strtoupper($system_params[1]." ".$system_params[7]." ".$system_params[6])."<br />
			<font style='font-weight:normal'>(".$date_period.")</font>
			</h3><br />
			</td></tr></table><br />";

	$html .="<table class='report' cellpadding='0' cellspacing='0'>
			<thead><tr>
			<th rowspan='2'>No.</th>
			<th rowspan='2'>".($tax_searched?"UPTD":"Jenis Pajak")."</th>
			<th colspan='4'>Jumlah Wajib ".($tax_searched?$tax_row['nama_paret']:"Pajak Daerah")."</th>
			<th rowspan='2' class='bor-right'>Keterangan</th>
			</tr><tr>
			<th>Keadaan s.d bulan lalu</th>
			<th>Penambahan bulan ini</th>
			<th>Penghapusan bulan ini</th>
			<th style='border-right:none'>Jumlah s.d bulan ini</th>
			</tr>
			<tr><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6 = (3+4-5)</th><th class='bor-right'>7</th></tr>
			</thead>
			<tbody>";	

	$no = 0;
	$n_rows = count($rows);
	$grand1 = 0;
	$grand2 = 0;
	$grand3 = 0;
	$grand_total = 0;
	foreach($rows1 as $row1){
		$no++;
		$bor_bottom = ($no==$n_rows?'bor-bottom':'');
		
		$params = array($row1['id']);					
		$dao1->set_sql_params($params);
		$row2 = $dao1->execute(1)->row_array();

		$dao2->set_sql_params($params);
		$row3 = $dao2->execute(1)->row_array();

		$dao3->set_sql_params($params);							
		$row4 = $dao3->execute(1)->row_array();

		$total = $row2['n_row']+$row3['n_row']-$row4['n_row'];
		$grand1 += $row2['n_row'];
		$grand2 += $row3['n_row'];
		$grand3 += $row4['n_row'];
		$grand_total += $total;
		
		$html .= "<tr>
				<td align='center' class='".$bor_bottom."'>".$no."</td>
				<td class='".$bor_bottom."'>".$row1['deskripsi']."</td>
				<td align='right' class='".$bor_bottom."'>".number_format($row2['n_row'])."</td>
				<td align='right' class='".$bor_bottom."'>".number_format($row3['n_row'])."</td>
				<td align='right' class='".$bor_bottom."'>".number_format($row4['n_row'])."</td>
				<td align='right' class='".$bor_bottom."'>".number_format($total)."</td>
)				<td class='bor-right ".$bor_bottom."'></td>
				</tr>";

	}

	$html .= "</tbody><tfoot>
			  <tr><td colspan='2' class='bor-bottom'></td>
			  <td align='right' class='bor-bottom'><b>".number_format($grand1)."</b></td>
			  <td align='right' class='bor-bottom'><b>".number_format($grand2)."</b></td>
			  <td align='right' class='bor-bottom'><b>".number_format($grand3)."</b></td>
			  <td align='right' class='bor-bottom'><b>".number_format($grand_total)."</b></td>
			  <td class='bor-bottom bor-right'></td></tr></tfoot></table><br /><br />
			  <table border=0 width='100%'>
			  <tr>
			  <td align='center'>
			  Mengetahui<br />";

	if(count($legalitator_row)>0){
		$html .= $legalitator_row['nama_jabatan']."
		<br /><br /><br /><br /><br />
		<b><u>".$legalitator_row['nama']."</u></b>
		<br />".$legalitator_row['pangkat']."
		<br />NIP. ".$legalitator_row['nip'];
	}

	$html .= "</td><td align='center'>Diperiksa Oleh<br />";

	if(count($evaluator_row)>0){
		$html .= $evaluator_row['nama_jabatan']."
		<br /><br /><br /><br /><br />
		<b><u>".$evaluator_row['nama']."</u></b>
		<br />".$evaluator_row['pangkat']."
		<br />NIP. ".$evaluator_row['nip'];
	}

	$html .= "</td></tr></table></div></body></html>";

	$mpdf->SetTitle('Daftar Perkembangan Wajib Pajak');
	$mpdf->WriteHTML($html);
	$mpdf->Output('daftar_perkembangan_wajib_pajak.pdf','I');
?>