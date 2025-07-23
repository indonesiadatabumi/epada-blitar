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
			<th>Nomor Pemeriksaan</th>
			<th>Tgl. Pemeriksaan</th>
			<th>Ketetapan</th>
			<th>NPWPD</th>
			<th>Nama WP</th>
			<th>Rekening</th>
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
					<td align='center'>" . $row['no_pemeriksaan'] . "</td>
					<td align='center'>" . $row['tgl_pemeriksaan'] . "</td>
					<td align='center'>" . $row['singkatan_spt'] . "</td>
					<td align='center'>" . $row['npwprd'] . "</td>
					<td align='center'>" . $row['nama_wp'] . "</td>					
					<td align='center'>" . $row['kode_rekening'] . " - " . $row['nama_rekening'] . "</td>
					<td align='right'>" . number_format($row['pajak']) . "</td>
					<td align='center'>";

			if ($update_priv == '1')
				echo "<button type='button' id='btn-edit1" . $no . "' class='btn btn-default btn-xs' data-toggle='modal' data-target='#formModal' onclick=\"load_form_content(this.id)\" title='Edit'>";
			else
				echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk merubah data');\" title='Edit'>";

			echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='" . $row['lhp_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='wp_wr_detil_id' value='" . $row['wp_wr_detil_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>
						<i class='fa fa-pencil'></i></button>";

			if ($delete_priv == '1')
				echo "<button type='button' id='btn-delete1" . $no . "' class='btn btn-default btn-xs' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" title='Delete'>";
			else
				echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'>";

			echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='" . $row['lhp_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>
						<i class='fa fa-trash-o'></i></button>
					</td>
				</tr>";
		}
		?>
	</tbody>
</table>