<?php	
	echo "
	<div id='advanced-form2-content1' style='display:".($advanced_form2_content1?'block':'none')."'>
		<hr></hr>
		<fieldset>
			<div class='row'>
				<div class='col-md-6'>
					<table class='table table-bordered table-hovered'>
						<thead>
							<tr><th>Jenis Kamar</th><th>Jumlah</th><th>Tarif</th></tr>
						</thead>
						<tbody>";
						foreach($room_types1 as $key=>$val){
							echo "<tr>
							<td>".$val."</td>
							<td><input type='text' class='form-control thousand_format' onkeyup=\"sum_room_numbers()\" value='".$curr_data1['jumlah_'.$key]."' name='input3-jumlah_".$key."-int' id='input3-jumlah_".$key."'/></td>
							<td><input type='text' class='form-control thousand_format' onkeyup=\"sum_room_numbers()\" value='".$curr_data1['tarif_'.$key]."' name='input3-tarif_".$key."-int' id='input3-tarif_".$key."'/></td>
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
							<td><input type='text' class='form-control thousand_format' onkeyup=\"sum_room_numbers()\" value='".$curr_data1['jumlah_'.$key]."' name='input3-jumlah_".$key."-int' id='input3-jumlah_".$key."'/></td>
							<td><input type='text' class='form-control thousand_format' onkeyup=\"sum_room_numbers()\" value='".$curr_data1['tarif_'.$key]."' name='input3-tarif_".$key."-int' id='input3-tarif_".$key."'/></td>
							</tr>";
						}
						echo "</tbody>
					</table>
					<div class='form-group'>
						<label class='control-label col-md-3'>Jumlah Kamar</label>
						<div class='col-md-4'>
							<div class='input'>
								<input type='text' class='form-control thousand_format' name='input3-jumlah_kamar-int' id='input3-jumlah_kamar' value='".$curr_data1['jumlah_kamar']."' readonly/>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<label class='control-label col-md-3'>Golongan Hotel <font color='red'>*</font></label>
						<div class='col-md-9'>
							<div class='input state-disabled'>
								<select name='input3-golongan_hotel' id='input3-golongan_hotel' class='form-control' required>
									<option value='' selected></option>";										
										foreach($hotel_type_rows as $row){
											$selected = ($row['ref_kode']==$curr_data1['golongan_hotel']?'selected':'');
											echo "<option value='".$row['ref_kode']."' ".$selected.">".$row['golongan']."</option>";
										}										
								echo "</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>		
		<br />		
	</div>
	<div id='advanced-form2-content2' style='display:".($advanced_form2_content2?'block':'none')."'>
		<hr></hr>
		<fieldset>
			<div class='row'>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label col-md-3'>Jenis Restoran <font color='red'>*</font></label>
						<div class='col-md-9'>
							<div class='input state-disabled'>
								<select name='input3-jenis_restoran' id='input3-jenis_restoran' class='form-control' required>
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
								<input class='form-control thousand_format' name='input3-jumlah_meja-int' id='input3-jumlah_meja' value='".$curr_data2['jumlah_meja']."' required/>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<label class='control-label col-md-3'>Jumlah Kursi <font color='red'>*</font></label>
						<div class='col-md-4'>
							<div class='input'>
								<input class='form-control thousand_format' name='input3-jumlah_kursi-int' id='input3-jumlah_kursi' value='".$curr_data2['jumlah_kursi']."' required/>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label col-md-3'>Kap. Pengunjung</label>
						<div class='col-md-4'>
							<div class='input'>
								<input class='form-control thousand_format' name='input3-kapasitas_pengunjung-int' id='input3-kapasitas_pengunjung' value='".$curr_data2['kapasitas_pengunjung']."'/>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<label class='control-label col-md-3'>Jumlah Karyawan</label>
						<div class='col-md-4'>
							<div class='input'>
								<input class='form-control thousand_format' name='input3-jumlah_karyawan-int' id='input3-jumlah_karyawan' value='".$curr_data2['jumlah_karyawan']."'/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>			
	</div>
	<div id='advanced-form2-content3' style='display:".($advanced_form2_content3?'block':'none')."'>
		<hr></hr>
		<fieldset>
			<div class='row'>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label col-md-3'>Jenis Sumber Air <font color='red'>*</font></label>
						<div class='col-md-5'>
							<div class='input state-disabled'>
								<select name='input3-jenis_sat_id' id='input3-jenis_sat_id' class='form-control' required>
									<option value='' selected></option>";
									foreach($water_source_type_rows as $row){
										$selected = ($row['ref_jensat_id']==$curr_data3['jenis_sat_id']?'selected':'');
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
								<select name='input3-hrgab_id' id='input3-hrgab_id' class='form-control' onchange=\"get_groundwater_resources_components(this.value,'input3-kompsda_id','loader-input3_kompsda_id')\" required>
									<option value='' selected></option>";
									foreach($water_type_rows as $row){
										$selected = ($row['ref_hrgab_id']==$curr_data3['hrgab_id']?'selected':'');
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
						<div class='col-md-7' id='container-sumber_alternatif' style='display:".(!empty($curr_data3['sumber_alternatif'])?'block':none)."'>
							<input type='text' id='input3-sumber_alternatif' name='input3-sumber_alternatif' class='form-control' value='".$curr_data3['sumber_alternatif']."' ".(empty($curr_data3['sumber_alternatif']?'disabled':''))."/>
						</div>
					</div>
					
				</div>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label col-md-3'>Komp. SDA <font color='red'>*</font></label>
						<div class='col-md-9'>
							<div id='loader-input3_kompsda_id' style='display:none'>
								<img src='".$this->config->item('img_path')."ajax-loaders/ajax-loader-1.gif'/>
							</div>
							<div class='input state-disabled'>									
								<select name='input3-kompsda_id' id='input3-kompsda_id' class='form-control' required>
									<option value='' selected></option>";
									foreach($sda_component_rows as $row){
										$selected = ($row['ref_kompsda_id']==$curr_data3['kompsda_id']?'selected':'');
										echo "<option value='".$row['ref_kompsda_id']."' ".$selected.">".$row['kriteria']."</option>";
									}
								echo "</select>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<label class='control-label col-md-3'>Komp. Kompensasi <font color='red'>*</font></label>
						<div class='col-md-9'>
							<div class='input state-disabled'>
								<select name='input3-kompkom_id' id='input3-kompkom_id' class='form-control' required>
									<option value='' selected></option>";
									foreach($compensation_component_rows as $row){
										$selected = ($row['ref_kompkom_id']==$curr_data3['kompkom_id']?'selected':'');
										echo "<option value='".$row['ref_kompkom_id']."' ".$selected.">".$row['peruntukan']."</option>";
									}
								echo "</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</div>";
	
?>