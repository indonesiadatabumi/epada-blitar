<input type="hidden" id="base_url" value="<?=base_url();?>"/>
<input type="hidden" id="menu" value="<?=$menu;?>"/>
<input type="hidden" id="bundle_id" value="<?=$bundle_id;?>"/>

<?php
  echo $banner_info;  
  echo $navbar;
?>

<section class="portfolio-showcase-block min-height-maincontent">
	
	<div class="box">

		<div class="row">
  			<div class="col-md-6">
			    <h5>
			  	<i class="fa fa-database"></i> Info Umum
			  	</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
				  <li><a href="#"><?=$bundle_row['nama_paret'];?></a></li>				  
				  <li>Info Umum</li>
				</ul>
			</div>
		</div>

		<div class="panel-group">
			<div class="panel panel-default">
		      	<div class="panel-body">
					<div id="loader_generalInfo" style="display:none" align="center">
						<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
					</div>														
					<div id="content_generalInfo">
					</div>
				</div>
			</div>
		</div>
  	</div>

</section>          

<script type="text/javascript">
	
	function load_general_info(){

		data_ajax1  = ['bundle_id='+$('#bundle_id').val()];
		data_ajax2 = ['bundle_id='+$('#bundle_id').val()];

		ajax_object.reset_object();
		ajax_object
			 .set_n_req(2)
             .set_url([base_url+'glob/get_banner_info',base_url+'glob/get_general_info'])
             .set_loading(['#loader-income-global-info','#loader_generalInfo'])
             .set_content(['#income-global-info','#content_generalInfo'])
             .set_data_ajax2([data_ajax1,data_ajax2])
             .request_ajax();
	}

	$(document).ready(function(){
        load_general_info();
    });

</script>