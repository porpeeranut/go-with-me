<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Profile</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-4">
        <img class="img-responsive" src="http://placehold.it/300x200" alt="">
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
                <label for="exampleInputEmail1">Current password</label>
                <input type="password" class="form-control input-sm" id="txtCurPass" name="all_score">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">New password</label>
                <input type="password" class="form-control input-sm" id="txtNewPass" name="all_score">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Re-type password</label>
                <input type="password" class="form-control input-sm" id="txtRePass" name="all_score">
            </div>
            <div class="form-group">
                <label>Profile Picture</label>
                <input id="pic" type="file" class="filestyle" name="pic">
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
        id = getUrlParameter('ID');
        user = getUrlParameter('USERNAME');
        name = getUrlParameter('NAME');
        email = getUrlParameter('EMAIL');
        profile = getUrlParameter('PROFILE');
        score = getUrlParameter('ALL_SCORE');

        document.getElementById('txtName').value = name;
        document.getElementById('txtEmail').value = email;
        document.getElementById('txtScore').value = score;

        $.get("module/administrator/get.php?option=member&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            document.getElementById('txtUsername').value = obj.data[0].USERNAME;
            document.getElementById('txtName').value = obj.data[0].NAME;
            document.getElementById('txtEmail').value = obj.data[0].EMAIL;
            document.getElementById('txtScore').value = obj.data[0].ALL_SCORE;
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