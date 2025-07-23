<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | Buku Wajib Pajak</title>
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>report-style.css" />
	<style type="text/css">
		@import "<?= $this->config->item('css_path'); ?>report-table-style.css";
	</style>
</head>

<body>
	<div style="margin:10px;">
		<table border=0 width="100%">
			<tr>
				<td width="30%">
					<div style="float:left;margin-right:10px;">
						<img src="<?= $this->config->item('img_path'); ?>logo_pemda.png" style="width:48px;" />
					</div>
					<div style="float:left">
						<?php echo "<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "<br />
							" . strtoupper($system_params[2]) . "<br />
							<font style='font-weight:normal'>" . $system_params[3] . "</font><br />
							<font style='font-weight:normal'>Telp. " . $system_params[4] . ", email : bapenda@blitarkab.go.id, website : bapenda.blitarkab.go.id</font>
							</h4>";
						?>
					</div>
					<div style="clear:both"></div>
				</td>
				<td width="40%">
					<h3 align="center">BUKU WAJIB PAJAK</h3>
					<table class="noborder">
						<tr>
							<td>NAMA WAJIB PAJAK</td>
							<td>: <?= $taxpayer_row['nama_wp']; ?></td>
						</tr>
						<tr>
							<td>N.P.W.P.D</td>
							<td>: P.2.<?= $taxpayer_row['npwprd']; ?></td>
						</tr>
						<tr>
							<td>ALAMAT</td>
							<td>: <?= $taxpayer_row['alamat']; ?></td>
						</tr>
						<tr>
							<td></td>
							<td>: <?= "KELURAHAN " . $taxpayer_row['kelurahan'] . " - KECAMATAN " . $taxpayer_row['kecamatan']; ?></td>
						</tr>
						<tr>
							<td>TAHUN PAJAK</td>
							<td>: <?= $tax_year . " (" . strtoupper($taxpayer_row['jenis_pemungutan']) . ")"; ?></td>
						</tr>
					</table>
				</td>
				<td>

				</td>
			</tr>
		</table>

		<span>Tgl. Proses : <?= $print_date; ?></span>
		<table class="report" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th rowspan="2">NO.</th>
					<th rowspan="2">REKENING</th>
					<th rowspan="2">URAIAN</th>
					<th rowspan="2">MASA PAJAK</th>
					<th colspan="<?= ($taxpayer_row['jenis_spt_id'] == '8' ? '4' : '3'); ?>">DATA <?= strtoupper($taxpayer_row['singkatan_spt']); ?></th>
					<th colspan="<?= ($taxpayer_row['jenis_spt_id'] == '8' ? '4' : '3'); ?>">DATA SKPDKB</th>
					<th colspan="5">PENYETORAN</th>
					<th rowspan="2">SISA</th>
				</tr>
				<tr>
					<th>TANGGAL</th>
					<th>NO. SPT</th>
					<?php
					if ($taxpayer_row['jenis_spt_id'] == '8') {
						echo "<th>DASAR OMZET</th><th>PAJAK</th><th>TANGGAL</th><th>NO. SPT</th><th>DASAR OMZET</th><th>PAJAK</th><th>Kode Billing</th><th>DENDA</th>";
					} else {
						echo "<th>KETETAPAN</th><th>TANGGAL</th><th>NO. SPT</th><th>KETETAPAN</th><th>Kode Billing</th><th>DENDA</th>";
					}
					?>
					<!-- <th>KODE BILLING</th> -->
					<th>NO. REG</th>
					<th>TGL. REG</th>
					<th style="border-right:none!important">JUMLAH SETOR</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$grand_tax = 0;
				$grand_payment = 0;
				$grand_arrears = 0;
				$grand_tax_jenis8 = 0;
				$grand_tax_else = 0;
				foreach ($rows as $row) {
					$no++;

					// if ($taxpayer_row['jenis_spt_id'] == '8') {
					// 	$sql = "SELECT pokok_pajak,denda,no_transaksi,to_char(tgl_bayar,'dd-mm-yyyy') as tgl_bayar,total_bayar FROM transaksi_pajak WHERE spt_id='" . $row['spt_id'] . "' AND jenis_spt_id='8'";
					// } else {
					// 	$sql = "SELECT pokok_pajak,denda,no_transaksi,to_char(tgl_bayar,'dd-mm-yyyy') as tgl_bayar,total_bayar FROM transaksi_pajak WHERE spt_id='" . $row['spt_id'] . "'";
					// }
					$sql = "SELECT pokok_pajak,denda,no_transaksi,to_char(tgl_bayar,'dd-mm-yyyy') as tgl_bayar,total_bayar FROM transaksi_pajak WHERE spt_id='" . $row['spt_id'] . "'";
					$row2 = $dao->execute(0, $sql)->row_array();

					$trans_numb = "";
					$denda = "";
					$payment_date = "";
					$payment = "";
					$_payment = 0;
					if (is_array($row2)) {
						$trans_numb = $row2['no_transaksi'];
						$payment_date = $row2['tgl_bayar'];
						$payment = number_format($row2['total_bayar'], 0, ',', '.');
						$denda = number_format($row2['denda'], 0, ',', '.');
						$_payment = $row2['total_bayar'];
					}
					if (isset($row2['total_bayar'])) {
						$arrears = abs($row2['pokok_pajak'] + $row2['denda'] - $_payment);
					}
					// $arrears = abs($row['pajak'] + $row2['denda'] - $_payment);
					if ($row['jenis_spt_id'] == '8') {
						echo "<tr>
							<td align='center'>" . $no . "</td>
							<td align='center'>" . $row['kode_rekening_pajak'] . "</td>
							<td>" . $row['nama_pajak'] . "</td>
							<td align='center'>" . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td>
							<td align='center'>" . $row['tgl_proses'] . "</td>
							<td align='center'>" . $row['nomor_spt'] . "</td>";
					}else {
						echo "<tr>
							<td align='center'>" . $no . "</td>
							<td align='center'>" . $row['kode_rekening_pajak'] . "</td>
							<td>" . $row['nama_pajak'] . "</td>
							<td align='center'>" . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td>
							<td align='center'></td>
							<td align='center'></td>";
					}
					if ($row['jenis_spt_id'] == '8') {
						echo "<td align='right'>" . number_format($row['nilai_terkena_pajak'], 0, ',', '.') . "</td>";
					}else {
						echo "<td align='right'></td>";
					}
					if (isset($arrears) && $row2 != null) {
						if ($row['jenis_spt_id'] == '8') {
							echo "<td align='right'>" . number_format($row2['pokok_pajak'], 0, ',', '.') . "</td>
							<td align='center'></td>
							<td align='center'></td>
							<td align='center'></td>
							<td align='center'></td>
							<td align='center'>" . $row['kode_billing'] . "</td>
							<td align='center'>" . $denda . "</td>
							<td align='center'>" . $trans_numb . "</td>
							<td align='center'>" . $payment_date . "</td>
							<td align='right'>" . $payment . "</td>
							<td align='right'>" . number_format($arrears, 0, ',', '.') . "</td>
							</tr>";
						}else {
							echo "<td align='right'></td>
							<td align='center'>" . $row['tgl_proses'] . "</td>
							<td align='center'>" . $row['nomor_spt'] . "</td>
							<td align='right'>" . number_format($row['nilai_terkena_pajak'], 0, ',', '.') . "</td>
							<td align='right'>" . number_format($row2['pokok_pajak'], 0, ',', '.') . "</td>
							<td align='center'>" . $row['kode_billing'] . "</td>
							<td align='center'>" . $denda . "</td>
							<td align='center'>" . $trans_numb . "</td>
							<td align='center'>" . $payment_date . "</td>
							<td align='right'>" . $payment . "</td>
							<td align='right'>" . number_format($arrears, 0, ',', '.') . "</td>
							</tr>";
						}
					} else {
						if ($row['jenis_spt_id'] == '8') {
							echo "<td align='right'>" . number_format($row['pajak'], 0, ',', '.') . "</td>
							<td align='center'></td>
							<td align='center'></td>
							<td align='center'></td>
							<td align='center'></td>
							<td align='center'>" . $row['kode_billing'] . "</td>
							<td align='center'>" . $denda . "</td>
							<td align='center'>" . $trans_numb . "</td>
							<td align='center'>" . $payment_date . "</td>
							<td align='right'>" . $payment . "</td>
							<td align='right'>0</td>
							</tr>";
						}else {
							echo "<td align='right'></td>
							<td align='center'>" . $row['tgl_proses'] . "</td>
							<td align='center'>" . $row['nomor_spt'] . "</td>
							<td align='center'>" . number_format($row['nilai_terkena_pajak'], 0, ',', '.') . "</td>
							<td align='center'>" . number_format($row['pajak'], 0, ',', '.') . "</td>
							<td align='center'>" . $row['kode_billing'] . "</td>
							<td align='center'>" . $denda . "</td>
							<td align='center'>" . $trans_numb . "</td>
							<td align='center'>" . $payment_date . "</td>
							<td align='right'>" . $payment . "</td>
							<td align='right'>0</td>
							</tr>";
						}
					}

					$grand_tax += $row['pajak'];
					$grand_payment += $_payment;
					if (isset($arrears)) {
						$grand_arrears += $arrears;
					}
					if ($row['jenis_spt_id'] == '8') {
						$grand_tax_jenis8 += $row['pajak']; // <--- khusus pajak dari jenis_spt_id = 8
					}else {
						$grand_tax_else += $row['pajak'];
					}
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="<?= ($taxpayer_row['jenis_spt_id'] == '8' ? '7' : '6') ?>" align="center"><b>TOTAL</b></td>
					<td align="right"><b><?= number_format($grand_tax_jenis8, 0, ',', '.'); ?></b></td>
					<td colspan="3"></td>
					<td align="right"><b><?= number_format($grand_tax_else, 0, ',', '.'); ?></b></td>
					<td colspan="4"></td>
					<td align="right"><b><?= number_format($grand_payment, 0, ',', '.'); ?></b></td>
					<td align="right"><b><?= number_format($grand_arrears, 0, ',', '.'); ?></b></td>
				</tr>
			</tfoot>
		</table><br /><br />

	</div>
</body>

</html>