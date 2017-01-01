 
  var snazzyMap = JSON.parse(wpGlobals.mapOptions);
  var map = new google.maps.Map(document.getElementById('the-map'), {
      center : new google.maps.LatLng(39.7392358, -104.990251),
      zoom : 4,
      mapTypeId : google.maps.MapTypeId.ROADMAP,
      disableDefaultUI: true,
      styles : snazzyMap,
	  scrollwheel: false
  });



 




//console.log(locations);



var infowindow = new google.maps.InfoWindow;

var marker, i;

for (i = 0; i < locations.length; i++) {  
    marker = new google.maps.Marker({
         position: new google.maps.LatLng(locations[i][1], locations[i][2]),
         map: map,
		 icon: pinSymbol("#b3b3b3"),
		 animation: google.maps.Animation.DROP,
    });
	

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
         return function() {
             infowindow.setContent(locations[i][0]);
             infowindow.open(map, marker);
         }
    })(marker, i));
	
	
	  
}
function pinSymbol(color) {
    return {
        path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
        fillColor: color,
        fillOpacity: 1,
        strokeColor: '#fff',
        strokeWeight: 1,
        scale: 1,
   };
}





