<?php
@include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("config.php");

//1.รับค่า Parameters จาก Request 
$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$countDay = $_REQUEST['countDay'];
$data = $_REQUEST['data']; //สำคัญ รับข้อมูลของ "หน่วยข้อมูลเฉพาะ" ที่ต้องการทราบยอดรายวัน ข้อมูลนี้มักจะถูกส่งมาเป็น Object หรือ Associative Array จาก JavaScript ซึ่งมีโครงสร้างตามที่กำหนดไว้ใน $arrTeamA/$arrTeamB หรือข้อมูล Seller ที่ได้จาก apiloadListTeam.php

$dvName = $data['dv']; //ดึงชื่อ DV ออกมาจาก $data
$teamName = $data['team']; //ดึงชื่อ Team ออกมาจาก $data
$sellID = $data['sellid']; //ดึง ID ของพนักงานขายออกมา (ถ้ามี)

//2.ปรับจำนวนวันสำหรับเดือนปัจจุบัน
if ($year == date('Y') && $month == date('m')) { //ตรวจสอบว่าปีและเดือนที่ร้องขอมา เป็นปีและเดือนปัจจุบันหรือไม่
    $countDay = date("d"); //ถ้าใช่ $countDay = date("d");: ให้กำหนด $countDay เป็น "วันปัจจุบัน" ของเดือน เพื่อป้องกันการวนลูปคำนวณข้อมูลของวันที่ยังมาไม่ถึง
}

//3.แปลงชื่อ DV/Team เป็น ID
$arrDVID = getDVToArray($dvName); //เรียกใช้ฟังก์ชัน getDVToArray() (จาก config.php) เพื่อแปลงชื่อ DV ($dvName) ให้เป็น Array ของ ID ที่ตรงกันในฐานข้อมูล
$arrTeamID = getTeamToArray($teamName); // เรียกใช้ฟังก์ชัน getTeamToArray() (จาก config.php) เพื่อแปลงชื่อ Team ($teamName) ให้เป็น Array ของ ID ที่ตรงกันในฐานข้อมูล
//เหตุผลที่ต้องแปลงเป็น ID เพราะฟังก์ชันนับข้อมูล (count...Team) มักจะใช้ ID ในการ Query ฐานข้อมูล

//4.กำหนดกลุ่ม DV พิเศษ (HTS) 
$arrHTS = array("DV331", "DV335"); //สร้าง Array เก็บชื่อ DV ที่ต้องการการคำนวณแบบพิเศษ (ซึ่งในที่นี้คือกลุ่ม HTS ที่อาจจะใช้ฟิลด์วันที่หรือ Logic ต่างออกไป)

//5.เตรียม Array สำหรับเก็บผลลัพธ์
$listReturn = array();  //สร้าง Array ว่าง เพื่อเตรียมเก็บข้อมูลที่จะส่งกลับเป็น JSON 

//5.1 คำนวณยอดสมัครและฝาก (แยกตามประเภท HTS หรือ ปกติ)
if ($_REQUEST['year']) { //ตรวจสอบว่ามีการส่งค่า $year มาหรือไม่ (เป็นการป้องกัน Error พื้นฐาน)
    $listReturn['status'] = true;
    $day = 1;
    while ($day < $countDay + 1) {         //เริ่ม Loop วนตามจำนวนวันในเดือน (ตามค่า $countDay ที่อาจถูกปรับแล้ว)
            $listReturn['list_data'][$day]['reg']['id'] = 'reg-'.$data['id'].'-date-'.$year.'-'.$month.'-'.$day; //สร้าง ID ที่ไม่ซ้ำกันสำหรับข้อมูล "ยอดสมัคร" ของหน่วยข้อมูลนี้ในวันนั้นๆ ID นี้จะตรงกับ class ของ <span> ในหน้า HTML (loadContant.php หรือ loadDaily.php) เพื่อให้ JavaScript รู้ว่าจะนำค่าไปใส่ที่ไหน
            // $listReturn['list_data'][$day]['reg']['value'] = countRegisterTeam($year, $month, $day, $arrDVID, $arrTeamID, $arrSellID);
            $listReturn['list_data'][$day]['dep']['id'] = 'dep-'.$data['id'].'-date-'.$year.'-'.$month.'-'.$day; //สร้าง ID สำหรับ "ยอดฝาก" ในลักษณะเดียวกัน
            // $listReturn['list_data'][$day]['dep']['value'] = countDepositTeam($year, $month, $day, $arrDVID, $arrTeamID, $arrSellID);
            if (in_array($dvName, $arrHTS)) { //คำนวณยอดสมัครและฝาก (แยกตามประเภท HTS หรือ ปกติ)  ตรวจสอบว่า $dvName อยู่ในกลุ่ม HTS หรือไม่
                $listReturn['list_data'][$day]['reg']['value'] = "0"; //กำหนดให้ยอดสมัครเป็น 0 (ตาม Logic เฉพาะของ HTS)
                $listReturn['list_data'][$day]['dep']['value'] = countDepositHTS($year, $month, $day, $arrDVID, $arrTeamID, $sellID); //เรียกใช้ฟังก์ชัน countDepositHTS() (จาก config.php) โดยส่ง ปี, เดือน, วัน, Array ของ DV ID ($arrDVID), Array ของ Team ID ($arrTeamID), และ Sell ID ($sellID) เพื่อคำนวณยอดฝากตาม Logic ของ HTS (อาจจะใช้ฟิลด์ _reindate)
            }else{
                $listReturn['list_data'][$day]['reg']['value'] = countRegisterTeam($year, $month, $day, $arrDVID, $arrTeamID, $sellID); //เรียกใช้ฟังก์ชัน countRegisterTeam() (จาก config.php) เพื่อคำนวณยอดสมัครปกติ โดยใช้ ID ต่างๆ ที่เตรียมไว้
                $listReturn['list_data'][$day]['dep']['value'] = countDepositTeam($year, $month, $day, $arrDVID, $arrTeamID, $sellID);  //เรียกใช้ฟังก์ชัน countDepositTeam() (จาก config.php) เพื่อคำนวณยอดฝากปกติ
            }
            //5.2 เก็บข้อมูลและคำนวณยอดรวมรายเดือน
            $listReturn['reg']['id'] = 'sumReg-'.$data['id']; //สร้าง ID สำหรับ Element ที่จะแสดง "ยอดรวมสมัคร" ของเดือนสำหรับหน่วยข้อมูลนี้ (เช่น sumReg-sport-dv35)
            $listReturn['reg']['sum'] = $listReturn['reg']['sum'] + $listReturn['list_data'][$day]['reg']['value']; //นำยอดสมัครของวันปัจจุบัน ($listReturn['list_data'][$day]['reg']['value']) มาบวกสะสมเข้าไปใน $listReturn['reg']['sum']
            $listReturn['dep']['id'] = 'sumDep-'.$data['id']; //สร้าง ID สำหรับ "ยอดรวมฝาก"
            $listReturn['dep']['sum'] = $listReturn['dep']['sum'] + $listReturn['list_data'][$day]['dep']['value']; //บวกสะสมยอดฝากของวันปัจจุบัน
            $day++; //เพิ่มค่า $day เพื่อวนไปยังวันถัดไป
        }
}else{
    $listReturn['status'] = false; //8. แปลง Array $listReturn ทั้งหมด (ซึ่งประกอบด้วย status, list_data ที่มียอดรายวันพร้อม ID, และ reg/dep ที่มียอดรวมรายเดือนพร้อม ID) ให้เป็น JSON String แล้วส่งกลับไปให้ JavaScript ที่เรียก API นี้
}
echo json_encode($listReturn);

include("../lib/disconnect.php");

/*ไฟล์นี้เป็น API Endpoint ที่ถูกเรียกใช้งานโดย JavaScript (ผ่าน AJAX) จากหน้าเว็บ (เช่น loadContant.php หรือ loadDaily.php) 
วัตถุประสงค์หลักคือการ คำนวณและส่งข้อมูลยอด "สมัคร" (Register) และ "ฝาก" (Deposit) แบบรายวัน สำหรับ หน่วยข้อมูลเฉพาะ (Specific Entity) ที่ร้องขอ 
(ซึ่งอาจเป็นกลุ่มทีมย่อย เช่น กีฬา DV35 หรือพนักงานขายรายบุคคล) ตลอดทั้งเดือนที่ระบุ โดยผลลัพธ์จะถูกส่งกลับไปในรูปแบบ JSON */