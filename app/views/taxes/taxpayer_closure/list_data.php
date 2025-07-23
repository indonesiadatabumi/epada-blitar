<input type="hidden" id="src_params-kecamatan_id" value="<?=(isset($src_params['kecamatan_id'])?$src_params['kecamatan_id']:'');?>"/>
<input type="hidden" id="src_params-kelurahan_id" value="<?=(isset($src_params['kelurahan_id'])?$src_params['kelurahan_id']:'');?>"/>

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>NPWP/NPWRD</th>
			<th>Nama WP/WR</th>
			<th>Pajak/Keg. Usaha</th>
			<th>No./Tgl. Berita Acara</th>			
			<th>Alamat OP</th>
			<th>Kelurahan<br />Kecamatan</th>
			<th>Tgl. Tutup</th>
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
					<td>".$row['nama_wpwr']."</td>
					<td>".$row['nama_paret']."/".$row['nama_kegus']."</td>
					<td>".$row['no_berita_acara']." / ".$row['tgl_berita_acara']."</td>
					<td>".$row['alamat_op']."</td>
					<td>".$row['kelurahan']."<br />".$row['kecamatan']."</td>
					<td>".$row['tgl_tutup']."</td>
					<td align='center'>";

						if($update_priv=='1')
							echo "<button type='button' id='btn-edit1".$no."' class='btn btn-default btn-xs' data-toggle='modal' data-target='#formModal' onclick=\"load_form_content(this.id)\" title='Edit'>";
						else
							echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk merubah data');\" title='Edit'>";

						echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='".$row['wp_wr_penutupan_id']."'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='".$menu."'/>
						<input type='hidden' id='ajax-req-dt' name='wp_wr_detil_id' value='".$row['wp_wr_detil_id']."'/>
						<i class='fa fa-pencil'></i></button>";

						if($delete_priv=='1')
							echo "<button type='button' id='btn-delete1".$no."' class='btn btn-default btn-xs' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" title='Delete'>";
						else
							echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'>";

						echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='".$row['wp_wr_penutupan_id']."'/>						
						<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='".$menu."'/>
						<input type='hidden' id='ajax-req-dt' name='wp_wr_detil_id' value='".$row['wp_wr_detil_id']."'/>
						<i class='fa fa-trash-o'></i></button>
					</td>
				</tr>";
			}
		?>
	</tbody>
</table>