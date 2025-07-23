<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
<input type="hidden" id="bundle_item_type" value="<?= $bundle_item_type; ?>" />
<input type="hidden" id="menu" value="<?= $menu; ?>" />
<input type="hidden" id="showed" value="0" />
<?php
echo $banner_info;
echo $navbar;
?>

<section class="portfolio-showcase-block min-height-maincontent">
	<div class="box">
		<div class="row">
			<div class="col-md-6">
				<h5>
					<i class="fa fa-pencil-square-o"></i> Rekam Surat Paksa
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Penagihan</a></li>
					<li>Rekam Surat Paksa</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" id="search_form" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/load_list"; ?>" method="POST">
						<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
						<input type="hidden" name="src-a#pajak_id" id="bundle_id" value="<?= $bundle_id; ?>" />
						<fieldset>

							<!-- <div class="form-group">
								<label class="control-label col-md-2">Periode</label>
								<div class="col-md-2">
									<div class="input state-disabled">
										<select class="form-control" name="src-tahun_pajak" id="src-tahun_pajak">
											<option value="" selected></option>
											<?php
											$curr_year = date('Y');
											for ($i = $curr_year; $i >= $curr_year - 5; $i--) {
												$selected = ($i == $curr_year ? 'selected' : '');
												echo "<option value='" . $i . "' " . $selected . ">" . $i . "</option>";
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Kecamatan</label>
								<div class="col-md-6">
									<div class="input state-disabled">
										<select class="form-control" name="src-b#kecamatan_id" id="src-kecamatan_id" onchange="get_villages(this.value,'src-kelurahan_id','loader_src_kelurahan')">
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
								<label class="control-label col-md-2">Kelurahan</label>
								<div class="col-md-6">
									<div class="input state-disabled">
										<div id="loader_src_kelurahan" style="display:none">
											<img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
										</div>
										<select class="form-control" name="src-b#kelurahan_id" id="src-kelurahan_id">
											<option value="" selected></option>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Tgl. Pemeriksaan</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src_date_range-tgl_pemeriksaan-start" id="src-tgl_pemeriksaan_awal" placeholder="Awal" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src_date_range-tgl_pemeriksaan-end" id="src-tgl_pemeriksaan_akhir" placeholder="Akhir" />
									</div>
								</div>
							</div> -->


						</fieldset>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-10 col-md-offset-2">
									<!-- <button class="btn btn-primary" type="submit">
										<i class="fa fa-filter"></i>
										Eksekusi Filter
									</button> -->
									<button class="btn btn-default" type="button" onclick="show_all_data();"><i class="fa fa-list-alt"></i> Tampilkan Semua</button>
									<?php
									if ($add_priv == '0') {
										echo "<button class='btn btn-default' type='button' onclick=\"alert('Anda tidak memiliki akses untuk menambah data!')\">";
									} else {
										echo "<button class='btn btn-default' type='button' id='btn-add1' data-toggle='modal' data-target='#formModal' onclick=\"load_taxpayer_search_panel(this.id)\">";
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
						<h4 class="modal-title" id="defModalHead">Form Rekam Surat Paksa</h4>
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
	$(document).ready(function() {
		$("#src-tgl_pemeriksaan_awal,#src-tgl_pemeriksaan_akhir").mask('99-99-9999');

		// START AND FINISH DATE
		$("#src-tgl_pemeriksaan_awal,#src-tgl_pemeriksaan_akhir").datepicker({
			dateFormat: 'dd-mm-yy',
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>'
		});
	});

	base_url = $('#base_url').val();
	bundle_item_type = $('#bundle_item_type').val();
	menu = $('#menu').val();
	access_privileges = $('#access_privileges').val();

	function get_villages(district_val, content_id, loader_id, type = '1', selected = '') {
		ajax_object.reset_object();
		var data_ajax = new Array('district=' + district_val, 'type=' + type, 'selected=' + selected);
		ajax_object.set_url(base_url + 'glob/get_villages').set_data_ajax(data_ajax).set_loading('#' + loader_id).set_content('#' + content_id).request_ajax();
	}

	function show_all_data() {
		ajax_object.reset_object();
		data_ajax = ['menu=' + $('#menu').val(), 'src-a#srt_paksa_jenis_pajak=' + $('#bundle_id').val()];
		ajax_object.set_plugin_datatable(true)
			.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/load_list')
			.set_loading('#loader-list-data')
			.set_content('#list-data')
			.set_data_ajax(data_ajax)
			.request_ajax();

		$('#showed').val('1');
	}

	function load_taxpayer_search_panel(id) {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		if (showed == '2') {
			data_ajax.push("src-tahun_pajak=" + $('#src-tahun_pajak').val());
			data_ajax.push("src-jenis_spt_id=" + $('#src-jenis_spt_id').val());
			data_ajax.push("src-b#kecamatan_id=" + $('#src-kecamatan_id').val());
			data_ajax.push("src-b#kelurahan_id=" + $('#src-kelurahan_id').val());
			data_ajax.push("src_date_range-tgl_pemeriksaan-start=" + $('#src-tgl_pemeriksaan_awal').val());
			data_ajax.push("src_date_range-tgl_pemeriksaan-end=" + $('#src-tgl_pemeriksaan_akhir').val());
		}

		ajax_object.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/load_taxpayer_list')
			.set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			.set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();

	}

	function load_form_content(id) {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		if (showed == '2') {
			data_ajax.push("src-tahun_pajak=" + $('#src_params-tahun_pajak').val());
			data_ajax.push("src-jenis_spt_id=" + $('#src_params-jenis_spt_id').val());
			data_ajax.push("src-b#kecamatan_id=" + $('#src_params-kecamatan_id').val());
			data_ajax.push("src-b#kelurahan_id=" + $('#src_params-kelurahan_id').val());
			data_ajax.push("src_date_range-tgl_pemeriksaan-start=" + $('#src_params-tgl_pemeriksaan_awal').val());
			data_ajax.push("src_date_range-tgl_pemeriksaan-end=" + $('#src_params-tgl_pemeriksaan_akhir').val());
		}

		ajax_object.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/form')
			.set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			.set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();

	}

	function delete_record(id) {
		ajax_object.reset_object();


		data_ajax = ['src-tahun_pajak=' + $('#src_params-tahun_pajak').val(),
			'src-jenis_spt_id=' + $('#src_params-jenis_spt_id').val(),
			'src-b#kecamatan_id=' + $('#src_params-kecamatan_id').val(),
			'src-b#kelurahan_id=' + $('#src_params-kelurahan_id').val(),
			"src_date_range-tgl_pemeriksaan-start=" + $('#src_params-tgl_pemeriksaan_awal').val(),
			"src_date_range-tgl_pemeriksaan-end=" + $('#src_params-tgl_pemeriksaan_akhir').val()
		];


		ajax_object.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/delete_record')
			.set_plugin_datatable(true)
			.set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			.set_data_ajax(data_ajax)
			.set_loading('#preloadAnimation').set_content('#list-data').update_ajax('menghapus data');
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
				.set_content('#list-data')
				.set_loading('#loader-list-data')
				.disable_pnotify()
				.set_form($search_form)
				.submit_ajax('');
			$('#showed').val('2');
			return false;
		}
	});
</script>