<div class="row">
	<div class="col-md-12">
		<table id="data-table-jq" class="table table-bordered table-striped table-hover">
			<thead>
		        <th>No.</th>
		        <th>NPWPD</th>
		        <th>Pajak/Keg. Usaha</th>
		        <th>Nama</th>
		        <th>Alamat</th>
		        <th>Kelurahan</th>
		        <th>Kecamatan</th>
		        <th><i class="fa fa-check"</i></th>
		    </thead>
		    <tbody>
		    	<?php
		    		$no = 0;
		    		foreach($rows as $row){
		    			$no++;
		    			echo "<tr>
		    			<td align='center'>".$no."</td>
		    			<td align='center'>".$row['npwprd']."</td>
		    			<td>".$row['nama_pajak']."/".$row['nama_kegus']."</td>
		    			<td>".$row['nama_wp']."</td>
		    			<td>".$row['alamat']."</td>
		    			<td>".$row['kelurahan']."</td>
		    			<td>".$row['kecamatan']."</td>
		    			<td align='center'>
		    				<button type='button' id='btn-open-form".$no."' class='btn btn-default btn-xs' onclick=\"select_row(['".$row['npwprd']."','".$row['nama_pajak']."','".$row['nama_kegus']."','".$row['wp_wr_detil_id']."'])\">
		    				<i class='fa fa-check'></i>
		    				</button>
		    			</td>
		    			</tr>";
		    		}
		    	?>
		    </tbody>
		</table>
		<div align="center">
			<button type="button" class="btn btn-danger" id="close-modal-form" data-dismiss="modal">Tutup</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	
	function select_row(params){

		$('#src-npwprd').val(params[0]);
		$('#src-wp_wr_detil_id').val(params[3]);
		$('#src-jenis_pajak').val(params[1]+'/'+params[2]);
		$('#close-modal-form').click();
		
	}
	

</script>