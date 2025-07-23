<table id="data-table-jq2" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>Pajak/Keg. Usaha</th>			
			<th>Nama</th>
			<th>Alamat</th>
			<th>No. Telepon</th>
			<th>Utama</th>
			<th>Panel Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 0;
			foreach($taxpayer_detail_rows as $row){

				$no++;
				echo "<tr>
				<td align='center'>".$no."</td>
				<td>".$row['nama_pajak']."/".$row['nama_kegus']."</td>
				<td>".$row['nama_wp']."</td>
				<td>".$row['alamat']."</td>
				<td>".$row['no_telepon']."</td>
				<td align='center'>".($row['utama']?"<i class='fa fa-check'></i>":"")."</td>
				<td align='center'>";

					if(!$row['utama']){

						if($update_priv=='1')
							echo "<button type='button' title='Edit' id='btn-edit2".$no."' class='btn btn-default btn-xs' onclick=\"load_form2_content(this.id)\">";
						else
							echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk merubah data');\" title='Edit'>";

						echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='".$row['wp_wr_detil_id']."'/>
						<input type='hidden' id='ajax-req-dt' name='wp_wr_id' value='".$wp_wr_id."'/>
						<input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
						<input type='hidden' id='ajax-req-dt' name='menu' value='".$menu."'/>
						<i class='fa fa-pencil'></i>";

						echo "</button>";

						if($delete_priv=='1')
							echo "<button type='button' id='btn-delete2".$no."' class='btn btn-default btn-xs' onclick=\"if(confirm('Anda yakin?')){delete_record_taxpayer_detail(this.id)}\" title='Delete'>";
						else
							echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'>";

						echo "
						<input type='hidden' id='ajax-req-dt' name='id' value='".$row['wp_wr_detil_id']."'/>
						<input type='hidden' id='ajax-req-dt' name='wp_wr_id' value='".$wp_wr_id."'/>						
						<input type='hidden' id='ajax-req-dt' name='menu' value='".$menu."'/>
						<i class='fa fa-trash-o'></i></button>";
					}else{
						echo "<font color='red'>can't be modified</font>";
					}

				echo "</td>
				</tr>";
			}
		?>
	</table>
	</table>
</table>

<script type="text/javascript">
	$(function(){
		$('#data-table-jq2').dataTable({
            "oLanguage": {
            "sSearch": "Search :"
            },
            "aoColumnDefs": [
                {
                    'bSortable': false,
                    'aTargets': [0]
                } //disables sorting for column one
            ],
            'iDisplayLength': 10,
            "sPaginationType": "full_numbers"
        });
	});
</script>