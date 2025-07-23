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
					<i class="fa fa-print"></i> Cetak Surat Tanda Setoran (STS)
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Pembayaran</a></li>
					<li>Cetak Surat Tanda Setoran (STS)</li>
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
							<div class="form-group">
								<label class="control-label col-md-2">Periode SPT</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control number" name="src-a#tahun_pajak" id="src-tahun_pajak" value="<?= date('Y'); ?>" maxlength="4" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Kegiatan Usaha</label>
								<div class="col-md-2">
									<div class="input state-disabled">
										<select class="form-control" name="src-b#kegus_id" id="src-kegus_id">
											<option value="" selected></option>
											<?php
											foreach ($kegus as $row) {
												echo "<option value='" . $row['ref_kegus_id'] . "'>" . $row['nama_kegus'] . "</option>";
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
										<input type="text" class="form-control" name="src_date_range-a#tgl_bayar-start" id="src-tgl_bayar_awal" placeholder="Awal" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src_date_range-a#tgl_bayar-end" id="src-tgl_bayar_akhir" placeholder="Akhir" />
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
									<button class="btn btn-success" type="button" onclick="alert('Dalam tahap pengembangan :)')"><i class="fa fa-file-excel-o"></i> Excel</button>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>


		<div id="data-view"></div>

	</div>
</section>

<script src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		$(".number").inputmask({
			'alias': 'numeric',
			'mask': '9999',
			rightAlign: false
		});

		$("#src-tgl_bayar_awal,#src-tgl_bayar_akhir,#tgl_cetak").mask('99-99-9999');

		// START AND FINISH DATE
		$("#src-tgl_bayar_awal,#src-tgl_bayar_akhir,#tgl_cetak").datepicker({
			dateFormat: 'dd-mm-yy',
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>'
		});
	});

	base_url = $('#base_url').val();
	bundle_item_type = $('#bundle_item_type').val();
	menu = $('#menu').val();


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