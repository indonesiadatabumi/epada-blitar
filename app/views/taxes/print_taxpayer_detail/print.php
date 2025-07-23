<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->config->item('sys_name_acr') . ' ' . $system_params[7] . ' ' . $system_params[6]; ?> | Info Rinci WP</title>
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>report-style.css" />
	<style type="text/css">
		@import "<?= $this->config->item('css_path'); ?>report-table-style.css";
	</style>
	<style type="text/css">
		.card {
			width: 320px;
			float: left;
			margin-right: 5px;
			margin-bottom: 5px;
			padding: 10px;
			border: 1px solid #000;
		}

		table.card-content {
			width: 100%;
			border: none;
		}

		table.card-content td {
			font-size: 0.9em;
		}

		#map {
			height: 600px !important;
			width: 100%;
			border;
			1px solid #cccccc;
		}
	</style>
	<script type="text/javascript" src="<?= $this->config->item('js_path'); ?>libs/jquery-2.1.1.min.js"></script>
	<script src="<?= base_url('assets/leaflet/leaflet.js') ?>"></script>
	<link rel="stylesheet" href="<?= base_url('assets/leaflet/leaflet.css') ?>" />
</head>

<body>
	<div style="margin:10px;padding:5px;border:1px solid #000">
		<table class="report" cellpadding="0" cellspacing="0" style="margin-bottom:5px;">
			<tr>
				<td width="50%">
					<div style="float:left;margin-right:10px;">
						<img src="<?= $this->config->item('img_path'); ?>logo_pemda.png" style="width:48px;" />
					</div>
					<div style="float:left">
						<?php echo "<h4>PEMERINTAH " . strtoupper($system_params[7] . " " . $system_params[6]) . "<br />
							" . strtoupper($system_params[2]) . "<br />
							<font style='font-weight:normal'>" . $system_params[3] . "</font><br />
							<font style='font-weight:normal'>Telp. " . $system_params[4] . ", email : bapenda@blitarkab.go.id, website : bapenda.blitarkab.go.id</font>
							</h4>";
						?>
					</div>
					<div style="clear:both"></div>
				</td>
				<td width="50%">
					<h3 align="center"><u>INFO RINCI WP</u></h3>
				</td>
			</tr>
		</table>

		<div class="fluid" style="margin-bottom:5px;">
			<div class="grid6">

				<table class="report" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td>Jenis Pajak</td>
							<td><?= $row['nama_paret']; ?></td>
						</tr>
						<tr>
							<td>Kegiatan Usaha</td>
							<td><?= $row['nama_kegus']; ?></td>
						</tr>
						<tr>
							<td>Golongan</td>
							<td><?= $row['nama_golongan']; ?></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td><?= $row['nama']; ?></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td><?= $row['alamat']; ?></td>
						</tr>
						<tr>
							<td>Kelurahan</td>
							<td><?= $row['kelurahan']; ?></td>
						</tr>
						<tr>
							<td>Kecamatan</td>
							<td><?= $row['kecamatan']; ?></td>
						</tr>
						<tr>
							<td>Kode Pos</td>
							<td><?= $row['kode_pos']; ?></td>
						</tr>
						<tr>
							<td>No. Telepon</td>
							<td><?= $row['no_telepon']; ?></td>
						</tr>
					</tbody>
				</table>

			</div>
			<div class="grid6">
				<table class="report" cellpadding="0" cellspacing="0">
					<tbody>
						<?php
						if ($row['golongan'] == '1') {
						} else {
							echo "
								<tr><td colspan='2'><b>Data Pemilik</b></td></tr>
								<tr><td>Nama</td><td>" . $row['nama_pemilik'] . "</td></tr>
								<tr><td>Alamat</td><td>" . $row['alamat_pemilik'] . "</td></tr>
								<tr><td>Kelurahan</td><td>" . $row['kelurahan_pemilik'] . "</td></tr>
								<tr><td>Kecamatan</td><td>" . $row['kecamatan_pemilik'] . "</td></tr>
								<tr><td>Kabupaten</td><td>" . $row['kabupaten_pemilik'] . "</td></tr>
								<tr><td>Kode Pos</td><td>" . $row['kode_pos_pemilik'] . "</td></tr>
								<tr><td>No. Telepon</td><td>" . $row['no_telepon_pemilik'] . "</td></tr>
								";
						}
						?>
						<tr>
							<td>No./Tgl. Pendaftaran</td>
							<td><?= $row['no_reg'] . " / " . indo_date_format($row['tgl_pendaftaran'], 'longDate'); ?></td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>

		<div class="fluid">
			<div class="grid6">
				<div style="border:1px solid #000">
					<div style="text-align:center;font-weight:bold;padding:5px;border-bottom:1px solid #000">
						Foto Objek Pajak
					</div>
					<div style="padding:2px;">
						<?php
						echo "<img src='" . $this->config->item('upload_path') . "tax_objects/" . $row['gambar'] . "' style='width:100%;height:600px;'>";
						?>
					</div>
				</div>
			</div>
			<div class="grid6">
				<div style="border:1px solid #000">
					<div style="text-align:center;font-weight:bold;padding:5px;border-bottom:1px solid #000">
						Lokasi Objek Pajak
						<?php
						echo "<input type='hidden' id='latitude' value='" . $row['latitude'] . "'/>
								<input type='hidden' id='longitude' value='" . $row['longitude'] . "'/>";
						?>
					</div>
					<div style="padding:2px;">
						<div id="map"></div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?= $api_key; ?>&libraries=geometry,places" defer></script>
	<script type="text/javascript">
		$(function() {

			// 'user strict';

			// var map,marker;
			// var mapDiv = document.getElementById('map');
			// var status = 'notset';
			// var latitude = $('#latitude').val(), longitude = $('#longitude').val();

			// var toLatLang = new google.maps.LatLng(latitude,longitude);

			// function initMap(){


			// 	map = new google.maps.Map(mapDiv,{
			// 		center:toLatLang,
			// 		zoom:15,
			// 		mapTypeId:'roadmap',
			// 		gestureHandling:'cooperative'
			// 	});


			// 	marker = new google.maps.Marker({
			// 		position:toLatLang,
			// 		map:map,
			// 		title:'Objek Pajak',
			// 		draggable:true,
			// 	});

			// }				

			// initMap();
			var map = L.map('map').setView({
				lat: <?= $row['latitude'] ?>,
				lon: <?= $row['longitude'] ?>
			}, 12);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
			}).addTo(map);

			L.marker({
				lat: <?= $row['latitude'] ?>,
				lon: <?= $row['longitude'] ?>
			}).addTo(map);
		});
	</script>
</body>

</html>