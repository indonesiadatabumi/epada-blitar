<?php

	$html = "<!DOCTYPE html><html><head>
			<title>".$this->config->item('sys_name_acr').' '.$system_params[7].' '.$system_params[6]." | Surat Tagihan Pajak Daerah</title>
			<link rel='stylesheet' type='text/css' href='".$this->config->item('css_path')."report-style.css'/>
			<style type='text/css'>@import ".$this->config->item('css_path')."report-table-style.css</style>
			</head>
			<body>";

	$i = 0;

	$n_row = count($rows);

	foreach($rows as $row){
		$i++;
		$x_date = explode('-',$row['masa_pajak1']);
		$tax_period = get_monthName($x_date[1]);

		$html.= "
				<table cellpadding=0 cellspacing=0 class='report'>
				<tr>
				<td width='35%'>
				<table class='noborder'>
				<tr>
				<td><img src='".$this->config->item('img_path')."logo_pemda.png' style='width:42px;'/>
				</td>
				<td>
				<h5>PEMERINTAH <br />".strtoupper($system_params[7]." ".$system_params[6])."
				</h5>
				</td></tr></table>
				</td>
				<td align='center' width='42%'>
				<h5>SURAT TAGIHAN PAJAK DAERAH<br />
				<span style='font-weight:normal'>(STP-DAERAH)</span>
				</h5><br />
				</td>
				<td class='bor-right' align='center'>
				<h5>NO. URUT</h5>
				".sprintf('%0'.$system_params[16].'s',$row['kohir'])."</td>
				</tr>
				<tr>
				<td colspan='3' class='bor-right'>
					<table class='noborder'>
					<tr><td width='45%'>Nama</td><td>: ".$row['nama_wp']."</td></tr>
					<tr><td>Alamat</td><td>: ".$row['alamat'].", Kel. ".$row['kelurahan']."</td></tr>
					<tr><td>Nomor Pokok Wajib Pajak Daerah (NPWPD)</td><td>: ".$row['npwpd']."</td></tr>
					<tr><td>Tgl. Jatuh Tempo</td><td>: ".indo_date_format($row['tgl_jatuh_tempo'],'longDate')."</td></tr>
					<tr><td>Kode Billing</td><td>: ".$row['kode_billing']."</td></tr>
					</table>
				</td></tr>
				<tr>
				<td colspan='3' style='padding:10px;' class='bor-right nobor-top'>";

		$html .= "<table class='report' cellpadding='0' cellspacing='0'>
					<tr><td align='center'>NO.</td><td align='center'>KODE REKENING</td><td align='center' colspan='2'>URAIAN PAJAK DAERAH</td>
					<td align='center' class='bor-right'>JUMLAH (Rp.)</td></tr>
					<tr><td align='center' valign='top'>1.</td>
					<td align='center' valign='top'>".$row['kode_rekening']."</td>
					<td valign='top' colspan='2'>".$row['nama_pajak']."<br />".$row['nama_kegus'];
			
		if($row['pajak_id']=='3'){
			$html .= "<br />Judul Reklame : ".$row['judul_reklame'];
		}
		$html .= "</td>
					<td class='bor-right' align='right' valign='top'>".number_format($row['pajak'])."</td>
					</tr>";

		$total = $row['pajak'];
		$interest = $row['bunga'];
		$discount = $row['diskon'];
		$grand_total = $total+$interest-$discount;

		$html .= "<tr><td colspan='2'></td><td colspan='2'>Jumlah Ketetapan Pokok Pajak</td><td align='right' class='bor-right'>".number_format($total)."</td></tr>
					<tr><td colspan='2' class='nobor-top'></td><td>Jumlah Sanksi</td><td class='nobor-left'>: a. Bunga</td><td align='right' class='bor-right'>".number_format($interest)."</td></tr>
					<tr><td colspan='2' class='nobor-top'></td><td></td><td class='nobor-left'>: b. Kenaikan</td><td align='right' class='bor-right'>".number_format($discount)."</td></tr>
					<tr><td colspan='2' class='nobor-top bor-bottom'></td><td colspan='2' class='bor-bottom'>Jumlah Keseluruhan</td><td align='right' class='bor-right bor-bottom'>".number_format($grand_total)."</td></tr>
					</table>
				</td>
				</tr>
				<tr><td colspan='3' style='padding:0px 10px 10px 10px' class='nobor-top bor-right'>
				<table class='report' cellpadding=0 cellspacing=0>
					<tr><td width='20%' class='nobor-left nobor-top'>Dengan Huruf :</td>
					<td class='bor-right bor-bottom'>".ucwords(NumToWords($grand_total))." Rupiah</td></tr>
				</table>
				</td></tr>
				<tr>
				<td colspan='3' style='padding:10px' class='bor-right'>
					<h5><u>PERHATIAN :</u></h5>";
		
		
		$html .= "<table class='noborder' style='font-size:0.8em'>
					<tr><td valign='top'>1.</td><td valign='top'>Harap penyetoran dilakukan pada Bank/Bendahara Penerimaan.</td></tr>
					<tr><td valign='top'>2.</td><td valign='top'>Apabila STPD ini tidak atau kurang dibayar setelah waktu paling lama 30 hari setelah STPD diterima atau (Tanggal jatuh tempo)
					dikenakan sanksi administrasi berupa bunga sebesar 2 % per bulan</td></tr>
					</table>";


		$html .= "</td>
				</tr>
				<tr>
				<td colspan='3' style='padding:10px' class='bor-right bor-bottom'>
					<table class='noborder'>
					<tr>
					<td>
						<img src='https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=".$row['kode_billing']."' height='150' width='150'/>
					</td>
					<td width='50%'>
						<table class='noborder'>
							<tr><td></td><td>".$system_params[19].", ".indo_date_format($row['tgl_penetapan'],'longDate')."</td></tr>
							<tr><td align='right' valign='top'>a.n</td>
							<td>Kepala ".$system_params[2]."<br />
							".$legalitator_row['nama_jabatan']."<br /><br /><br /><br /><br />
							<b><u>".$legalitator_row['nama']."</u></b>
							<br />Pangkat : ".$legalitator_row['pangkat']."
							<br />NIP : ".$legalitator_row['nip']."
							</td></tr>
						</table>
					</td>
					</tr>
					</table>
				</td>
				</tr></table>				
				<p style='font-style:italic;font-size:0.8em;margin-bottom:10px;'>".str_repeat(".",88)." potong di sini ".str_repeat(".",88)."</p>
				<table class='report' cellspacing='0'>
				<tr>
				<td colspan='3' class='bor-right' align='right'>				
					NO. URUT : ".sprintf('%0'.$system_params[16].'s',$row['kohir'])."
				</td>
				<tr>
				<td colspan='3' class='bor-right bor-bottom nobor-top' align='center'>
					<b>TANDA TERIMA</b><br />
					<table class='noborder'>
						<tr>
						<td width='25%' align='left'>
							<table class='noborder'>
								<tr><td>Nama</td><td>: ".$row['nama_wp']."</td></tr>
								<tr><td>Alamat</td><td>: ".$row['alamat']."</td></tr>
								<tr><td>NPWPD</td><td>: ".$row['npwpd']."</td></tr>
							</table>
						</td>
						<td width='25%' align='left'>
							".$system_params[19].", ".indo_date_format(date('Y-m-d'),'longDate')."<br />
							Yang menerima,
							<br />
							<br />
							<br />
							<br />
							(".str_repeat('.',40).")
						</td>
						
						</tr>
					</table>
				</td>
				</tr>
				</table>";

		$html .= "<p style='font-size:0.8em'>
					*) Coret yang tidak perlu<br />
					Catatan : <br />
					Penetapan jumlah STP - Daerah didasarkan pada nota perhitungan sebagai dasar perhitungan pajak
				</p>";

		if($i==$n_row){
			$html .= "</body></html>";
		}

		if($i>1){
			$mpdf->AddPage();
		}

		$mpdf->WriteHTML($html);
		$html = "";
	}

	$mpdf->SetTitle('Surat Ketetapan Pajak Daerah '.strtoupper($tax_name));
	$mpdf->Output('surat_ketetapan_pajak_daerah.pdf','I');
?>