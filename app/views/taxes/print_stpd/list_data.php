<input type="hidden" id="src_params-tahun_pajak" value="<?=(isset($src_params['tahun_pajak'])?$src_params['tahun_pajak']:'');?>"/>
<input type="hidden" id="src_params-kecamatan_id" value="<?=(isset($src_params['kecamatan_id'])?$src_params['kecamatan_id']:'');?>"/>
<input type="hidden" id="src_params-kelurahan_id" value="<?=(isset($src_params['kelurahan_id'])?$src_params['kelurahan_id']:'');?>"/>
<input type="hidden" id="src_params-tgl_proses_awal" value="<?=(isset($src_params['tgl_proses-start'])?$src_params['tgl_proses-start']:'');?>"/>
<input type="hidden" id="src_params-tgl_proses_akhir" value="<?=(isset($src_params['tgl_proses-end'])?$src_params['tgl_proses-end']:'');?>"/>

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>			
			<th>Nomor</th>
			<th>Periode</th>
			<th>Masa Pajak</th>
			<th>NPWPD / Nama WP</th>			
			<th>Tot. Pajak</th>
			<th>Tgl. Setoran</th>
			<th>Tot. Setoran</th>
			<th>Panel Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 0;
			foreach($rows as $row){
				$no++;

				echo "<tr>
					<td align='center'>".$no."</td>					
					<td align='right'>".$row['nomor_spt']."</td>
					<td align='center'>".$row['tahun_pajak']."</td>
					<td>".mix_2Date($row['masa_pajak1'],$row['masa_pajak2'])."</td>
					<td>".$row['npwpd']." / <br />".$row['nama_wp']."</td>
					<td align='right'>".number_format($row['pajak'])."</td>					
					<td align='center'></td>
					<td align='right'></td>
					<td align='center'>";

						if($print_priv=='1'){
							echo "<a href='".base_url()."bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/_print?id=".$row['spt_id']."' id='btn-print".$no."' 
						   		class='btn btn-default btn-xs' style='color:#000;' target='_blank' title='Cetak'>";
						}
						else
							echo "<a href='#' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk mencetak data');\" title='Cetak'>";

						echo "
						<i class='fa fa-print'></i></a>&nbsp;";

						if($print_priv=='1'){
							echo "<a href='".base_url()."bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/pdf?id=".$row['spt_id']."' id='btn-print".$no."' 
						   		class='btn btn-default btn-xs' style='color:#000;' target='_blank' title='PDF'>";
						}else
							echo "<a href='#' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk mencetak data');\" title='PDF'>";

						echo "						
						<i class='fa fa-file-pdf-o'></i></a>&nbsp;";
						
					echo "</td>
				</tr>";
			}
		?>
	</tbody>
</table>