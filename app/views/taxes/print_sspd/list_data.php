<input type="hidden" id="src_params-tahun_pajak" value="<?= (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : ''); ?>" />
<input type="hidden" id="src_params-kecamatan_id" value="<?= (isset($src_params['kecamatan_id']) ? $src_params['kecamatan_id'] : ''); ?>" />
<input type="hidden" id="src_params-kelurahan_id" value="<?= (isset($src_params['kelurahan_id']) ? $src_params['kelurahan_id'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_proses_awal" value="<?= (isset($src_params['tgl_proses-start']) ? $src_params['tgl_proses-start'] : ''); ?>" />
<input type="hidden" id="src_params-tgl_proses_akhir" value="<?= (isset($src_params['tgl_proses-end']) ? $src_params['tgl_proses-end'] : ''); ?>" />

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>No SSPD</th>
			<th>Periode</th>
			<th>Masa Pajak</th>
			<th>NPWPD / Nama WP</th>
			<th>Tot. Pajak</th>
			<th>Ketetapan / Tgl. Penetapan</th>
			<th>Tgl. Setoran</th>
			<th>Tot. Setoran</th>
			<th>Status Pembayaran</th>
			<th>Panel Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 0;
		foreach ($rows as $row) {
			$no++;
			if ($row['pajak_id'] == '7') {
				if ($row['masa_pajak1'] < '2024-01-01') {
					$tot_pajak = $row['pajak'];
				} elseif ($row['hrg_0_50'] == null) {
					if ($row['wp_wr_id'] == '40') {
						$pot_pajak = (97 / 100) * $row['pajak'];
						$tot_pajak = $row['pajak'] - $pot_pajak;
					} else {
						$pot_pajak = (55 / 100) * $row['pajak'];
						$tot_pajak = $row['pajak'] - $pot_pajak;
					}
				} else {
					if ($row['wp_wr_id'] == '40') {
						$pot_pajak = (97 / 100) * $row['nilai_terkena_pajak'];
						$tot_pajak = $row['nilai_terkena_pajak'] - $pot_pajak;
					} else {
						$pot_pajak = (55 / 100) * $row['nilai_terkena_pajak'];
						$tot_pajak = $row['nilai_terkena_pajak'] - $pot_pajak;
					}
				}
			} else {
				$tot_pajak = $row['pajak'] - $row['kompensasi'];
			}

			// $tot_pajak = $row['pajak'] - $row['kompensasi'];

			if ($row['pajak'] > 0) {
				echo "<tr>
					<td align='center'>" . $no . "</td>					
					<td align='right'>" . $row['no_urut_sspd'] . "</td>
					<td align='center'>" . $row['tahun_pajak'] . "</td>
					<td>" . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td>
					<td>" . $row['npwpd'] . " / <br />" . $row['nama_wp'] . "</td>
					<td align='right'>" . number_format($tot_pajak) . "</td>
					<td>" . $row['singkatan_spt'] . " / </td>
					<td align='center'>" . indo_date_format($row['tgl_bayar'], 'shortDate') . "</td>
					<td align='right'>" . number_format($row['total_bayar']) . "</td>";
				if ($row['status_bayar'] == '0') {
					echo "<td align='center'>Belum Lunas</td>";
				} else if ($row['status_bayar'] == '1') {
					echo "<td align='center'>Lunas</td>";
				}

				echo "<td align='center'>";

				if ($print_priv == '1') {
					echo "<a href='" . base_url() . "bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/_print?id=" . $row['spt_id'] . "&tgl_cetak=" . $tgl_cetak . "&nama_bendahara=" . $nama_bendahara . "&nip=" . $nip . "&no_sspd=" . $no_sspd . "&singkatan_spt=" . $row['singkatan_spt'] . "' id='btn-print" . $no . "' 
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
						<a href='" . base_url() . "bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/ganti_nomor?id=" . $row['spt_id'] . "&no_sspd=" . $no_sspd . "' class='btn btn-default btn-xs' title='Ganti Nomor'>Ganti Nomor</a>
					</td>
				</tr>";
			}
		}
		?>
	</tbody>
</table>