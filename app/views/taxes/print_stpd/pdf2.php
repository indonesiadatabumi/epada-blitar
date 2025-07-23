<?php

	$html = "<!DOCTYPE html><html><head>
			<title>".$this->config->item('sys_name_acr').' '.$system_params[7].' '.$system_params[6]." | Surat Ketetapan Pajak Daerah</title>
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
				<td>
					<table class='noborder'>
					<tr>
					<td><img src='".$this->config->item('img_path')."logo_pemda.png' style='width:42px;'/>
					</td>
					<td>			
					<h6>PEMERINTAH ".strtoupper($system_params[7]." ".$system_params[6])."<br />
					".strtoupper($system_params[2])."<br />
					<font style='font-weight:normal'>".$system_params[3]."</font><br />
					<font style='font-weight:normal'>Telp. ".$system_params[4]."</font><br />
					<font style='font-weight:normal'>".$system_params[6]."</font>
					</h6>
					</td></tr></table>
				</td>
				<td align='center' width='42%'>
					<h4>".$row['singkatan_spt']."<br />
					<font style='font-weight:normal;font-size:".($spt_type_id=='15'?'0.7em':'0.9em')."'>(".$row['keterangan_spt'].")</font><br />
					<font style='font-weight:normal'>Masa Pajak : ".$tax_period."</font><br />
					<font style='font-weight:normal'>Tahun : ".$row['tahun_pajak']."</font>
					</h4><br />
				</td>
				<td class='bor-right' align='center' width='10%'>
					No. Urut<br />".sprintf('%0'.$system_params[16].'s',$row['kohir'])."
				</td>
				</tr>";
		

		$html .= "<tr>
				<td colspan='3' class='bor-right'>
					<table class='noborder nopadding'>
					<tr><td>Nama</td><td>: ".$row['nama_wp']."</td></tr>
					<tr><td>Alamat</td><td>: ".$row['alamat'].", Kel. ".$row['kelurahan']."</td></tr>
					<tr><td>NPWPD</td><td>: ".$row['npwpd']."</td></tr>
					<tr><td>Tgl. Jatuh Tempo</td><td>: ".indo_date_format($row['tgl_jatuh_tempo'],'longDate')."</td></tr>
					<tr><td>Kode Billing</td><td>: ".$row['kode_billing']."</td></tr>
					</table>
				</td></tr>";
		$tot_credit = $row['kompensasi']+$row['setoran']+$row['kredit_pajak_lain'];
		$insufficient_pay = $row['pajak_terhutang']-$tot_credit;
		$tot_sanctions = $row['bunga']+$row['diskon'];
		$tot_payment = $insufficient_pay+$tot_sanctions;

		$form_model = '';
		switch ($spt_type_id) {
			case '11':$form_model='DPD-10D';break;
			case '12':$form_model='DPD-10F';break;
			case '14':$form_model='DPD-10C';break;
			case '15':$form_model='DPD-10E';break;
		}

		$html .= "<tr>
				<td colspan='3' class='bor-right'>
					<table class='noborder nopadding' style='font-size:0.9em!important'>
						<tr>
						<td valign='top' width='2%'>I.</td><td valign='top' colspan='2'>Berdasarkan Pasal 170 Undang-Undang No. 28 Tahun 2009 telah dilakukan pemeriksaan atau keterangan lain atas pelaksanaan kewajiban:</td>
						</tr>
						<tr><td></td><td width='25%'>Kode Rekening</td><td>: ".$row['kode_rekening']."</td></tr>
						<tr><td></td><td>Nama Pajak</td><td>: ".$row['nama_pajak']."</td></tr>						
						<tr><td valign='top'>II.</td><td valign='top' colspan='2'>Dan pemeriksaan atau keterangan lain tersebut di atas, perhitungan jumlah yang masih harus dibayar adalah sebagai berikut : </td></tr>
						<tr>
						<td></td>
						<td colspan='2'>
						<table class='noborder nopadding'>
							<tr><td width='2%'>1.</td><td colspan='3'>Dasar Pengenaan</td><td width='5%'>Rp.</td><td align='right' width='14%'>".number_format($row['nilai_terkena_pajak'])."</td></tr>
							<tr><td>2.</td><td colspan='3'>Pajak yang terhutang</td><td>Rp.</td><td align='right'>".number_format($row['pajak_terhutang'])."</td></tr>
							<tr><td>3.</td><td colspan='5'>Kredit Pajak :</td></tr>
							<tr><td colspan='6'></td></tr>
							<tr><td></td><td>a. Kompensasi kelebihan dari tahun sebelumnya</td>
							<td>Rp.</td><td align='right'>".number_format($row['kompensasi'])."</td><td colspan='2'></td></tr>
							<tr><td></td><td>b. Setoran yang dilakukan</td>
							<td>Rp.</td><td align='right' width='14%'>".number_format($row['setoran'])."</td><td colspan='2'></td></tr>
							<tr><td></td><td>c. Lain-lain</td>
							<td>Rp.</td><td align='right' width='14%'>".number_format($row['kredit_pajak_lain'])."</td><td colspan='2'></td></tr>
						<tr><td></td><td>d. Jumlah yang dapat dikreditkan (a+b+c)</td><td colspan='2' class='bor-top'></td><td>Rp.</td><td align='right'>".number_format($tot_credit)."</td></tr>";

				if($spt_type_id!='14'){
					$html .= "<tr><td colspan='4'></td><td colspan='2' class='bor-bottom'></td></tr>
						<tr><td>4.</td><td colspan='3'>Jumlah kekurangan pembayaran Pokok Pajak (2-3d)</td><td>Rp.</td><td align='right'>".number_format($insufficient_pay)."</td></tr>
						<tr><td>5.</td><td colspan='5'>Sanksi Administrasi :</td></tr>
						<tr><td colspan='6'></td></tr>
						<tr><td></td><td>a. Bunga (Psl. 9(1))</td>
						<td>Rp.</td><td align='right'>".number_format($row['bunga'])."</td><td colspan='2'></td></tr>
						<tr><td></td><td>a. Kenaikan (Psl. 9(5))</td>
						<td>Rp.</td><td align='right'>".number_format($row['diskon'])."</td><td colspan='2'></td></tr>
						<tr><td></td><td>c. Jumlah sanksi administrasi (a+b)</td><td colspan='2' class='bor-top'></td><td>Rp.</td><td align='right'>".number_format($tot_sanctions)."</td></tr>
						<tr><td colspan='4'></td><td colspan='2' class='bor-bottom'></td></tr>
						<tr><td>6.</td><td colspan='3'>Jumlah yang masih harus dibayar (4-5c)</td><td>Rp.</td><td align='right'>".number_format($tot_payment)."</td></tr>";
				}else{
					$html .= "<tr><td>4.</td><td colspan='3'>Jumlah yang masih harus dibayar (2-3d)</td><td>Rp.</td><td align='right'>".number_format($tot_payment)."</td></tr>";
				}
				
				$html .= "</table>
						</td>
						</tr>
					</table>
				</td>
				</tr>
				<tr>
				<td colspan='3' class='bor-right'>
					<table class='noborder' style='font-size:0.9em'>
					<tr><td align='right'>Dengan huruf :</td><td style='border:1px solid #000'>".($tot_payment>0?ucwords(NumToWords($tot_payment))." Rupiah":"NIHIL")."</td></tr>
					</table>
				</td>
				</tr>";
			if($spt_type_id!='14'){
				$html .= "<tr>
				<td colspan='3' class='bor-right'>
					<h5>PERHATIAN</h5>
					<table class='noborder nopadding' style='font-size:0.8em'>";
				if($spt_type_id!='12'){
					$html .= "<tr><td valign='top'>1.</td><td valign='top'>Harap penyetoran dilakukan melalui Bendahara Penerimaan atau Kas Daerah dengan menggunakan Surat Setoran Pajak Daerah (SSPD).</td></tr>
							<tr><td valign='top'>2.</td><td valign='top'>Apabila ".$row['singkatan_spt']." ini tidak atau Kurang Dibayar setelah lewat paling lama 30 hari sejak ".$row['singkatan_spt']." ini ditetapkan dikenakan sanksi administrasi beruba bunga sebesar 2% per bulan.</td></tr>";
				}else{
					$html .= "<tr><td valign='top'>1.</td><td valign='top'>Pengembalian kelebihan pajak dilakukan pada Kas Daerah dengan menggunakan Surat Perintah Membayar Kelebihan Pajak (SPMKP) dan Surat Perintah Mengeluarkan Uang (SPMU).</td></tr>";
				}
				
				$html .= "</table></td></tr>";
			}
			$html .= "<tr>
				<td colspan='3' style='font-size:0.9em' class='bor-right bor-bottom'>
					<table class='noborder'>
					<tr>
					<td>
						<img src='https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=".$row['kode_billing']."' height='150' width='150'/>
					</td>
					<td width='40%' align='center'>
						".$system_params[6].", ".indo_date_format($row['tgl_penetapan'],'longDate')."<br />
						a.n. Kepala ".$system_params[2]."<br />
						".$legalitator_row['nama_jabatan']."<br /><br /><br /><br />
						<b><u>".$legalitator_row['nama']."</u></b>
						<br />".$legalitator_row['pangkat']."
						<br />NIP. ".$legalitator_row['nip']."
					</td>
					</tr>
					</table>
				</td>
				</tr>
				</table>
				<table class='noborder nopadding' style='font-size:0.8em'>
				<tr><td width='20%'>Model ".$form_model."</td>
				<td width='60%' align='center'>".str_repeat('.',30)."<i>gunting di sini</i>".str_repeat('.',30)."</td>
				<td></td></tr></table>
				<table class='report' cellpadding='0' cellspacing='0'>
				<tr>
				<td class='bor-right bor-bottom'>
					<table class='noborder nopadding smallfont'>
						<tr><td align='center'>No. ".$row['singkatan_spt']." : ".sprintf('%0'.$system_params[16].'s',$row['kohir'])."</td></tr>
						<tr><td align='center'><b>TANDA TERIMA</b></td></tr>
					</table>
					<table class='noborder nopadding smallfont'>
						<tr><td>NPWPD</td><td>: ".$row['npwpd']."</td></tr>
						<tr><td>Nama</td><td>: ".$row['nama_wp']."</td></tr>
						<tr><td>Alamat</td><td>: ".$row['alamat'].", Kel. ".$row['kelurahan'].", Kec. ".$row['kecamatan']."</td></tr>
					</table>
					<table class='noborder nopadding smallfont'>
					<tr><td width='75%'>&nbsp;</td><td align='center'>
					".str_repeat('.',20)." Tahun ......<br />
					Yang menerima<br /><br /><br />
					(".str_repeat('.',30).")
					</td></tr>
					</table>
				</td>
				</tr>
				</table>Model ".$form_model;



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