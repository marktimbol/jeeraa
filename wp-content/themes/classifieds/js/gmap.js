jQuery(document).ready(function($){

	$('.gmap_input').on('keyup keypress', function(e) {
		var code = e.keyCode || e.which;
		if (code == 13) { 
			e.preventDefault();
			return false;
		}
	});

	$( '.gmap' ).each(function(){
		var $this = $(this);
		var longitude = $this.find('.longitude').val();
		var latitude = $this.find('.latitude').val();

		if( longitude !== '' && latitude !== '' ){
			var location = new google.maps.LatLng( latitude, longitude );
		}
		else{
			var location = new google.maps.LatLng( 45.2714514, 19.849441);				
		}


		var mapOptions = { 
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: location,
			zoom: 12
		};

		var map =  new google.maps.Map(document.getElementById("map"), mapOptions);

		var input = $this.find('.gmap_input');
		var options = {};
		if( classifieds_data.restrict_country !== '' ){
			options['componentRestrictions'] = {
				country: classifieds_data.restrict_country
			};
		}
		var searchBox = new google.maps.places.Autocomplete(input[0], options);
		var markers = [];

		if( longitude !== '' && latitude !== '' ){
			var marker = new google.maps.Marker({
			    position: location,
			    map: map,
			    draggable: true
			});
			google.maps.event.addListener(
			    marker,
			    'drag',
			    function() {
			    	$this.find('.longitude').val( marker.position.lng() );
			    	$this.find('.latitude').val( marker.position.lat() );
			    }
			);
			markers.push( marker );
		}		

		searchBox.addListener('place_changed', function() {
		    var place = searchBox.getPlace();

		    // Clear out the old markers.
		    markers.forEach(function(marker) {
		    	marker.setMap(null);
		    });
		    markers = [];



	    	var marker = new google.maps.Marker({
	        	map: map,
	        	title: place.name,
	        	position: place.geometry.location,
	        	draggable: true
	      	});
	    	$this.find('.longitude').val( marker.position.lng() );
	    	$this.find('.latitude').val( marker.position.lat() );	      	
	      	markers.push( marker );
			google.maps.event.addListener(
			    marker,
			    'drag',
			    function() {
			    	$this.find('.longitude').val( marker.position.lng() );
			    	$this.find('.latitude').val( marker.position.lat() );
			    }
			);


			map.panTo(place.geometry.location);
		});
	});	
});	