<?php
@include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("config.php");

$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$countDay = $_REQUEST['countDay'];

if ($year == date('Y') && $month == date('m')) {
    $countDay = date("d");
}

$dvid = $_REQUEST['dvid'];
$sellid = $_REQUEST['sellid'];

$listReturn = array();
if ($_REQUEST['year']) {
    $listReturn['status'] = true;
    $day = 1;
    while ($day < $countDay + 1) {        
            $listReturn['list_data'][$day]['reg']['id'] = 'reg-'.$sellid.'-date-'.$year.'-'.$month.'-'.$day;
            $listReturn['list_data'][$day]['reg']['value'] = countRegister($year, $month, $day, $dvid, $sellid);
            $listReturn['list_data'][$day]['dep']['id'] = 'dep-'.$sellid.'-date-'.$year.'-'.$month.'-'.$day;
            $listReturn['list_data'][$day]['dep']['value'] = countDeposit($year, $month, $day, $dvid, $sellid);
            $listReturn['reg']['id'] = 'sumReg-'.$sellid;
            $listReturn['reg']['sum'] = $listReturn['reg']['sum'] + $listReturn['list_data'][$day]['reg']['value'];
            $listReturn['dep']['id'] = 'sumDep-'.$sellid;
            $listReturn['dep']['sum'] = $listReturn['dep']['sum'] + $listReturn['list_data'][$day]['dep']['value'];
            $day++;
        }
}else{
    $listReturn['status'] = false;
}
echo json_encode($listReturn);

include("../lib/disconnect.php");