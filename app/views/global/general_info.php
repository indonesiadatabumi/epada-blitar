<?php
if ($bundle_id != '3') {

	echo "
		<div class='row'>
			<div class='col-md-6'>
				<h6 style='margin-bottom:5px!important;'><i class='fa fa-money'></i> Daftar Rekapitulasi Setoran Wajib Pajak Tahun " . date('Y') . "</h6>
				<table class='table table-bordered table-striped table-hover'>
					<thead>
						<tr>
						<th><b>Bulan</b></th><th><b>Total Tagihan</b></th><th><b>Total Terbayar</b></th><th><b>Ratio (%)</b></th>
						</tr>
					</thead>
					<tbody>";
	$j = 0;
	$tot_bill = 0;
	$tot_paid = 0;

	for ($i = 1; $i <= 12; $i++) {
		$tax_deposit = $tax_deposits[$j];
		$ratio = ($tax_deposit['bill'] > 0 ? $tax_deposit['paid'] / $tax_deposit['bill'] * 100 : 0);
		echo "<tr>
						<td>" . get_monthName($i) . "</td>
						<td align='right'>" . number_format($tax_deposit['bill']) . "</td>
						<td align='right'>" . number_format($tax_deposit['paid']) . "</td>
						<td align='right'>" . number_format($ratio, 2, '.', ',') . "</td>
						</tr>";
		$j++;
		$tot_bill += $tax_deposit['bill'];
		$tot_paid += $tax_deposit['paid'];
		$tot_ratio = ($tot_bill > 0 ? $tot_paid / $tot_bill * 100 : 0);
	}
	echo "</tbody>
					<tfoot>
					<tr>
					<td align='right'><b>Total</b></td>
					<td align='right'>" . number_format($tot_bill) . "</td>
					<td align='right'>" . number_format($tot_paid) . "</td>
					<td align='right'>" . number_format($tot_ratio, 2, '.', ',') . "</td>
					</tr>
					</tfoot>
				</table>
			</div>
			<div class='col-md-6'>
				<h6 style='margin-bottom:5px!important;'><i class='fa fa-list'></i> Daftar Tagihan Pajak Bulan Berjalan (" . get_monthName(date('m')) . ")</h6>
				<table class='table table-bordered table-striped table-hover'>
					<thead>
						<tr>
						<th>No.</th><th>Nama WP/NPWPD</th><th>Alamat WP</th><th>Tagihan Pajak (Rp.)</th>
						</tr>
					</thead>
					<tbody>";
	$no = 0;
	foreach ($tax_bills as $row) {
		$no++;
		echo "<tr>
							<td align='center'>" . $no . "</td>
							<td>" . $row['nama_wp'] . "<br />
							" . $row['npwpd'] . "</td>
							<td>" . $row['alamat'] . "</td>
							<td align='right'>" . number_format($row['pajak']) . "</td>
							</tr>";
	}
	echo "</tbody>
				</table>
			</div>
		</div>";
} else {

	echo "
		<div class='row'>
			<div class='col-md-6'>
				<h6 style='margin-bottom:5px!important;'><i class='fa fa-list'></i> Daftar Status Reklame</h6>
			</div>
			<div class='col-md-6'>
				<table cellspacing=5 cellpadding=0 width='100%'>
					<tr>
						<td width='10%' style='background:#eef229'>&nbsp;</td>
						<td width='20%'>&nbsp;Masa Tenggang&nbsp;&nbsp;</td>
						<td width='10%' style='background:#ff3a62'>&nbsp;</td>
						<td width='20%'>&nbsp;Berakhir&nbsp;&nbsp;</td>
						<td width='10%' style='background:#68f128'>&nbsp;</td>
						<td>&nbsp;Berlangsung&nbsp;&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
		<table class='table table-bordered table-striped table-hover'>
			<thead>
				<tr>
					<th>No.</th><th>Wajib Pajak</th><th>Tahun Pajak</th><th>Jenis Reklame</th><th>Lokasi Reklame</th><th>Lama Pasang</th><th>Tgl. Pasang</th><th>Tg. Berakhir</th>
				</tr>
			</thead>
			<tbody>";

	$no = 0;
	foreach ($ads_installation_status_rows as $row) {
		$no++;
		echo "<tr>
					<td align='center'>" . $no . "</td>
					<td>" . $row['nama_wp'] . "</td>
					<td align='center'>" . $row['tahun_pajak'] . "</td>
					<td>" . $row['jenis_reklame'] . "</td>
					<td>" . $row['lokasi'] . "</td>
					<td>" . $row['jangka_waktu'] . " " . $row['satuan_jangka_waktu'] . "</td>
					<td align='center'>" . $row['tgl_pasang'] . "</td>
					<td align='center'>" . $row['tgl_berakhir'] . "</td>
					</tr>";
	}

	echo "</tbody>
		</table>";
}
