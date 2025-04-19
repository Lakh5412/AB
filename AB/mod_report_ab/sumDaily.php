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

$listReturn = array();
if ($_REQUEST['year']) {
    $listReturn['status'] = true;
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $count = wewebNumRowsDB($coreLanguageSQL, $query);
    while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
        $valSellid = $row[0];       
        $listReturn['list_data'][$row['id']]['reg']['id'] = 'sumReg-'.$row['id'];
        $listReturn['list_data'][$row['id']]['reg']['sum'] = sumDaily($year, $month, $dvid, $valSellid, 0);
        $listReturn['list_data'][$row['id']]['dep']['id'] = 'sumDep-'.$row['id'];
        $listReturn['list_data'][$row['id']]['dep']['sum'] = sumDaily($year, $month,$dvid, $valSellid, 1);
    }
}else{
    $listReturn['status'] = false;
}
echo json_encode($listReturn);

include("../lib/disconnect.php");
