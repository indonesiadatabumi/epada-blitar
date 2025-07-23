<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
<input type="hidden" id="bundle_item_type" value="<?= $bundle_item_type; ?>" />
<input type="hidden" id="menu" value="<?= $menu; ?>" />

<?php
echo $banner_info;
echo $navbar;
?>

<section class="portfolio-showcase-block min-height-maincontent">
	<div class="box">
		<div class="row">
			<div class="col-md-6">
				<h5>
					<i class="fa fa-money"></i> Rekam Setoran Pajak
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
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
						<li role="presentation"><a href="#tab2" aria-controls="main" role="tab" data-toggle="tab">Daftar Transaksi</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="tab1">
							<form class="form-horizontal" id="search_form1" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/load_billing_list"; ?>" method="POST">
								<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
								<fieldset>
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
						<div role="tabpanel" class="tab-pane" id="tab2">
							<form class="form-horizontal" id="search_form1" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/load_list"; ?>" method="POST">
								<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
								<input type="hidden" name="src-a#pajak_id" id="bundle_id" value="<?= $bundle_id; ?>" />
								<fieldset>
									<div class="form-group">
										<label class="control-label col-md-2" for="src-kecamatan_id">Kecamatan</label>
										<div class="col-md-6">
											<div class="input state-disabled">
												<select class="form-control" name="src-kecamatan_id" id="src-kecamatan_id" onchange="get_villages(this.value,'src-kelurahan_id','loader_src_kelurahan')" required>
													<option value="" selected>- Semua Kecamatan -</option>
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
										<label class="control-label col-md-2" for="src-kelurahan_id">Kelurahan</label>
										<div class="col-md-6">
											<div class="input state-disabled">
												<div id="loader_src_kelurahan" style="display:none">
													<img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
												</div>
												<select class="form-control" name="src-kelurahan_id" id="src-kelurahan_id">
													<option value="" selected></option>
												</select>
											</div>
										</div>
									</div>
								</fieldset>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-10 col-md-offset-2">
											<button class="btn btn-primary" type="submit">
												<i class="fa fa-filter"></i>
												Eksekusi Filter
											</button>
											<button class="btn btn-default" type="button" onclick="show_all_data();"><i class="fa fa-list-alt"></i> Tampilkan Semua</button>
											<?php
											if ($add_priv == '0') {
												echo "<button class='btn btn-default' type='button' onclick=\"alert('Anda tidak memiliki akses untuk menambah data!')\">";
											} else {
												echo "<button class='btn btn-default' type='button' id='btn-add1' data-toggle='modal' data-target='#formModal' onclick=\"load_form_content(this.id)\">";
											}
											echo "
											<input type='hidden' id='ajax-req-dt' name='act' value='add'/>
											<input type='hidden' id='ajax-req-dt' name='menu' value='" . $menu . "'/>

											<i class='fa fa-plus'></i> Tambah</button>";
											?>
										</div>
									</div>
								</div>
							</form>
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

<script type="text/javascript" src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.inputmask.bundle.min.js"></script>

<script type="text/javascript">
	base_url = $('#base_url').val();
	bundle_item_type = $('#bundle_item_type').val();
	menu = $('#menu').val();
	access_privileges = $('#access_privileges').val();

	$(document).ready(function() {
		$(".number").inputmask({
			'alias': 'numeric',
			'mask': '9999999999999999',
			rightAlign: false
		});

	});

	function get_villages(district_val, content_id, loader_id, type = '1', selected = '') {
		ajax_object.reset_object();
		var data_ajax = new Array('district=' + district_val, 'type=' + type, 'selected=' + selected);
		ajax_object.set_url(base_url + 'glob/get_villages').set_data_ajax(data_ajax).set_loading('#' + loader_id).set_content('#' + content_id).request_ajax();
	}

	function show_all_data() {
		ajax_object.reset_object();
		data_ajax = ['menu=' + $('#menu').val(), 'src-a#pajak_id=' + $('#bundle_id').val()];
		ajax_object.set_plugin_datatable(true)
			.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/load_list')
			.set_loading('#loader-list-data')
			.set_content('#list-data')
			.set_data_ajax(data_ajax)
			.request_ajax();

		$('#showed').val('1');
	}


	var search_form1_id = 'search_form1';
	var search_form2_id = 'search_form2';
	var $search_form1 = $('#' + search_form1_id);
	var $search_form2 = $('#' + search_form2_id);
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
</script>