<!DOCTYPE html>
<html>
<head>
<script
src="http://maps.googleapis.com/maps/api/js">
</script>

<h1 class="page-header">Add</h1>

<div id="all-row" class="row">
</div>

<div class="col-lg-6">
    <form action="" method="post" enctype="multipart/form-data" id="add">
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" id="txtName" name="name">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Detail</label>
            <input type="text" class="form-control" id="txtDetail" name="detail">
        </div>
        <input type="hidden" name="lat" value="0" id='lat'>
        <input type="hidden" name="lng" value="0" id='lng'>
        <div class="form-group">
            <label for="exampleInputPassword1">Picture</label>
            <input id="ex_pic" type="file" class="filestyle" name="ex_pic">
        </div>
        <label for="exampleInputPassword1">Position</label>
        <div id="googleMap" style="width:500px;height:380px;"></div><br>
        <button id="submit" class="btn btn-default">Submit</button>
    </form>
</div>

<script>
var map;
var myCenter=new google.maps.LatLng(18.797943232667826,98.95317077636719);
var lat;
var lng;
function initialize() {
    var mapProp = {
        center:myCenter,
        zoom:15,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
        $("#lat").val(event.latLng.lat());
        $("#lng").val(event.latLng.lng());
    });
}

function placeMarker(location) {
    var marker = new google.maps.Marker({
        position: location,
        map: map,
    });
    var infowindow = new google.maps.InfoWindow({
        content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
    });
    infowindow.open(map,marker);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>


</body>
</html>


<script>
    $(document).ready(function(event){
        TYPE = getUrlParameter('TYPE');
        if (TYPE != 'location')
            $('#googleMap').hide();
        $('#add').attr("action", "module/administrator/add.php?option="+TYPE);
        $('#add').ajaxForm(function(result) {
            //alert(result);
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "admin.php?option="+TYPE;
            else
                alert(obj.data);
        });
    });
</script>