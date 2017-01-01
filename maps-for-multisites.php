<?php

/*

Plugin Name: Maps for Multisites
Description: Uses the Google Maps API to drop markers for each site's location as defined in ttp-plugin Biz Admin. Applies Snazzy styles. A work in progress! .
Author: Charlie Meers
Version: 1.1

*/
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

function my_enqueue_scripts() {

  if(is_front_page() || is_page(193)){ // was tossing error on pages without map
    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAqCySRcS6jifg3KJqSoo2obTKk2S1aEe8&sensor=true', array(), null, true);

    wp_enqueue_script('sog-map-script', plugins_url( '/js/sog-map.js', __FILE__ ), array('google-maps'), null, true);
    
    // wp_register_script( "script", dirname(__FILE__) . '/map_style.json' );
    wp_register_script( "script", plugins_url('map_style.json', __FILE__) );
      wp_enqueue_script( "script" );
    wp_localize_script( 'script', 'wpGlobals', array(

      'mapOptions' => file_get_contents( dirname(__FILE__) . '/map_style.json' )

      ) );
  }
}

add_shortcode( 'ttp_multisite_map', 'ttp_multisite_map' );

function ttp_multisite_map(){
	
  echo '<div id="the-map"></div>';
  $sites_array = wp_get_sites($site_args);
  $citycoords = array();
  //$counter=0;
  //$output = '';


  foreach($sites_array as $site){

    switch_to_blog($site['blog_id']);

    if('' != get_option('biz_city')){
		
	  $city = get_option('biz_city');
	  $prepCity = str_replace(' ','+',$city);
	  $address = $prepCity . '+' . state_abr(get_option('biz_state'));
	  $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
	  $output2= json_decode($geocode);
	  $lat = $output2->results[0]->geometry->location->lat;
	  $long = $output2->results[0]->geometry->location->lng;
	  //echo '<br />Lat: <span class="lat">'.$lat.'</span><br>Long: <span class="lng">'.$long.'</span>';

	  $citycoords[] = array($city, $lat, $long);

      //ob_start();
	  //echo $citycoords[$counter][0];
	  //$counter++;
      //$output .= ob_get_clean();
	  
    } //end of if statement
	

    restore_current_blog();

  }  //end of loop 

//print_r($citycoords);


?>
<script type="text/javascript">   
    var locations = <?php echo json_encode($citycoords); ?>;
</script>

<?php
      
//return $output;

} //end of locations_list_function