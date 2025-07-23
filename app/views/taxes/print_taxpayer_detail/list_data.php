<form id="multiPrint_form" method="POST" action="<?=base_url()."/bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/report_controller";?>">
<input type='hidden' name='report_type' id='report_type'/>

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>NPWPD</th>
			<th>No. Pendaftaran</th>			
			<th>Nama</th>
			<th>Alamat</th>
			<th>Kelurahan</th>
			<th>Kecamatan</th>
			<th>Golongan</th>
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
					<td align='center'>".$row['no_reg']."</td>					
					<td>".$row['nama']."</td>
					<td>".$row['alamat']."</td>
					<td>".$row['kelurahan']."</td>
					<td>".$row['kecamatan']."</td>
					<td>".$row['golongan']."</td>
					<td>".$row['nama_kegus']."</td>
					<td align='center'>";
						if($print_priv=='1'){
							echo "<a href='".base_url()."bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/_print?id=".$row['wp_wr_detil_id']."' id='btn-print".$no."' 
						   class='btn btn-default btn-xs' style='color:#000;' target='_blank' title='Cetak'>";
						}else{
							echo "<a href='#' class='btn btn-default btn-xs' onclick=\"alert('Anda tidak memiliki akses untuk mencetak data');\" title='Cetak'>";
						}
						echo "<i class='fa fa-print'></i></a>";
					echo "</td>
				</tr>";
			}
		?>
	</tbody>	
</table>
</form>
<div id="data-view"></div>

<script type="text/javascript">
	function fill_report_type(type)
    {       
        $('#report_type').val(type);
    }

    var multiPrint_form_id = 'multiPrint_form';
    var $multiPrint_form = $('#'+multiPrint_form_id);    

	$multiPrint_form.submit(function(){
    	ajax_object.reset_object();
        ajax_object.set_plugin_datatable(true)
                    .set_loading('#preloadAnimation')
                    .set_content('#data-view')
                    .disable_pnotify()
                    .set_form($multiPrint_form)
                    .submit_ajax('');            
        return false;
    });	
</script>