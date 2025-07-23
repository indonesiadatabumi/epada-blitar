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
					<i class="fa fa-print"></i> Cetak Daftar Surat Ketetapan
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Penetapan</a></li>
					<li>Cetak Daftar Surat Ketetapan</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" id="search_form" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/report_controller"; ?>" method="POST">
						<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
						<input type="hidden" name="report_type" id="report_type" />
						<fieldset>

							<div class="form-group">
								<label class="control-label col-md-2">Jenis Ketetapan <font color="red">*</font></label>
								<div class="col-md-4">
									<div class="input state-disabled">
										<select class="form-control" name="src-jenis_spt_id" onchange="control_kohir_numb(this.value)" id="src-jenis_spt_id" required>
											<option value="" selected></option>
											<?php
											foreach ($spt_type_rows as $row) {
												echo "<option value='" . $row['ref_jenspt_id'] . "'>" . $row['keterangan'] . " (" . $row['singkatan'] . ")</option>";
											}
											?>
										</select>
									</div>
									<div class="note">Pilih Jenis Ketetapan lebih dulu sebelum mengisi Nomor Kohir</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Tgl. Penetapan</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src-tgl_penetapan_awal" id="src-tgl_penetapan_awal" placeholder="Awal" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src-tgl_penetapan_akhir" id="src-tgl_penetapan_akhir" placeholder="Akhir" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2" for="src-kecamatan_id">Kecamatan</label>
								<div class="col-md-4">
									<div class="input state-disabled">
										<select class="form-control" name="src-kecamatan_id" id="src-kecamatan_id" onchange="get_villages(this.value,'src-kelurahan_id','loader_src_kelurahan')">
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

							<hr>
							</hr>

							<div class="form-group">
								<div class="control-label col-md-2"></div>
								<div class="col-md-4">
									<input type="checkbox" name="printAttr-show_signature" value="1" checked /> Sertakan kolom tanda tangan
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
									<button class="btn btn-danger" type="submit" onclick="fill_report_type('2')"><i class="fa fa-file-pdf-o"></i> PDF</button>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>

		<!-- MODAL -->
		<div class="modal fade" id="formModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="defModalHead">Daftar Dokumen Ketetapan</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div id="loader-determinationList" class="" align="center"><img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" /></div>
							<div class="col-md-12 col-sm-12 col-xs-12" id="content-determinationList">
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
		$("#src-tgl_penetapan_awal,#src-tgl_penetapan_akhir,#printAttr-print_date").mask('99-99-9999');

		// START AND FINISH DATE
		$("#src-tgl_penetapan_awal,#src-tgl_penetapan_akhir,#printAttr-print_date").datepicker({
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

	function control_kohir_numb(val) {

		$('#src-kohir_awal').attr('disabled', (val == ''));
		$('#src-kohir_akhir').attr('disabled', (val == ''));
		$('#btn-kohir_awal').attr('disabled', (val == ''));
		$('#btn-kohir_akhir').attr('disabled', (val == ''));

		$('#src-kohir_awal').attr('required', (val != ''));
		$('#src-kohir_akhir').attr('required', (val != ''));

	}

	function load_determination_list(input_id, spt_type) {
		ajax_object.reset_object();

		data_ajax = ["input_id=" + input_id, "jenis_spt_id=" + spt_type];

		ajax_object.set_plugin_datatable(true)
			.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/determination_list')
			.set_loading('#loader-determinationList')
			.set_content('#content-determinationList')
			.set_data_ajax(data_ajax)
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
			ajax_object.set_plugin_datatable(false)
				.set_loading('#preloadAnimation')
				.set_content('#data-view')
				.disable_pnotify()
				.set_form($search_form)
				.submit_ajax('');
			return false;
		}
	});
</script>