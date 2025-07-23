<!DOCTYPE html>
<html>

<head>
	<title>Laporan SSPD</title>
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>report-style.css" />
	<style type="text/css">
		@import "<?= $this->config->item('css_path'); ?>report-table-style.css";
	</style>
</head>

<body>
	<div style="margin:10px;">
		<table border=0 width="100%">
			<tr>
				<td>
					<h3 align="center">LAPORAN SSPD<br />
						<font style="font-weight:normal"></font>
					</h3><br />
				</td>
			</tr>
			<tr>
				<td>

				</td>
			</tr>
			<tr>
				<td>

				</td>
			</tr>

		</table>


		<table class="report" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>NO.</th>
					<th>No SSPD</th>
					<th>Periode</th>
					<th>Masa Pajak</th>
					<th>NPWPD / Nama WP</th>
					<th>Tot. Pajak</th>
					<th>Ketetapan / Tgl. Penetapan</th>
					<th>Tgl. Setoran</th>
					<th>Tot. Setoran</th>
					<th>Status Pembayaran</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$tot_pajak_final = 0;
				$tot_setoran = 0;
				foreach ($response as $row) {
					$no++;
					if ($row['pajak_id'] == '7') {
						$tot_pajak = $row['pajak'];
					} else {
						$tot_pajak = $row['pajak'] - $row['kompensasi'];
					}

					if ($row['pajak'] > 0) {
						echo "<tr>
					<td align='center'>" . $no . "</td>					
					<td align='right'>" . $row['no_urut_sspd'] . "</td>
					<td align='center'>" . $row['tahun_pajak'] . "</td>
					<td>" . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td>
					<td>" . $row['npwpd'] . " / <br />" . $row['nama_wp'] . "</td>
					<td align='right'>" . number_format($tot_pajak) . "</td>
					<td>" . $row['singkatan_spt'] . " / </td>
					<td align='center'>" . indo_date_format($row['tgl_bayar'], 'shortDate') . "</td>
					<td align='right'>" . number_format($row['total_bayar']) . "</td>";
						if ($row['status_bayar'] == '0') {
							echo "<td align='center'>Belum Lunas</td>";
						} else if ($row['status_bayar'] == '1') {
							echo "<td align='center'>Lunas</td>";
						}

						echo "
				</tr>";
					}
					$tot_pajak_final += $tot_pajak;
					$tot_setoran += $row['total_bayar'];
				}
			
				?>
			</tbody>
			<tfoot>

				<tr>
					<td colspan="5" align="right"><b>Total</b></td>
					<td align="right"><?= number_format($tot_pajak_final)?></td>
					<td></td>
					<td></td>
					<td align="right"><?= number_format($tot_setoran)?></td>
					<td></td>
				</tr>
			</tfoot>
		</table><br /><br />
	</div>
</body>

</html>