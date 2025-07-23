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
					<i class="fa fa-print"></i> Cetak Buku Wajib Pajak
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Pembukuan</a></li>
					<li><a href="#">Pembukuan Penerimaan</a></li>
					<li>Cetak Buku Wajib Pajak</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" id="search_form" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/report_controller"; ?>" method="POST">
						<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
						<input type='hidden' name='report_type' id='report_type' />
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
								<label class="control-label col-md-2" for="src-kecamatan_id">Nomor Wajib Pajak</label>
								<div class="col-md-4">
									<div class="input-group">
										<input class="form-control" type="text" name="src-npwpd" id="src-npwpd" placeholder="NPWPD" required />
										<input type='hidden' name='src-wp_wr_detil' id='src-wp_wr_detil' />
										<div class="input-group-btn">
											<button class="btn btn-default btn-primary" type="button" data-toggle="modal" data-target="#formModal" onclick="load_taxpayer_list('src-npwpd', 'src-wp_wr_detil')">
												Browse
											</button>
										</div>
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
									<button class="btn btn-primary" type="submit" onclick="fill_report_type('1')"><i class="fa fa-print"></i> Cetak</button>
									<!-- <button class="btn btn-danger" type="submit" onclick="fill_report_type('2')"><i class="fa fa-file-pdf-o"></i> PDF</button> -->
									<button class="btn btn-success" type="submit" onclick="fill_report_type('3')"><i class="fa fa-file-excel-o"></i> Excel</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="data-view"></div>

		<!-- MODAL -->
		<div class="modal fade" id="formModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="defModalHead">Daftar Wajib Pajak</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div id="loader-formModal" class="" align="center"><img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" /></div>
							<div class="col-md-12 col-sm-12 col-xs-12" id="content-formModal">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END OF MODAL -->

	</div>
</section>

<script src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#src-tgl_bayar_awal,#src-tgl_bayar_akhir,#printAttr-print_date").mask('99-99-9999');

		// START AND FINISH DATE
		$("#src-tgl_bayar_awal,#src-tgl_bayar_akhir,#printAttr-print_date").datepicker({
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

	function fill_report_type(type) {
		$('#report_type').val(type);
	}

	function load_taxpayer_list(input_element, wp_wr_detil) {
		ajax_object.reset_object();
		data_ajax = ['menu=' + $('#menu').val(), 'tax_id=' + tax_id, 'input_element=' + input_element, 'wp_wr_detil=' + wp_wr_detil];
		ajax_object.set_url(base_url + 'glob/get_taxpayers')
			.set_plugin_datatable(true)
			.set_loading('#loader-formModal')
			.set_data_ajax(data_ajax)
			.set_content('#content-formModal')
			.request_ajax();

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