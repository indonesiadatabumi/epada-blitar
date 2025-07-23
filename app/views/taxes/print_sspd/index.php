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
					<i class="fa fa-print"></i> Cetak Surat Setoran Pajak Daerah (SSPD)
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Pembayaran</a></li>
					<li>Cetak Surat Setoran Pajak Daerah (SSPD)</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" id="search_form" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/load_list"; ?>" method="POST">
						<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
						<input type="hidden" name="src-pajak_id" id="bundle_id" value="<?= $bundle_id; ?>" />
						<fieldset>
							<div class="form-group">
								<label class="control-label col-md-2">Periode SPT</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control number" name="src-tahun_pajak" id="src-tahun_pajak" value="<?= date('Y'); ?>" maxlength="4" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Tgl. Pendataan</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src_date_range-tgl_proses-start" id="src-tgl_proses_awal" placeholder="Awal" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="src_date_range-tgl_proses-end" id="src-tgl_proses_akhir" placeholder="Akhir" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Kegiatan Usaha</label>
								<div class="col-md-2">
									<div class="input state-disabled">
										<select class="form-control" name="src-kegus_id" id="src-kegus_id">
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
								<label class="control-label col-md-2">Status Bayar</label>
								<div class="col-md-4">
									<div class="input state-disabled">
										<select class="form-control" name="src-status_bayar" id="src-status_bayar">
											<option value="" selected></option>
											<option value="1">Lunas</option>
											<option value="0">Belum Lunas</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Tgl. Cetak</label>
								<div class="col-md-2">
									<div class="input">
										<input type="date" class="form-control" name="tgl_cetak" id="tgl_cetak">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Nama Bendahara</label>
								<div class="col-md-4">
									<div class="input state-disabled">
										<select class="form-control" name="nama_bendahara" id="nama_bendahara" onchange="get_nip()">
											<option value="" selected></option>
											<?php
											foreach ($ref_bendahara as $row) {
												echo "<option value='" . $row['pejda_id'] . "'>" . $row['nama'] . "</option>";
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">NIP</label>
								<div class="col-md-3">
									<div class="input">
										<input type="text" class="form-control" name="nip" id="nip" readonly>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">No. Urut SSPD</label>
								<div class="col-md-2">
									<div class="input">
										<input type="text" class="form-control" name="no_sspd">
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
									<button class="btn btn-success" type="button" onclick="cetak_daftar()"><i class="fa fa-print"></i> Cetak</button>
									<!-- <button class="btn btn-success" type="button" onclick="cetak_daftar_excel()"><i class="fa fa-file-excel-o"></i> Excel</button> -->
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

		$("#src-tgl_proses_awal,#src-tgl_proses_akhir").mask('99-99-9999');

		// START AND FINISH DATE
		$("#src-tgl_proses_awal,#src-tgl_proses_akhir").datepicker({
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

	function get_nip() {
		nama_bendahara = $('#nama_bendahara').val()
		$.ajax({
			type: "post",
			url: base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/get_nip',
			data: {
				nama_bendahara: nama_bendahara
			},
			dataType: "json",
			success: function(response) {
				$('[name="nip"]').val(response.nip)
			}
		})
	}

	function cetak_daftar() {
		tahun_pajak = $('#src-tahun_pajak').val()
		tgl_proses_awal = $('#src-tgl_proses_awal').val()
		tgl_proses_akhir = $('#src-tgl_proses_akhir').val()
		kegus_id = $('#src-kegus_id').val()
		status_bayar = $('#src-status_bayar').val()
		tgl_cetak = $('#tgl_cetak').val()
		nama_bendahara = $('#nama_bendahara').val()
		nip = $('#nip').val()
		$.ajax({
			type: "post",
			url: base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/cetak_daftar',
			data: {
				tahun_pajak: tahun_pajak,
				tgl_proses_awal: tgl_proses_awal,
				tgl_proses_akhir: tgl_proses_akhir,
				kegus_id: kegus_id,
				status_bayar: status_bayar,
				tgl_cetak: tgl_cetak,
				nama_bendahara: nama_bendahara,
				nip: nip
			},
			dataType: "html",
			success: function(response) {
				var tab = window.open('about:blank', '_blank');
				tab.document.write(response);
				tab.document.close();
			}
		})
	}

	// function cetak_daftar_excel() {
	// 	tahun_pajak = $('#src-tahun_pajak').val()
	// 	tgl_proses_awal = $('#src-tgl_proses_awal').val()
	// 	tgl_proses_akhir = $('#src-tgl_proses_akhir').val()
	// 	kegus_id = $('#src-kegus_id').val()
	// 	status_bayar = $('#src-status_bayar').val()
	// 	tgl_cetak = $('#tgl_cetak').val()
	// 	nama_bendahara = $('#nama_bendahara').val()
	// 	nip = $('#nip').val()
	// 	$.ajax({
	// 		type: "post",
	// 		url: base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/cetak_daftar_excel',
	// 		data: {
	// 			tahun_pajak: tahun_pajak,
	// 			tgl_proses_awal: tgl_proses_awal,
	// 			tgl_proses_akhir: tgl_proses_akhir,
	// 			kegus_id: kegus_id,
	// 			status_bayar: status_bayar,
	// 			tgl_cetak: tgl_cetak,
	// 			nama_bendahara: nama_bendahara,
	// 			nip: nip
	// 		},
	// 		dataType: "html",
	// 		success: function(response) {
	// 			var tab = window.open('about:blank', '_blank');
	// 			tab.document.write(response);
	// 			tab.document.close();
	// 		}
	// 	})
	// }
</script>