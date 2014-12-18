<?php
$lat = $_GET["lat"];
$lng = $_GET["lng"];
$name = $_GET["name"];
?>

<!DOCTYPE html>
<html>
<head>
<script src="http://maps.googleapis.com/maps/api/js"></script>
<style>
html, body, #googleMap {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
}
#googleMap {
    position: relative;
}
</style>
<script>

var lat = <?=$lat?>;
var lng = <?=$lng?>;
var name = '<?=$name?>';

var myCenter=new google.maps.LatLng(lat,lng);
var marker;

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:5,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

marker=new google.maps.Marker({
  position:myCenter,
  animation:google.maps.Animation.BOUNCE
  });

marker.setMap(map);

var infowindow = new google.maps.InfoWindow({
  content: name
  });

infowindow.open(map,marker);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>
<div id="googleMap"></div>
</body>
</html>
