<?php
    include_once "config.inc.php";
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>GoWithMe</title>
    <script src="<?=$CONFIG["javascript"]["admin"]?>jquery-1.11.0.js"></script>
    <script src="<?=$CONFIG["javascript"]["admin"]?>jquery.form.js"></script>

    <link href="<?=$CONFIG["css"]["frontend"]?>bootstrap.css" rel="stylesheet">
    
    <link href="<?=$CONFIG["css"]["frontend"]?>sticky-footer.css" rel="stylesheet">
  <link href="<?=$CONFIG["css"]["frontend"]?>fblogin.css" rel="stylesheet">
  </head>

  <body>
    <div id="wrap">
      <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">GoWithMe</a>
          </div>
      <div class="collapse navbar-collapse">
        <form class="navbar-form navbar-right" action="" method="post" id="login">

          <div class="lt-left">
            <div class="form-group">
              <label for="exampleInputEmail2">Username</label>
              <input type="text" class="form-control input-sm" name="user" id="exampleInputEmail2" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword2">Password</label>
              <input type="password" class="form-control input-sm" name="pass" id="exampleInputPassword2" placeholder="Password">
            </div>
            <div class="lt-right">
              <button id="submit" class="login-btn">Login</button>
            </div>
          </div>
        </form>
            
          </div>
        </div>
      </div>
      <div class="container" id="home">
    <div class="row">
      <div class="col-md-7">
        <h3 class="slogan">
          eiei.
        </h3>
        <img src="img/background.png" class="img-responsive" />
      </div>
      <div class="col-md-5">
        <form action="module/frontend/add.php?option=register" method="post" class="form" id="register">
      <legend><a>Create your account</a></legend>
            <h4>It's free and always will be.</h4>
            <input class="form-control input-lg" name="user" placeholder="Username" type="text" />
            <input class="form-control input-lg" name="name" placeholder="Name" type="text" />
            <input class="form-control input-lg" name="email" placeholder="Email" type="email" />
            <input class="form-control input-lg" name="pass" placeholder="Password" type="password" />
            <input class="form-control input-lg" name="repass" placeholder="Re-type Password" type="password" />
            <label>Profile Picture</label>
            <input id="pic" type="file" class="filestyle" name="image">
            <br />
            <button class="btn btn-lg btn-primary btn-block signup-btn" id="submit">
                Create my account</button>
            </form>
      
      </div>
    </div>
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
          $('#register').ajaxForm(function(result) {
              //alert(result);
              var obj = jQuery.parseJSON(result);
              if (obj.status == "success")
                  window.location.href = 'main.php?option=home';
              else
                  alert(obj.data);
          });
      });
    </script>

  </body>
</html>

