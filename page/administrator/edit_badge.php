<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Badge</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-2">
        <label>Logo</label>
        <img id="logo_img" class="img-responsive img-circle" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-3">
        <label>Ex. picture</label>
        <img id="ex_img" class="img-responsive" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-4">
        <form action="" method="post" enctype="multipart/form-data" id="update">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control input-sm" id="txtName" name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Score</label>
                <input type="text" class="form-control input-sm" id="txtScore" name="score">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Detail</label>
                <input type="text" class="form-control input-sm" id="txtDetail" name="detail">
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
        SCORE = getUrlParameter('SCORE');
        DETAIL = getUrlParameter('DETAIL');
        $("#logo_img").attr("src", "images/badges/logo_"+ID+".jpg");
        $("#ex_img").attr("src", "images/badges/ex_"+ID+".jpg");
        $("#txtName").attr("value", NAME);
        $("#txtScore").attr("value", SCORE);
        $("#txtDetail").attr("value", DETAIL);
        $('#update').attr("action", "module/administrator/update.php?option=badge&id="+ID);
        $('#update').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "main.php?option=badge";
            else
                alert(obj.data);
        });
    });
</script>