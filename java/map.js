//<![CDATA[

    var map;
    var geocoder = null;
    var addressMarker;
    var addresses = ["Москва, Кутузовский проспект, д.30"];
    var numGeocoded = 0;

    function geocodeAll() {
        geocoder.getLocations(addresses[numGeocoded], addressResolved);
    }

   function addressResolved(response) {
     var delay = 0;
     if (response.Status.code == 620) {
       // Too fast, try again, with a small pause
       delay = 500;
     } else {
       if (response.Status.code == 200) {
         // Success; do something with the address.
         place = response.Placemark[0];
         point = new GLatLng(place.Point.coordinates[1],
                             place.Point.coordinates[0]);
map.setCenter(point, 16);
map.openInfoWindow(point, document.createTextNode(addresses[numGeocoded]));
         marker = new GMarker(point);
         map.addOverlay(marker);
       }
     }
   }

    function load() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
//        map.setCenter(new GLatLng(47.61630, -122.34546), 13);
        map.setMapType(G_NORMAL_MAP);

        geocoder = new GClientGeocoder();
        geocoder.setCache(null);
//        window.setTimeout(geocodeAll, 50);
  geocodeAll();
	  }
    }

    //]]>