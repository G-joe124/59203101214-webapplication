<!-- <!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html {
        height: 100%;
        margin: 0;
        padding: 0;
		text-align: center;
      }

      #map {
        height: 500px;
        width: 600px;
      }
    </style>
  </head>
  <body>

  <div id="map"></div>
    <script>

      function initMap() {
			var mapOptions = {
			  center: {lat: 6.882325, lng: 101.236949},
			  zoom: 14,
			}
				
			var maps = new google.maps.Map(document.getElementById("map"),mapOptions);

			var marker, info;

			$.getJSON( "json.php", function( jsonObj ) {
					//*** loop
					$.each(jsonObj, function(i, item){
						marker = new google.maps.Marker({
						   position: new google.maps.LatLng(item.lat, item.lng),
						   map: maps,
						   title: item.bus_stopnme
						});

					  info = new google.maps.InfoWindow();

					  google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
						  info.setContent(item.bus_stopnme);
						  info.open(maps, marker);
						}
					  })(marker, i));

					}); // loop

			 });

		}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD17YvaJEgevt9tHKIoU5ZPqKUlCLBhxM8&callback=initMap" async defer></script>
  </body>
</html> -->

<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="icon" href="images/bus-stop-icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
  <?php
    // require_once("checkpermission.php");
    //add menu on the top of this insert form
    include "menu.php";

    //the aim of this part is to generate HNO automatically, 
    //using year and number of person registered in that year
    date_default_timezone_set('Asia/Bangkok'); //ตั้งค่าโซนเวลา
    include "dbconnect.php";
    $sql = "SELECT * FROM bus_stop";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo '<script type="text/javascript">';
    echo "var bstp = '$row';"; // ส่งค่า $data จาก PHP ไปยังตัวแปร data ของ Javascript
    echo '</script>';
    // $n = $row['np']; 
    // $hno = "HN".date("Y").($n+1);
    // $conn->close();
    // while($bstp = fecth_array($row))

?>


   <div id="map"></div>
   <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
   var map, infoWindow;
   
  function initMap() {
	  var mapOptions = {
	    center: {lat: 6.882325, lng: 101.236949}, 
	    zoom: 17,
	  }
		 
  	var maps = new google.maps.Map(document.getElementById("map"),mapOptions);
    for(var i=0; i<bstp; i++){
      var busstop1 = new google.maps.Marker({
        position: new google.maps.LatLng($row["lat"],$row["lng"]),
        map: maps,
        title: $row["bus_stopnme"],
        icon: 'images/bus-stop-iconnn.png',
        });
    }
  //   if ($result->num_rows > 0) {
  //     while($row = $result->fetch_assoc()) {
  //       var busstop1 = new google.maps.Marker({
  //       position: new google.maps.LatLng($row["lat"],$row["lng"]),
  //       map: maps,
  //       title: $row["bus_stopnme"],
  //       icon: 'images/bus-stop-iconnn.png',
  //       });
  //     }
  //   }
  // 
  }
      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD17YvaJEgevt9tHKIoU5ZPqKUlCLBhxM8&callback=initMap">
    </script>
  </body>
</html>