<?php
@include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("config.php");


$masterkey = $_REQUEST['masterkey']; //1. รับค่า masterkey ที่ถูกส่งมากับ Request (อาจจะเป็น GET หรือ POST) ค่านี้จะเป็นตัวกำหนดว่าจะใช้ข้อมูลของทีม HA หรือ HB
//2.เลือก Array ทีมหลัก
if ($masterkey == "HA") {  //ถ้า $masterkey เป็น "HA" จะนำค่า Array $arrTeamA (ที่กำหนดใน config.php) มาใส่ในตัวแปร $arrTeamDV
    $arrTeamDV = $arrTeamA; 
}elseif($masterkey == "HB"){
    $arrTeamDV = $arrTeamB; 
}

//3.ดึงข้อมูลพนักงานขาย
$arrSellID = getSellTeam($masterkey); //เรียกใช้ฟังก์ชัน getSellTeam() (ซึ่งอยู่ใน config.php) โดยส่ง $masterkey ('HA' หรือ 'HB') เข้าไป
//ฟังก์ชัน getSellTeam() จะทำการ Query ฐานข้อมูลในตาราง $mod_tb_data เพื่อค้นหาข้อมูลพนักงานขาย (masterkey = 'sell') ที่มีสถานะ 'Enable' และสังกัดอยู่กับทีม (_team) ที่ชื่อขึ้นต้นด้วย 'HA' หรือ 'HB' ตาม $masterkey ที่ส่งมา
//ผลลัพธ์ที่ได้จาก getSellTeam() จะเป็น Array ที่มีโครงสร้างเฉพาะ (ตามที่กำหนดใน config.php) สำหรับพนักงานขายแต่ละคน และถูกเก็บไว้ในตัวแปร $arrSellID

//4.รวมข้อมูลทีมหลักและพนักงานขาย
foreach ($arrSellID as $key => $value) { //วนลูป Array $arrSellID ที่เก็บข้อมูลพนักงานขาย
    array_push($arrTeamDV, $value );  //ในแต่ละรอบของ Loop จะนำข้อมูลพนักงานขาย ($value ซึ่งเป็น Array ย่อย) ไปต่อท้าย (push) เข้าไปใน Array $arrTeamDV
    //ผลลัพธ์: ทำให้ตอนนี้ $arrTeamDV มีข้อมูลครบถ้วน ทั้งโครงสร้างกลุ่มทีมหลัก (จาก $arrTeamA หรือ $arrTeamB) และข้อมูลพนักงานขายรายบุคคล (จาก $arrSellID)
}

//5.เตรียมข้อมูลสำหรับส่งกลับ
$listReturn = array(); //สร้าง Array ว่างชื่อ $listReturn เพื่อเตรียมเก็บข้อมูลที่จะแปลงเป็น JSON

//ตรวจสอบเงื่อนไข: มีการเช็คค่า id ที่ส่งมาด้วยวิธี POST ว่าเท่ากับ 9999 หรือไม่ นี่อาจเป็นการตรวจสอบง่ายๆ เพื่อให้แน่ใจว่า Request มาจากแหล่งที่ถูกต้อง (เช่น จาก JavaScript ที่เรียกใช้ API นี้) หรืออาจเป็นการส่งค่าเพื่อระบุประเภทของการร้องขอ
if ($_POST['id'] == 9999) { //ถ้าเงื่อนไขเป็นจริง (id=9999)
    $listReturn['status'] = true;        //กำหนดสถานะเป็น true (สำเร็จ)
    $listReturn['list_data'] = $arrTeamDV;       //นำ Array $arrTeamDV ที่รวมข้อมูลทีมและพนักงานขายแล้ว ไปใส่ใน key list_data ของ $listReturn
}else{
    $listReturn['status'] = false;        
}

echo json_encode($listReturn); //ส่งข้อมูลกลับ: แปลง Array $listReturn ทั้งหมดให้เป็นรูปแบบ JSON String และส่งกลับไปเป็น Response ของ API นี้ ซึ่ง JavaScript ที่เรียก API นี้จะได้รับ JSON String นี้ไปใช้งานต่อ

include("../lib/disconnect.php");


/*ไฟล์นี้ทำหน้าที่เป็น API (Application Programming Interface) endpoint ซึ่งหมายความว่ามันถูกออกแบบมาเพื่อให้สคริปต์อื่น (ในที่นี้คือ JavaScript ฝั่ง Client ผ่าน AJAX) 
เรียกใช้งานเพื่อขอข้อมูลรายชื่อ "ทีม" โดยข้อมูลที่ส่งกลับจะอยู่ในรูปแบบ JSON

"ทีม" ในที่นี้มีความหมายรวมถึง:

กลุ่มทีมหลัก (Team Groups): โครงสร้างทีมที่กำหนดไว้ล่วงหน้าใน $arrTeamA หรือ $arrTeamB (จาก config.php) ซึ่งอาจแทนกลุ่มย่อย เช่น กีฬา DV35, หวย DV35 เป็นต้น
พนักงานขายรายบุคคล (Sellers): ข้อมูลพนักงานขายที่ดึงมาจากฐานข้อมูลโดยตรง ซึ่งสังกัดอยู่ภายใต้ Master Key (HA หรือ HB) ที่ร้องขอ */