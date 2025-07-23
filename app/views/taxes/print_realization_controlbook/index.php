<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
<input type="hidden" id="curr_month" value="<?= (int)date('m'); ?>" />
<input type="hidden" id="curr_year" value="<?= date('Y'); ?>" />
<?php
echo $banner_info;
echo $navbar;
?>

<section class="portfolio-showcase-block min-height-maincontent">
	<div class="box">
		<div class="row">
			<div class="col-md-6">
				<h5>
					<i class="fa fa-print"></i> Cetak Realisasi & Buku Kendali
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Pembukuan</a></li>
					<li><a href="#">Pembukuan Peneriman</a></li>
					<li>Cetak Realisasi & Buku Kendali</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">

					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="style1" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
										Cetak Realisasi</a>
								</h4>
							</div>
							<div id="collapse1" class="panel-collapse collapse in">
								<div class="panel-body">

									<form class="form-horizontal" id="search_form1" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/report_controller"; ?>" method="POST">
										<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
										<input type="hidden" name="search_type" value="1" />
										<input type="hidden" name="report_type" id="report_type1" />
										<fieldset>

											<div class="form-group">
												<label class="control-label col-md-2">Periode Realisasi</label>
												<div class="col-md-2">
													<div class="input state-disabled">
														<!-- <select class="form-control" name="src1-masa_pajak1" id="src1-masa_pajak1">
															<?php
															for ($i = 1; $i <= 12; $i++) {
																$selected = ($i == 1 ? 'selected' : '');
																echo "<option value='" . $i . "' " . $selected . ">" . get_monthName($i) . "</option>";
															}
															?>
														</select> -->
														<input class="form-control" type="text" name="src1-masa_pajak1" id="src1-masa_pajak1" style="font-style:bold;font-size:1.5em" required />
													</div>
												</div>
												<!-- <div class="col-md-1">
													<div class="input">
														<input type="text" class="form-control" name="src1-tahun_pajak1" id="src1-tahun_pajak1" value="<?= date('Y'); ?>" maxlength="4" />
													</div>
												</div> -->
												<div class="col-md-1" align="center">s.d</div>

												<div class="col-md-2">
													<div class="input state-disabled">
														<!-- <select class="form-control" name="src1-masa_pajak2" id="src1-masa_pajak2">
															<?php
															for ($i = 1; $i <= 12; $i++) {
																$selected = ($i == date('m') ? 'selected' : '');
																echo "<option value='" . $i . "' " . $selected . ">" . get_monthName($i) . "</option>";
															}
															?>
														</select> -->
														<input class="form-control" type="text" name="src1-masa_pajak2" id="src1-masa_pajak2" style="font-style:bold;font-size:1.5em" required />
													</div>
												</div>
												<!-- <div class="col-md-1">
													<div class="input">
														<input type="text" class="form-control" name="src1-tahun_pajak2" id="src1-tahun_pajak2" value="<?= date('Y'); ?>" maxlength="4" />
													</div>
												</div> -->
											</div>
											<div class="form-group">
												<label class="control-label col-md-2">Jenis Ketetapan <font color="red">*</font></label>
												<div class="col-md-4">
													<div class="input state-disabled">
														<select class="form-control" name="src1-jenis_spt_id" onchange="control_kohir_numb(this.value)" id="src-jenis_spt_id" required>
															<?php
															foreach ($spt_type_rows as $row) {
																$selected = ($row['ref_jenspt_id'] == $bundle_row['jenis_spt_id'] ? 'selected' : '');
																echo "<option value='" . $row['ref_jenspt_id'] . "' " . $selected . ">" . $row['keterangan'] . " (" . $row['singkatan'] . ")</option>";
															}
															?>
														</select>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-2">Kecamatan</label>
												<div class="col-md-4">
													<div class="input state-disabled">
														<select class="form-control" name="src1-kecamatan_id" id="src1-kecamatan_id" onchange="get_villages(this.value,'src-kelurahan_id','loader_src_kelurahan')">
															<option value="" selected></option>
															<?php
															foreach ($district_rows as $row) {
																echo "<option value='" . $row['kecamatan_id'] . "'>" . $row['nama_kecamatan'] . "</option>";
															}
															?>
														</select>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-2">Kelurahan</label>
												<div class="col-md-4">
													<div class="input state-disabled">
														<div id="loader_src_kelurahan" style="display:none">
															<img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
														</div>
														<select class="form-control" name="src1-kelurahan_id" id="src-kelurahan_id">
															<option value="" selected></option>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="control-label col-md-2"></div>
												<div class="col-md-4">
													<input type="checkbox" name="src1-denda" value="1" checked /> Sertakan Denda
												</div>
											</div>

										</fieldset>
										<div class="form-actions">
											<div class="row">
												<div class="col-md-10 col-md-offset-2">
													<button class="btn btn-primary" type="submit" onclick="fill_report_type('1','1')"><i class="fa fa-print"></i> Cetak</button>
													<button class="btn btn-success" type="submit" onclick="fill_report_type('3','1')"><i class="fa fa-file-excel-o"></i> Excel</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="style1" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
										Cetak Buku Kendali</a>
								</h4>
							</div>
							<div id="collapse2" class="panel-collapse collapse">
								<div class="panel-body">
									<form class="form-horizontal" id="search_form2" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/report_controller"; ?>" method="POST">
										<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
										<input type="hidden" name="search_type" value="2" />
										<input type="hidden" name="report_type" id="report_type2" />
										<fieldset>
											<div class="form-group">
												<label class="control-label col-md-2">Periode Buku Kendali</label>
												<div class="col-md-2">
													<div class="input state-disabled">
														<select class="form-control" name="src2-masa_pajak1" id="src2-masa_pajak1">
															<?php
															for ($i = 1; $i <= 12; $i++) {
																$selected = ($i == 1 ? 'selected' : '');
																echo "<option value='" . $i . "' " . $selected . ">" . get_monthName($i) . "</option>";
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-md-1">
													<div class="input">
														<input type="text" class="form-control" name="src2-tahun_pajak1" id="src2-tahun_pajak1" value="<?= date('Y'); ?>" maxlength="4" />
													</div>
												</div>
												<div class="col-md-1" align="center">s.d</div>

												<div class="col-md-2">
													<div class="input state-disabled">
														<select class="form-control" name="src2-masa_pajak2" id="src2-masa_pajak2">
															<?php
															for ($i = 1; $i <= 12; $i++) {
																$selected = ($i == date('m') ? 'selected' : '');
																echo "<option value='" . $i . "' " . $selected . ">" . get_monthName($i) . "</option>";
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-md-1">
													<div class="input">
														<input type="text" class="form-control" name="src2-tahun_pajak2" id="src2-tahun_pajak2" value="<?= date('Y'); ?>" maxlength="4" />
													</div>
												</div>
											</div>


											<div class="form-group">
												<label class="control-label col-md-2">Jenis Ketetapan <font color="red">*</font></label>
												<div class="col-md-4">
													<div class="input state-disabled">
														<select class="form-control" name="src2-jenis_spt_id" onchange="control_kohir_numb(this.value)" id="src-jenis_spt_id" required>
															<?php
															foreach ($spt_type_rows as $row) {
																$selected = ($row['ref_jenspt_id'] == $bundle_row['jenis_spt_id'] ? 'selected' : '');
																echo "<option value='" . $row['ref_jenspt_id'] . "' " . $selected . ">" . $row['keterangan'] . " (" . $row['singkatan'] . ")</option>";
															}
															?>
														</select>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-2">Kecamatan</label>
												<div class="col-md-4">
													<div class="input state-disabled">
														<select class="form-control" name="src2-kecamatan_id" id="src2-kecamatan_id">
															<option value="" selected></option>
															<?php
															foreach ($district_rows as $row) {
																echo "<option value='" . $row['kecamatan_id'] . "'>" . $row['nama_kecamatan'] . "</option>";
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="control-label col-md-2"></div>
												<div class="col-md-4">
													<input type="checkbox" name="src2-denda" value="1" checked /> Sertakan Denda
												</div>
											</div>

										</fieldset>
										<div class="form-actions">
											<div class="row">
												<div class="col-md-10 col-md-offset-2">
													<button class="btn btn-primary" type="submit" onclick="fill_report_type('1','2')"><i class="fa fa-print"></i> Cetak</button>
													<button class="btn btn-success" type="submit" onclick="fill_report_type('3','2')"><i class="fa fa-file-excel-o"></i> Excel</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="data-view"></div>

	</div>
</section>

<script src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
	base_url = $('#base_url').val();

	$(document).ready(function() {

		$("#src1-masa_pajak1,#src1-masa_pajak2").mask('99-99-9999');

		// START AND FINISH DATE
		$("#src1-masa_pajak1,#src1-masa_pajak2").datepicker({
			dateFormat: 'dd-mm-yy',
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>'
		});

		$(".number").inputmask({
			'alias': 'numeric',
			'mask': '9999999999999999',
			rightAlign: false
		});

	});


	function fill_report_type(rpt_type, src_type) {
		$('#report_type' + src_type).val(rpt_type);
	}

	function get_villages(district_val, content_id, loader_id, type = '1', selected = '') {
		ajax_object.reset_object();
		var data_ajax = new Array('district=' + district_val, 'type=' + type, 'selected=' + selected);
		ajax_object.set_url(base_url + 'glob/get_villages').set_data_ajax(data_ajax).set_loading('#' + loader_id).set_content('#' + content_id).request_ajax();
	}

	function control_tax_period(val) {
		var $tax_period = $('#src1-masa_pajak'),
			$tax_year = $('#src1-tahun_pajak');
		var curr_month = $('#curr_month').val(),
			curr_year = $('#curr_year').val();

		if (val == '2') {
			$tax_period.val('');
			$tax_year.val('');
		} else {
			$tax_period.val(curr_month);
			$tax_year.val(curr_year);
		}

		$tax_period.attr('disabled', (val == '2'));
		$tax_year.attr('disabled', (val == '2'));
	}

	var search_form1_id = 'search_form1';
	var $search_form1 = $('#' + search_form1_id);
	var search_stat1 = $search_form1.validate({
		// Do not change code below
		errorPlacement: function(error, element) {
			error.addClass('error');
			error.insertAfter(element.parent());
		}
	});

	$search_form1.submit(function() {
		if (search_stat1.checkForm()) {
			ajax_object.reset_object();
			ajax_object.set_plugin_datatable(true)
				.set_loading('#preloadAnimation')
				.set_content('#data-view')
				.disable_pnotify()
				.set_form($search_form1)
				.submit_ajax('');
			return false;
		}
	});


	var search_form2_id = 'search_form2';
	var $search_form2 = $('#' + search_form2_id);
	var search_stat2 = $search_form2.validate({
		// Do not change code below
		errorPlacement: function(error, element) {
			error.addClass('error');
			error.insertAfter(element.parent());
		}
	});

	$search_form2.submit(function() {
		if (search_stat2.checkForm()) {
			ajax_object.reset_object();
			ajax_object.set_plugin_datatable(true)
				.set_loading('#preloadAnimation')
				.set_content('#data-view')
				.disable_pnotify()
				.set_form($search_form2)
				.submit_ajax('');
			return false;
		}
	});
</script>