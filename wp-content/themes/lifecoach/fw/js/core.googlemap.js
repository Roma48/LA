function lifecoach_googlemap_init(dom_obj, coords) {
	"use strict";
	if (typeof LIFECOACH_STORAGE['googlemap_init_obj'] == 'undefined') lifecoach_googlemap_init_styles();
	LIFECOACH_STORAGE['googlemap_init_obj'].geocoder = '';
	try {
		var id = dom_obj.id;
		LIFECOACH_STORAGE['googlemap_init_obj'][id] = {
			dom: dom_obj,
			markers: coords.markers,
			geocoder_request: false,
			opt: {
				zoom: coords.zoom,
				center: null,
				scrollwheel: false,
				scaleControl: false,
				disableDefaultUI: false,
				panControl: true,
				zoomControl: true, //zoom
				mapTypeControl: false,
				streetViewControl: false,
				overviewMapControl: false,
				styles: LIFECOACH_STORAGE['googlemap_styles'][coords.style ? coords.style : 'default'],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		};
		
		lifecoach_googlemap_create(id);

	} catch (e) {
		
		dcl(LIFECOACH_STORAGE['strings']['googlemap_not_avail']);

	};
}

function lifecoach_googlemap_create(id) {
	"use strict";

	// Create map
	LIFECOACH_STORAGE['googlemap_init_obj'][id].map = new google.maps.Map(LIFECOACH_STORAGE['googlemap_init_obj'][id].dom, LIFECOACH_STORAGE['googlemap_init_obj'][id].opt);

	// Add markers
	for (var i in LIFECOACH_STORAGE['googlemap_init_obj'][id].markers)
		LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].inited = false;
	lifecoach_googlemap_add_markers(id);
	
	// Add resize listener
	jQuery(window).resize(function() {
		if (LIFECOACH_STORAGE['googlemap_init_obj'][id].map)
			LIFECOACH_STORAGE['googlemap_init_obj'][id].map.setCenter(LIFECOACH_STORAGE['googlemap_init_obj'][id].opt.center);
	});
}

function lifecoach_googlemap_add_markers(id) {
	"use strict";
	for (var i in LIFECOACH_STORAGE['googlemap_init_obj'][id].markers) {
		
		if (LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].inited) continue;
		
		if (LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].latlng == '') {
			
			if (LIFECOACH_STORAGE['googlemap_init_obj'][id].geocoder_request!==false) continue;
			
			if (LIFECOACH_STORAGE['googlemap_init_obj'].geocoder == '') LIFECOACH_STORAGE['googlemap_init_obj'].geocoder = new google.maps.Geocoder();
			LIFECOACH_STORAGE['googlemap_init_obj'][id].geocoder_request = i;
			LIFECOACH_STORAGE['googlemap_init_obj'].geocoder.geocode({address: LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].address}, function(results, status) {
				"use strict";
				if (status == google.maps.GeocoderStatus.OK) {
					var idx = LIFECOACH_STORAGE['googlemap_init_obj'][id].geocoder_request;
					if (results[0].geometry.location.lat && results[0].geometry.location.lng) {
						LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = '' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
					} else {
						LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = results[0].geometry.location.toString().replace(/\(\)/g, '');
					}
					LIFECOACH_STORAGE['googlemap_init_obj'][id].geocoder_request = false;
					setTimeout(function() { 
						lifecoach_googlemap_add_markers(id); 
						}, 200);
				} else
					dcl(LIFECOACH_STORAGE['strings']['geocode_error'] + ' ' + status);
			});
		
		} else {
			
			// Prepare marker object
			var latlngStr = LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].latlng.split(',');
			var markerInit = {
				map: LIFECOACH_STORAGE['googlemap_init_obj'][id].map,
				position: new google.maps.LatLng(latlngStr[0], latlngStr[1]),
				clickable: LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].description!=''
			};
			if (LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].point) markerInit.icon = LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].point;
			if (LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].title) markerInit.title = LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].title;
			LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].marker = new google.maps.Marker(markerInit);
			
			// Set Map center
			if (LIFECOACH_STORAGE['googlemap_init_obj'][id].opt.center == null) {
				LIFECOACH_STORAGE['googlemap_init_obj'][id].opt.center = markerInit.position;
				LIFECOACH_STORAGE['googlemap_init_obj'][id].map.setCenter(LIFECOACH_STORAGE['googlemap_init_obj'][id].opt.center);				
			}
			
			// Add description window
			if (LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].description!='') {
				LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].infowindow = new google.maps.InfoWindow({
					content: LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].description
				});
				google.maps.event.addListener(LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].marker, "click", function(e) {
					var latlng = e.latLng.toString().replace("(", '').replace(")", "").replace(" ", "");
					for (var i in LIFECOACH_STORAGE['googlemap_init_obj'][id].markers) {
						if (latlng == LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].latlng) {
							LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].infowindow.open(
								LIFECOACH_STORAGE['googlemap_init_obj'][id].map,
								LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].marker
							);
							break;
						}
					}
				});
			}
			
			LIFECOACH_STORAGE['googlemap_init_obj'][id].markers[i].inited = true;
		}
	}
}

function lifecoach_googlemap_refresh() {
	"use strict";
	for (id in LIFECOACH_STORAGE['googlemap_init_obj']) {
		lifecoach_googlemap_create(id);
	}
}

function lifecoach_googlemap_init_styles() {
	// Init Google map
	LIFECOACH_STORAGE['googlemap_init_obj'] = {};
	LIFECOACH_STORAGE['googlemap_styles'] = {
		'default': []
	};
	if (window.lifecoach_theme_googlemap_styles!==undefined)
		LIFECOACH_STORAGE['googlemap_styles'] = lifecoach_theme_googlemap_styles(LIFECOACH_STORAGE['googlemap_styles']);
}