<?php
@include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("config.php"); 

$listReturn = array();

$masterkey = $_REQUEST['masterkey'];
$arrSellers = getSellersByTeam($masterkey);

if (!empty($arrSellers)) {
    $listReturn['status'] = true;
    $listReturn['list_data'] = $arrSellers;
} else {
    $listReturn['status'] = false;
    $listReturn['message'] = 'No sellers found for Team ' . $masterkey . '.';
}


echo json_encode($listReturn);
include("../lib/disconnect.php");
?>
