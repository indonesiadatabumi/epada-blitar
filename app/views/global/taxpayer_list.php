<input type="hidden" id="input_element" value="<?= $input_element; ?>" />
<input type="hidden" id="wp_wr_detil" value="<?= $wp_wr_detil; ?>" />
<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>NPWPD</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Kegiatan Usaha</th>
			<th><i class="fa fa-check"></i></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 0;
		foreach ($rows as $row) {
			$no++;
			echo "<tr>
				<td align='center'>" . $no . "</td>
				<td align='center'>" . $row['npwprd'] . "</td>
				<td>" . $row['nama_wp'] . "</td>
				<td>" . $row['alamat'] . "</td>
				<td>" . $row['nama_kegus'] . "</td>
				<td align='center'>
				<button type='button' class='btn btn-default btn-xs' onclick=\"pick_row('" . $row['npwprd'] . "', '" . $row['wp_wr_detil_id'] . "')\"><i class='fa fa-check'></i></button>
				</td>
				</tr>";
		}
		?>
	</tbody>
</table>
<center>
	<button type="button" class="btn btn-danger" id="close-modal-form" data-dismiss="modal">
		Tutup
	</button>
</center>
<script type="text/javascript">
	function pick_row(npwprd, wp_wr_detil) {
		var $input_element = $('#' + $('#input_element').val());
		$input_element.val(npwprd);
		var $wp_wr_detil = $('#' + $('#wp_wr_detil').val());
		$wp_wr_detil.val(wp_wr_detil);
		$('#close-modal-form').click();
	}
</script>