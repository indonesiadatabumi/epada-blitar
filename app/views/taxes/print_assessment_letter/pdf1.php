<?php
$html = "<!DOCTYPE html><html><head>
			<title>" . $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6] . " | Surat Ketetapan Pajak Daerah</title>
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
	$pajak_sesungguhnya = $row['pajak'];

	if ($row['wp_wr_id'] == '40') {
		$html .= "
				<table cellpadding=0 cellspacing=0 class='report'>
				<tr>
				<td width='35%'>
				<table class='noborder'>
				<tr>
				<td><img src='" . $this->config->item('logo_path') . "logo_pemda.png' style='width:42px;'/>
				</td>
				<td>
				<h5>PEMERINTAH <br />" . strtoupper($system_params[7] . " " . $system_params[6]) . "
				</h5>
				</td></tr></table>
				</td>
				<td align='center' width='42%'>
				<h5>SURAT KETETAPAN PAJAK DAERAH<br />
				<span style='font-weight:normal'>(SKP-DAERAH)</span>
				</h5><br />
				</td>
				<td class='bor-right' align='center'>
				<h5>NO. URUT</h5>
				" . sprintf('%0' . $system_params[16] . 's', $row['kohir']) . "</td>
				</tr>
				<tr>
				<td colspan='3' class='bor-right'>
					<table class='noborder' style='font-size:0.8em'>
					<tr><td width='45%' style='font-size:10px;'>Nama Wajib Pajak</td><td style='font-size:10px;'>: " . $row['nama_pemilik'] . "</td></tr>
					<tr><td width='45%' style='font-size:10px;'>Nama Perusahaan</td><td style='font-size:10px;'>: " . $row['nama_wp'] . "</td></tr>
					<tr><td style='font-size:10px;'>Alamat Perusahaan</td><td style='font-size:10px;'>: " . $row['alamat'] . "</td></tr>
					<tr><td style='font-size:10px;'>Nomor Pokok Wajib Pajak Daerah (NPWPD)</td><td style='font-size:10px;'>: P.2." . $row['npwpd'] . "</td></tr>
					<tr><td style='font-size:10px;'>Masa Pajak</td><td style='font-size:10px;'> : " . $tax_period . "</td></tr>
					<tr><td style='font-size:10px;'>Tgl. Jatuh Tempo</td><td style='font-size:10px;'>: " . indo_date_format($row['tgl_jatuh_tempo'], 'longDate') . "</td></tr>
					<tr><td style='font-size:10px;'>Kode Billing</td><td style='font-size:10px;'>: 3505" . $kode_pajak['rek_bank'] . $row['kode_billing'] . "</td></tr>
					</table>
				</td></tr>
				<tr>
				<td colspan='3' style='padding:10px;' class='bor-right nobor-top'>";
	} else {
		$html .= "
				<table cellpadding=0 cellspacing=0 class='report'>
				<tr>
				<td width='35%'>
				<table class='noborder'>
				<tr>
				<td><img src='" . $this->config->item('img_path') . "logo_pemda.png' style='width:42px;'/>
				</td>
				<td>
				<h5>PEMERINTAH <br />" . strtoupper($system_params[7] . " " . $system_params[6]) . "
				</h5>
				</td></tr></table>
				</td>
				<td align='center' width='42%'>
				<h5>SURAT KETETAPAN PAJAK DAERAH<br />
				<span style='font-weight:normal'>(SKP-DAERAH)</span>
				</h5><br />
				</td>
				<td class='bor-right' align='center'>
				<h5>NO. URUT</h5>
				" . sprintf('%0' . $system_params[16] . 's', $row['kohir']) . "</td>
				</tr>
				<tr>
				<td colspan='3' class='bor-right'>
					<table class='noborder' style='font-size:0.8em'>
					<tr><td width='45%' style='font-size:10px;'>Nama Wajib Pajak</td><td style='font-size:10px;'>: " . $row['nama_pemilik'] . "</td></tr>
					<tr><td width='45%' style='font-size:10px;'>Nama Perusahaan</td><td style='font-size:10px;'>: " . $row['nama_wp'] . "</td></tr>
					<tr><td style='font-size:10px;'>Alamat Perusahaan</td><td style='font-size:10px;'>: " . $row['alamat'] . ", Kel. " . $row['kelurahan'] . "</td></tr>
					<tr><td style='font-size:10px;'>Nomor Pokok Wajib Pajak Daerah (NPWPD)</td><td style='font-size:10px;'>: P.2." . $row['npwpd'] . "</td></tr>
					<tr><td style='font-size:10px;'>Masa Pajak</td><td style='font-size:10px;'> : " . $tax_period . "</td></tr>
					<tr><td style='font-size:10px;'>Tgl. Jatuh Tempo</td><td style='font-size:10px;'>: " . indo_date_format($row['tgl_jatuh_tempo'], 'longDate') . "</td></tr>
					<tr><td style='font-size:10px;'>Kode Billing</td><td style='font-size:10px;'>: 3505" . $kode_pajak['rek_bank'] . $row['kode_billing'] . "</td></tr>
					</table>
				</td></tr>
				<tr>
				<td colspan='3' style='padding:10px;' class='bor-right nobor-top'>";
	}

	$npa1 = $row['vol_0_50'] * $row['hrg_0_50'];
	$npa2 = $row['vol_51_500'] * $row['hrg_51_500'];
	$npa3 = $row['vol_501_1000'] * $row['hrg_501_1000'];
	$npa4 = $row['vol_1001_2500'] * $row['hrg_1001_2500'];
	$npa5 = $row['vol_leb_2500'] * $row['hrg_leb_2500'];
	$tot_npa = $npa1 + $npa2 + $npa3 + $npa4 + $npa5;

	if ($row['hrg_0_50'] == '0') {
		$html .= "<table class='report' cellpadding='0' cellspacing='0'>
					<tr><td align='center' style='font-size:10px;'>NO.</td><td width='20%' align='center' style='font-size:10px;'>KODE REKENING</td><td align='center' colspan='2' style='font-size:10px;'>URAIAN PAJAK DAERAH</td>
					<td align='center' class='bor-right' style='font-size:10px;'>JUMLAH (Rp.)</td></tr>
					<tr><td align='center' valign='top' style='font-size:10px;'>1.</td>
					<td align='center' valign='top' style='font-size:10px;'>" . $row['kode_rekening'] . "</td>
					<td valign='top' colspan='2' style='font-size:10px;'>Ketetapan " . $row['nama_pajak'] . " Bagian Bulan<br />" . $tax_period . " Tahun " . $row['tahun_pajak'] . "<br/> Volume : " . $row['volume'] . "<br/>Harga Dasar Air : " . number_format($row['tarif_dasar'], 0, '.', ',') . "<br/>Nilai Perolehan Air : " . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "<br/>Tarif : " . $row['persen_tarif'] . "%<br/>" . $row['nama_pajak'] . " : " . number_format($pajak_sesungguhnya, 0, '.', ',') . "";
	} else {
		$html .= "<table class='report' cellpadding='0' cellspacing='0'>
					<tr><td align='center' style='font-size:10px;'>NO.</td><td width='20%' align='center' style='font-size:10px;'>KODE REKENING</td><td align='center' colspan='2' style='font-size:10px;'>URAIAN PAJAK DAERAH</td>
					<td align='center' class='bor-right' style='font-size:10px;'>JUMLAH (Rp.)</td></tr>
					<tr><td align='center' valign='top' style='font-size:10px;'>1.</td>
					<td align='center' valign='top' style='font-size:10px;'>" . $row['kode_rekening'] . "</td>
					<td valign='top' colspan='2' style='font-size:10px;'>Ketetapan " . $row['nama_pajak'] . " Bagian Bulan<br />" . $tax_period . " Tahun " . $row['tahun_pajak'] . "<br/> Volume : " . $row['volume'] . "<br/>Harga Dasar Air : " . number_format($row['hrg_0_50'], 0, '.', ',') . ", " . number_format($row['hrg_51_500'], 0, '.', ',') . ", " . number_format($row['hrg_501_1000'], 0, '.', ',') . ", " . number_format($row['hrg_1001_2500'], 0, '.', ',') . ", " . number_format($row['hrg_leb_2500'], 0, '.', ',') . "<br/>Nilai Perolehan Air : " . number_format($tot_npa, 0, '.', ',') . "<br/>Tarif : " . $row['persen_tarif'] . "%<br/>" . $row['nama_pajak'] . " : " . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "";
	}

	if ($row['pajak_id'] == '3') {
		$html .= "<br />Judul Reklame : " . $row['judul_reklame'];
	}
	if ($row['pajak_id'] == '7') {
		if ($row['hrg_0_50'] == '0') {
			$html .= "</td>
					<td class='bor-right' align='right' valign='top' style='font-size:10px;'>" . number_format($pajak_sesungguhnya, 0, '.', ',') . "</td>
					</tr>";
		} else {
			$html .= "</td>
					<td class='bor-right' align='right' valign='top' style='font-size:10px;'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td>
					</tr>";
		}
	} else {
		$html .= "</td>
					<td class='bor-right' align='right' valign='top' style='font-size:10px;'>" . number_format($pajak_sesungguhnya, 0, '.', ',') . "</td>
					</tr>";
	}
	if ($row['hrg_0_50'] == '0') {
		if ($row['wp_wr_id'] == '40') {
			$pengurangan_pat = (97 / 100) * $row['pajak'];
			$total = $pajak_sesungguhnya - $pengurangan_pat;
		} else {
			$pengurangan_pat = (55 / 100) * $row['pajak'];
			$total = $pajak_sesungguhnya - $pengurangan_pat;
		}
	} else {
		if ($row['wp_wr_id'] == '40') {
			$pengurangan_pat = (97 / 100) * $row['nilai_terkena_pajak'];
			$total = $pajak_sesungguhnya;
		} else {
			$pengurangan_pat = (55 / 100) * $row['nilai_terkena_pajak'];
			$total = $pajak_sesungguhnya;
		}
	}
	$interest = $row['bunga'];
	$discount = $row['diskon'];
	$grand_total = $total + $interest - $discount;
	// $diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
	// $fine = assess_fine($row['pajak'], $diff_month);
	// $total = $row['pajak'] + $fine;
	if ($row['hrg_0_50'] == '0') {
		if ($row['wp_wr_id'] == '40') {
			$html .= "<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Ketetapan Pokok Pajak</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($pajak_sesungguhnya, 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Kompensasi Bulan Sebelumnya</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($row['kompensasi'], 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Pengurangan PAT 55%</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($pengurangan_pat, 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' class='nobor-top' style='font-size:10px;'></td><td style='font-size:10px;'>Jumlah Sanksi</td><td class='nobor-left' style='font-size:10px;'>: a. Denda</td><td align='right' class='bor-right' style='font-size:10px;'>0</td></tr>
					<tr><td colspan='2' class='nobor-top' style='font-size:10px;'></td><td></td><td class='nobor-left' style='font-size:10px;'>: b. Kenaikan</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format('0', 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' class='nobor-top bor-bottom' style='font-size:10px;'></td><td colspan='2' class='bor-bottom' style='font-size:10px;'>Jumlah Keseluruhan</td><td align='right' class='bor-right bor-bottom' style='font-size:10px;'>" . number_format($total, 0, '.', ',') . "</td></tr>
					</table>
				</td>
				</tr>
				<tr><td colspan='3' style='padding:0px 10px 10px 10px' class='nobor-top bor-right'>
				<table class='report' cellpadding=0 cellspacing=0>
					<tr><td width='20%' class='nobor-left nobor-top' style='font-size:10px;'>Dengan Huruf :</td>
					<td class='bor-right bor-bottom' style='font-size:10px;'>" . ucwords(NumToWords(round($total))) . " Rupiah</td></tr>
				</table>
				</td></tr>
				<tr>
				<td colspan='3' style='padding:10px' class='bor-right'>
					<h5><u>PERHATIAN :</u></h5>";
		} else {
			$html .= "<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Ketetapan Pokok Pajak</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($pajak_sesungguhnya, 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Kompensasi Bulan Sebelumnya</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($row['kompensasi'], 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Pengurangan PAT 55%</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($pengurangan_pat, 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' class='nobor-top' style='font-size:10px;'></td><td style='font-size:10px;'>Jumlah Sanksi</td><td class='nobor-left' style='font-size:10px;'>: a. Denda</td><td align='right' class='bor-right' style='font-size:10px;'>0</td></tr>
					<tr><td colspan='2' class='nobor-top' style='font-size:10px;'></td><td></td><td class='nobor-left' style='font-size:10px;'>: b. Kenaikan</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format('0', 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' class='nobor-top bor-bottom' style='font-size:10px;'></td><td colspan='2' class='bor-bottom' style='font-size:10px;'>Jumlah Keseluruhan</td><td align='right' class='bor-right bor-bottom' style='font-size:10px;'>" . number_format($total, 0, '.', ',') . "</td></tr>
					</table>
				</td>
				</tr>
				<tr><td colspan='3' style='padding:0px 10px 10px 10px' class='nobor-top bor-right'>
				<table class='report' cellpadding=0 cellspacing=0>
					<tr><td width='20%' class='nobor-left nobor-top' style='font-size:10px;'>Dengan Huruf :</td>
					<td class='bor-right bor-bottom' style='font-size:10px;'>" . ucwords(NumToWords(round($total))) . " Rupiah</td></tr>
				</table>
				</td></tr>
				<tr>
				<td colspan='3' style='padding:10px' class='bor-right'>
					<h5><u>PERHATIAN :</u></h5>";
		}
	} else {
		if ($row['wp_wr_id'] == '40') {
			$html .= "<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Ketetapan Pokok Pajak</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Kompensasi Bulan Sebelumnya</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($row['kompensasi'], 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Pengurangan PAT 97%</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($pengurangan_pat, 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' class='nobor-top' style='font-size:10px;'></td><td style='font-size:10px;'>Jumlah Sanksi</td><td class='nobor-left' style='font-size:10px;'>: a. Denda</td><td align='right' class='bor-right' style='font-size:10px;'>0</td></tr>
					<tr><td colspan='2' class='nobor-top' style='font-size:10px;'></td><td></td><td class='nobor-left' style='font-size:10px;'>: b. Kenaikan</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format('0', 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' class='nobor-top bor-bottom' style='font-size:10px;'></td><td colspan='2' class='bor-bottom' style='font-size:10px;'>Jumlah Keseluruhan</td><td align='right' class='bor-right bor-bottom' style='font-size:10px;'>" . number_format($total, 0, '.', ',') . "</td></tr>
					</table>
				</td>
				</tr>
				<tr><td colspan='3' style='padding:0px 10px 10px 10px' class='nobor-top bor-right'>
				<table class='report' cellpadding=0 cellspacing=0>
					<tr><td width='20%' class='nobor-left nobor-top' style='font-size:10px;'>Dengan Huruf :</td>
					<td class='bor-right bor-bottom' style='font-size:10px;'>" . ucwords(NumToWords(round($total))) . " Rupiah</td></tr>
				</table>
				</td></tr>
				<tr>
				<td colspan='3' style='padding:10px' class='bor-right'>
					<h5><u>PERHATIAN :</u></h5>";
		} else {
			$html .= "<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Ketetapan Pokok Pajak</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($row['nilai_terkena_pajak'], 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Kompensasi Bulan Sebelumnya</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($row['kompensasi'], 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' style='font-size:10px;'></td><td colspan='2' style='font-size:10px;'>Jumlah Pengurangan PAT 55%</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format($pengurangan_pat, 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' class='nobor-top' style='font-size:10px;'></td><td style='font-size:10px;'>Jumlah Sanksi</td><td class='nobor-left' style='font-size:10px;'>: a. Denda</td><td align='right' class='bor-right' style='font-size:10px;'>0</td></tr>
					<tr><td colspan='2' class='nobor-top' style='font-size:10px;'></td><td></td><td class='nobor-left' style='font-size:10px;'>: b. Kenaikan</td><td align='right' class='bor-right' style='font-size:10px;'>" . number_format('0', 0, '.', ',') . "</td></tr>
					<tr><td colspan='2' class='nobor-top bor-bottom' style='font-size:10px;'></td><td colspan='2' class='bor-bottom' style='font-size:10px;'>Jumlah Keseluruhan</td><td align='right' class='bor-right bor-bottom' style='font-size:10px;'>" . number_format($total, 0, '.', ',') . "</td></tr>
					</table>
				</td>
				</tr>
				<tr><td colspan='3' style='padding:0px 10px 10px 10px' class='nobor-top bor-right'>
				<table class='report' cellpadding=0 cellspacing=0>
					<tr><td width='20%' class='nobor-left nobor-top' style='font-size:10px;'>Dengan Huruf :</td>
					<td class='bor-right bor-bottom' style='font-size:10px;'>" . ucwords(NumToWords(round($total))) . " Rupiah</td></tr>
				</table>
				</td></tr>
				<tr>
				<td colspan='3' style='padding:10px' class='bor-right'>
					<h5><u>PERHATIAN :</u></h5>";
		}
	}



	// $html .= "<table class='noborder' style='font-size:0.8em'>
	// 				<tr><td valign='top'>1.</td><td valign='top'>Harap penyetoran dilakukan pada Bank/Bendahara Penerimaan.</td></tr>
	// 				<tr><td valign='top'>2.</td><td valign='top'>Apabila " . $row['singkatan_spt'] . " ini tidak atau kurang dibayar setelah waktu paling lama 30 hari setelah " . $row['singkatan_spt'] . " diterima atau (Tanggal jatuh tempo)
	// 				dikenakan sanksi administrasi berupa bunga sebesar 2 % per bulan</td></tr>
	// 				<tr><td valign='top'>3.</td><td valign='top'>Pembayaran pajak daerah bukan merupakan bukti izin. Wajib pajak mengurus perijinan pada instansi perijinan terkait.</td></tr>
	// 				</table>";

	$html .= "<table class='noborder' style='font-size:10px;'>
					<tr><td valign='top'>1.</td><td valign='top' align='justify'>Harap penyetoran dilakukan pada Bank/Bendahara Penerimaan.</td></tr>
					<tr><td valign='top'>2.</td><td valign='top' align='justify'>Apabila " . $row['singkatan_spt'] . " ini tidak atau kurang dibayar setelah paling lama 1 (satu) bulan sejak tanggal pengiriman " . $row['singkatan_spt'] . " diberikan sanksi administratif berupa bunga sebesar 1 % (satu persen) per bulan dihitung dari pajak pajak yang kurang dibayar, dihitung dari tanggal jatuh tempo pembayaran sampai dengan tanggal pembayaran, untuk jangka waktu paling lama 24 (dua puluh empat) bulan.</td></tr>
					<tr><td valign='top'>3.</td><td valign='top' align='justify'>Pembayaran pajak daerah bukan merupakan bukti izin. Wajib pajak mengurus perijinan pada instansi perijinan terkait.</td></tr>
					</table>";


	$html .= "</td>
				</tr>
				<tr>
				<td colspan='3' style='padding:10px' class='bor-right bor-bottom'>
					<table class='noborder'>
					<tr>
					<td align='center'>Scan Me <br>
						<img src='" . $this->config->item('img_path') . "barcode_payment_blitar.png'/>
					</td>
					<td width='50%'>
						<table class='noborder' style='font-size:0.8em'>
							<tr><td></td><td>" . $system_params[19] . ", " . indo_date_format($row['tgl_penetapan'], 'longDate') . "</td></tr>
							<tr><td align='right' valign='top'></td>
							<td>Kepala " . $system_params[2] . "<br />
							" . $legalitator_row['nama_jabatan'] . "<br /><br /><br /><br /><br />
							<b><u>" . $legalitator_row['nama'] . "</u></b>
							<br />" . $legalitator_row['pangkat'] . "
							<br />NIP : " . $legalitator_row['nip'] . "
							</td></tr>
						</table>
					</td>
					</tr>
					</table>
				</td>
				</tr></table>		
				<p style='font-style:italic; font-size:8px;text-align:center'>Dokumen ini telah  ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan oleh Balai Besar Sertifikasi Elektronik (BSrE), BSSN</p>
				<p style='font-style:italic; font-size:8px;text-align:center'>Otentisitas dokumen ini dapat dicetak pada https://tte.kominfo.go.id/verifypdf</p>
				<p style='font-style:italic; font-size:8px;margin-bottom:10px;text-align:center'>File pdf dapat diminta pada petugas lapang dan/atau pelayanan pada Badan Pendapatan Daerah Kabupaten Blitar</p>
				<p style='font-style:italic;font-size:0.8em;margin-bottom:10px;'>" . str_repeat(".", 88) . " potong di sini " . str_repeat(".", 88) . "</p>
				<table class='report' cellspacing='0'>
				<tr>
				<td colspan='3' class='bor-right' align='right'>				
					NO. URUT : " . sprintf('%0' . $system_params[16] . 's', $row['kohir']) . "
				</td>
				<tr>
				<td colspan='3' class='bor-right bor-bottom nobor-top' align='center'>
					<b>TANDA TERIMA</b><br />
					<table class='noborder'>
						<tr>
						<td width='25%' align='left'>
							<table class='noborder'>
								<tr><td>Nama</td><td>: " . $row['nama_wp'] . "</td></tr>
								<tr><td>Alamat</td><td>: " . $row['alamat'] . "</td></tr>
								<tr><td>NPWPD</td><td>: P.2." . $row['npwpd'] . "</td></tr>
								<tr><td>Nominal</td><td>: " . number_format($total, 0, '.', ',') . "</td></tr>
								<tr><td>Kode Billing</td><td>: 3505" . $kode_pajak['rek_bank'] . $row['kode_billing'] . "</td></tr>
							</table>
						</td>
						<td width='25%' align='left'>
							" . $system_params[19] . ",<br />
							Yang menerima,
							<br />
							<br />
							<br />
							<br />
							(" . str_repeat('.', 40) . ")
						</td>
						
						</tr>
					</table>
				</td>
				</tr>
				</table>";

	// $html .= "<p style='font-size:0.8em'>
	// 				*) Coret yang tidak perlu<br />
	// 				Catatan : <br />
	// 				Penetapan jumlah SKP - Daerah didasarkan pada nota perhitungan sebagai dasar perhitungan pajak
	// 			</p>";

	if ($i == $n_row) {
		$html .= "</body></html>";
	}

	if ($i > 1) {
		$mpdf->AddPage();
	}

	$mpdf->WriteHTML($html);
	$html = "";
}

$mpdf->SetTitle('Surat Ketetapan Pajak Daerah ' . strtoupper($tax_name));
$mpdf->Output('surat_ketetapan_pajak_daerah.pdf', 'I');
