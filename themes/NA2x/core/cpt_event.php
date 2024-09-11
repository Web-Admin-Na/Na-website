<?php
// backwards compatible
add_action( 'admin_init', 'add_custom_box_event', 1 );

/* Adds a box to the main column on the Post and Page edit screens */
function add_custom_box_event() {
    add_meta_box(
        'custom_box_event',
        __( 'Event Information', 'admin' ),
        'inner_custom_box_event',
        'event'
    );
}
/* Prints the box content */
function inner_custom_box_event() {
	global $post;
	$custom = get_post_custom($post->ID);
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'noncename' );

    // date, location, registration form url, lat, long, gallery
	$event_date = isset($custom["event_date"][0]) ? $custom["event_date"][0] : '';
	$event_location = isset($custom["event_location"][0]) ? $custom["event_location"][0] : '';
	$event_address = isset($custom["event_address"][0]) ? $custom["event_address"][0] : '';
	$event_lat = isset($custom["event_lat"][0]) ? $custom["event_lat"][0] : '';
	if( empty( $event_lat ) ) $event_lat = 30.050962884327888;
	$event_long = isset($custom["event_long"][0]) ? $custom["event_long"][0] : '';
	if( empty( $event_long ) ) $event_long = 31.244585937500005;
	$event_form = isset($custom["event_form"][0]) ? $custom["event_form"][0] : '';

	echo "<p><label>Event Date<label><br/><input type='date' name='event_date' value='$event_date' style='width: 100%;'></p>";
	echo "<p><label>Event Location<label><br/><input type='name' name='event_location' value='$event_location' style='width: 100%;'></p>";
	echo "<p><label>Event Address<label><br/><input type='name' name='event_address' value='$event_address' style='width: 100%;'></p>";
	echo "<p style='width: 48%; display: inline-block; margin-right: 4%; display: none'><label>Lat<label><input type='name' id='event_lat' name='event_lat' value='$event_lat' style='width: 100%;'></p>";
	echo "<p style='width: 48%; display: inline-block; display: none'><label>Long<label><br/><input type='name' id='event_long' name='event_long' value='$event_long' style='width: 100%;'></p>";
	?>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
	var geocoder = new google.maps.Geocoder();

	function geocodePosition(pos) {
	  geocoder.geocode({
	    latLng: pos
	  }, function(responses) {
	    if (responses && responses.length > 0) {
	      updateMarkerAddress(responses[0].formatted_address);
	    } else {
	      updateMarkerAddress('Cannot determine address at this location.');
	    }
	  });
	}

	function updateMarkerStatus(str) {
	  document.getElementById('markerStatus').innerHTML = str;
	}

	function updateMarkerPosition(latLng) {

	  document.getElementById('info').innerHTML = [
	    latLng.lat(),
	    latLng.lng()
	  ].join(', ');

	  var event_lat = document.getElementById("event_lat");
	  event_lat.value = latLng.lat();

	  var event_long = document.getElementById("event_long");
	  event_long.value = latLng.lng();
	}

	function updateMarkerAddress(str) {
	  document.getElementById('address').innerHTML = str;
	}

	function initialize() {
	  var latLng = new google.maps.LatLng(<?php echo $event_lat.','.$event_long; ?>);
	  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
	    zoom: 12,
	    center: latLng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	  var marker = new google.maps.Marker({
	    position: latLng,
	    title: 'Point A',
	    map: map,
	    draggable: true
	  });

	  // Update current position info.
	  updateMarkerPosition(latLng);
	  geocodePosition(latLng);

	  // Add dragging event listeners.
	  google.maps.event.addListener(marker, 'dragstart', function() {
	    updateMarkerAddress('Dragging...');
	  });

	  google.maps.event.addListener(marker, 'drag', function() {
	    updateMarkerStatus('Dragging...');
	    updateMarkerPosition(marker.getPosition());
	  });

	  google.maps.event.addListener(marker, 'dragend', function() {
	    updateMarkerStatus('Drag ended');
	    geocodePosition(marker.getPosition());
	  });
	}

	// Onload handler to fire off the app.
	google.maps.event.addDomListener(window, 'load', initialize);
	</script>
	<div id="mapCanvas" style="width: 100%; height: 250px"></div>
	<div id="markerStatus"><i>Click and drag the marker.</i></div>
	<div id="info"></div>
	<div id="address"></div>
	<hr style='color: #ccc; border: 0 height: 1px; margin: 20px 0;'>

<?php
	echo "<p><label>Event Form URL<label><br/><input type='name' name='event_form' value='$event_form' style='width: 100%;'></p>";

}
?>
