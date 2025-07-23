<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | STS</title>
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
	</style>
</head>

<body>
	<div style="margin:10px;">
		<div style="border:1px solid #000;padding:1px;">
			<div style="border:1px solid #000;">
				<div style="border-bottom:2px solid #000;padding:5px;text-align:center">
					<?php
					echo "<h2>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "<br />
							<span style='font-family:times;font-weight:normal;'>SURAT TANDA SETORAN<br />(STS)</span>";
					?>
				</div>
				<div style="margin-top:10px;">
					<div class="fluid">
						<div class="grid8">
							<table class="noborder">
								<!-- <tr><td width="40%">STS No.</td><td>: <?= $row['nomor_spt']; ?></td></tr> -->
								<tr>
									<td width="40%">STS No.</td>
									<td>: <?= $row['no_urut_sts']; ?></td>
								</tr>
								<tr>
									<td>Harap diterima uang sebesar</td>
									<td>: Rp. <?= number_format($row['total_bayar']); ?></td>
								</tr>
								<tr>
									<td valign="top">(dengan huruf)</td>
									<td><i><?= ucwords(NumToWords(round($row['total_bayar']))); ?> Rupiah</i></td>
								</tr>
							</table>
						</div>
						<div class="grid4">
							<table class="noborder">
								<tr>
									<td>Bank</td>
									<td>: <?= $row['loket_pembayaran']; ?></td>
								</tr>
								<tr>
									<td>No. Rekening</td>
									<td>: <?= $bundle_row['kode_rekening']; ?></td>
								</tr>
							</table>
						</div>
					</div>
					<p style="margin-top:10px!important;margin-left:4px!important;">Dengan rincian penerimaan sebagai berikut : </p><br />
					<table class="report" cellspacing="0">
						<tbody>
							<tr>
								<td class="nobor-left" align="center"><b>NO.</b></td>
								<td align="center"><b>KODE REKENING</b></td>
								<td align="center" colspan="7"><b>URAIAN RINCIAN OBJEK</b></td>
								<td class="nobor-right" align="center" colspan="2"><b>JUMLAH (Rp)</b></td>
							</tr>
							<?php
							$main_detail_row = $detail_rows[0];

							$description = $row['nama_pajak'] . "/" . $main_detail_row['nama_rekening'];
							if ($row['pajak_id'] != '5') {
								$description .= "<br />-" . $row['nama_wp'];
							}

							echo "
									<tr>
										<td align='center' class='nobor-left'>1</td>
										<td align='center'>" . $main_detail_row['kode_rekening'] . "</td>
										<td colspan='7'>" . $description . "</td>
										<td>Rp.</td>
										<td align='right' class='nobor-left nobor-right'>" . number_format($main_detail_row['jumlah_pajak']) . "</td>
									</tr>";


							//fine row
							if (isset($detail_rows[1])) {
								$fine_row = $detail_rows[1];
								echo "
										<tr>
											<td align='center' class='nobor-left'>2</td>
											<td align='center'>" . $fine_row['kode_rekening'] . "</td>
											<td colspan='7'>" . $fine_row['nama_rekening'] . "</td>
											<td>Rp.</td>
											<td align='right' class='nobor-left nobor-right'>" . number_format($fine_row['jumlah_pajak']) . "</td>
										</tr>";
							}

							?>
							<tr>
								<td colspan="9" class="nobor-left" align="center"><b>Jumlah</b></td>
								<td><b>Rp.</b></td>
								<td class="nobor-left nobor-right" align="right"><b><?= number_format($row['total_bayar']); ?></b></td>
							</tr>
						</tbody>
					</table>
					<?php
					echo "<br />
						<table class='noborder'>
							
							<tr><td colspan='4' align='left'>
							Uang tersebut diterima pada tanggal " . indo_date_format($row['tgl_bayar'], 'longDate') . "<br /></td></tr>
							
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
						</table>";
					?>
				</div>
			</div>
		</div>
		<span><i>(Catatan : -STS dilampiri Slip Setoran Bank)</i></span><br />
	</div>
</body>

</html>