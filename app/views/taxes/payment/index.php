<section class="portfolio-showcase-block min-height-maincontent" style="margin-top:50px!important">
	<div class="box">
		<div class="row">
			<div class="col-md-6">
				<h5>
					<i class="fa fa-money"></i> Rekam Setoran Pajak
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#">Pembayaran</a></li>
					<li>Rekam Setoran Pajak</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#tab1" aria-controls="main" role="tab" data-toggle="tab">Transaksi</a></li>
						<!-- <li role="presentation"><a href="#tab2" aria-controls="main" role="tab" data-toggle="tab">Daftar Transaksi</a></li> -->
						<li role="presentation"><a href="#tab3" aria-controls="main" role="tab" data-toggle="tab">Pelunasan Teller</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="tab1">
							<form class="form-horizontal" id="search_form1" action="<?= base_url() ?>payment/load_billing_list" method="POST">
								<fieldset>
									<div class="form-group">
										<div class="col-md-3">&nbsp;</div>
										<div class="col-md-3">
											<div class="input-group">
												<input class="form-control" type="text" name="input-tgl_setor" id="input-tgl_setor" style="font-style:bold;font-size:1.5em" placeholder="Tanggal Penyetoran" required />
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">&nbsp;</div>
										<div class="col-md-6">
											<div class="input-group">
												<input class="form-control number" type="text" name="input-kode_billing" id="input-kode_billing" style="font-style:bold;font-size:1.5em" placeholder="Masukkan Kode Billing" required />
												<div class="input-group-btn">
													<button class="btn btn-default btn-primary" type="submit">
														<i class="fa fa-search"></i> Search
													</button>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
							</form>
							<div id="loader-billing_data" style="display:none;" align="center">
								<img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
							</div>
							<div id="content-billing_data">
							</div>
						</div>
						<!-- <div role="tabpanel" class="tab-pane" id="tab2">
							<form class="form-horizontal" id="search_form2" action="<?= base_url() . "bundle/taxes/" . $bundle_item_type . $menu . "/load_list"; ?>" method="POST">
								<fieldset>
									<div class="form-group">
										<label class="control-label col-md-2" for="src-pajak_id">Jenis Pajak</label>
										<div class="col-md-6">
											<div class="input state-disabled">
												<select class="form-control" name="src-pajak_id" id="src-pajak_id" required>
													<option value="" selected>- Semua Jenis Pajak -</option>
													<?php
													foreach ($bundle_rows as $row) {
														echo "<option value='" . $row['bundel_id'] . "'>" . $row['nama_paret'] . "</option>";
													}
													?>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-2">Tgl. Pembayaran</label>
										<div class="col-md-2">
											<div class="input">
												<input type="text" class="form-control" name="src-tgl_bayar_awal" id="src-tgl_bayar_awal" placeholder="Awal" />
											</div>
										</div>
										<div class="col-md-2">
											<div class="input">
												<input type="text" class="form-control" name="src-tgl_bayar_akhir" id="src-tgl_bayar_akhir" placeholder="Akhir" />
											</div>
										</div>
									</div>

								</fieldset>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-10 col-md-offset-2">
											<button class="btn btn-primary" type="submit">
												<i class="fa fa-search"></i>
												Cari
											</button>
										</div>
									</div>
								</div>
							</form>
						</div> -->
						<div role="tabpanel" class="tab-pane" id="tab3">
							<form class="form-horizontal" id="search_form3" action="<?= base_url() ?>payment/load_billing_list_teller" method="POST">
								<fieldset>
									<div class="form-group">
										<div class="col-md-3">&nbsp;</div>
										<div class="col-md-3">
											<div class="input-group">
												<input class="form-control" type="text" name="input-tgl_setor_teller" id="input-tgl_setor_teller" style="font-style:bold;font-size:1.5em" placeholder="Tanggal Penyetoran" required />
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">&nbsp;</div>
										<div class="col-md-6">
											<div class="input-group">
												<input class="form-control number" type="text" name="input-kode_billing_teller" id="input-kode_billing_teller" style="font-style:bold;font-size:1.5em" placeholder="Masukkan Kode Billing" required />
												<div class="input-group-btn">
													<button class="btn btn-default btn-primary" type="submit">
														<i class="fa fa-search"></i> Search
													</button>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
							</form>
							<div id="loader-billing_data2" style="display:none;" align="center">
								<img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
							</div>
							<div id="content-billing_data2">
							</div>
						</div>
					</div>

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
			<div class="modal-dialog modal-lg" style="width:1200px!important;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="defModalHead">Form WP Pribadi</h4>
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
	base_url = $('#base_url').val();

	$(document).ready(function() {

		$("#input-tgl_setor,#input-tgl_setor_teller,#src-tgl_bayar_awal,#src-tgl_bayar_akhir").mask('99-99-9999');

		// START AND FINISH DATE
		$("#input-tgl_setor,#input-tgl_setor_teller,#src-tgl_bayar_awal,#src-tgl_bayar_akhir").datepicker({
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


	var search_form1_id = 'search_form1';
	var search_form2_id = 'search_form2';
	var search_form3_id = 'search_form3';
	var $search_form1 = $('#' + search_form1_id);
	var $search_form2 = $('#' + search_form2_id);
	var $search_form3 = $('#' + search_form3_id);
	var search_stat1 = $search_form1.validate({
		// Do not change code below
		errorPlacement: function(error, element) {
			error.addClass('error');
			error.insertAfter(element.parent());
		}
	});

	var search_stat2 = $search_form1.validate({
		// Do not change code below
		errorPlacement: function(error, element) {
			error.addClass('error');
			error.insertAfter(element.parent());
		}
	});

	var search_stat3 = $search_form1.validate({
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
				.set_content('#content-billing_data')
				.set_loading('#loader-billing_data')
				.disable_pnotify()
				.set_form($search_form1)
				.submit_ajax('');
			return false;
		}
	});

	$search_form2.submit(function() {
		if (search_stat1.checkForm()) {
			ajax_object.reset_object();
			ajax_object.set_plugin_datatable(true)
				.set_content('#list-data')
				.set_loading('#loader-list-data')
				.disable_pnotify()
				.set_form($search_form2)
				.submit_ajax('');
			return false;
		}
	});

	$search_form3.submit(function() {
		if (search_stat1.checkForm()) {
			ajax_object.reset_object();
			ajax_object.set_plugin_datatable(true)
				.set_content('#content-billing_data2')
				.set_loading('#loader-billing_data2')
				.disable_pnotify()
				.set_form($search_form3)
				.submit_ajax('');
			return false;
		}
	});
</script>