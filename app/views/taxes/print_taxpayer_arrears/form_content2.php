<div id="loader-list-data" style="display:none;" align="center">
	<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
</div>
<div id="list-data2">
	<?php
		echo $list_data;
	?>
</div>

<hr></hr>
<div class="row">
	<div class="col-md-12" align="center">
		<button type="button" class="btn btn-default" id="btn-add2" onclick="load_form2_content(this.id)">
			<input type="hidden" id='ajax-req-dt' name="act" value="add"/>
			<input type="hidden" id='ajax-req-dt' name="menu" value="<?=$menu;?>"/>
			<input type="hidden" id='ajax-req-dt' name="wp_wr_id" value="<?=$wp_wr_id;?>"/>
			<i class="fa fa-plus"></i> Tambah
		</button>
		<button type="button" class="btn btn-danger" id="btn-close-form2" onclick="close_form2_content()">Tutup Form</button>
	</div>
</div>

<br />

<div id="loader-form2" style="display:none;" align="center">
	<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
</div>

<div id="content-form2">
</div>

<script type="text/javascript">
	
	function close_form2_content(){
		$('#content-form2').html('');
		$('#content-form2').hide();
	}

	function load_form2_content(id){
		ajax_object.reset_object();

        ajax_object.set_url(base_url+'bundle/taxes/hotel/record_taxpayer1/form_taxpayer_detail')
        		   .set_id_input(id)
        		   .set_input_ajax('ajax-req-dt')
        		   .set_data_ajax()
        		   .set_loading('#loader-form2')
        		   .set_content('#content-form2')
        		   .request_ajax();
	}

	function delete_record_taxpayer_detail(id){
		ajax_object.reset_object();

        ajax_object.set_url(base_url+'bundle/taxes/hotel/record_taxpayer1/delete_record_taxpayer_detail')
        		   .set_plugin_datatable(false)
        		   .set_id_input(id)
        		   .set_input_ajax('ajax-req-dt')
        		   .set_data_ajax()
        		   .set_loading('#preloadAnimation').set_content('#list-data2').update_ajax('menghapus data');
	}

</script>