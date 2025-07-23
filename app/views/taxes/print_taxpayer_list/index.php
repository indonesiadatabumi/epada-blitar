
<input type="hidden" id="base_url" value="<?=base_url();?>"/>

<?php
  echo $banner_info;
  echo $navbar;
?>

<section class="portfolio-showcase-block min-height-maincontent">
  	<div class="box">
  		<div class="row">
  			<div class="col-md-6">
			    <h5>
			  	<i class="fa fa-print"></i> Cetak Daftar Induk WP
			  	</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
				  <li><a href="#"><?=$bundle_row['nama_paret'];?></a></li>
				  <li><a href="#">Pendaftaran</a></li>
				  <li>Cetak Daftar Induk WP</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
		      	<div class="panel-body">
		      		<form class="form-horizontal" id="search_form" action="<?=base_url()."/bundle/taxes/".$bundle_item_type."/".$menu."/report_controller";?>" method="POST">
		      			<input type="hidden" name="menu" id="menu" value="<?=$menu;?>"/>		      			
		      			<input type='hidden' name='report_type' id='report_type'/>
		      			<fieldset>
		      				<div class="form-group">
		      					<label class="control-label col-md-2">Golongan</label>
								<div class="col-md-3">
									<div class="input state-disabled">
										<select class="form-control" name="src-golongan" id="src-golongan">
											<option value=""></option>
											<option value="1">Pribadi</option>
											<option value="2">Badan Usaha</option>
										</select>
									</div>
								</div>								
		      				</div>

		      				<div class="form-group">
		      					<label class="control-label col-md-2">Kegiatan Usaha</label>
								<div class="col-md-3">
									<div class="input state-disabled">
										<select class="form-control" name="src-kegus_id" id="src-kegus_id">
											<option value=""></option>
											<?php
												foreach($business_rows as $row){
													echo "<option value='".$row['ref_kegus_id']."'>".$row['nama_kegus']."</option>";
												}
											?>
										</select>
									</div>
								</div>
		      				</div>

			      			<div class="form-group">
								<label class="control-label col-md-2" for="src-kecamatan_id">Kecamatan</label>
								<div class="col-md-6">
									<div class="input state-disabled">
										<select class="form-control" name="src-kecamatan_id" id="src-kecamatan_id" onchange="get_villages(this.value,'src-kelurahan_id','loader_src_kelurahan')">
											<option value="" selected></option>
											<?php
												foreach($district_rows as $row){
													echo "<option value='".$row['kecamatan_id']."'>".$row['nama_kecamatan']."</option>";
												}
											?>
										</select>
									</div>

								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2" for="src-kelurahan_id">Kelurahan</label>
								<div class="col-md-6">
									<div class="input state-disabled">
										<div id="loader_src_kelurahan" style="display:none">
											<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
										</div>									
										<select class="form-control" name="src-kelurahan_id" id="src-kelurahan_id">
											<option value="" selected>- Silahkan pilih Kecamatan lebih dahulu -</option>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Tgl. Pendaftaran</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src-tgl_pendaftaran_awal" id="src-tgl_pendaftaran_awal" placeholder="Awal"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src-tgl_pendaftaran_akhir" id="src-tgl_pendaftaran_akhir" placeholder="Akhir"/>
									</div>
								</div>
							</div>

							<hr></hr>

							<div class="form-group">
								<label class="control-label col-md-2">Tgl. Cetak</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="printAttr-print_date" value="<?=date('d-m-Y');?>" id="printAttr-print_date">
 									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Mengetahui</label>
								<div class="col-md-6">
									<select class="form-control" name="printAttr-legalitator" id="printAttr-legalitator">
										<option value="" selected></option>
										<?php
											foreach($official_rows as $row){
												echo "<option value='".$row['pejda_id']."'>".$row['nama']." / ".$row['nama_jabatan']."</option>";
											}
										?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Diperiksa Oleh</label>
								<div class="col-md-6">
									<select class="form-control" name="printAttr-evaluator" id="printAttr-evaluator">
										<option value="" selected></option>
										<?php
											foreach($official_rows as $row){
												echo "<option value='".$row['pejda_id']."'>".$row['nama']." / ".$row['nama_jabatan']."</option>";
											}
										?>
									</select>
								</div>
							</div>

				      	</fieldset>
				      	<div class="form-actions">
							<div class="row">
								<div class="col-md-10 col-md-offset-2">										
									<button class="btn btn-primary" type="submit" onclick="fill_report_type('1')"><i class="fa fa-print"></i> Cetak</button>
									<button class="btn btn-danger" type="submit" onclick="fill_report_type('2')"><i class="fa fa-file-pdf-o"></i> PDF</button>
								</div>
							</div>
						</div>
					</form>
		      	</div>
		    </div>
		</div>

		<div id="data-view"></div>

  	</div>
</section>

<script src="<?=$this->config->item('js_path');?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
		$("#src-tgl_pendaftaran_awal,#src-tgl_pendaftaran_akhir,#printAttr-print_date").mask('99-99-9999');		

		// START AND FINISH DATE
		$("#src-tgl_pendaftaran_awal,#src-tgl_pendaftaran_akhir,#printAttr-print_date").datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>'			
		});
	});

	base_url = $('#base_url').val();  	
  	

	function get_villages(district_val,content_id,loader_id,type='1',selected=''){
		ajax_object.reset_object();
		var data_ajax = new Array('district='+district_val,'type='+type,'selected='+selected);
		ajax_object.set_url(base_url+'glob/get_villages').set_data_ajax(data_ajax).set_loading('#'+loader_id).set_content('#'+content_id).request_ajax();
	}

	function fill_report_type(type)
    {       
        $('#report_type').val(type);
    }	
	

	var search_form_id = 'search_form';
    var $search_form = $('#'+search_form_id);
    var search_stat = $search_form.validate({
        // Do not change code below
        errorPlacement : function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());
        }
    });

	$search_form.submit(function(){
        if(search_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true)
                        .set_loading('#preloadAnimation')
                        .set_content('#data-view')
                        .disable_pnotify()
                        .set_form($search_form)
                        .submit_ajax('');            
            return false;
        }
    });	

</script>