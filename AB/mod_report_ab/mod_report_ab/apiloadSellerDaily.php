<?php
@include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("config.php"); // Include config ของ mod_report_ab

$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$countDay = $_REQUEST['countDay'];
$data = $_REQUEST['data']; // รับข้อมูล seller ที่ส่งมาจาก JS

$seller_id_raw = isset($data['sellid_raw']) ? $data['sellid_raw'] : 0; // ID จริงสำหรับ Query
$seller_id_prefix = isset($data['id']) ? $data['id'] : ''; // ID ที่มี prefix สำหรับสร้าง class ใน HTML

$listReturn = array();

if ($year && $month && $seller_id_raw > 0 && $seller_id_prefix) {
    $listReturn['status'] = true;

    // ปรับ countDay ถ้าเป็นเดือนปัจจุบัน
    if ($year == date('Y') && $month == date('m')) {
        $countDay = date("d");
    }

    $day = 1;
    $totalRegMonth = 0;
    $totalDepMonth = 0;

    while ($day <= $countDay) { // ใช้ <= เพื่อรวมวันสุดท้าย
        $current_day_padded = sprintf('%02d', $day);
        $current_month_padded = sprintf('%02d', $month);

        // ใช้ฟังก์ชันนับยอดที่แก้ไข/เพิ่มใน config.php
        $dailyReg = countRegisterBySellID($year, $month, $day, $seller_id_raw);
        $dailyDep = countDepositBySellID($year, $month, $day, $seller_id_raw);

        // สร้าง ID สำหรับ HTML element ให้ตรงกับ loadContant.php และ js/script.js
        $reg_element_id = 'reg-' . $seller_id_prefix . '-date-' . $year . '-' . $current_month_padded . '-' . $current_day_padded;
        $dep_element_id = 'dep-' . $seller_id_prefix . '-date-' . $year . '-' . $current_month_padded . '-' . $current_day_padded;

        $listReturn['list_data'][$day]['reg']['id'] = $reg_element_id;
        $listReturn['list_data'][$day]['reg']['value'] = $dailyReg;
        $listReturn['list_data'][$day]['dep']['id'] = $dep_element_id;
        $listReturn['list_data'][$day]['dep']['value'] = $dailyDep;

        $totalRegMonth += $dailyReg;
        $totalDepMonth += $dailyDep;

        $day++;
    }

    // สร้าง ID สำหรับ ยอดรวมเดือน
    $listReturn['reg']['id'] = 'sumReg-' . $seller_id_prefix;
    $listReturn['reg']['sum'] = $totalRegMonth;
    $listReturn['dep']['id'] = 'sumDep-' . $seller_id_prefix;
    $listReturn['dep']['sum'] = $totalDepMonth;

} else {
    $listReturn['status'] = false;
    $listReturn['message'] = 'Missing required parameters or invalid seller ID.';
}

echo json_encode($listReturn);
include("../lib/disconnect.php");
?>