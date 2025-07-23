<?php
echo "
	<input type='hidden' id='base_url' value='" . base_url() . "'/>
	<div class='panel-group'>
		<div class='panel panel-default'>			
		    <div class='panel-body'>
		    	<h3 align='center' style='font-weight:bold;font-size:1.5em'><u>Daftar Tagihan Pajak</u></h3>
		    	<div class='row'>
		    		<div class='col-md-12'>
		    			<table class='table table-striped table-bordered table-hover'>
		    				<thead>
		    					<tr><th>No.</th><th>Kode Billing</th><th>Nama WP/Alamat</th>
		    					<th>Jenis Pajak/Keg. Usaha</th><th>Thn. Pajak/Masa Pajak</th><th>Tgl. Jatuh Tempo</th>
		    					<th>Pokok Pajak</th><th>Denda</th><th>Total Bayar</th><th></th></tr>
		    				</thead>
		    				<tbody>";
$no  = 0;
foreach ($rows as $row) {
	$no++;

	// $diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
	$diff_month = get_diff_months($row['tgl_jatuh_tempo'], $tgl_setor, $row['jenis_spt_id']);
	if ($row['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
		$fine = 0;
		$total = $row['tot_pajak_terhutang'] + $fine;
	} else {
		if ($row['pajak_id'] == '6') {
			$fine = assess_fine($row['tot_pajak_terhutang'], $diff_month);
			$total = $row['tot_pajak_terhutang'] + $fine;
		} else {
			$fine = assess_fine_new($row['tot_pajak_terhutang'], $diff_month);
			$total = $row['tot_pajak_terhutang'] + $fine;
		}
	}

	echo "<tr>
		    							<td align='center'>" . $no . "</td>
		    							<td align='center'>" . $row['kode_billing'] . "</td>
		    							<td>" . $row['nama_wp'] . "<br /><small><b>" . $row['alamat'] . "</b></small></td>
		    							<td>" . $row['nama_pajak'] . "<br /><small><b>" . $row['nama_rekening'] . "</b></small></td>
		    							<td>" . $row['tahun_pajak'] . " / " . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td>
		    							<td align='center'>" . indo_date_format($row['tgl_jatuh_tempo'], 'shortDate') . "</td>
		    							<td align='right'>" . number_format($row['tot_pajak_terhutang']) . "</td>
		    							<td align='right'>" . number_format($fine) . "</td>
		    							<td align='right'>" . number_format($total) . "</td>
		    							<td align='center'>
		    								<button type='button' title='Pilih' id='btn-choose" . $no . "' class='btn btn-default btn-xs' onclick=\"callback_manual('" . $row['kode_billing'] . "'," . $row['tot_pajak_terhutang'] . "," . $fine . "," . $total . ",'" . $tgl_setor . "','" . $row['masa_pajak1'] . "')\">
		    									<input type='hidden' id='ajax-req-dt' name='kode_billing' value='" . $row['kode_billing'] . "'/>
												<input type='hidden' id='ajax-req-dt' name='tgl_setor' value='" . $tgl_setor . "'/>												
												<i class='fa fa-check'></i>
		    								</button>
		    							</td>
		    						</tr>";
}
echo "</tbody>
		    			</table>
		    		</div>
		    	</div>
		    </div>
		</div>
	</div>";
?>

<script type="text/javascript">
	base_url = $('#base_url').val();

	function callback_manual(kode_billing, pokok, denda, total, tgl_setor, masa_pajak1) {
		const split_masa = masa_pajak1.split("-")
		const tahun = split_masa[0]
		const masa = split_masa[1]
		$.ajax({
			type: "post",
			url: base_url + "/API/payment_manual.php",
			data: JSON.stringify({
				Nop: kode_billing,
				Merchant: '6010',
				DateTime: tgl_setor + " 00:00:00",
				Masa: masa,
				Tahun: tahun,
				Pokok: pokok,
				Denda: denda,
				Total: total
			}),
			dataType: "json",
			success: function(response) {
				alert('Pelunasan Sukses')
			}
		});
	}
</script>