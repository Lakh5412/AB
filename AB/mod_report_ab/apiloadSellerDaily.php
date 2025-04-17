<?php
@include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("config.php"); // Include config ของ mod_report_ab

$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : null;
$month = isset($_REQUEST['month']) ? $_REQUEST['month'] : null;
$countDay = isset($_REQUEST['countDay']) ? $_REQUEST['countDay'] : null;
$data = isset($_REQUEST['data']) ? $_REQUEST['data'] : null;
$masterkey = isset($_REQUEST['masterkey']) ? $_REQUEST['masterkey'] : ''; // รับค่า masterkey

$seller_id_raw = isset($data['sellid_raw']) ? $data['sellid_raw'] : 0;
$seller_id_prefix = isset($data['id']) ? $data['id'] : ''; // ID ที่มี prefix เช่น 'sellid-123'

$listReturn = array();

// ตรวจสอบ Parameter ที่จำเป็นให้ครบถ้วน
if ($year && $month && $countDay && $seller_id_raw > 0 && $seller_id_prefix && !empty($masterkey)) {
    $listReturn['status'] = true;

    // ปรับจำนวนวันสำหรับเดือนปัจจุบัน
    if ($year == date('Y') && $month == date('m')) {
        $countDay = date("d");
    }

    $day = 1;
    $totalRegMonth = 0;
    $totalDepMonth = 0;

    // แปลงเดือนและวันเป็น 2 หลัก (มี 0 นำหน้า)
    $current_month_padded = sprintf('%02d', $month);

    while ($day <= $countDay) { // แก้ไขเงื่อนไข loop เป็น <=
        $current_day_padded = sprintf('%02d', $day); // แปลงวันเป็น 2 หลัก

        // ส่ง $masterkey เข้าไปในฟังก์ชันนับด้วย
        $dailyReg = countRegisterBySellID($year, $month, $day, $seller_id_raw, $masterkey);
        $dailyDep = countDepositBySellID($year, $month, $day, $seller_id_raw, $masterkey);

        // สร้าง ID ของ element ให้ถูกต้อง (ใช้ month และ day ที่แปลงแล้ว)
        $reg_element_id = 'reg-' . $seller_id_prefix . '-date-' . $year . '-' . $current_month_padded . '-' . $current_day_padded;
        $dep_element_id = 'dep-' . $seller_id_prefix . '-date-' . $year . '-' . $current_month_padded . '-' . $current_day_padded;

        // เก็บข้อมูลรายวัน
        $listReturn['list_data'][$day]['reg']['id'] = $reg_element_id;
        $listReturn['list_data'][$day]['reg']['value'] = $dailyReg;
        $listReturn['list_data'][$day]['dep']['id'] = $dep_element_id;
        $listReturn['list_data'][$day]['dep']['value'] = $dailyDep;

        // คำนวณยอดรวมรายเดือน
        $totalRegMonth += $dailyReg;
        $totalDepMonth += $dailyDep;

        $day++;
    }

    // เก็บยอดรวมรายเดือน
    $listReturn['reg']['id'] = 'sumReg-' . $seller_id_prefix; // ID ของ element ยอดรวมสมัคร
    $listReturn['reg']['sum'] = $totalRegMonth;
    $listReturn['dep']['id'] = 'sumDep-' . $seller_id_prefix; // ID ของ element ยอดรวมฝาก
    $listReturn['dep']['sum'] = $totalDepMonth;

} else {
    $listReturn['status'] = false;
    // ระบุสาเหตุของข้อผิดพลาดให้ชัดเจนขึ้น
    $missing = [];
    if (!$year) $missing[] = 'year';
    if (!$month) $missing[] = 'month';
    if (!$countDay) $missing[] = 'countDay';
    if (!$seller_id_raw > 0) $missing[] = 'valid seller id';
    if (!$seller_id_prefix) $missing[] = 'seller id prefix';
    if (empty($masterkey)) $missing[] = 'masterkey';
    $listReturn['message'] = 'Missing required parameters: ' . implode(', ', $missing);
}


// ส่งผลลัพธ์กลับเป็น JSON
echo json_encode($listReturn);
include("../lib/disconnect.php");
?>