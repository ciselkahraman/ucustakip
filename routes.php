<?php
include("includes/db.php");
$type = $_GET["type"];
$action = $_GET["action"];
if($type == "flights"){
    switch($action) {
    case "create":
        include (__DIR__."/flights/create.php");
    break;
    
}
}
?>
