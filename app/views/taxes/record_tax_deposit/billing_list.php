<?php
echo "
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

	$diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
	$fine = assess_fine($row['tot_pajak_terhutang'], $diff_month);
	$total = $row['tot_pajak_terhutang'] + $fine;
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
		    								<button type='button' title='Pilih' id='btn-choose" . $no . "' class='btn btn-default btn-xs' onclick=\"load_billing_data(this.id)\">
		    									<input type='hidden' id='ajax-req-dt' name='kode_billing' value='" . $row['kode_billing'] . "'/>
												<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>
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
	function load_billing_data(id) {
		ajax_object.reset_object();

		ajax_object.set_plugin_datatable(true)
			.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/load_billing_data')
			.set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			.set_data_ajax()
			.set_content('#content-billing_data')
			.set_loading('#loader-billing_data')
			.request_ajax();

	}
</script>