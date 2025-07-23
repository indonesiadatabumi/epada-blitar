<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
<input type="hidden" id="bundle_item_type" value="<?= $bundle_item_type; ?>" />

<?php
echo $banner_info;
echo $navbar;
?>

<section class="portfolio-showcase-block min-height-maincontent">
	<div class="box">
		<div class="row">
			<div class="col-md-6">
				<h5>
					<i class="fa fa-print"></i> Cetak Surat Teguran
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Penagihan</a></li>
					<li>Cetak Surat Teguran</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" id="search_form" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/report_controller"; ?>" method="POST">
						<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
						<input type="hidden" name="pajak_id" id="pajak_id" value="<?= $bundle_id; ?>" />
						<input type="hidden" name="report_type" id="report_type" />
						<fieldset>
							<div class="form-group">
								<label class="control-label col-md-2">Periode SPT</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src-tahun_pajak" id="src1-tahun_pajak" value="<?= date('Y'); ?>" maxlength="4" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">N.P.W.P.D</label>
								<div class="col-md-4">
									<div class="input">
										<div class="input-group">
											<input class="form-control" type="text" name="src-npwprd" id="src-npwprd" readonly required />
											<div class="input-group-btn">
												<button class="btn btn-default btn-primary" type="button" data-toggle="modal" data-target="#formModal" onclick="load_taxobject_list()">...</button>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Pajak / Kegiatan Usaha</label>
								<div class="col-md-5">
									<div class="input">
										<input class="form-control" id="src-jenis_pajak" readonly />
										<input type="hidden" name="src-wp_wr_detil_id" id="src-wp_wr_detil_id" />
									</div>
								</div>
							</div>

							<hr>
							</hr>

							<div class="form-group">
								<label class="control-label col-md-2">Tgl. Cetak</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src-tgl_cetak" value="<?= date('d-m-Y'); ?>" id="src-tgl_cetak">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Mengetahui</label>
								<div class="col-md-6">
									<select class="form-control" name="printAttr-legalitator" id="printAttr-legalitator">
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
									<select class="form-control" name="printAttr-evaluator" id="printAttr-evaluator">
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
									<button class="btn btn-primary" type="submit" onclick="fill_report_type('1','1')"><i class="fa fa-print"></i> Cetak Teguran Laporan</button>
									<button class="btn btn-primary" type="submit" onclick="fill_report_type('2','1')"><i class="fa fa-print"></i> Cetak Teguran Bayar</button>
									<!-- <button class="btn btn-danger" type="submit" onclick="fill_report_type('2','1')"><i class="fa fa-file-pdf-o"></i> PDF</button> -->
									<!-- <a href="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/list_teguran"; ?>" class="btn btn-primary">Daftar Penerima Teguran</a> -->
									<button class="btn btn-default" type="button" onclick="show_all_data();"><i class="fa fa-list-alt"></i> Daftar Penerima Teguran</button>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>

		<div id="loader-list-data" style="display:none;" align="center">
			<img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
		</div>


		<!-- LIST DATA CONTENT -->
		<div id="list-data">
		</div>
		<!-- END OF LIST DATA CONTENT -->

		<!-- MODAL -->
		<div class="modal fade" id="formModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="defModalHead">Daftar Objek Pajak <?= $bundle_row['nama_paret']; ?></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div id="loader-taxobjectList" class="" align="center"><img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" /></div>
							<div class="col-md-12 col-sm-12 col-xs-12" id="content-taxobjectList">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END OF MODAL -->

		<div id="data-view"></div>

	</div>
</section>

<script src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#printAttr-print_date,#src-tgl_cetak").mask('99-99-9999');

		// START AND FINISH DATE
		$("#printAttr-print_date,#src-tgl_cetak").datepicker({
			dateFormat: 'dd-mm-yy',
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>'
		});
	});

	base_url = $('#base_url').val();
	bundle_item_type = $('#bundle_item_type').val();
	menu = $('#menu').val();

	function fill_report_type(rpt_type) {
		$('#report_type').val(rpt_type);
	}

	function load_taxobject_list(id) {
		ajax_object.reset_object();

		ajax_object.set_plugin_datatable(true)
			.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/taxobject_list')
			.set_loading('#loader-taxobjectList')
			.set_content('#content-taxobjectList')
			.request_ajax();
	}

	function show_all_data() {
		ajax_object.reset_object();
		data_ajax = ['menu=' + $('#menu').val(), 'pajak_id=' + $('#pajak_id').val()];
		ajax_object.set_plugin_datatable(true)
			.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/list_teguran')
			.set_loading('#loader-list-data')
			.set_content('#list-data')
			.set_data_ajax(data_ajax)
			.request_ajax();

		$('#showed').val('1');
	}

	var search_form_id = 'search_form';
	var $search_form = $('#' + search_form_id);
	var search_stat = $search_form.validate({
		// Do not change code below
		errorPlacement: function(error, element) {
			error.addClass('error');
			error.insertAfter(element.parent());
		}
	});

	$search_form.submit(function() {
		if (search_stat.checkForm()) {
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