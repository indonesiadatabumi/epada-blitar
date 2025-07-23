<input type="hidden" id="src_params-tahun_pajak" value="<?= (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : ''); ?>" />
<input type="hidden" id="src_params-kecamatan_id" value="<?= (isset($src_params['kecamatan_id']) ? $src_params['kecamatan_id'] : ''); ?>" />
<input type="hidden" id="src_params-kelurahan_id" value="<?= (isset($src_params['kelurahan_id']) ? $src_params['kelurahan_id'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_proses_awal" value="<?= (isset($src_params['tgl_proses-start']) ? $src_params['tgl_proses-start'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_proses_akhir" value="<?= (isset($src_params['tgl_proses-end']) ? $src_params['tgl_proses-end'] : ''); ?>" />
<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
<input type="hidden" id="bundle_item_type" value="<?= $bundle_item_type; ?>" />
<input type="hidden" id="menu" value="<?= $menu; ?>" />

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>No. Transaksi</th>
			<th>Periode</th>
			<th>Masa Pajak</th>
			<th>NPWPD / Nama WP</th>
			<th>Ketetapan / Tgl. Penetapan</th>
			<th>Tgl. Setoran</th>
			<th>Pokok Pajak</th>
			<th>Denda</th>
			<th>Tot. Bayar</th>
			<th>Panel Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 0;
		foreach ($rows as $row) {
			$no++;

			echo "<tr>
					<td align='center'>" . $no . "</td>					
					<td align='right'>" . $row['no_transaksi'] . "</td>
					<td align='center'>" . $row['tahun_pajak'] . "</td>
					<td>" . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td>
					<td>" . $row['npwprd'] . " / <br />" . $row['nama_wp'] . "</td>
					<td>" . $row['singkatan_spt'] . " / </td>
					<td align='center'>" . $row['tgl_bayar'] . "</td>
					<td align='right'>" . number_format($row['pokok_pajak']) . "</td>					
					<td align='right'>" . number_format($row['denda']) . "</td>
					<td align='right'>" . number_format($row['total_bayar']) . "</td>
					<td align='center'>";

			if ($print_priv == '1') {
				echo "<a href='" . base_url() . "bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/_print?id=" . $row['spt_id'] . "&no_sts=" . $row['no_urut_sts'] . "&tgl_cetak=" . $tgl_cetak . "' id='btn-print" . $no . "' 
						   		class='btn btn-default btn-xs' style='color:#000;' target='_blank' title='Cetak'>";
			} else
				echo "<a href='#' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk mencetak data');\" title='Cetak'>";

			echo "						
						<i class='fa fa-print'></i></a>";

			if ($print_priv == '1') {
				echo "<a href='" . base_url() . "bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/pdf?id=" . $row['spt_id'] . "' id='btn-print" . $no . "' 
						   		class='btn btn-default btn-xs' style='color:#000;' target='_blank' title='PDF'>";
			} else
				echo "<a href='#' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk mencetak data');\" title='PDF'>";

			echo "						
						<i class='fa fa-file-pdf-o'></i></a>
						<button class='btn btn-default btn-xs' type='button' onclick=\"change_number(" . $row['transaksi_id'] . ")\" title='Ganti Nomor'>Ganti No. STS</button>
					</td>
				</tr>";
		}
		?>
	</tbody>
</table>
<script>
	function change_number(id) {
		var no_sts = prompt("No sts yang baru?");
		base_url = $('#base_url').val();
		bundle_item_type = $('#bundle_item_type').val();
		menu = $('#menu').val();
		data_ajax = ['id=' + id, 'no_sts=' + no_sts];
		ajax_object.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/change_no_sts')
			.set_data_ajax(data_ajax)
			.request_ajax();
	}
</script>