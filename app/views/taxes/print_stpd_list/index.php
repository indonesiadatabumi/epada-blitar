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
					<i class="fa fa-print"></i> Cetak Daftar STPD
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Pendataan</a></li>
					<li>Cetak Daftar STPD</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">

					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div id="collapse1" class="panel-collapse collapse in">
								<div class="panel-body">

									<form class="form-horizontal" id="search_form1" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/report_controller"; ?>" method="POST">
										<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
										<input type="hidden" name="search_type" value="1" />
										<input type="hidden" name="report_type" id="report_type1" />
										<fieldset>
											<div class="form-group">
												<label class="control-label col-md-2">Jenis Pajak</label>
												<div class="col-md-4">
													<div class="input">
														<input type="text" class="form-control" name="jenis_pajak" id="jenis_pajak" value="<?= $bundle_row['nama_paret']; ?>" readonly />
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-2">Kecamatan</label>
												<div class="col-md-4">
													<div class="input state-disabled">
														<select class="form-control" name="src1-kecamatan_id" id="src1-kecamatan_id">
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
												<label class="control-label col-md-2">Masa Pajak</label>
												<div class="col-md-2">
													<div class="input state-disabled">
														<select class="form-control" name="src1-masa_pajak" id="src1-masa_pajak">
															<?php
															for ($i = 1; $i <= 12; $i++) {
																echo "<option value='" . $i . "'>" . get_monthName($i) . "</option>";
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-md-1">
													<div class="input">
														<input type="text" class="form-control" name="src1-tahun_pajak" id="src1-tahun_pajak" value="<?= date('Y'); ?>" maxlength="4" />
													</div>
												</div>
											</div>

											<hr>
											</hr>

											<div class="form-group">
												<label class="control-label col-md-2">Tgl. Cetak</label>
												<div class="col-md-2">
													<div class="input">
														<input type="text" class="form-control" name="printAttr1-print_date" value="<?= date('d-m-Y'); ?>" id="printAttr1-print_date">
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-2">Mengetahui</label>
												<div class="col-md-6">
													<select class="form-control" name="printAttr1-legalitator" id="printAttr1-legalitator">
														<option value="" selected></option>
														<?php
														foreach ($official_rows as $row) {
															echo "<option value='" . $row['pejda_id'] . "'>" . $row['nama'] . " / " . $row['nama_jabatan'] . "</option>";
														}
														?>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-2">Diperiksa Oleh</label>
												<div class="col-md-6">
													<select class="form-control" name="printAttr1-evaluator" id="printAttr1-evaluator">
														<option value="" selected></option>
														<?php
														foreach ($official_rows as $row) {
															echo "<option value='" . $row['pejda_id'] . "'>" . $row['nama'] . " / " . $row['nama_jabatan'] . "</option>";
														}
														?>
													</select>
												</div>
											</div>

										</fieldset>
										<div class="form-actions">
											<div class="row">
												<div class="col-md-10 col-md-offset-2">
													<button class="btn btn-primary" type="submit" onclick="fill_report_type('1','1')"><i class="fa fa-print"></i> Cetak</button>
													<!-- <button class="btn btn-danger" type="submit" onclick="fill_report_type('2','1')"><i class="fa fa-file-pdf-o"></i> PDF</button>
													<button class="btn btn-success" type="submit" onclick="fill_report_type('3','1')"><i class="fa fa-file-excel-o"></i> Excel</button> -->
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div id="collapse2" class="panel-collapse collapse">
								<div class="panel-body">
									<form class="form-horizontal" id="search_form2" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/report_controller"; ?>" method="POST">
										<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
										<input type="hidden" name="search_type" value="2" />
										<input type="hidden" name="report_type" id="report_type2" />
										<fieldset>
											<div class="form-group">
												<label class="control-label col-md-2">Jenis Pajak</label>
												<div class="col-md-4">
													<div class="input">
														<input type="text" class="form-control" name="jenis_pajak" id="jenis_pajak" value="<?= $bundle_row['nama_paret']; ?>" readonly />
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
												<label class="control-label col-md-2">Tgl. Pendataan</label>
												<div class="col-md-2">
													<div class="input">
														<input type="text" class="form-control" name="src2-tgl_proses_awal" id="src2-tgl_proses_awal" value="" placeholder="Awal" />
													</div>
												</div>
												<div class="col-md-2">
													<div class="input">
														<input type="text" class="form-control" name="src2-tgl_proses_akhir" id="src2-tgl_proses_akhir" value="" placeholder="Akhir" />
													</div>
												</div>
											</div>

											<hr>
											</hr>

											<div class="form-group">
												<label class="control-label col-md-2">Tgl. Cetak</label>
												<div class="col-md-2">
													<div class="input">
														<input type="text" class="form-control" name="printAttr2-print_date" value="<?= date('d-m-Y'); ?>" id="printAttr2-print_date">
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-2">Mengetahui</label>
												<div class="col-md-6">
													<select class="form-control" name="printAttr2-legalitator" id="printAttr2-legalitator">
														<option value="" selected></option>
														<?php
														foreach ($official_rows as $row) {
															echo "<option value='" . $row['pejda_id'] . "'>" . $row['nama'] . " / " . $row['nama_jabatan'] . "</option>";
														}
														?>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-2">Diperiksa Oleh</label>
												<div class="col-md-6">
													<select class="form-control" name="printAttr2-evaluator" id="printAttr2-evaluator">
														<option value="" selected></option>
														<?php
														foreach ($official_rows as $row) {
															echo "<option value='" . $row['pejda_id'] . "'>" . $row['nama'] . " / " . $row['nama_jabatan'] . "</option>";
														}
														?>
													</select>
												</div>
											</div>

										</fieldset>
										<div class="form-actions">
											<div class="row">
												<div class="col-md-10 col-md-offset-2">
													<button class="btn btn-primary" type="submit" onclick="fill_report_type('1','2')"><i class="fa fa-print"></i> Cetak</button>
													<button class="btn btn-danger" type="submit" onclick="fill_report_type('2','2')"><i class="fa fa-file-pdf-o"></i> PDF</button>
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
	$(document).ready(function() {
		$("#src2-tgl_proses_awal,#src2-tgl_proses_akhir,#printAttr-print_date").mask('99-99-9999');

		// START AND FINISH DATE
		$("#src2-tgl_proses_awal,#src2-tgl_proses_akhir,#printAttr-print_date").datepicker({
			dateFormat: 'dd-mm-yy',
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>'
		});
	});

	base_url = $('#base_url').val();


	function fill_report_type(rpt_type, src_type) {
		$('#report_type' + src_type).val(rpt_type);
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