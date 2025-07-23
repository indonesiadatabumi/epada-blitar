<input type="hidden" id="src_params-kecamatan_id" value="<?=(isset($src_params['kecamatan_id'])?$src_params['kecamatan_id']:'');?>"/>
<input type="hidden" id="src_params-kelurahan_id" value="<?=(isset($src_params['kelurahan_id'])?$src_params['kelurahan_id']:'');?>"/>

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>NPWPD</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Kelurahan</th>
			<th>Kecamatan</th>
			<th>Kode Pos</th>
			<th>No. Telepon</th>			
			<th>Kegiatan Usaha</th>
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
					<td align='center'>".$row['npwprd']."</td>
					<td>".$row['nama']."</td>
					<td>".$row['alamat']."</td>
					<td>".$row['kelurahan']."</td>
					<td>".$row['kecamatan']."</td>
					<td>".$row['kode_pos']."</td>
					<td>".$row['no_telepon']."</td>
					<td>".$row['nama_kegus']."</td>
					<td align='center'>";

						if($update_priv=='1')
							echo "<button type='button' id='btn-edit1".$no."' class='btn btn-default btn-xs' data-toggle='modal' data-target='#formModal' onclick=\"load_form_content(this.id)\" title='Edit'>";
						else
							echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk merubah data');\" title='Edit'>";

						echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='".$row['wp_wr_id']."'/>
						<input type='hidden' id='ajax-req-dt' name='wp_wr_detil_id' value='".$row['wp_wr_detil_id']."'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='".$menu."'/>
						<i class='fa fa-pencil'></i></button>";

						if($delete_priv=='1')
							echo "<button type='button' id='btn-delete1".$no."' class='btn btn-default btn-xs' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" title='Delete'>";
						else
							echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'>";

						echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='".$row['wp_wr_id']."'/>
						<input type='hidden' id='ajax-req-dt' name='wp_wr_detil_id' value='".$row['wp_wr_detil_id']."'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='".$menu."'/>
						<i class='fa fa-trash-o'></i></button>
					</td>
				</tr>";
			}
		?>
	</tbody>
</table>