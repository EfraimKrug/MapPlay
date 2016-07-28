<!DOCTYPE html>
<!--
 api key  MapBrowserKey: AIzaSyBLl-vbXZLqO4GmccEeN4ZoJufCsbXkx9M
-->
<html>
  <head>
    <title>Impressive?</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      // begin circle code
      var citymap = {
        gardner: {
          center: {lat: 42.338, lng: -71.099},
          population: 1
        },
        parsons: {
          center: {lat: 42.337, lng: -71.115},
          population: 5
        },
        kenmore: {
          center: {lat: 42.349, lng: -71.096},
          population: 3
        },
        childrens: {
          center: {lat: 42.337, lng: -71.105},
          population: 1
        }
      };
      // end circle code

      function initMap() {
        var customMapType = new google.maps.StyledMapType([
            {
              stylers: [
                {hue: '#00FF00'},
                {visibility: 'simplified'},
                {gamma: 0.5},
                {weight: 0.5}
              ]
            },
            {
              elementType: 'labels',
              stylers: [{visibility: 'on'}]
            },
            {
              featureType: 'water',
              stylers: [{color: '#0000FF'}]
            }
          ], {
            name: 'Custom Style'
        });
        var customMapTypeId = 'custom_style';

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: {lat: 42.337, lng: -71.105},  // Children's Hospital.
          mapTypeControlOptions: {
            mapTypeIds: ['roadmap', customMapTypeId]
          }
        });
// begin
for (var city in citymap) {
  // Add the circle for this city to the map.
  var cityCircle = new google.maps.Circle({
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FFFFFF',
    fillOpacity: 0.35,
    map: map,
    center: citymap[city].center,
    radius: Math.sqrt(citymap[city].population) * 100
  });
}

// end
        map.mapTypes.set(customMapTypeId, customMapType);
        map.setMapTypeId(customMapTypeId);
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLl-vbXZLqO4GmccEeN4ZoJufCsbXkx9M&callback=initMap">
    </script>
  </body>
</html>
