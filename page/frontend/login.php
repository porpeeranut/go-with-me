<div class="col-lg-6">
    <h1 class="page-header">Login</h1>
</div>
<div class="col-lg-6">
    <h1 class="page-header">Register</h1>
</div>
<div id="all-row" class="row">
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
    <div class="col-lg-6">
        <form action="" method="post" enctype="multipart/form-data" id="register">
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="user">
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="pass">
            </div>
            <div class="form-group">
                <label>Re-type</label>
                <input type="password" class="form-control" name="repass">
            </div>
            <div class="form-group">
                <label>Profile Picture</label>
                <input id="pic" type="file" class="filestyle" name="pic">
            </div>
            <button id="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(event){
        $('#login').attr("action", "module/frontend/login.php");
        $('#login').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = 'main.php?option=home';
            else
                alert(obj.data);
        });
        $('#register').attr("action", "module/frontend/register.php");
        $('#register').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = 'main.php?option=home';
            else
                alert(obj.data);
        });
    });
</script>