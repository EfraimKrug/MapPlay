/*****
 * Efraim Krug
 * July 28, 2016
 * Calling ajax with a callback function to ensure
 * the database call returns before filling the maps
 *****/
function doAjaxPart(callback){
        $.ajax({url: "../php/getStuff.php",
              success: function(result){
                    citymap = JSON.parse(result);
                    callback();
                  },
              failure: function(result){
                    alert("Failure - crash and burn!");
                  }
              });
}

/**********
 * Efraim Krug
 * July 28, 2016
 * stand-in function - called from the google api call
 **********/
function doItAll(){
    doAjaxPart(initMap);
}

/**********
 * Efraim Krug
 * July 28, 2016
 * stand-in function - called from the google api call
 * This is cloned from google
 * Google used this as the callback in the google api... but that
 * doesn't work with the slower database fetch
 **********/

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

    for (var city in citymap) {
        var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FFFFFF',
            fillOpacity: 0.35,
            map: map,
            center: citymap[city].center,
            radius: Math.sqrt(citymap[city].population) * 50
        });
    }

    map.mapTypes.set(customMapTypeId, customMapType);
    map.setMapTypeId(customMapTypeId);
}
