(function() {
  var mapStyle = [
    {
      elementType: "geometry",
      stylers: [
        {
          color: "#212121"
        }
      ]
    },
    {
      elementType: "labels.icon",
      stylers: [
        {
          visibility: "off"
        }
      ]
    },
    {
      elementType: "labels.text.fill",
      stylers: [
        {
          color: "#757575"
        }
      ]
    },
    {
      elementType: "labels.text.stroke",
      stylers: [
        {
          color: "#212121"
        }
      ]
    },
    {
      featureType: "administrative",
      elementType: "geometry",
      stylers: [
        {
          color: "#757575"
        }
      ]
    },
    {
      featureType: "administrative.country",
      elementType: "labels.text.fill",
      stylers: [
        {
          color: "#9e9e9e"
        }
      ]
    },
    {
      featureType: "administrative.land_parcel",
      stylers: [
        {
          visibility: "off"
        }
      ]
    },
    {
      featureType: "administrative.land_parcel",
      elementType: "labels",
      stylers: [
        {
          visibility: "off"
        }
      ]
    },
    {
      featureType: "administrative.locality",
      elementType: "labels.text.fill",
      stylers: [
        {
          color: "#bdbdbd"
        }
      ]
    },
    {
      featureType: "poi",
      elementType: "labels.text",
      stylers: [
        {
          visibility: "off"
        }
      ]
    },
    {
      featureType: "poi",
      elementType: "labels.text.fill",
      stylers: [
        {
          color: "#757575"
        }
      ]
    },
    {
      featureType: "poi.park",
      elementType: "geometry",
      stylers: [
        {
          color: "#181818"
        }
      ]
    },
    {
      featureType: "poi.park",
      elementType: "labels.text.fill",
      stylers: [
        {
          color: "#616161"
        }
      ]
    },
    {
      featureType: "poi.park",
      elementType: "labels.text.stroke",
      stylers: [
        {
          color: "#1b1b1b"
        }
      ]
    },
    {
      featureType: "road",
      elementType: "geometry.fill",
      stylers: [
        {
          color: "#2c2c2c"
        }
      ]
    },
    {
      featureType: "road",
      elementType: "labels.text.fill",
      stylers: [
        {
          color: "#8a8a8a"
        }
      ]
    },
    {
      featureType: "road.arterial",
      elementType: "geometry",
      stylers: [
        {
          color: "#373737"
        }
      ]
    },
    {
      featureType: "road.highway",
      elementType: "geometry",
      stylers: [
        {
          color: "#3c3c3c"
        }
      ]
    },
    {
      featureType: "road.highway.controlled_access",
      elementType: "geometry",
      stylers: [
        {
          color: "#4e4e4e"
        }
      ]
    },
    {
      featureType: "road.local",
      elementType: "labels",
      stylers: [
        {
          visibility: "off"
        }
      ]
    },
    {
      featureType: "road.local",
      elementType: "labels.text.fill",
      stylers: [
        {
          color: "#616161"
        }
      ]
    },
    {
      featureType: "transit",
      elementType: "labels.text.fill",
      stylers: [
        {
          color: "#757575"
        }
      ]
    },
    {
      featureType: "water",
      elementType: "geometry",
      stylers: [
        {
          color: "#000000"
        }
      ]
    },
    {
      featureType: "water",
      elementType: "labels.text.fill",
      stylers: [
        {
          color: "#3d3d3d"
        }
      ]
    }
  ];

  var pointsOnMap = [
    [
      32.2685625084,
      34.8500052143,
      1,
      {
        head: "StartPC",
        address: "",
        tel: ""
      }
    ]
  ];

  // Function return array of markers that was create from "locations" and added to "map"
  function setMarkers(map, locations, marker_url) {
    var markers = [];
    var image = new google.maps.MarkerImage(
      marker_url,
      null,
      null,
      null,
      new google.maps.Size(39, 48)
    );
    for (var i = 0; i < locations.length; i++) {
      var point = locations[i];
      var myLatlng = new google.maps.LatLng(point[0], point[1]);
      var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: image,
        title: point[3].head,
        zIndex: point[2]
      });
      marker.infoContent = point[3];
      markers.push(marker);
    }

    return markers;
  }

  // After function is complete all marker in array will contain object with info for infowindow
  function setInfoWindowContent(arrayOfMarkers, infoWindow) {
    for (var i = 0; i < arrayOfMarkers.length; i++) {
      google.maps.event.addListener(arrayOfMarkers[i], "click", function() {
        var content = composeInfoWindowContent(this.infoContent);
        infoWindow.setContent(content);
        infoWindow.open(map, this);
      });
    }
  }

  function composeInfoWindowContent(data) {
    return (
      '<ul class="marker-info">' +
      '<li class="marker-info__head">' +
      data.head +
      "</li>" +
      '<li class="marker-info__address">' +
      data.address +
      "</li>" +
      '<li class="marker-info__tel">' +
      data.tel +
      "</li>" +
      "</ul>"
    );
  }

  function initMap(el) {
    var container;

    switch (typeof el) {
      case "string":
        container = document.querySelector(el);
        break;
      case "object":
        container = el;
        break;
      default:
        container = document.getElementById("map");
    }

    var mapOptions = {
      zoom: 14,
      disableDefaultUI: true,
      scrollwheel: false,
      center: new google.maps.LatLng(32.2685625084, 34.8500052143),
      styles: mapStyle
    };

    var map = new google.maps.Map(container, mapOptions);

    var mapMarkers = setMarkers(
      map,
      pointsOnMap,
      $(container).attr("data-marker-url")
    );

    google.maps.event.addDomListener(window, "resize", function() {
      var center = map.getCenter();
      google.maps.event.trigger(map, "resize");
      map.setCenter(center);
    });
    var mapInfoWindow = new google.maps.InfoWindow();

    setInfoWindowContent(mapMarkers, mapInfoWindow);
  }

  function loadScript(el) {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src =
      "https://maps.googleapis.com/maps/api/js?key=AIzaSyDwtEY-nVy75bCxRCaWXxkThFEYAmauEfE&v=3&signed_in=false";
    script.onload = function() {
      initMap(el);
    };
    document.head.appendChild(script);
  }

  window.loadMap = loadScript;
})();
