<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | SSPD</title>
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>report-style.css" />
	<style type="text/css">
		@import "<?= $this->config->item('css_path'); ?>report-table-style.css";
	</style>
	<style type="text/css">
		.card {
			width: 320px;
			float: left;
			margin-right: 5px;
			margin-bottom: 5px;
			padding: 10px;
			border: 1px solid #000;
		}

		table.card-content {
			width: 100%;
			border: none;
		}

		table.card-content td {
			font-size: 0.9em;
		}

		ol li {
			line-height: 20px;
		}

		/* The container */
		.container {
			display: block;
			position: relative;
			padding-left: 22px;
			margin-bottom: 4px;
			cursor: pointer;
			font-size: 12px;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		/* Hide the browser's default checkbox */
		.container input {
			position: absolute;
			opacity: 0;
			cursor: pointer;
			height: 0;
			width: 0;
		}

		/* Create a custom checkbox */
		.checkmark {
			position: absolute;
			top: 0;
			left: 0;
			height: 18px;
			width: 18px;
			background-color: #eee;
		}

		/* On mouse-over, add a grey background color */
		.container:hover input~.checkmark {
			background-color: #ccc;
		}

		/* When the checkbox is checked, add a blue background */
		.container input:checked~.checkmark {
			background-color: #919191;
		}

		/* Create the checkmark/indicator (hidden when not checked) */
		.checkmark:after {
			content: "";
			position: absolute;
			display: none;
		}

		/* Show the checkmark when checked */
		.container input:checked~.checkmark:after {
			display: block;
		}

		/* Style the checkmark/indicator */
		.container .checkmark:after {
			left: 5px;
			top: 1px;
			width: 5px;
			height: 8px;
			border: solid white;
			border-width: 0 3px 3px 0;
			-webkit-transform: rotate(45deg);
			-ms-transform: rotate(45deg);
			transform: rotate(45deg);
		}
	</style>
</head>

<body>
	<div style="margin:10px;">
		<div style="border:1px solid #000;margin-bottom:5px;">
			<table class="report" cellspacing="0">
				<tbody>
					<tr>
						<td width="50%" class="nobor-top nobor-left">
							<table class="noborder">
								<tr>
									<td><img src="<?= $this->config->item('img_path'); ?>logo_pemda.png" style="width:48px;" /></td>
									<td>
										<?php
										echo "<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "</h4>
											<h5>" . strtoupper($system_params[2]) . "<br />
											<font style='font-weight:normal'>" . $system_params[3] . "</font><br />
											<font style='font-weight:normal'>Telp. " . $system_params[4] . ", email : bapenda@blitarkab.go.id, website : bapenda.blitarkab.go.id</font>
											</h5>";
										?>
									</td>
								</tr>
							</table>
						</td>
						<td class="nobor-top nobor-right">
							<table class="noborder">
								<tr>
									<td><b>No. Seri : <?= $row['spt_id']; ?></b></td>
									<!-- <td><b>No. Urut : <?= $row['nomor_spt']; ?></b></td> -->
									<!-- <td><b>No. Urut : <?= $no_sspd; ?></b></td> -->
									<?php
									if ($no_urut_sspd['no_urut_sspd'] == null) {
										echo "<td><b>No. Urut : " . $no_sspd . "</b></td>";
									} else {
										echo "<td><b>No. Urut : " . $no_urut_sspd['no_urut_sspd'] . "</b></td>";
									}
									?>
								</tr>
								<tr>
									<td align="center">
										<h1 style="font-family:times">S S P D</h1>
										<h4>(SURAT SETORAN PAJAK DAERAH)<br />TAHUN <?= date('Y', strtotime($tgl_cetak)); ?></h4>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<?php
			echo "
				<table class='noborder'>
					<tr><td>Nama</td><td colspan='2'>: " . $row['nama_wp'] . "</td></tr>
					<tr><td>Alamat</td><td colspan='2'>: " . $row['alamat'] . "</td></tr>
					<tr><td>NPWPD</td><td colspan='2'>: P.2." . $row['npwpd'] . "</td></tr>
					<tr><td>Kode Billing</td><td colspan='2'>: 3505" . $kode_pajak['rek_bank'] . $row['kode_billing'] . "</td></tr> 
					<tr>
					<td colspan='2' valign='top'>Menyetor berdasarkan *)</td>
					<td>
						<table class='noborder' cellspacing='2'>
							<tr>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '1' ? 'checked' : '') . ">SKPD
								</td>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '3' ? 'checked' : '') . ">STPD
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '99' ? 'checked' : '') . ">Lain-Lain
								</td>
							</tr>
							<tr>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '2' ? 'checked' : '') . ">SKPDT
								</td>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '8' ? 'checked' : '') . ">SPTPD
								<td>									
								</td>
							</tr>
							<tr>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '11' ? 'checked' : '') . ">SKPDKB
								</td>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '16' ? 'checked' : '') . ">SK Pembulatan
								<td></td>
							</tr>
							<tr>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '15' ? 'checked' : '') . ">SKPDKBT
								</td>
								<td>
									<input type='checkbox' " . ($row['jenis_spt_id'] == '17' ? 'checked' : '') . ">SK Keberatan
								<td></td>
							</tr>
						</table>
					</td>	
					</tr>
				</table>
				<table style='border:1px solid black;'>
					<tbody>
						<tr>
							<td colspan='6'><b>Detail Pembayaran :</b></td>
						</tr>";
			if ($row['pajak_id'] == '1') {
				echo "
							<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Pembayaran Sewa Kamar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
							</tr>
							<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Pembayaran Makan dan Minum</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>
							<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Pembayaran Fasilitas Lainnya</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>";
			} elseif ($row['pajak_id'] == '2') {
				echo "
							<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Pembayaran Makan dan Minuman</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
							</tr>
							<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Pembayaran Lain-lain</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>";
			} elseif ($row['pajak_id'] == '4') {
				echo "
							<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Pembayaran Tiket Masuk</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
							</tr>
							<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Pembayaran Lain-lain</td><td>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
							</tr>";
			} elseif ($row['pajak_id'] == '5') {
				echo "
							<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Nilai Jual Tenaga Listrik</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
							</tr>";
			} elseif ($row['pajak_id'] == '6') {
				echo
				"
							<tr>
								<td>- </td><td colspan='6' class='nobor-left'>Penggunaan Mineral Bukan Logam dan Batuan</td>
							</tr>
							<tr><td class='nobor-top'>&nbsp;</td>
								<td colspan='4' class='nobor-top nobor-left'>
								<table class='report' cellspacing='0'>
									<tbody>
										<tr><td align='center' colspan='2'>Jenis</td><td align='center'>Volume</td><td colspan='3' align='center'>Nilai Pasar (Rp.)</td><td align='center'>Nilai Jual (Rp.)</td></tr>";
				$no = 0;
				foreach ($mblb_rows as $row2) {
					$no++;
					echo "
											<tr>
											<td align='center'>" . $no . "</td>
											<td class='nobor-left'>" . $row2['jenis_mblb'] . "</td>
											<td align='right'>" . number_format($row2['volume']) . "</td>
											<td align='center'>x</td>
											<td align='right'>" . number_format($row2['tarif_dasar']) . "</td>
											<td align='center'>=</td>
											<td align='right'>" . number_format($row2['nilai_jual']) . "</td>
											</tr>";
				}
				echo "</tbody>
								</table>
								</td>
								</tr>";
				echo "<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Nilai Jual Mineral Bukan Logam dan Batuan</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
							</tr>";
			} elseif ($row['pajak_id'] == '7') {
				if (isset($air_tanah['volume'])) {
					$npa1 = $air_tanah['vol_0_50'] * $air_tanah['hrg_0_50'];
					$npa2 = $air_tanah['vol_51_500'] * $air_tanah['hrg_51_500'];
					$npa3 = $air_tanah['vol_501_1000'] * $air_tanah['hrg_501_1000'];
					$npa4 = $air_tanah['vol_1001_2500'] * $air_tanah['hrg_1001_2500'];
					$npa5 = $air_tanah['vol_leb_2500'] * $air_tanah['hrg_leb_2500'];
					$tot_npa = $npa1 + $npa2 + $npa3 + $npa4 + $npa5;
					$masa_pajak = strtotime($row['masa_pajak1']);

					if ($air_tanah['hrg_0_50'] == null) {
						echo
						"
							<tr>
								<td>- </td><td colspan='6' class='nobor-left'>Penggunaan Air Tanah</td>
							</tr>
							<tr><td class='nobor-top'>&nbsp;</td>
								<td colspan='4' class='nobor-top nobor-left'>
								<table class='report' cellspacing='0'>
									<tbody>
										<tr><td align='center' colspan='2'>Volume</td><td align='center'>Harga Dasar Air</td><td colspan='3' align='center'>Nilai Perolehan Air (Rp.)</td></tr>
										<tr><td align='center' colspan='2'>" . $air_tanah['volume'] . "</td><td align='center'>" . $air_tanah['tarif_dasar'] . "</td><td colspan='3' align='center'>" . number_format($air_tanah['nilai_terkena_pajak']) . "</td></tr>";
					} else {
						echo
						"
							<tr>
								<td>- </td><td colspan='6' class='nobor-left'>Penggunaan Air Tanah</td>
							</tr>
							<tr><td class='nobor-top'>&nbsp;</td>
								<td colspan='4' class='nobor-top nobor-left'>
								<table class='report' cellspacing='0'>
									<tbody>
										<tr><td align='center' colspan='2'>Volume</td><td align='center'>Harga Dasar Air</td><td colspan='3' align='center'>Nilai Perolehan Air (Rp.)</td></tr>
										<tr><td align='center' colspan='2'>" . $air_tanah['volume'] . "</td><td align='center'>" . $air_tanah['tarif_dasar'] . "</td><td colspan='3' align='center'>" . number_format($tot_npa) . "</td></tr>";
					}

					echo "</tbody>
								</table>
								</td>
								</tr>";
				} else {
					echo
					"
							<tr>
								<td>- </td><td colspan='6' class='nobor-left'>Penggunaan Air Tanah</td>
							</tr>
							<tr><td class='nobor-top'>&nbsp;</td>
								<td colspan='4' class='nobor-top nobor-left'>
								<table class='report' cellspacing='0'>
									<tbody>
										<tr><td align='center' colspan='2'>Volume</td><td align='center'>Harga Dasar Air</td><td colspan='3' align='center'>Nilai Perolehan Air (Rp.)</td></tr>
										<tr><td align='center' colspan='2'>0</td><td align='center'>0</td><td colspan='3' align='center'>0</td></tr>";

					echo "</tbody>
								</table>
								</td>
								</tr>";
				}
			} elseif ($row['pajak_id'] == '11') {
				echo "
							<tr>
								<td>- </td><td colspan='3' class='nobor-left'>Nilai Omset Parkir</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
							</tr>";
			}
			if ($row['jenis_ketetapan'] == 'SPT' && $row['singkatan_spt'] == 'SPTPD') {
				if ($row['status_bayar'] == '1') {
					$fine = $row['denda'];
					$total = $row['pajak'] - $row['kompensasi'] + $fine;
				} else {
					if ($row['tgl_jatuh_tempo'] == null) {
						$row['tgl_jatuh_tempo'] = date('Y-m-d', strtotime("+2 months - 1 day", strtotime($row['masa_pajak1'])));
						$diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
						if ($row['kegus_id'] == 8) {
							$fine = 0;
						} else {
							if ($row['pajak_id'] == '6') {
								$fine = assess_fine($row['pajak'], $diff_month);
							} else {
								$fine = assess_fine_new($row['pajak'], $diff_month);
							}
						}
					} else {
						$diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
						if ($row['kegus_id'] == 8) {
							$fine = 0;
						} else {
							if ($row['pajak_id'] == '6') {
								$fine = assess_fine($row['pajak'], $diff_month);
							} else {
								$fine = assess_fine_new($row['pajak'], $diff_month);
							}
						}
					}
					$total = $row['pajak'] - $row['kompensasi'] + $fine;
				}
				echo "	
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Terutang (" . $row['persen_tarif'] . "% x DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($rows2['pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Kompensasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['kompensasi']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Sanksi Administrasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($fine) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Jumlah Pajak yang Dibayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($total) . "</td>
						</tr>
				</table>";
			} elseif ($row['jenis_ketetapan'] == 'LHP') {
				// $total = $row['pajak'] + $rows2['bunga'];
				if ($row['status_bayar'] == '1') {
					$fine = $row['denda'];
					$total = $row['pajak'] + $fine;
				} else {
					if ($row['tgl_jatuh_tempo'] == null) {
						$row['tgl_jatuh_tempo'] = date('Y-m-d', strtotime("+2 months - 1 day", strtotime($row['masa_pajak1'])));
						$diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
						if ($row['pajak_id'] == '6') {
							$fine = assess_fine($row['pajak'], $diff_month);
						} else {
							$fine = assess_fine_new($row['pajak'], $diff_month);
						}
					} else {
						$diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
						if ($row['pajak_id'] == '6') {
							$fine = assess_fine($row['pajak'], $diff_month);
						} else {
							$fine = assess_fine_new($row['pajak'], $diff_month);
						}
					}
					$total = $row['pajak'] + $fine;
				}

				echo "	
						<tr>
							<td>a </td><td colspan='3' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
						</tr>
						<tr>
							<td>b </td><td colspan='3' class='nobor-left'>Pajak Terutang (" . $row['persen_tarif'] . "% x DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($rows2['pajak_terhutang']) . "</td>
						</tr>
						<tr>
							<td>c </td><td colspan='3' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($rows2['pokok_pajak']) . "</td>
						</tr>
						<tr>
							<td>d </td><td colspan='3' class='nobor-left'>Bunga Kurang atau Lebih Bayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($rows2['bunga']) . "</td>
						</tr>
						<tr>
							<td>e </td><td colspan='3' class='nobor-left'>Sanksi Administrasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($fine) . "</td>
						</tr>
						<tr>
							<td>f </td><td colspan='3' class='nobor-left'>Jumlah Pajak yang Dibayar(c+d+e)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($total) . "</td>
						</tr>
				</table>";
			} elseif ($row['jenis_ketetapan'] == 'SPT' && $row['singkatan_spt'] == 'SKPD') {

				if ($row['status_bayar'] == '1') {
					$fine = $row['denda'];
					if ($air_tanah['hrg_0_50'] == null) {
						if ($row['wp_wr_id'] == '40') {
							$pengurangan_pat = (97 / 100) * $row['pajak'];
							$total = $row['pajak'] - $pengurangan_pat - $row['kompensasi'] + $fine;
						} else {
							$pengurangan_pat = (55 / 100) * $row['pajak'];
							$total = $row['pajak'] - $pengurangan_pat - $row['kompensasi'] + $fine;
						}
					} else {
						if ($row['wp_wr_id'] == '40') {
							$pengurangan_pat = (97 / 100) * $row['nilai_terkena_pajak'];
							// $total = $row['nilai_terkena_pajak'] - $pengurangan_pat - $row['kompensasi'] + $fine;
							$total = $row['pajak'] - $row['kompensasi'] + $fine;
						} else {
							$pengurangan_pat = (55 / 100) * $row['nilai_terkena_pajak'];
							// $total = $row['nilai_terkena_pajak'] - $pengurangan_pat - $row['kompensasi'] + $fine;
							$total = $row['pajak'] - $row['kompensasi'] + $fine;
						}
					}
				} else {
					if ($row['tgl_jatuh_tempo'] == null) {
						$row['tgl_jatuh_tempo'] = date('Y-m-d', strtotime("+2 months - 1 day", strtotime($row['masa_pajak1'])));
						$diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
						if ($row['pajak_id'] == '6') {
							$fine = assess_fine($row['pajak'], $diff_month);
						} else {
							$fine = assess_fine_new($row['pajak'], $diff_month);
						}
					} else {
						$diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
						if ($row['pajak_id'] == '6') {
							$fine = assess_fine($row['pajak'], $diff_month);
						} else {
							$fine = assess_fine_new($row['pajak'], $diff_month);
						}
					}

					if ($air_tanah['hrg_0_50'] == null) {
						if ($row['wp_wr_id'] == '40') {
							$pengurangan_pat = (97 / 100) * $row['pajak'];
							$total = $row['pajak'] - $pengurangan_pat - $row['kompensasi'] + $fine;
						} else {
							$pengurangan_pat = (55 / 100) * $row['pajak'];
							$total = $row['pajak'] - $pengurangan_pat - $row['kompensasi'] + $fine;
						}
					} else {
						if ($row['wp_wr_id'] == '40') {
							$pengurangan_pat = (97 / 100) * $row['nilai_terkena_pajak'];
							// $total = $row['nilai_terkena_pajak'] - $pengurangan_pat - $row['kompensasi'] + $fine;
							$total = $row['pajak'] - $row['kompensasi'] + $fine;
						} else {
							$pengurangan_pat = (55 / 100) * $row['nilai_terkena_pajak'];
							// $total = $row['nilai_terkena_pajak'] - $pengurangan_pat - $row['kompensasi'] + $fine;
							$total = $row['pajak'] - $row['kompensasi'] + $fine;
						}
					}
				}

				if (date('Y-m-d,', $masa_pajak) < '2024-01-01') {
					echo "	
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Terutang (" . $row['persen_tarif'] . "% x DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($rows2['pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Kompensasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['kompensasi']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Sanksi Administrasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($fine) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Jumlah Pajak yang Dibayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($total) . "</td>
						</tr>
				</table>";
				} elseif ($air_tanah['hrg_0_50'] == null) {
					if ($row['wp_wr_id'] == '40') {
						echo "	
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Terutang (" . $row['persen_tarif'] . "% x DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($rows2['pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Kompensasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['kompensasi']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pengurangan PAT (97%)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($pengurangan_pat) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Sanksi Administrasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($fine) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Jumlah Pajak yang Dibayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($total) . "</td>
						</tr>
				</table>";
					} else {
						echo "	
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['nilai_terkena_pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Terutang (" . $row['persen_tarif'] . "% x DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($rows2['pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Kompensasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['kompensasi']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pengurangan PAT (55%)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($pengurangan_pat) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Sanksi Administrasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($fine) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Jumlah Pajak yang Dibayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($total) . "</td>
						</tr>
				</table>";
					}
				} else {
					if ($row['wp_wr_id'] == '40') {
						echo "	
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($tot_npa) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Terutang (" . $row['persen_tarif'] . "% x DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($rows2['nilai_terkena_pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Kompensasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['kompensasi']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pengurangan PAT (97%)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($pengurangan_pat) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Sanksi Administrasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($fine) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Jumlah Pajak yang Dibayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($total) . "</td>
						</tr>
				</table>";
					} else {
						echo "	
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Dasar Pengenaan Pajak (DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($tot_npa) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Terutang (" . $row['persen_tarif'] . "% x DPP)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($rows2['nilai_terkena_pajak']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Kompensasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($row['kompensasi']) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pengurangan PAT (55%)</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($pengurangan_pat) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Pajak Kurang atau Lebih Bayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>-</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Sanksi Administrasi</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($fine) . "</td>
						</tr>
						<tr>
							<td>- </td><td colspan='3' class='nobor-left'>Jumlah Pajak yang Dibayar</td><td width='1%'>Rp.</td><td width='20%' align='right' class='nobor-left'>" . number_format($total) . "</td>
						</tr>
				</table>";
					}
				}
			}


			echo "<table class='report' cellspacing='0'>	
						<tr>
							<td align='center' class='nobor-left'>No.</td>
							<td align='center'>Rekening</td>
							<td align='center'>Jenis Pajak</td>
							<td align='center'>Uraian</td>
							<td colspan='2' align='center' class='nobor-right'>Jumlah</td>
						</tr>
						<tr>
							<td align='center' width='5%' class='nobor-left'>1.</td>
							<td align='center'>" . $row['kode_rekening'] . "</td>
							<td align='center'>" . $row['nama_rekening'] . "</td>
							<td align='center'>Untuk Pembayaran Pajak Bulan $tax_month Tahun " . $row['tahun_pajak'] . "</td>
							<td colspan='2' align='right' class='nobor-right'>" . number_format($total) . "</td>
						</tr>
						<td class='nobor-left nobor-bottom' colspan='4'></td>
						<td><b>Jumlah Setoran Pajak</td>
						<td class='nobor-right' align='right'><b>Rp." . number_format($total) . "</td>
						</tr>
						<tr>
							<td colspan='6' class='nobor-left nobor-right' style='padding:3px;'>
								<table class='noborder'>
									<tr>
										<td width='15%'>Dengan huruf</td>
										<td style='border:1px solid #000!important;'><b>" . ucwords(NumToWords(round($total))) . " Rupiah</b></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table class='report' cellspacing='0'>
					<tbody>
						<tr>
							<td width='30%' align='center' class='nobor-left nobor-top nobor-bottom'>
								Ruang untuk teraan<br />
								Kas Register/Tanda Tangan<br />
								Petugas Penerima
								<br />
								<br />
								<br />
								<br />
								<br />
								<br />
							</td>
							<td valign='top' class='nobor-top nobor-bottom'>
								<center>Diterima<br />
								Petugas Tempat Pembayaran</center>
								<table class='noborder'>
								<tr>
									<td width='40%'>Tanggal</td><td>:</td>
								</tr>
								<tr>
									<td>Tanda Tangan</td><td>:</td>
								</tr>
								<tr>
									<td>Nama Terang</td><td>: " . $nama_bendahara['nama'] . "</td>
								</tr>
								<tr>
									<td>NIP</td><td>: " . $nip . "</td>
								</tr>
								</table>
							</td>
							<td width='30%' align='center' valign='top' class='nobor-right nobor-top nobor-bottom'>
								" . date_indo($tgl_cetak) . "<br />
								<br /><br />
								Penyetor
								<br />
								<br />
								<br />
								<br />
								(........................................)
							</td>							
						</tr>
					</tbody>
				</table>";
			?>
		</div>
		<span>*) Beri tanda v pada kotak <span style='border:1px solid #000'>&nbsp;&nbsp;&nbsp;&nbsp;</span> sesuai dengan yang dimiliki<br />
			<b>
				<font style="font-family:times">
					<!-- MODEL : DPD - 12 -->
				</font>
			</b>
	</div>
</body>

</html>