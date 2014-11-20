<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Photo</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-1">
    </div>
    <div class="col-md-4">
        <img id="img" class="img-responsive" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-4">
        <form action="" method="post" enctype="multipart/form-data" id="update">
            <div class="form-group">
                <label for="exampleInputEmail1">Caption</label>
                <input type="text" class="form-control input-sm" id="txtCaption" name="caption">
            </div>
            <button id="Submit" class="btn btn-default">Submit</button>
        </form>
    </div>

</div>

<div id="data_row" class="row">
</div>
<hr>

<script>
    var start = 0;
    var n = 8;  
	$(document).ready(function(){
        ID = getUrlParameter('ID');
        CAPTION = getUrlParameter('CAPTION');
        $("#img").attr("src", "images/photos/"+ID+".jpg");
        $("#txtCaption").attr("value", CAPTION);
        $('#update').attr("action", "module/administrator/update.php?option=photo&id="+ID);
        $('#update').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "main.php?option=photo";
            else
                alert(obj.data);
        });
    });
</script>