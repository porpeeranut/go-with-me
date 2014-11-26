<?php
    include_once "config.inc.php";
    session_start();
    if (isset($_SESSION["login"])=="true") {
      $option = $_GET["option"];
      $content = file_get_contents($CONFIG["page"]["frontend"].$option.".php");
    } else {
      $content = file_get_contents($CONFIG["page"]["frontend"]."login.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$CONFIG["web"]["title"]?></title>
    
    <script src="<?=$CONFIG["javascript"]["admin"]?>jquery-1.11.0.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>

    <!-- Core CSS - Include with every page -->
    <link href="<?=$CONFIG["css"]["admin"]?>bootstrap.css" rel="stylesheet" />
    <link href="<?=$CONFIG["css"]["admin"]?>font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet" />
    <link href="<?=$CONFIG["css"]["frontend"]?>style.css" rel="stylesheet" />
    <link href="<?=$CONFIG["css"]["frontend"]?>main-style.css" rel="stylesheet" />
    <!-- Page-Level CSS -->
   </head>
<body>
    <!--  wrapper -->
    <div id="wrapper">
        
        <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <div class="user-section">
                            <div class="user-section-inner">
                                <img src="bs-siminta-admin/bs-siminta-admin/assets/img/user.jpg" alt="">
                            </div>
                            <div class="user-info">
                                <div><strong>Jonny Deen</strong></div>
                                <div class="user-text-online">
                                    <span></span>&nbsp;
                                </div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    <li class="sidebar-search">
                        <!-- search section-->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!--end search section-->
                    </li>
                    <li class="selected">
                        <a href="#" id="HOME"><i class="fa fa-dashboard fa-fw"></i>Home</a>
                    </li>
                    <li>
                        <a href="#" id="PROFILE"><i class="fa fa-edit fa-fw"></i>Profile</a>
                    </li>
                    <li>
                        <a href="#" id="PHOTO"><i class="fa fa-edit fa-fw"></i>Photo</a>
                    </li>
                    <li>
                        <a href="#" id="BADGE"><i class="fa fa-edit fa-fw"></i>Badge</a>
                    </li>
                    <li>
                        <a href="#" id="LOGOUT"><i class="fa fa-edit fa-fw"></i>Logout</a>
                    </li>
                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper">
            <div class="row">
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12" id="div1">
                                <?=$content?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="<?=$CONFIG["javascript"]["admin"]?>bootstrap.min.js"></script>
    <script src="<?=$CONFIG["javascript"]["admin"]?>function.js"></script>

    <script>
        $("#HOME").click(function(){
            window.location.href = 'main2.php?option=home';
        });
        $("#PROFILE").click(function(){
            window.location.href = 'main2.php?option=profile';
        });
        $("#PHOTO").click(function(){
            window.location.href = 'main2.php?option=photo';
        });
        $("#BADGE").click(function(){
            window.location.href = 'main2.php?option=badge';
        });
        $("#LOGOUT").click(function(){
            window.location.href = "<?=$CONFIG["module"]["frontend"]?>logout.php";
        });

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>

</body>

</html>