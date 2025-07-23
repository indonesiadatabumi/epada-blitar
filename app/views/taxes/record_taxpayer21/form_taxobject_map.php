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

	<input id="pac-input" class="controls" type="text" placeholder="Search Box">
	<div id="map"></div><br />
	<fieldset>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-3"><b>Alamat Objek Pajak</b></label>
					<div class="col-md-9">
						<div class="input">
							<input class="form-control" value="<?=$curr_data['alamat'];?>"/>
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
	
		'user strict';

		var map,marker;
		var mapDiv = document.getElementById('map');
		var status = 'notset';
		var latitude = -2.6161818, longitude = 121.1202081, toLatitude = $('#taxobject_latitude').val(), toLongitude = $('#taxobject_longitude').val();

		if((parseFloat(toLatitude)!=0 && toLatitude!='') && (parseFloat(toLongitude)!=0 && toLongitude!='')){
			latitude = toLatitude;
			longitude = toLongitude;
			status = 'set';
		}

		var toLatLang = new google.maps.LatLng(latitude,longitude);

		function initMap(){

			map = new google.maps.Map(mapDiv,{
				center:toLatLang,
				zoom:(status=='set'?15:12),
				mapTypeId:'roadmap',
				gestureHandling:'cooperative'
			});

			//create the search box and link it to the UI element
			var input = document.getElementById('pac-input');
			var searchBox = new google.maps.places.SearchBox(input);
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			//Bias the SearchBox result towards current map's viewport
			map.addListener('bounds_changed',function(){
				searchBox.setBounds(map.getBounds());
			});

			marker = new google.maps.Marker({
				position:toLatLang,
				map:map,
				title:$('#taxobject_name').val(),
				draggable:true,
			});

			//listen for the event fired when the user selects a prediction and retrieve
			//more details for that place.
			searchBox.addListener('places_changed',function(){
				var places = searchBox.getPlaces();

				if(places.length == 0){
					return;
				}

				//for each place, get the icon, name and location.
				var bounds = new google.maps.LatLngBounds();

				var i = 0;
				places.forEach(function(place){

					if(!place.geometry){
						console.log("Returned place contains no geometry");
						return;
					}

					map.setCenter(place.geometry.location);
					marker.setPosition(place.geometry.location);
					marker.setMap(map);

					$('#input5-latitude').val(place.geometry.location.lat());
					$('#input5-longitude').val(place.geometry.location.lng());

					if(place.geometry.viewport){
						//only geocodes have viewport
						bounds.union(place.geometry.viewport);
					}else{
						bounds.extend(place.geometry.location);
					}

				});

				map.fitBounds(bounds);
			});

			marker.addListener('drag',function(){				
				$('#input5-latitude').val(marker.getPosition().lat());
				$('#input5-longitude').val(marker.getPosition().lng());
			});
			
		}

		function handleLocationError(browserHasGeoLocation, infoWindow, pos){
			infoWindow.setPosition(pos);
			infoWindow.setContent(browserHasGeoLocation?
									'Error: The Geolocation service failed.':
									'Error: Your browser doesn\'t support geolcation.');
		}

		initMap();
	});
</script>