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
    $day = 1;
    while ($day < $countDay + 1) {
        $query = wewebQueryDB($coreLanguageSQL, $sql);
        $count = wewebNumRowsDB($coreLanguageSQL, $query);
        while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
            $valSellid = $row[0];       
            $listReturn['list_data'][$day][$row['id']]['reg']['id'] = 'reg-'.$row['id'].'-date-'.$year.'-'.$month.'-'.$day;
            $listReturn['list_data'][$day][$row['id']]['reg']['value'] = countRegister($year, $month, $day, $dvid, $valSellid);
            $listReturn['list_data'][$day][$row['id']]['dep']['id'] = 'dep-'.$row['id'].'-date-'.$year.'-'.$month.'-'.$day;
            $listReturn['list_data'][$day][$row['id']]['dep']['value'] = countDeposit($year, $month, $day, $dvid, $valSellid);

        }
        $day++;
    }
}else{
    $listReturn['status'] = false;
}
echo json_encode($listReturn);

include("../lib/disconnect.php");
