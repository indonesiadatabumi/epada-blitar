<input type="hidden" id="src_params-tahun_pajak" value="<?= (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : ''); ?>" />
<input type="hidden" id="src_params-kecamatan_id" value="<?= (isset($src_params['b#kecamatan_id']) ? $src_params['b#kecamatan_id'] : ''); ?>" />
<input type="hidden" id="src_params-kelurahan_id" value="<?= (isset($src_params['b#kelurahan_id']) ? $src_params['b#kelurahan_id'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_penetapan_awal" value="<?= (isset($src_params['tgl_penetapan-start']) ? $src_params['tgl_penetapan-start'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_penetapan_akhir" value="<?= (isset($src_params['tgl_penetapan-end']) ? $src_params['tgl_penetapan-end'] : ''); ?>" />

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>Kode Billing</th>
			<th>Kohir</th>
			<th>Jenis Pajak</th>
			<th>Periode</th>
			<th>Wajib Pajak</th>
			<th>No. Pemeriksaan</th>
			<th>Tgl. Penetapan</th>
			<th>Jenis Ketetapan</th>
			<th>Tgl. Jatuh Tempo</th>
			<th>Pajak</th>
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
					<td align='center'>" . $row['kode_billing'] . "</td>
					<td align='center'>" . $row['kohir'] . "</td>
					<td align='center'>" . $row['nama_paret'] . "</td>
					<td align='center'>" . $row['tahun_pajak'] . "</td>
					<td>" . $row['npwprd'] . " - " . $row['nama_wp'] . "</td>
					<td align='center'>" . $row['no_pemeriksaan'] . "</td>
					<td align='center'>" . $row['tgl_penetapan'] . "</td>
					<td>" . $row['singkatan_spt'] . "</td>					
					<td align='center'>" . $row['tgl_jatuh_tempo'] . "</td>
					<td align='right'>" . number_format($row['pajak']) . "</td>
					<td align='center'>";

			if ($delete_priv == '1')
				echo "<button type='button' id='btn-delete1" . $no . "' class='btn btn-default btn-xs' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" title='Delete'>";
			else
				echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'>";

			echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='" . $row['penetapan_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='lhp_id' value='" . $row['lhp_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>
						<i class='fa fa-trash-o'></i></button>";

			if ($print_priv == '1') {
				echo "<a href='" . base_url() . "bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/_print?id=" . $row['lhp_id'] . "' 
						   		class='btn btn-default btn-xs' style='color:#000;' target='_blank' title='Cetak'>";
			} else
				echo "<a href='#' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk mencetak data');\" title='Cetak'>";

			echo "						
						<i class='fa fa-print'></i></a>";
			echo "		</td>
				</tr>";
		}
		?>
	</tbody>
</table>