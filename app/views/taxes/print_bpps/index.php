
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
			  	<i class="fa fa-print"></i> Cetak Buku Pembantu Penerimaan Sejenis (BPPS)
			  	</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
				  <li><a href="#"><?=$bundle_row['nama_paret'];?></a></li>
				  <li><a href="#">Pembayaran</a></li>
				  <li>Cetak Buku Pembantu Penerimaan Sejenis (BPPS)</li>
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
								<label class="control-label col-md-2">Tgl. Penerimaan</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src-tgl_bayar_awal" id="src-tgl_bayar_awal" placeholder="Awal"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src-tgl_bayar_akhir" id="src-tgl_bayar_akhir" placeholder="Akhir"/>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">BPPS Via</label>
								<div class="col-md-3">
									<div class="input state-disabled">
										<select class="form-control" name="src-loket_pembayaran_id" id="src-loket_pembayaran_id">
											<option value=""></option>
											<?php
												foreach($locket_rows as $row){
													echo "<option value='".$row['ref_lokemba_id']."'>".$row['loket_pembayaran']."</option>";
												}
											?>
										</select>
									</div>
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
		$("#src-tgl_bayar_awal,#src-tgl_bayar_akhir,#printAttr-print_date").mask('99-99-9999');		

		// START AND FINISH DATE
		$("#src-tgl_bayar_awal,#src-tgl_bayar_akhir,#printAttr-print_date").datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>'			
		});
	});

	base_url = $('#base_url').val();

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