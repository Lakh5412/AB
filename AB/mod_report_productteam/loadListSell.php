<?php
@include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("config.php");

$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$countDay = $_REQUEST['countDay'];
$dvid = $_REQUEST['dvid'];
$sql = $_REQUEST['sql'];
// $sql = $sql . " LIMIT 2";

$listReturn = array();
if ($sql) {
    $listReturn['status'] = true;
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
        $valSellid = $row[0];      
        $listReturn['list_data'][]['id'] = $valSellid;       
    }    
}else{
    $listReturn['status'] = false;
}

echo json_encode($listReturn);

include("../lib/disconnect.php");