<h1 class="page-header">Login</h1>

<div id="all-row" class="row">
</div>

<div class="col-lg-6">
    <form action="" method="post" enctype="multipart/form-data" id="login">
        <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" name="user">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name="pass">
        </div>
        <button id="submit" class="btn btn-default">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function(event){
        $('#login').attr("action", "module/administrator/login.php");
        $('#login').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = 'admin.php?option=member';
            else
                alert(obj.data);
        });
    });
</script>