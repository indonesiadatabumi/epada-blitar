
<script type="text/javascript" src="<?=$this->config->item('js_path');?>/my_scripts/ajax_upload.js"></script>

<script type='text/javascript'>
    ajax_upload.form_id[0]='<?=$form3_id;?>';
    ajax_upload.loader_id[0]='preloadAnimation';
    ajax_upload.content_id[0]='list-data3';
</script>

<form id="<?=$form3_id;?>" method="POST" action="<?=base_url()."/bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/upload_taxobject_image";?>" class="form-horizontal" onsubmit="ajax_upload.upload_files(event,0);" enctype="multipart/form-data">	
	<input type="hidden" name="menu" value="<?=$menu;?>"/>	
	<input type="hidden" name="wp_wr_id" value="<?=$wp_wr_id;?>"/>

	<fieldset>		
		<ul class="nav nav-tabs" style="margin-top:0!important">
		  <li class="active"><a data-toggle="tab" href="#home">Unggah Gambar Objek Pajak</a></li>
		</ul>
		<div class="tab-content">
		  	<div id="home" class="tab-pane fade in active">
		  		<div class="form-group">
		  			<label class="control-label col-md-3">Objek Pajak <font color="red">*</font></label>
		  			<div class="col-md-6">
		  				<div class="input state-disabled">
		  					<select name="input4-wp_wr_detil_id" id="input4-wp_wr_detil_id" class="form-control" required>
		  						<option value=""></option>
		  						<?php
		  							foreach($taxpayer_detail_rows as $row){
		  								echo "<option value='".$row['wp_wr_detil_id']."'>".$row['nama_wp']." (".$row['nama_kegus'].")</option>";
		  							}
		  						?>
		  					</select>
		  				</div>
		  			</div>
		  		</div>
		  		<div class="form-group">
					<label class="control-label col-md-3">File <font color="red">*</font></label>
					<div class="col-md-6">
						<div class="input">							
							<input type="file" name="input4-file" id="input4-file" onchange="ajax_upload.prepare_upload(event,['image/jpeg','image/png','image/gif'],1000000)" required/>
						</div>
						<div class="note">
							Format : *.jpg, *.png, *.gif, Ukuram Maks. : 1 MB
						</div>
					</div>
					<div class="col-md-3">
						<button type="submit" class="btn btn-primary">Upload</button>
					</div>
				</div>
		  	</div>
		</div>
	</fieldset>
</form>

<div id="list-data3">
	<?php
		echo $list_data;		
	?>
</div>

<script type="text/javascript">
	var $form3=$('#<?=$form3_id;?>');	
	var form3_stat = $form3.validate({
        // Do not change code below
        errorPlacement : function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());

        }
    });

    function delete_taxobject_image(id){
		ajax_object.reset_object();

        ajax_object.set_url(base_url+'bundle/taxes/hotel/record_taxpayer2/delete_taxobject_image')
        		   .set_plugin_datatable(false)
        		   .set_id_input(id)
        		   .set_input_ajax('ajax-req-dt')
        		   .set_data_ajax()
        		   .set_loading('#preloadAnimation').set_content('#list-data3').update_ajax('menghapus data');
	}
</script>