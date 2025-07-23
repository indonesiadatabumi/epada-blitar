<table id="data-table-jq4" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>Pajak/Keg. Usaha</th>			
			<th>Nama</th>
			<th>Alamat</th>
			<th>Latitude, Longitude</th>			
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
				<td>".(empty($row['latitude']) && empty($row['longitude'])?"<font color='red'>not set</font>":$row['latitude'].", ".$row['longitude'])."</td>
				<td align='center'>";

					if($update_priv=='1')
						echo "<button type='button' title='Edit' id='btn-edit4".$no."' class='btn btn-default btn-xs' onclick=\"load_form4_content(this.id)\">";
					else
						echo "<button type='button' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk merubah data');\" title='Edit'>";

					echo "
					<input type='hidden' id='ajax-req-dt' name='id' value='".$row['wp_wr_detil_id']."'/>
					<input type='hidden' id='ajax-req-dt' name='wp_wr_id' value='".$wp_wr_id."'/>					
					<input type='hidden' id='ajax-req-dt' name='menu' value='".$menu."'/>
					<i class='fa fa-gear'></i>";

					echo "</button>";					

				echo "</td>
				</tr>";
			}
		?>
	</table>
	</table>
</table>

<script type="text/javascript">
	$(function(){
		$('#data-table-jq4').dataTable({
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