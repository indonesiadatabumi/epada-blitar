<div id="loader-list-data4" style="display:none;" align="center">
	<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
</div>
<div id="list-data4">
	<?php
		echo $list_data;
	?>
</div>

<div id="loader-form4" style="display:none;" align="center">
	<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
</div>
<div id="content-form4">
</div>

<script type="text/javascript">
	function load_form4_content(id){
		ajax_object.reset_object();

        ajax_object.set_url(base_url+'bundle/taxes/hotel/record_taxpayer2/form_taxobject_map')
        		   .set_id_input(id)
        		   .set_input_ajax('ajax-req-dt')
        		   .set_data_ajax()
        		   .set_loading('#loader-form4')
        		   .set_content('#content-form4')
        		   .request_ajax();
	}
</script>