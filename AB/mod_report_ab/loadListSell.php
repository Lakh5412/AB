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
if ($sql) {
    $listReturn['status'] = true;
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
        $valSellid = $row[0];
        $masterkey = $row[3]; // เพิ่ม masterkey
        $listReturn['list_data'][] = [
            'id' => $valSellid,
            'masterkey' => $masterkey
        ];
    }
} else {
    $listReturn['status'] = false;
}
echo json_encode($listReturn);

include("../lib/disconnect.php");
