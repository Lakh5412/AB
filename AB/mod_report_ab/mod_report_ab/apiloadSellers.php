<?php
@include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("config.php"); // Include config ของ mod_report_ab

$listReturn = array();

// ใช้ฟังก์ชันที่แก้ไข/เพิ่มใน config.php ของ mod_report_ab
$arrSellers = getSellersTeamA();

if (!empty($arrSellers)) {
    $listReturn['status'] = true;
    $listReturn['list_data'] = $arrSellers;
} else {
    $listReturn['status'] = false;
    $listReturn['message'] = 'No sellers found for Team A.';
}

echo json_encode($listReturn);
include("../lib/disconnect.php");
?>
