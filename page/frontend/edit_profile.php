<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Profile</h1>
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
            <!-- <div class="form-group">
                <label>Profile Picture</label>
                <input id="pic" type="file" class="filestyle" name="pic">
            </div> -->
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
        id = getUrlParameter('id');
        user = getUrlParameter('USERNAME');
        name = getUrlParameter('name');
        email = getUrlParameter('email');
        profile = getUrlParameter('PROFILE');
        profileEXT = getUrlParameter('ext');
        score = getUrlParameter('ALL_SCORE');

        document.getElementById('txtName').value = name;
        document.getElementById('txtEmail').value = email;
        if (profileEXT=="no") filename = "user.png";
        else filename = id+'.'+profileEXT;
        $("#showPic").attr("src","images/members/"+filename);

        /*$.get("module/administrator/get.php?option=member&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            document.getElementById('txtUsername').value = obj.data[0].USERNAME;
            document.getElementById('txtName').value = obj.data[0].NAME;
            document.getElementById('txtEmail').value = obj.data[0].EMAIL;
            document.getElementById('txtScore').value = obj.data[0].ALL_SCORE;
        });*/
        $('#update').attr("action", "module/frontend/update.php?option=member&id="+id);
        $('#update').ajaxForm(function(result) {
            alert(result);
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "main.php?option=home";
            else
                alert(obj.data);
        });
    });
</script>