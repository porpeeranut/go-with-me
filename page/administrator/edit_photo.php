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
    var n = 800;  
	$(document).ready(function(){
        ID = getUrlParameter('ID');
        CAPTION = getUrlParameter('CAPTION');

        $.get("module/administrator/get.php?option=photo&s=0&n="+n, function(result) {
            //alert(result);
            var obj = jQuery.parseJSON(result);
            row = "";
            for (i=0;i<obj.data.length;i++) {
                if (ID == obj.data[i].ID) {
                    CAPTION = obj.data[i].CAPTION;
                    OWNER_ID = obj.data[i].OWNER_ID;
                    DATE_TIME = obj.data[i].DATE_TIME;
                    $("#txtCaption").val(CAPTION);
                    row += '<div class="col-md-3 portfolio-item">';
                    row += '<a href="#">';
                    row += '<img onclick="window.document.location=\'admin.php?option=photo_detail&ID='+ID+'&CAPTION='+CAPTION+'&OWNER_ID='+OWNER_ID+'&DATE_TIME='+DATE_TIME+'\';" class="img-responsive" src="images/photos/'+ID+'.jpg" alt="">';
                    row += '</a>';
                    row += '<b>'+CAPTION+'</b><br>';
                    row += '</div>';
                }
            }
            init_table('#all-row', row);
        });

        $("#img").attr("src", "images/photos/"+ID+".jpg");
        $('#update').attr("action", "module/administrator/update.php?option=photo&id="+ID);
        $('#update').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "admin.php?option=photo";
            else
                alert(obj.data);
        });
    });
</script>