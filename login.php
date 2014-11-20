<?php
include_once "config.inc.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- jQuery Version 1.11.0 -->
    <script src="<?=$CONFIG["javascript"]["admin"]?>jquery-1.11.0.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$CONFIG["web"]["title"]?> Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=$CONFIG["css"]["admin"]?>bootstrap.min.css" rel="stylesheet">

    <link href="<?=$CONFIG["css"]["admin"]?>font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=$CONFIG["css"]["admin"]?>simple-sidebar.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Admin
                    </a>
                </li>
                <li>
                    <a href="#" id="MEMBER">MEMBER</a>
                </li>
                <li>
                    <a href="#" id="PHOTO">PHOTO</a>
                </li>
                <li>
                    <a href="#" id="BADGE">BADGE</a>
                </li>
                <li>
                    <a href="#" id="LOCATION">LOCATION</a>
                </li>
                <li>
                    <a href="#" id="TIMING">TIMING</a>
                </li>
                <li>
                    <a href="#" id="POSTURE">POSTURE</a>
                </li>
                <li>
                    <a href="#" id="THING">THING</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12" id="div1">
                        <?=$content?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$CONFIG["javascript"]["admin"]?>bootstrap.min.js"></script>
    <script src="<?=$CONFIG["javascript"]["admin"]?>function.js"></script>

</body>

</html>
