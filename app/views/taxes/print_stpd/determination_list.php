
<div class="row">
	<div class="col-md-12">
		<table id="data-table-jq" class="table table-bordered table-striped table-hover">
			<thead>
		        <th>No.</th>
		        <th>No. Kohir</th>
		        <th>Wajib Pajak</th>
		        <th>Periode</th>
		        <th>Tgl. Penetapan</th>
		        <th>Jatuh Tempo</th>		        
		        <th><i class="fa fa-check"</i></th>
		    </thead>
		    <tbody>
		    	<?php
		    		$no = 0;
		    		foreach($rows as $row){
		    			$no++;
		    			echo "<tr>
		    			<td align='center'>".$no."</td>
		    			<td align='center'>".$row['kohir']."</td>
		    			<td>".$row['npwpd']." - ".$row['nama_wp']."</td>
		    			<td align='center'>".$row['tahun_pajak']."</td>
		    			<td align='center'>".$row['tgl_penetapan']."</td>
		    			<td align='center'>".$row['tgl_jatuh_tempo']."</td>		    			
		    			<td align='center'>
		    				<button type='button' id='btn-open-form".$no."' class='btn btn-default btn-xs' onclick=\"select_row(['".$row['kohir']."','".$input_id."'])\">
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
		
		$kohir = $('#src-kohir_'+(params[1]=='1'?'awal':'akhir'));
		$kohir.val(params[0]);

		$('#close-modal-form').click();
	}
	

</script>