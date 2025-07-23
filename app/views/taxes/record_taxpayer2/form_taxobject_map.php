<script src="<?= base_url('assets/leaflet/leaflet.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/leaflet/leaflet.css') ?>" />

<style type="text/css">
	#map{
		height:500px!important;
		width:100%;
		border;1px solid #cccccc;
	}
	.controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
</style>

<form id="<?=$form4_id;?>" method="POST" action="<?=base_url()."/bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/submit_form_taxobject_map";?>" class="form-horizontal">
	<input type="hidden" name="id_value" value="<?=$id_value;?>"/>	
	<input type="hidden" name="menu" value="<?=$menu;?>"/>	
	<input type="hidden" name="wp_wr_id" value="<?=$wp_wr_id;?>"/>		

	<input type="hidden" id="taxobject_latitude" value="<?=$curr_data['latitude'];?>"/>
	<input type="hidden" id="taxobject_longitude" value="<?=$curr_data['longitude'];?>"/>
	<input type="hidden" id="taxobject_name" value="<?=$curr_data['nama'];?>"/>

	<!-- <input id="pac-input" class="controls" type="text" placeholder="Search Box"> -->
	<div id="map"></div><br />
	<fieldset>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-3"><b>Alamat Objek Pajak</b></label>
					<div class="col-md-9">
						<div class="input">
							<input class="form-control" value="<?=$curr_data['alamat'];?>" readonly/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3"><b>Latitude, Longitude</b></label>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control" name="input5-latitude" id="input5-latitude" value="<?=$curr_data['latitude']?>" required/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="input">
							<input class="form-control" name="input5-longitude" id="input5-longitude" value="<?=$curr_data['longitude']?>" required/>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<div class="row">
			<div class="col-md-12" align="center">
				<button type="submit" class="btn btn-primary">
					Simpan
				</button>				
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	
	var form4_id = '<?=$form4_id;?>';
    var $form4 = $('#'+form4_id);
    var submit_noty = 'menambah';
    var form4_stat = $form4.validate({
        // Do not change code below
        errorPlacement : function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());

        }
    });

	$form4.submit(function(){
        if(form4_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(false)
            			.set_content('#list-data4')
                        .set_loading('#loader-list-data4')
                        .enable_pnotify()
                        .set_form($form4)
                        .submit_ajax(submit_noty);             
            return false;
        }
    });

	$(function(){
	
		var map = L.map('map').setView({
    	lat: <?=$curr_data['latitude']?>,
    	lon: <?=$curr_data['longitude']?>
  		}, 12);

  		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    	maxZoom: 19,
    	attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
  		}).addTo(map);

  		L.marker({
    		lat: <?=$curr_data['latitude']?>,
    		lon: <?=$curr_data['longitude']?>
  		}).addTo(map);
	});
</script>