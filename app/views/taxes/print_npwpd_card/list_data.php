<form id="multiPrint_form" method="POST" action="<?=base_url()."/bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/report_controller";?>">
<input type='hidden' name='report_type' id='report_type'/>
<div class="alert alert-warning">
	<strong>Petunjuk :</strong><br />
	<ol type="1">
		<li>Cetak Individual => Klik Tombol Tombol <b><i>PDF</i></b> (dengan icon pdf) untuk mencetak Kartu dengan format PDF pada data WP yang diinginkan</li>
		<li>Cetak Multi => Ceklis/centang baris data WP yang diinginkan kemudian klik tombol PDF pada bagian bawah tabel</li>
	</ol>
</div>
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
					<td align='center'>						
						<a href='".base_url()."bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/pdf?type=single&id=".$row['wp_wr_id']."' id='btn-pdf1".$no."' class='btn btn-default btn-xs' style='color:#000;' target='_blank' title='Print'>
						<i class='fa fa-file-pdf-o'></i></a>&nbsp;|&nbsp;
						<input type='checkbox' name='input-choice".$no."' value='1'/>
						<input type='hidden' name='input-id".$no."' value='".$row['wp_wr_id']."'/>
					</td>
				</tr>";
			}
		?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="10" align="right">
				<input type="hidden" name="n_rows" value="<?=$no;?>"/>
				<button class="btn btn-warning" type="submit" onclick="fill_report_type('2')"><i class="fa fa-file-pdf-o"></i> PDF</button>
			</td>
		</tr>
	</tfoot>
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