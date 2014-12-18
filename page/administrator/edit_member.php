<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Member</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-1">
    </div>
    <div class="col-md-4">
        <img class="img-responsive" id="showPic" width="96%" src="" alt="">
    </div>

    <div class="col-md-4">
        <form action="" method="post" enctype="multipart/form-data" id="update">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control input-sm" id="txtName" name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" class="form-control input-sm" id="txtEmail" name="email">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Score</label>
                <input type="text" class="form-control input-sm" id="txtScore" name="all_score">
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
        id = getUrlParameter('ID');
        /*user = getUrlParameter('USERNAME');
        name = getUrlParameter('NAME');
        email = getUrlParameter('EMAIL');
        profile = getUrlParameter('PROFILE');
        score = getUrlParameter('ALL_SCORE');*/

        /*document.getElementById('txtName').value = name;
        document.getElementById('txtEmail').value = email;
        document.getElementById('txtScore').value = score;*/

        $.get("module/administrator/get.php?option=member&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            for (i=0;i < obj.data.length;i++) {
                if (id == obj.data[i].ID) {
                    name = obj.data[i].NAME;
                    email = obj.data[i].EMAIL;
                    score = obj.data[i].ALL_SCORE;
                    profileEXT = obj.data[i].PROFILE;
                    
                    $("#txtName").val(obj.data[i].NAME);
                    $("#txtEmail").val(obj.data[i].EMAIL);
                    $("#txtScore").val(obj.data[i].ALL_SCORE);
                    $("#showPic").attr("src","images/members/"+id+"."+profileEXT);
                    break;
                }
            }
        });
        $('#update').attr("action", "module/administrator/update.php?option=member&id="+id);
        $('#update').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "admin.php?option=member";
            else
                alert(obj.data);
        });
    });
</script>