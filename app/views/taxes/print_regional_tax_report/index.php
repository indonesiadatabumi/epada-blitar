<input type="hidden" id="bundle_item_type" value="<?= $bundle_item_type; ?>" />
<input type="hidden" id="menu" value="<?= $menu; ?>" />
<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
<input type="hidden" id="tax_id" value="<?= $bundle_id; ?>" />
<?php
echo $banner_info;
echo $navbar;
?>

<section class="portfolio-showcase-block min-height-maincontent">
	<div class="box">
		<div class="row">
			<div class="col-md-6">
				<h5>
					<i class="fa fa-print"></i> Cetak Laporan Pajak Daerah
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Pembukuan</a></li>
					<li><a href="#">Pembukuan Pelaporan</a></li>
					<li>Cetak Laporan Pajak Daerah</li>
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
										Mingguan
									</a>
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
												<label class="control-label col-md-2">Tahun Pajak</label>
												<div class="col-md-2">
													<div class="input">
														<input type="text" class="form-control number" name="src-tahun_pajak" id="src-tahun_pajak" value="<?= date('Y'); ?>" maxlength="4" />
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-2">Tgl. Proses</label>
												<div class="col-md-2">
													<div class="input">
														<input type="text" class="form-control" name="src-tgl_proses" value="<?= date('d-m-Y'); ?>" id="src-tgl_proses">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-2">Tgl. Cetak</label>
												<div class="col-md-2">
													<div class="input">
														<input type="text" class="form-control" name="printAttr-print_date" value="<?= date('d-m-Y'); ?>" id="printAttr-print_date">
													</div>
												</div>
											</div>
										</fieldset>
										<div class="form-actions">
											<div class="row">
												<div class="col-md-10 col-md-offset-2">
													<button class="btn btn-primary" type="submit" onclick="fill_report_type('1','1')"><i class="fa fa-print"></i> Cetak</button>
													<button class="btn btn-danger" type="submit" onclick="fill_report_type('2','1')"><i class="fa fa-file-pdf-o"></i> PDF</button>
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
										Bulanan
									</a>
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
												<label class="control-label col-md-2">Tahun Pajak</label>
												<div class="col-md-2">
													<div class="input">
														<input type="text" class="form-control number" name="src-tahun_pajak" id="src-tahun_pajak" value="<?= date('Y'); ?>" maxlength="4" />
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-2">Bulan Pajak</label>
												<div class="col-md-2">
													<div class="input">
														<!-- <input type="text" class="form-control" name="src-bulan_proses" value="<?= date('d-m-Y'); ?>" id="src-tgl_proses"> -->
														<select class="form-control" name="src-tgl_proses">
															<?php
															for ($i = 1; $i <= 12; $i++) {
																$selected = ($i == date('m') ? 'selected' : '');
																echo "<option value='" . $i . "' " . $selected . ">" . get_monthName($i) . "</option>";
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-2">Tgl. Cetak</label>
												<div class="col-md-2">
													<div class="input">
														<input type="text" class="form-control" name="printAttr-print_date" value="<?= date('d-m-Y'); ?>" id="printAttr-print_date">
													</div>
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
		$("#src-tgl_proses,#printAttr-print_date").mask('99-99-9999');

		// START AND FINISH DATE
		$("#src-tgl_proses,#printAttr-print_date").datepicker({
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

	base_url = $('#base_url').val();
	bundle_item_type = $('#bundle_item_type').val();
	tax_id = $('#tax_id').val();
	menu = $('#menu').val();

	function fill_report_type(rpt_type, src_type) {
		$('#report_type' + src_type).val(rpt_type);
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