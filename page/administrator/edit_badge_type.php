<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-1">
    </div>
    <div class="col-md-4">
        <label>Ex. picture</label>
        <img id="img" class="img-responsive" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-4">
        <form action="" method="post" enctype="multipart/form-data" id="update">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control input-sm" id="txtName" name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Detail</label>
                <input type="text" class="form-control input-sm" id="txtDetail"name="detail">
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
        NAME = getUrlParameter('NAME');
        DETAIL = getUrlParameter('DETAIL');
        TYPE = getUrlParameter('TYPE');
        $("#img").attr("src", "images/"+TYPE+"/"+ID+".jpg");
        $("#txtName").attr("value", NAME);
        $("#txtDetail").attr("value", DETAIL);

        if (TYPE == "locations")
            TYPE = "location";
        else if (TYPE == "times")
            TYPE = "timing";
        else if (TYPE == "postures")
            TYPE = "posture";
        else if (TYPE == "things")
            TYPE = "thing";
        $('#update').attr("action", "module/administrator/update.php?option="+TYPE+"&id="+ID);
        $('#update').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "main.php?option="+TYPE;
            else
                alert(obj.data);
        });
    });
</script>