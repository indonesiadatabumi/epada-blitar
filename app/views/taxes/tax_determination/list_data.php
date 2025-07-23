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
			<th>No. SPT</th>
			<th>Tgl. Penetapan</th>
			<th>Jenis Ketetapan</th>
			<th>Tgl. Jatuh Tempo</th>
			<th>Pajak</th>
			<th>Status</th>
			<th>Panel Aksi</th>
		</tr>
	</thead>
	<tbody>
		<!-- <?php
				$no = 0;
				foreach ($rows as $row) {
					$no++;
					echo "<tr>
					<td align='center'>" . $no . "</td>
					<td align='center'>" . $row['kode_billing'] . "</td>
					<td align='center'>" . $row['kohir'] . "</td>
					<td align='center'>" . $row['nama_paret'] . "</td>
					<td align='center'>" . $row['tahun_pajak'] . "</td>
					<td>" . $row['npwpd'] . " - " . $row['nama_wp'] . "</td>
					<td align='center'>" . $row['nomor_spt'] . "</td>
					<td align='center'>" . $row['tgl_penetapan'] . "</td>
					<td>" . $row['singkatan_spt'] . "</td>					
					<td align='center'>" . $row['tgl_jatuh_tempo'] . "</td>
					<td align='right'>" . number_format($row['pajak']) . "</td>
					<td align='center'>" . $row['status_bayar'] . "</td>
					
					<td align='center'>";


					if ($delete_priv == '1')
						echo "<button type='button' id='btn-delete1" . $no . "' class='btn btn-default btn-xs' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" title='Delete'>";
					else
						echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'>";

					echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='" . $row['penetapan_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='spt_id' value='" . $row['spt_id'] . "'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>
						<i class='fa fa-trash-o'></i></button>
					</td>
				</tr>";
				}
				?> -->
		<?php
		$no = 0;
		foreach ($rows as $row) :
			$no++;

		?>

			<tr>
				<th scope="row"><?= $no ?></th>
				<td align='center'><?= $row['kode_billing']; ?></td>
				<td align='center'><?= $row['kohir']; ?></td>
				<td align='center'><?= $row['nama_paret']; ?></td>
				<td align='center'><?= $row['tahun_pajak']; ?></td>
				<td><?= $row['npwpd']; ?> - <?= $row['nama_wp']; ?></td>
				<td align='center'><?= $row['nomor_spt']; ?></td>
				<td align='center'><?= $row['tgl_penetapan']; ?></td>
				<td><?= $row['singkatan_spt']; ?></td>
				<td align='center'><?= $row['tgl_jatuh_tempo']; ?></td>
				<td align='right'><?= number_format($row['pajak']); ?></td>
				<td align="center"><?php
									if ($row['status_bayar'] == 0) {
										echo 'Belum Lunas';
									} else {
										echo 'Lunas';
									} ?>
				</td>
				<td align="center">
					<?php
					if ($delete_priv == '1')
						echo "<button type='button' id='btn-delete1" . $no . "' class='btn btn-default btn-xs' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" title='Delete'>
					<input type='hidden' id='ajax-req-dt' name='id' value='" . $row['penetapan_id'] . "'/>
					<input type='hidden' id='ajax-req-dt' name='spt_id' value='" . $row['spt_id'] . "'/>
					<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
					<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>
					<i class='fa fa-trash-o'></i></button> ";
					else
						echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'><i class='fa fa-trash-o'></i></button> ";
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>