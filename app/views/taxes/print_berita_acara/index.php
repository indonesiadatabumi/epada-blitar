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
					<i class="fa fa-pencil-square-o"></i> Cetak Berita Acara Surat Paksa
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#"><?= $bundle_row['nama_paret']; ?></a></li>
					<li><a href="#">Penagihan</a></li>
					<li>Cetak Berita Acara Surat Paksa</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" id="search_form" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/load_list"; ?>" method="POST">
						<input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
						<input type="hidden" name="src-a#pajak_id" id="bundle_id" value="<?= $bundle_id; ?>" />
						<div class="form-actions">
							<div class="row">
								<div class="col-md-10 col-md-offset-2">
									<button class="btn btn-default" type="button" onclick="show_all_data();"><i class="fa fa-list-alt"></i> Tampilkan Semua</button>
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
	</div>
</section>

<script type="text/javascript" src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.inputmask.bundle.min.js"></script>

<script type="text/javascript">
	base_url = $('#base_url').val();
	bundle_item_type = $('#bundle_item_type').val();
	menu = $('#menu').val();
	access_privileges = $('#access_privileges').val();

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
</script>