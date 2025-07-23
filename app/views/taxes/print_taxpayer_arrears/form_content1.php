<form id="<?=$main_form_id;?>" method="POST" action="<?=base_url()."/bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/submit_form";?>" class="form-horizontal">
	<input type="hidden" name="act" id="act" value="<?=$act;?>"/>
	<input type="hidden" name="id_value" value="<?=$id_value;?>"/>
	<input type="hidden" name="wp_wr_detil_id" value="<?=$wp_wr_detil_id;?>"/>
	<input type="hidden" name="menu" value="<?=$menu;?>"/>	
	
	<?php	
	echo "
	<input type='hidden' name='input-".($act=='add'?'created':'modified')."_by' value='".$this->session->userdata('username')."'/>
	<input type='hidden' name='input-".($act=='add'?'created':'modified')."_time' value='".date('Y-m-d H:i:s')."'/>";
	if($act=='add'){
		echo "<input type='hidden' name='input-modified_time' value='".date('Y-m-d H:i:s')."'/>";
	}
	?>

	<input type="hidden" name="showed" value="<?=$showed;?>"/>	

	<?php
		foreach($src_params as $key=>$val){
			echo "<input type='hidden' name='src-".$key."' value='".$val."'/>";
		}
	?>

	<fieldset>
		<div class="row">
			<div class="col-md-6">
				
				<div class="form-group">
					<label class="control-label col-md-3"><b>Jenis Pajak</b></label>
					<div class="col-md-9">
						<div class="input">
							<input class="form-control" value="<?=$bundle_name;?>" readonly/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3"><b>Kegiatan Usaha</b> <?=($act=='add'?"<font color='red'>*</font>":"");?></label>
					<div class="col-md-9">
						<div class="input state-disabled">
							<select name="input-kegus_id" id="input-kegus_id" class="form-control" <?=($act=='add'?"required":"disabled");?>>
								<option value="" selected></option>
								<?php
									foreach($business_type_rows as $row){
										$selected = ($row['ref_kegus_id']==$curr_data['kegus_id']?'selected':'');
										echo "<option value='".$row['ref_kegus_id']."_".$row['kode_kegus']."' ".$selected.">".$row['nama_kegus']."</option>";
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
							<input class="form-control" name="input-nama" id="input-nama" value="<?=$curr_data['nama'];?>" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Alamat <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<textarea class="form-control" name="input-alamat" id="input-alamat" rows="2" required><?=$curr_data['alamat'];?></textarea>
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
							<select name="input-kecamatan" id="input-kecamatan" class="form-control" onchange="get_villages(this.value,'input-kelurahan','loader_input_kelurahan','2')" required>
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
							<div id="loader_input_kelurahan" style="display:none">
								<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
							</div>														
							<select class="form-control" name="input-kelurahan" id="input-kelurahan" required>
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

				<div class="form-group">
					<label class="control-label col-md-3">Kabupaten</label>
					<div class="col-md-9">
						<div class="input">
							<input class="form-control" name="input-kabupaten" id="input-kabupaten" value="<?=$system_params[6];?>" readonly/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Kode Pos <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control" name="input-kode_pos" id="input-kode_pos" value="<?=$curr_data['kode_pos'];?>" required/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">No. Telepon <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control" name="input-no_telepon" id="input-no_telepon" value="<?=$curr_data['no_telepon'];?>" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Kewarganegaraan <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input state-disabled">
							<select class="form-control" name="input-kewarganegaraan" id="input-kewarganegaraan" required>
								<option value="" selected></option>
								<?php
									$opts = array('WNI','WNA');
									foreach($opts as $opt){
										$selected = ($curr_data['kewarganegaraan']==$opt?'selected':'');
										echo "<option value='".$opt."' ".$selected.">".$opt."</option>";
									}
								?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Tanda Bukti Diri <font color="red">*</font></label>
					<div class="col-md-3">
						<div class="input state-disabled">
							<select class="form-control" name="input-jns_tb" id="input-jns_tb" required>
								<option value="" selected></option>
								<?php
									$opts = array('KTP','SIM','Paspor');
									foreach($opts as $opt){
										$selected = ($curr_data['jns_tb']==$opt?'selected':'');
										echo "<option value='".$opt."' ".$selected.">".$opt."</option>";
									}
								?>
							</select>
						</div>
						<div class="note">
							Jenis
						</div>
					</div>
					<div class="col-md-3">
						<div class="input">
							<input class="form-control" name="input-no_tb" id="input-no_tb" value="<?=$curr_data['no_tb'];?>" required/>
						</div>
						<div class="note">
							Nomor
						</div>
					</div>
					<div class="col-md-3">
						<div class="input">
							<input class="form-control datepicker" name="input-tgl_tb-date" id="input-tgl_tb" value="<?=indo_date_format($curr_data['tgl_tb'],'shortDate');?>" required/>
						</div>
						<div class="note">
							Tanggal
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Kartu Keluarga</label>					
					<div class="col-md-6">
						<div class="input">
							<input class="form-control" name="input-no_kk" id="input-no_kk" value="<?=$curr_data['no_kk'];?>"/>
						</div>
						<div class="note">
							Nomor
						</div>
					</div>
					<div class="col-md-3">
						<div class="input">
							<input class="form-control datepicker" name="input-tgl_kk-date" id="input-tgl_kk" value="<?=indo_date_format($curr_data['tgl_kk'],'shortDate');?>" />
						</div>
						<div class="note">
							Tanggal
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Pekerjaan</label>
					<div class="col-md-4">
						<div class="input state-disabled">
							<select class="form-control" id="input-pekerjaan-selector" onchange="select_job(this.value);">
								<option value="" selected></option>
								<?php
									$opts = array('Pegawai Negeri','Karyawan Swasta','Pemilik Usaha','Lainnya');
									$job = "";
									if($curr_data['pekerjaan']!=''){
										$job = (!in_array($curr_data['pekerjaan'],$opts)?'Lainnya':$curr_data['pekerjaan']);
									}
									foreach($opts as $opt){									
										$selected = ($job==$opt?'selected':'');
										echo "<option value='".$opt."' ".$selected.">".$opt."</option>";
									}
								?>
							</select>
						</div>						
					</div>
					<div class="col-md-5">
						<div class="input">
							<input class="form-control" name="input-pekerjaan" id="input-pekerjaan" value="<?=$curr_data['pekerjaan'];?>" />
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Nama Instansi</label>
					<div class="col-md-9">
						<div class="input">
							<input class="form-control" name="input-nm_instansi" id="input-nm_instansi" value="<?=$curr_data['nm_instansi'];?>" />
						</div>
						<div class="note">
							Tempat bekerja/usaha
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Alamat Instansi</label>
					<div class="col-md-9">
						<div class="input">
							<textarea class="form-control" name="input-alamat_instansi" id="input-alamat_instansi" rows="2" required><?=$curr_data['alamat_instansi'];?></textarea>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Tgl. Terima Form <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control datepicker" name="input-tgl_terima_form-date" id="input-tgl_terima_form" value="<?=indo_date_format($curr_data['tgl_terima_form'],'shortDate');?>" required/>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Tgl. Pendaftaran <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control datepicker" name="input-tgl_pendaftaran-date" id="input-tgl_pendaftaran" value="<?=indo_date_format($curr_data['tgl_pendaftaran'],'shortDate');?>" required/>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Tgl. Batas Kirim <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control datepicker" name="input-tgl_bts_kirim-date" id="input-tgl_bts_kirim" value="<?=indo_date_format($curr_data['tgl_bts_kirim'],'shortDate');?>" required/>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Tgl. Form Kembali <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control datepicker" name="input-tgl_form_kembali-date" id="input-tgl_form_kembali" value="<?=indo_date_format($curr_data['tgl_form_kembali'],'shortDate');?>" required/>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</fieldset>

	<?php
	if($bundle_id=='1' or $bundle_id=='2' or $bundle_id=='7'){

		echo "<hr></hr>";
		echo "		
		<fieldset>";
			if($bundle_id=='1'){
				echo "<div class='row'>
					<div class='col-md-6'>
						
						<table class='table table-bordered table-hovered'>
							<thead>
								<tr><th>Jenis Kamar</th><th>Jumlah</th><th>Tarif</th></tr>
							</thead>
							<tbody>";
							foreach($room_types1 as $key=>$val){
								echo "<tr>
								<td>".$val."</td>
								<td><input type='text' class='form-control thousand_format' value='".$curr_data2['jumlah_'.$key]."' onkeyup=\"sum_room_numbers()\" name='input1-jumlah_".$key."-int' id='input1-jumlah_".$key."'/></td>
								<td><input type='text' class='form-control thousand_format' value='".$curr_data2['tarif_'.$key]."' onkeyup=\"sum_room_numbers()\" name='input1-tarif_".$key."-int' id='input1-tarif_".$key."'/></td>
								</tr>";
							}
							echo "</tbody>
						</table>


					</div>
					<div class='col-md-6'>						
						<table class='table table-bordered table-hovered'>
							<thead>
								<tr><th>Jenis Kamar</th><th>Jumlah</th><th>Tarif</th></tr>
							</thead>
							<tbody>";
							foreach($room_types2 as $key=>$val){
								echo "<tr>
								<td>".$val."</td>
								<td><input type='text' class='form-control thousand_format' value='".$curr_data2['jumlah_'.$key]."' onkeyup=\"sum_room_numbers()\" name='input1-jumlah_".$key."-int' id='input1-jumlah_".$key."'/></td>
								<td><input type='text' class='form-control thousand_format' value='".$curr_data2['tarif_'.$key]."' onkeyup=\"sum_room_numbers()\" name='input1-tarif_".$key."-int' id='input1-tarif_".$key."'/></td>
								</tr>";
							}
							echo "</tbody>
						</table>
						<div class='form-group'>
							<label class='control-label col-md-3'>Jumlah Kamar</label>
							<div class='col-md-4'>
								<div class='input'>
									<input type='text' class='form-control thousand_format' name='input1-jumlah_kamar-int' id='input1-jumlah_kamar' value='".$curr_data2['jumlah_kamar']."' readonly/>
								</div>
							</div>
						</div>
						<div class='form-group'>
							<label class='control-label col-md-3'>Golongan Hotel <font color='red'>*</font></label>
							<div class='col-md-9'>
								<div class='input state-disabled'>
									<select name='input1-golongan_hotel' id='input1-golongan_hotel' class='form-control' required>
										<option value='' selected></option>";										
											foreach($hotel_type_rows as $row){
												$selected = ($row['ref_kode']==$curr_data2['golongan_hotel']?'selected':'');
												echo "<option value='".$row['ref_kode']."' ".$selected.">".$row['golongan']."</option>";
											}										
									echo "</select>
								</div>
							</div>
						</div>
					</div>
				</div>";
			}else if($bundle_id=='2'){
				echo "<div class='row'>
					<div class='col-md-6'>
						<div class='form-group'>
							<label class='control-label col-md-3'>Jenis Restoran <font color='red'>*</font></label>
							<div class='col-md-9'>
								<div class='input state-disabled'>
									<select name='input1-jenis_restoran' id='input1-jenis_restoran' class='form-control' required>
										<option value='' selected></option>";										
											foreach($resto_type_rows as $row){
												$selected = ($row['ref_kode']==$curr_data2['jenis_restoran']?'selected':'');
												echo "<option value='".$row['ref_kode']."' ".$selected.">".$row['jenis_restoran']."</option>";
											}										
									echo "</select>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-3'>Jumlah Meja <font color='red'>*</font></label>
							<div class='col-md-4'>
								<div class='input'>
									<input class='form-control thousand_format' name='input1-jumlah_meja-int' id='input1-jumlah_meja' value='".$curr_data2['jumlah_meja']."' required/>
								</div>
							</div>
						</div>
						<div class='form-group'>
							<label class='control-label col-md-3'>Jumlah Kursi <font color='red'>*</font></label>
							<div class='col-md-4'>
								<div class='input'>
									<input class='form-control thousand_format' name='input1-jumlah_kursi-int' id='input1-jumlah_kursi' value='".$curr_data2['jumlah_kursi']."' required/>
								</div>
							</div>
						</div>
					</div>
					<div class='col-md-6'>
						<div class='form-group'>
							<label class='control-label col-md-3'>Kap. Pengunjung</label>
							<div class='col-md-4'>
								<div class='input'>
									<input class='form-control thousand_format' name='input1-kapasitas_pengunjung-int' id='input1-kapasitas_pengunjung' value='".$curr_data2['kapasitas_pengunjung']."'/>
								</div>
							</div>
						</div>
						<div class='form-group'>
							<label class='control-label col-md-3'>Jumlah Karyawan</label>
							<div class='col-md-4'>
								<div class='input'>
									<input class='form-control thousand_format' name='input1-jumlah_karyawan-int' id='input1-jumlah_karyawan' value='".$curr_data2['jumlah_karyawan']."'/>
								</div>
							</div>
						</div>
					</div>
				</div>";
			}else if($bundle_id=='7'){

				echo "<div class='row'>
					<div class='col-md-6'>
						<div class='form-group'>
							<label class='control-label col-md-3'>Jenis Sumber Air <font color='red'>*</font></label>
							<div class='col-md-5'>
								<div class='input state-disabled'>
									<select name='input1-jenis_sat_id' id='input1-jenis_sat_id' class='form-control' required>
										<option value='' selected></option>";
										foreach($water_source_type_rows as $row){
											$selected = ($row['ref_jensat_id']==$curr_data2['jenis_sat_id']?'selected':'');
											echo "<option value='".$row['ref_jensat_id']."' ".$selected.">".$row['jenis_sat']."</option>";
										}
									echo "</select>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-3'>Jenis Air <font color='red'>*</font></label>
							<div class='col-md-4'>
								<div class='input state-disabled'>
									<select name='input1-hrgab_id' id='input1-hrgab_id' class='form-control' required>
										<option value='' selected></option>";
										foreach($water_type_rows as $row){
											$selected = ($row['ref_hrgab_id']==$curr_data2['hrgab_id']?'selected':'');
											echo "<option value='".$row['ref_hrgab_id']."' ".$selected.">".$row['deskripsi']."</option>";
										}
									echo "</select>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-3'>Sumber Altenatif</label>
							<div class='col-md-2'>
								<input type='checkbox' id='sumber_alternatif_checker' onclick=\"water_source_alternative_controller()\" value='1' ".(!empty($curr_data2['sumber_alternatif'])?'checked':'')."/> Ada
								<input type='hidden' name='sumber_alternatif' value='false'/>
							</div>
							<div class='col-md-7' id='container-sumber_alternatif' style='display:".(!empty($curr_data2['sumber_alternatif'])?'block':none)."'>
								<input type='text' id='input1-sumber_alternatif' name='input1-sumber_alternatif' class='form-control' value='".$curr_data2['sumber_alternatif']."' ".(empty($curr_data2['sumber_alternatif']?'disabled':''))."/>
							</div>
						</div>
						
					</div>
					<div class='col-md-6'>
						<div class='form-group'>
							<label class='control-label col-md-3'>Komp. SDA</label>
							<div class='col-md-9'>
								<div class='input state-disabled'>
									<select name='input1-kompsda_id' id='input1-kompsda_id' class='form-control' required>
										<option value='' selected></option>";
										foreach($sda_component_rows as $row){
											$selected = ($row['ref_kompsda_id']==$curr_data2['kompsda_id']?'selected':'');
											echo "<option value='".$row['ref_kompsda_id']."' ".$selected.">".$row['kriteria']."</option>";
										}
									echo "</select>
								</div>
							</div>
						</div>
						<div class='form-group'>
							<label class='control-label col-md-3'>Komp. Komponesasi</label>
							<div class='col-md-9'>
								<div class='input state-disabled'>
									<select name='input1-kompkom_id' id='input1-kompkom_id' class='form-control' required>
										<option value='' selected></option>";
										foreach($compensation_component_rows as $row){
											$selected = ($row['ref_kompkom_id']==$curr_data2['kompkom_id']?'selected':'');
											echo "<option value='".$row['ref_kompkom_id']."' ".$selected.">".$row['peruntukan']."</option>";
										}
									echo "</select>
								</div>
							</div>
						</div>
					</div>
				</div>";
			}
		echo "</fieldset>		
		<br />";

	}
	?>
	<div class="form-actions">
		<div class="row">
			<div class="col-md-12" align="center">
				<button type="submit" class="btn btn-primary">
					Simpan
				</button>
				<button type="button" class="btn btn-default" id="close-modal-form" data-dismiss="modal">
					Batal
				</button>
			</div>
		</div>
	</div>
</form>

<script src="<?=$this->config->item('js_path');?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">

	$(document).ready(function(){
		$("#input-tgl_tb,#input-tgl_kk,#input-tgl_terima_form,#input-tgl_pendaftaran,#input-tgl_bts_kirim,#input-tgl_form_kembali").mask('99-99-9999');		

		// START AND FINISH DATE
		$('#input-tgl_tb,#input-tgl_kk,#input-tgl_terima_form,#input-tgl_pendaftaran,#input-tgl_bts_kirim,#input-tgl_form_kembali').datepicker({
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

	var main_form_id = '<?=$main_form_id;?>';
    var $main_form = $('#'+main_form_id);
    var submit_noty = ($('#act').val()=='add'?'menambah':'merubah');
    var main_form_stat = $main_form.validate({
        // Do not change code below
        errorPlacement : function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());

        }
    });

	$main_form.submit(function(){
        if(main_form_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true)
            			.set_content('#list-data')
                        .set_loading('#loader-list-data')
                        .enable_pnotify()
                        .set_form($main_form)
                        .submit_ajax(submit_noty);
            $('#close-modal-form').click();
            return false;
        }
    });

    function select_job(job){    	
    	$input_pekerjaan = $('#input-pekerjaan');
    	$input_pekerjaan.val((job.toLowerCase()!='lainnya'?job:''));
    }

    function sum_room_numbers(){

    	var room_types = ['standar','standar_ac','double','superior','delux',
    					  'executive_suite','club_room','apartment'];
    	var $room_numbers,$total_room = $('#input1-jumlah_kamar');
    	var room_numbers = 0;
    	var total_room = 0;

    	for(i = 0;i<room_types.length;i++){
    		$room_numbers = $('#input1-jumlah_'+room_types[i]);
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
</script>