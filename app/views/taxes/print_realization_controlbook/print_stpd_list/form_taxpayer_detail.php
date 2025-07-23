<input type="hidden" id="base_url" value="<?=base_url();?>"/>
<form id="<?=$form2_id;?>" method="POST" action="<?=base_url()."/bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/submit_form_taxpayer_detail";?>" class="form-horizontal">
	<input type="hidden" name="act" id="act" value="<?=$act;?>"/>
	<input type="hidden" name="id_value" value="<?=$id_value;?>"/>	
	<input type="hidden" name="menu" value="<?=$menu;?>"/>	
	<input type="hidden" name="wp_wr_id" value="<?=$wp_wr_id;?>"/>	
	<fieldset>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3"><b>Jenis Pajak</b> <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input state-disabled">
							<?php
							

							echo "
							<select name='input2-pajak_id' id='input2-pajak_id' class='form-control' onchange=\"get_business_types(this.value,'input2-kegus_id','loader_input2_kegus_id','2')\" ".($act=='add'?'required':'readonly').">";
								if($act=='add'){
									echo "<option value='' selected></option>";
									foreach($tax_rows as $row){
										echo "<option value='".$row['bundel_id']."'>".$row['nama_paret']."</option>";

									}
								}else{
									foreach($tax_rows as $row){
										$selected = ($row['bundel_id']==$curr_data['pajak_id']);
										if($selected)
											echo "<option value='".$row['bundel_id']."'>".$row['nama_paret']."</option>";

									}
								}
								
							echo "
							</select>";							
							?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Kegiatan Usaha <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input state-disabled">

							<div id="loader_input2_kegus_id" style="display:none">
								<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
							</div>														

							<?php
							echo "
							<select class='form-control' name='input2-kegus_id' id='input2-kegus_id' ".($act=='add'?'required':'readonly').">";
								if($act=='add'){
									echo "<option value='' selected>- Silahkan pilih Jenis Pajak lebih dulu -</option>";
								}
								else{
									foreach($business_type_rows as $row){
										$selected = ($row['ref_kegus_id']==$curr_data['kegus_id']);
										if($selected)
											echo "<option value='".$row['ref_kegus_id']."' ".$selected.">".$row['nama_kegus']."</option>";
									}
								}
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Nama <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input class="form-control" name="input2-nama" id="input2-nama" value="<?=$curr_data['nama'];?>" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Alamat <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<textarea class="form-control" name="input2-alamat" id="input2-alamat" rows="2" required><?=$curr_data['alamat'];?></textarea>
						</div>
						<div class="note">
							Jalan/No. RT/RW/RK
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Kecamatan <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input state-disabled">
							<select name="input2-kecamatan" id="input2-kecamatan" class="form-control" onchange="get_villages(this.value,'input2-kelurahan','loader_input2_kelurahan','2')" required>
								<option value="" selected></option>
								<?php
									foreach($district_rows as $row){
										$selected = ($row['kecamatan_id']==$curr_data['kecamatan_id']?'selected':'');
										echo "<option value='".$row['kecamatan_id']."_".$row['nama_kecamatan']."_".$row['kode_kecamatan']."' ".$selected.">".$row['nama_kecamatan']."</option>";
									}
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Kelurahan <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input state-disabled">
							<div id="loader_input2_kelurahan" style="display:none">
								<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
							</div>														
							<select class="form-control" name="input2-kelurahan" id="input2-kelurahan" required>
								<option value="" selected>- Silahkan pilih Kecamatan lebih dulu -</option>
								<?php
									if($act=='edit'){
										foreach($village_rows as $row){
											$selected = ($row['kelurahan_id']==$curr_data['kelurahan_id']?'selected':'');
											echo "<option value='".$row['kelurahan_id']."_".$row['nama_kelurahan']."_".$row['kode_kelurahan']."' ".$selected.">".$row['nama_kelurahan']."</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
				</div>

				
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Kabupaten</label>
					<div class="col-md-9">
						<div class="input">
							<input class="form-control" name="input2-kabupaten" id="input2-kabupaten" value="<?=$system_params[6];?>" readonly/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Kode Pos <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control" name="input2-kode_pos" id="input2-kode_pos" value="<?=$curr_data['kode_pos'];?>" required/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">No. Telepon <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input class="form-control" name="input2-no_telepon" id="input2-no_telepon" value="<?=$curr_data['no_telepon'];?>" required/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Tgl. Terima Form <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control datepicker" name="input2-tgl_terima_form-date" id="input2-tgl_terima_form" value="<?=indo_date_format($curr_data['tgl_terima_form'],'shortDate');?>" required/>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Tgl. Pendaftaran <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control datepicker" name="input2-tgl_pendaftaran-date" id="input2-tgl_pendaftaran" value="<?=indo_date_format($curr_data['tgl_pendaftaran'],'shortDate');?>" required/>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Tgl. Batas Kirim <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control datepicker" name="input2-tgl_bts_kirim-date" id="input2-tgl_bts_kirim" value="<?=indo_date_format($curr_data['tgl_bts_kirim'],'shortDate');?>" required/>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Tgl. Form Kembali <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control datepicker" name="input2-tgl_form_kembali-date" id="input2-tgl_form_kembali" value="<?=indo_date_format($curr_data['tgl_form_kembali'],'shortDate');?>" required/>
						</div>						
					</div>
				</div>
			</diV>
		</div>
	</fieldset>

	<?php
		echo $advanced_form;
	?>

	<div class="form-actions">
		<div class="row">
			<div class="col-md-12" align="center">
				<button type="submit" class="btn btn-primary">
					Simpan
				</button>				
			</div>
		</div>
	</div>
</form>

<script src="<?=$this->config->item('js_path');?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
	var base_url = $('#base_url').val();
	var form2_id = '<?=$form2_id;?>';
    var $form2 = $('#'+form2_id);
    var submit_noty = ($('#act').val()=='add'?'menambah':'merubah');
    var form2_stat = $form2.validate({
        // Do not change code below
        errorPlacement : function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());

        }
    });

	$form2.submit(function(){
        if(form2_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(false)
            			.set_content('#list-data2')
                        .set_loading('#loader-list-data2')
                        .enable_pnotify()
                        .set_form($form2)
                        .submit_ajax(submit_noty);
             $('#btn-close-form2').click();
            return false;
        }
    });

	function get_business_types(tax_val,content_id,loader_id,type='1',selected=''){
		ajax_object.reset_object();
		var data_ajax = new Array('tax='+tax_val,'type='+type,'selected='+selected);
		ajax_object.set_url(base_url+'glob/get_business_types').set_data_ajax(data_ajax).set_loading('#'+loader_id).set_content('#'+content_id).request_ajax();

		var $advanced1 = $('#advanced-form2-content1'),$advanced2 = $('#advanced-form2-content2'),$advanced3 = $('#advanced-form2-content3');

		if(tax_val=='1'){
			$advanced2.hide();
			$advanced3.hide();
			$advanced1.show();
		}else if(tax_val=='2'){
			$advanced1.hide();
			$advanced3.hide();
			$advanced2.show();
		}else if(tax_val=='7'){
			$advanced1.hide();
			$advanced2.hide();
			$advanced3.show();
		}else{
			$advanced1.hide();
			$advanced2.hide();
			$advanced3.hide();
		}
	}

	function sum_room_numbers(){

    	var room_types = ['standar','standar_ac','double','superior','delux',
    					  'executive_suite','club_room','apartment'];
    	var $room_numbers,$total_room = $('#input3-jumlah_kamar');
    	var room_numbers = 0;
    	var total_room = 0;

    	for(i = 0;i<room_types.length;i++){
    		$room_numbers = $('#input3-jumlah_'+room_types[i]);
    		room_numbers = gnv($room_numbers.val());
    		
    		room_numbers = replaceall(room_numbers,',','');
    		total_room += parseInt(room_numbers);
    	}

    	total_room = (total_room==0?0:number_format(total_room,0,'.',','));

    	$total_room.val(total_room);

    }

    function water_source_alternative_controller(){

    	var $checker = $('#sumber_alternatif_checker'), $container = $('#container-sumber_alternatif'), $input = $('#input1-sumber_alternatif');

    	if($checker.prop('checked')){
    		$container.show();
    		$input.attr('disabled',false);
    	}else{
    		$container.hide();
    		$input.val('');
    		$input.attr('disabled',true);
    	}

    }

	$(document).ready(function(){
		$("#input2-tgl_terima_form,#input2-tgl_pendaftaran,#input2-tgl_bts_kirim,#input2-tgl_form_kembali").mask('99-99-9999');		

		// START AND FINISH DATE
		$('#input2-tgl_terima_form,#input2-tgl_pendaftaran,#input2-tgl_bts_kirim,#input2-tgl_form_kembali').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>'			
		});

		$(".thousand_format").inputmask({
            'alias': 'numeric',
            rightAlign: true,
            'groupSeparator': '.',
            'autoGroup': true
          });
	});

</script>