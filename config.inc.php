<?php
//Database Config
$CONFIG["database"]["host"] = "localhost";
$CONFIG["database"]["sid"] = "XE";
/*$CONFIG["database"]["username"] = "gowithme";
$CONFIG["database"]["password"] = "1234567890";*/
$CONFIG["database"]["username"] = "cpe342project";
$CONFIG["database"]["password"] = "1234567890";

//Admin Config
$CONFIG["admin"]["username"] = "admin";
$CONFIG["admin"]["password"] = "1234567890";

//Path Root Config
$CONFIG["path"]["root"] = realpath(dirname(__FILE__));
$CONFIG["path"]["module"] = "module";
$CONFIG["path"]["page"] = "page";
$CONFIG["path"]["image"] = "images";
$CONFIG["path"]["css"] = "css";
$CONFIG["path"]["javascript"] = "js";

//Include File Config;
$CONFIG["inc"]["connect"] = $CONFIG["path"]["root"]."/".$CONFIG["path"]["module"]."/connect.php";
$CONFIG["inc"]["function"] = $CONFIG["path"]["root"]."/".$CONFIG["path"]["module"]."/function.php";

//Path Sub Config
$CONFIG["path"]["admin"] = "administrator";
$CONFIG["path"]["frontend"] = "frontend";
$CONFIG["path"]["member"] = "members";
$CONFIG["path"]["photo"] = "photos";
$CONFIG["path"]["badge"] = "badges";
$CONFIG["path"]["location"] = "locations";
$CONFIG["path"]["thing"] = "things";
$CONFIG["path"]["time"] = "times";
$CONFIG["path"]["posture"] = "postures";

//Relative Path Config
$CONFIG["module"]["admin"] = $CONFIG["path"]["module"]."/".$CONFIG["path"]["admin"]."/";
$CONFIG["module"]["frontend"] = $CONFIG["path"]["module"]."/".$CONFIG["path"]["frontend"]."/";
$CONFIG["page"]["admin"] = $CONFIG["path"]["page"]."/".$CONFIG["path"]["admin"]."/";
$CONFIG["page"]["frontend"] = $CONFIG["path"]["page"]."/".$CONFIG["path"]["frontend"]."/";
$CONFIG["image"]["member"] = $CONFIG["path"]["image"]."/".$CONFIG["path"]["member"]."/";
$CONFIG["image"]["photo"] = $CONFIG["path"]["image"]."/".$CONFIG["path"]["photo"]."/";
$CONFIG["image"]["badge"] = $CONFIG["path"]["image"]."/".$CONFIG["path"]["badge"]."/";
$CONFIG["image"]["location"] = $CONFIG["path"]["image"]."/".$CONFIG["path"]["location"]."/";
$CONFIG["image"]["thing"] = $CONFIG["path"]["image"]."/".$CONFIG["path"]["thing"]."/";
$CONFIG["image"]["timing"] = $CONFIG["path"]["image"]."/".$CONFIG["path"]["time"]."/";
$CONFIG["image"]["posture"] = $CONFIG["path"]["image"]."/".$CONFIG["path"]["posture"]."/";
$CONFIG["css"]["admin"] = $CONFIG["path"]["css"]."/".$CONFIG["path"]["admin"]."/";
$CONFIG["css"]["frontend"] = $CONFIG["path"]["css"]."/".$CONFIG["path"]["frontend"]."/";
$CONFIG["javascript"]["admin"] = $CONFIG["path"]["javascript"]."/".$CONFIG["path"]["admin"]."/";
$CONFIG["javascript"]["frontend"] = $CONFIG["path"]["javascript"]."/".$CONFIG["path"]["frontend"]."/";

//Web Detail Config
$CONFIG["web"]["name"] = "Gowithme";
$CONFIG["web"]["charset"] = "utf-8";
$CONFIG["web"]["title"] = $CONFIG["web"]["name"]." - ";
$CONFIG["web"]["icon"] = $CONFIG["path"]["image"]."/gowithme.ico";
$CONFIG["web"]["creator"]["name"][0] = "Pongsakorn Sommalai";
$CONFIG["web"]["creator"]["name"][1] = "Kuy1";
$CONFIG["web"]["creator"]["name"][2] = "Kuy2";
$CONFIG["web"]["creator"]["email"][0] = "pongsakorn_sommalai@cmu.ac.th";
$CONFIG["web"]["creator"]["email"][1] = "e1";
$CONFIG["web"]["creator"]["email"][2] = "e2";

//Upload File Config

$CONFIG["upload"]["type"] = array('png', 'jpg', 'jpeg', 'no');

?>
