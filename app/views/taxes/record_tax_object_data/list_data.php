<input type="hidden" id="src_params-tahun_pajak" value="<?= (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : ''); ?>" />
<input type="hidden" id="src_params-kecamatan_id" value="<?= (isset($src_params['kecamatan_id']) ? $src_params['kecamatan_id'] : ''); ?>" />
<input type="hidden" id="src_params-kelurahan_id" value="<?= (isset($src_params['kelurahan_id']) ? $src_params['kelurahan_id'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_proses_awal" value="<?= (isset($src_params['tgl_proses-start']) ? $src_params['tgl_proses-start'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_proses_akhir" value="<?= (isset($src_params['tgl_proses-end']) ? $src_params['tgl_proses-end'] : ''); ?>" />

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>Pemungutan</th>
			<th>No. SPT</th>
			<th>Periode</th>
			<th>Masa Pajak</th>
			<th>NPWPD / Nama WP</th>
			<th>Tot. Pajak</th>
			<th>Ketetapan / Tgl. Penetapan</th>
			<th>Tgl. Setoran</th>
			<th>Tot. Setoran</th>
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
					<td align='center'>" . $row['jenis_pemungutan'] . "</td>
					<td align='right'>" . $row['nomor_spt'] . "</td>
					<td align='center'>" . $row['tahun_pajak'] . "</td>
					<td>" . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td>
					<td>" . $row['npwpd'] . " / <br />" . $row['nama_wp'] . "</td>
					<td align='right'>" . number_format($row['pajak']) . "</td>
					<td>" . $row['singkatan_spt'] . " / </td>					
					<td align='center'></td>
					<td align='right'></td>
					<td align='center'>";

			if ($update_priv == '1')
				echo "<button type='button' id='btn-edit1" . $no . "' class='btn btn-default btn-xs' data-toggle='modal' data-target='#formModal' onclick=\"load_form_content(this.id)\" title='Edit'>";
			else
				echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk merubah data');\" title='Edit'>";

			echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='" . $row['spt_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='wp_wr_detil_id' value='" . $row['wp_wr_detil_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>
						<i class='fa fa-pencil'></i></button>";

			if ($delete_priv == '1')
				echo "<button type='button' id='btn-delete1" . $no . "' class='btn btn-default btn-xs' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" title='Delete'>";
			else
				echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'>";

			echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='" . $row['spt_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>
						<i class='fa fa-trash-o'></i></button>
						<a class='btn btn-default btn-xs' href='http://e-pada.blitarkab.go.id/lihat_lampiran.php?kode_billing=" . $row['kode_billing'] . "' title='Lihat Lampiran' target='_blank'><i class='fa fa-file'></i></a>
					</td>
				</tr>";
		}
		?>
	</tbody>
</table>