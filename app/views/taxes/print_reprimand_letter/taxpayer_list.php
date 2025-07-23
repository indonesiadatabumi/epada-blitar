<input type="hidden" id="src_params2-pajak_id" value="<?= (isset($src_params['a.golongan']) ? $src_params['a.golongan'] : ''); ?>" />
<input type="hidden" id="src_params2-golongan" value="<?= (isset($src_params['a.pajak_id']) ? $src_params['a.pajak_id'] : ''); ?>" />
<input type="hidden" id="src_params2-status" value="<?= (isset($src_params['a.status']) ? $src_params['a.status'] : ''); ?>" />

<table class="table table-bordered table-striped table-hover">
	<thead>
		<th>No SPT</th>
		<th>NPWPD</th>
		<th>Pajak/Keg. Usaha</th>
		<th>Nama</th>
		<th>Masa Pajak</th>
		<th>Pajak</th>
		<th><i class="fa fa-check" </i></th>
	</thead>
	<tbody>
		<?php
		$no = 0;
		foreach ($rows as $row) {
			$no++;
			echo "<tr>
    			<td align='center'>" . $row['nomor_spt'] . "</td>
    			<td align='center'>" . $row['npwpd'] . "</td>
    			<td>" . $row['nama_pajak'] . "/" . $row['nama_rekening'] . "</td>
    			<td>" . $row['nama_wp'] . "</td>
    			<td>" . indo_date_format($row['masa_pajak1'], 'longDate'); ?> - <?= indo_date_format($row['masa_pajak2'], 'longDate') . "</td>
    			<td>" . number_format($row['pajak'], 0, '.', ',') . "</td>
    			<td align='center'>
    				<button type='button' id='btn-open-form" . $no . "' class='btn btn-default btn-xs' onclick=\"load_form2_content(this.id);\">
    				<input type='hidden' id='ajax-req-dt' name='id' value=''>
    				<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'>
    				<input type='hidden' id='ajax-req-dt' name='act' value='" . $act . "'>
    				<input type='hidden' id='ajax-req-dt' name='showed' value='" . $showed . "'>
    				<input type='hidden' id='ajax-req-dt' name='spt_id' value='" . $row['spt_id'] . "'>";
																				foreach ($src_params as $key => $val) {
																					echo "<input type='hidden' id='ajax-req-dt' name='src-" . $key . "' value='" . $val . "'/>";
																				}
																				foreach ($src_daterange_params as $key => $val) {
																					echo "<input type='hidden' id='ajax-req-dt' name='src_date_range-" . $key . "' value='" . $val . "'/>";
																				}
																				echo "<i class='fa fa-check'></i>
    				</button>
    			</td>
    			</tr>";
																			}
																				?>
	</tbody>
</table>

<div id="loader-form" style="display:none;" align="center">
	<img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
</div>

<div id="content-form">
</div>
<script>
	function load_form2_content(id) {
		ajax_object.reset_object();

		ajax_object.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/form')
			.set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			.set_data_ajax(data_ajax)
			.set_loading('#loader-form')
			.set_content('#content-form')
			.request_ajax();

	}
</script>