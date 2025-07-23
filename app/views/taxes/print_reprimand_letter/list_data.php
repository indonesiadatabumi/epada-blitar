<input type="hidden" id="src_params-tahun_pajak" value="<?= (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : ''); ?>" />
<input type="hidden" id="src_params-jenis_spt_id" value="<?= (isset($src_params['jenis_spt_id']) ? $src_params['jenis_spt_id'] : ''); ?>" />
<input type="hidden" id="src_params-kecamatan_id" value="<?= (isset($src_params['b#kecamatan_id']) ? $src_params['b#kecamatan_id'] : ''); ?>" />
<input type="hidden" id="src_params-kelurahan_id" value="<?= (isset($src_params['b#kelurahan_id']) ? $src_params['b#kelurahan_id'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_pemeriksaan_awal" value="<?= (isset($src_params['tgl_pemeriksaan-start']) ? $src_params['tgl_pemeriksaan-start'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_pemeriksaan_akhir" value="<?= (isset($src_params['tgl_pemeriksaan-end']) ? $src_params['tgl_pemeriksaan-end'] : ''); ?>" />

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>Periode</th>
			<th>Masa Pajak</th>
			<th>NPWPD / Nama WP</th>
			<th>Tot. Pajak</th>
			<th>Jatuh_tempo</th>
			<th>Kode Billing</th>
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
					<td align='center'>" . $row['st_periode'] . "</td>
					<td>" . mix_2Date($row['st_periode_jual1'], $row['st_periode_jual2']) . "</td>
					<td>" . $row['npwpd'] . " / <br />" . $row['nama_wp'] . "</td>
					<td align='right'>" . number_format($row['pajak']) . "</td>
					<td align='center'>" . indo_date_format($row['st_jatuh_tempo'], 'longDate') . "</td>
					<td align='center'>" . $row['st_kode_billing'] . "</td>
					<td align='center'>";

			if ($print_priv == '1') {
				echo "<a href='" . base_url() . "bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/_print?id=" . $row['st_id'] . "' id='btn-print" . $no . "' 
						   		class='btn btn-default btn-xs' style='color:#000;' target='_blank' title='Cetak'>";
			} else
				echo "<a href='#' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk mencetak data');\" title='Cetak'>";

			echo "
						<i class='fa fa-print'></i></a>&nbsp;";

			if ($delete_priv == '1')
				echo "<button type='button' id='btn-delete1" . $no . "' class='btn btn-default btn-xs' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" title='Delete'>";
			else
				echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'>";

			echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='" . $row['st_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>
						<i class='fa fa-trash-o'></i></button>
					</td>
				</tr>";
		}
		?>
	</tbody>
</table>