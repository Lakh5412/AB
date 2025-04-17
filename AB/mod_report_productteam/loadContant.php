<?php
include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("../core/incLang.php");
include("incModLang.php");
include("config.php");

$year = date("Y");
$month = date("m");
$countDay = date("t");

$explode = explode("-", $_REQUEST['dateInput']);

if ($explode[0]) { //ถ้ามีการส่ง dateInput มา จะใช้ค่าเดือนและปีจาก dateInput แทนค่าเริ่มต้น และคำนวณ $countDay ใหม่ตามเดือนและปีที่ได้รับ
    $year = $explode[1];
    $month = $explode[0];
    $countDay = date("t", strtotime($year . "-" . $month));
}

$valNav1 = $langTxt["nav:home2"];
$valLinkNav1 = "../core/index.php";
$valNav2 = getNameMenu($_REQUEST["menukeyid"]); //ตั้งค่าตัวแปรสำหรับแสดง Breadcrumb Navigation (เช่น หน้าแรก > ชื่อเมนูรายงาน)

$valPermission = getUserPermissionOnMenu($_SESSION[$valSiteManage . "core_session_groupid"], $_REQUEST["menukeyid"]);

//เลือก Array โครงสร้างทีม ($arrTeamA หรือ $arrTeamB ที่กำหนดไว้ใน config.php) มาใช้งานโดยเก็บไว้ในตัวแปร $arrTeamDV
$masterkey = $_REQUEST['masterkey'];
if ($masterkey == "HA") {
    $arrTeamDV = $arrTeamA; 
}elseif($masterkey == "HB"){
    $arrTeamDV = $arrTeamB; 
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />

    <link href="../css/theme.css" rel="stylesheet" />
    <title><?php echo  $core_name_title ?></title>
    <link rel="stylesheet" href="../js/jquery-ui-1.9.0.css">

    <style>
        .table-list {
            margin-left: 1rem;
        }

        .table-header {
            border-left: 1px solid #eee;

        }

        .table-main {
            display: block;
            max-width: 1370px;
            overflow-x: scroll;
            text-align: center;
            border-left: 1px solid #eee;

        }
        .table-main tbody {
            display: block;
            width: 48px;   
        }

        .table-header .divRightTitleTb {
            height: 22px;
            border-right: 1px solid #eee;

        }

        .table-sub-header {
            background-color: #00436c;
            height: 48px;
        }

        .table-sub-header .fontTitlTbLeft {
            color: #fff;
            width: 50px;
            padding-left: 15px;
            padding-right: 15px;
            /* padding-top: 4px; */
            padding-bottom: 4px;
            border-bottom: 2px solid #969696;

        }

        .table-sub-header .divRightTitleTb {
            background-color: #00436c;
        }
        

        .table-sub-header .divRightTitleTb.right {
            border-right: 1px solid #eee;
            padding: 0px 14px 0px 14px;
        }
        .table-sub-header .divRightTitleTb.left {
            padding: 0px 12px 0px 12px;
        }


        .divSubOverTb.table-list td {
            height: 25px;
            border-bottom: 1px solid #eee;
            border-right: 1px solid #eee;
            padding: 0 20px 0 20px;
        }

        .divOverTb.table-list td {
            height: 25px;
            border-bottom: 1px solid #eee;
            border-right: 1px solid #eee;

        }

        .ui-datepicker-calendar {
            display: none;
        }

        .table-list .divRightContantOverTb {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
            height: 20px;
        }

        .table-sum .divRightContantOverTb {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
            height: 30px;
        }

        .divRightContantOverTb {
            height: 30px;
        }

        @media (max-width: 1440px) {
            .table-main {
                display: block;
                max-width: 1120px;
                overflow-x: scroll;
                text-align: center;
                border-left: 1px solid #eee;

            }
        }
    </style>
    <script language="JavaScript" type="text/javascript" src="../js/jquery-1.9.0.js"></script>
    <script language="JavaScript" type="text/javascript" src="../js/jquery-ui-1.9.0.js"></script>
    <script language="JavaScript" type="text/javascript" src="../js/jquery.blockUI.js"></script>
    <script language="JavaScript" type="text/javascript" src="../js/scriptCoreWeweb.js"></script>
    <script language="JavaScript" type="text/javascript" src="js/script.js"></script> 
    <script type="text/javascript" language="javascript">
        jQuery('.btnExport').click(function(e) {
            var data = $('#export').val();
            jQuery('#sql_export').val(data);
            document.myFormExport.action = 'exportReport.php'; //ไฟล์ JavaScript เฉพาะของโมดูลนี้ (สำคัญมาก เพราะใช้โหลดข้อมูลแบบ AJAX)
            document.myFormExport.submit();
        });
    </script>
</head>

<body>
    <?php
    // Check to set default value ######################### ส่วนจัดการการค้นหาและเตรียมข้อมูล Export

    if ($_REQUEST['inputSearch'] != "") { //รับค่า $inputSearch จาก Request
        $inputSearch = trim($_REQUEST['inputSearch']);
    } else {
        $inputSearch = $_REQUEST['inputSearch'];
    }

    // Search Value SQL #########################
    $sqlSearch = ""; //กำหนดตัวแปรสำหรับเก็บเงื่อนไข SQL จากการค้นหา (แต่ในไฟล์นี้ไม่ได้นำไปใช้โดยตรงในการ query ข้อมูลหลัก)


    if ($_REQUEST['sdateInputSe'] <> "" && $_REQUEST['edateInputSe'] <> "") {
        $valSdate = DateFormatInsertNoTime($_REQUEST['sdateInputSe']);
        $valEdate = DateFormatInsertNoTime($_REQUEST['edateInputSe']);

        $sqlSearch = $sqlSearch . "  AND  (" . $mod_tb_root . "_credate BETWEEN '" . $valSdate . " 00:00:00' AND '" . $valEdate . " 23:59:59')  ";
    }

    if ($inputSearch <> "") { //หากมีคำค้นหา จะสร้างเงื่อนไข SQL เพิ่มเติม (ไม่ได้ใช้ในไฟล์นี้)
        $sqlSearch = $sqlSearch . "  AND  (
		" . $mod_tb_data . "_subject LIKE '%$inputSearch%'  
        ) ";
    }

    if ($_REQUEST['inputSellID'] >= 1) { //หากมีการเลือกพนักงานขาย จะสร้างเงื่อนไข SQL เพิ่มเติม (ไม่ได้ใช้ในไฟล์นี้)
        $sqlSearch = $sqlSearch . "  AND " . $mod_tb_root . "_sellid	 ='" . $_REQUEST['inputSellID'] . "'   ";
    }

    if ($_REQUEST['inputStatusID'] >= 1) {  //หากมีการเลือกสถานะ จะสร้างเงื่อนไข SQL เพิ่มเติม (ไม่ได้ใช้ในไฟล์นี้)
        $sqlSearch = $sqlSearch . "  AND " . $mod_tb_root . "_statusid	 ='" . $_REQUEST['inputStatusID'] . "'   ";
    } 
    // SQL SELECT #########################
    // $sqlGroupBy = " GROUP BY ".$mod_tb_root."_subject,".$mod_tb_root."_year";
    $sql_export = "SELECT 
      	" . $mod_tb_root . "_id,
			" . $mod_tb_root . "_fbid,
			" . $mod_tb_root . "_sellid,
			" . $mod_tb_root . "_dvid,
			" . $mod_tb_root . "_statusid
        FROM " . $mod_tb_root;
    $sql_export = $sql_export . "  WHERE " . $mod_tb_root . "_masterkey ='" . $_REQUEST['masterkey'] . "'   ";
    $sql_export = $sql_export . $sqlSearch;
    // $sql_export = $sql_export . $sqlGroupBy;



    ?> <!--ฟอร์มที่ซ่อนไว้สำหรับส่งข้อมูลไปยัง exportReport.php ประกอบด้วย input type="hidden" ต่างๆ-->
    <form action="?" method="post" name="myFormExport" id="myFormExport">
        <input name="sql_export" type="hidden" id="sql_export" value="<?php echo  $sql_export ?>" /> <!--ส่งค่า SQL query ที่ใช้สำหรับ Export ไปยังฟอร์ม Export-->
        <input name="language_export" type="hidden" id="language_export" value="<?php echo  $_SESSION[$valSiteManage . 'core_session_language'] ?>" /> <!--ส่งค่าภาษาที่ใช้งานอยู่ไปยังฟอร์ม Export-->
        <input name="masterkey" type="hidden" id="masterkey" value="<?php echo  $_REQUEST["masterkey"] ?>" /> <!--ส่งค่า masterkey ไปยังฟอร์ม Export-->
        <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo  $_REQUEST["menukeyid"] ?>" /> <!--ส่งค่า menukeyid ไปยังฟอร์ม Export-->
        <input name="dateInput" type="hidden" id="dateInput" value="<?php echo  $_REQUEST["dateInput"] ?>" />   <!--ส่งค่า dateInput ไปยังฟอร์ม Export-->
        <input name="inputSellID" type="hidden" id="inputSellID" value="<?php echo  $_REQUEST["inputSellID"] ?>" /> <!--ส่งค่า inputSellID ไปยังฟอร์ม Export-->
        <input name="dvName" type="hidden" id="dvName" value="<?php echo  $_REQUEST['dvName'] ?>" /> <!--ส่งค่า dvName ไปยังฟอร์ม Export  //  ข้อมูลเพิ่มเติม (อาจไม่จำเป็นสำหรับ Export นี้)-->

    </form>

    <!--ฟอร์มหลักของหน้า ใช้สำหรับส่งค่าการค้นหา (เช่น dateInput) หรือเก็บค่าต่างๆ ที่จำเป็นในการทำงานของหน้าเว็บและ JavaScript ผ่าน input type="hidden"-->
    <form action="?" method="post" name="myForm" id="myForm">
        <input name="masterkey" type="hidden" id="masterkey" value="<?php echo  $_REQUEST['masterkey'] ?>" /> <!--Key หลัก-->
        <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo  $_REQUEST['menukeyid'] ?>" /> 
        <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo  $module_pageshow ?>" />  <!--ค่าเกี่ยวกับการแบ่งหน้าและการเรียงลำดับ (อาจไม่ใช้ในหน้านี้)-->
        <input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo  $module_pagesize ?>" />
        <input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo  $module_orderby ?>" />
        <input name="dvName" type="hidden" id="dvName" value="<?php echo  $_REQUEST['dvName'] ?>" /> <!--ชื่อ DV (รับมาจาก Request อาจใช้แสดงผล)-->

        <div class="divRightNav"> <!--ส่วนแสดง Breadcrumb Navigation-->
            <table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td class="divRightNavTb" align="left"><span class="fontContantTbNav"><a href="<?php echo  $valLinkNav1 ?>" target="_self"><?php echo  $valNav1 ?></a> <img src="../img/btn/nav.png" align="absmiddle" vspace="5" /> <a href="javascript:void(0)" onclick="btnBackPage('index.php')" target="_self"><?php echo  $valNav2 ?></a> </td>
                    <td class="divRightNavTb" align="right">
                    </td>
                </tr>
            </table>
        </div>
        <div style="clear:both;"></div>
        <div class="divRightHeadSearch">  <!--ส่วนแสดงแถบค้นหา-->


            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:20px;" align="center">



                <tr>

                    
                    <td id="boxSelectTest" class="textSearch2"> <!--ปุ่มค้นหา-->
                        <input name="dateInput" type="text" id="dateInput" placeholder="<?php echo $langMod["tit:sdate"] ?>" autocomplete="off" value="<?php echo $_REQUEST['dateInput'] ?>" class="formInputSearchStyle dateInput" />
                    <td class="bottonSearchStyle" align="left"><input name="searchOk" id="searchOk" onClick="document.myForm.submit();" type="button" class="btnSearch" value=" " /></td>

                </tr>

            </table>

        </div>

        <!--ส่วน Input ที่ซ่อนไว้สำหรับ JavaScript/AJAX-->
        <input type="hidden" id="sql_countDaily" name="sql_countDaily" value="<?php echo $sql_sell_search; ?>"> <!--เก็บ SQL Query (อาจใช้สำหรับนับข้อมูล แต่ดูเหมือนไม่ได้ใช้ใน Flow หลักของ script.js ที่ให้มา)-->
        <input type="hidden" id="valYear" name="year" value="<?php echo $year; ?>">
        <input type="hidden" id="valMonth" name="month" value="<?php echo $month; ?>">
        <input type="hidden" id="countDay" name="countDay" value="<?php echo $countDay; ?>">

        <input type="hidden" id="export" value="<?php echo $sql_sell_search ?>"> 

        <div class="divRightHead"> <!--ส่วนหัวของรายงาน-->
            <table width="96%" cellspacing="0" cellpadding="0" class="borderBottom" align="center">
                <tr>
                    <?php
                    
                    if ($_SESSION[$valSiteManage . "core_session_language"] != "CN") {

                        if ($explode[0]) {
                            $year = $explode[1];
                            $month = $explode[0];
                            $titleDate = $langMod["tit:month"] . " " . $coreMonthMem[(int)$month] . " " . $year;
                        } else {
                            $titleDate = $langMod["tit:month"] . " " . $coreMonthMem[(int)date('m')] . " " . date('Y');
                        }
                    } else {
                        if ($explode[0]) { //คำนวณ $titleDate: สร้างข้อความส่วนหัวที่ระบุเดือนและปีของรายงาน (เช่น "รายงานเดือน เมษายน 2025") โดยใช้ภาษาที่ตั้งค่าไว้ใน Session
                            $year = $explode[1];
                            $month = $explode[0];
                            $titleDate = $year . "年" . " " . $coreMonthMemCN[(int)$month] . "的";
                        } else {
                            $titleDate = date("Y") . "年" . " " . $coreMonthMemCN[(int)date('m')] . "的";
                        }
                    }

                    // $arrTeamID = getTeamToArray("HA-F,HS-F,HX-F");


                    ?>
                    <?php //
                    if ($_SESSION[$valSiteManage . "core_session_language"] != "CN") { ?>

                        <td height="77" align="left"><span class="fontHeadRight"><?php echo  $valNav2 ?><?php echo  $titleDate ?></span></td>
                    <?php } else { ?>

                        <td height="77" align="left"><span class="fontHeadRight"><?php echo  $titleDate ?><?php echo  $valNav2 ?></span></td>
                    <?php }
                    ?>

                    <!-- <td align="left">
                        <table border="0" cellspacing="0" cellpadding="0" align="right">
                            <tr>
                                <td align="right">
                                    <?php if ($valPermission == "RW") { ?>
                                        <div class="btnExport" title="<?php echo  $langTxt["btn:export"] ?>"></div>
                                    <?php  } ?>
                                </td>
                            </tr>
                        </table>
                    </td> -->
                </tr>
            </table>
        </div>
        <div class="divRightMain flexd"> <!--ส่วนเนื้อหารายงานหลัก-->
            <div class="table-list"> <!--ตารางด้านซ้าย (สรุปรวมรายวัน)-->


                <table width="15%" border="0" cellspacing="0" cellpadding="0" align="left" class="tbBoxListwBorder">
                    <tr class="head">
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center" colspan="3"><span class="fontTitlTbRight"><?php echo $langMod["tit:total"] ?></span></td>
                    </tr>
                    <tr class="head"> <!--แสดงหัวข้อ "ยอดรวม" และหัวคอลัมน์ "วันที่", "สมัคร", "ฝาก"-->
                        <td width="10%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:date-cn"] ?></span></td>
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:regis"] ?></span></td>
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:deposit"] ?></span></td>
                    </tr>
                    <?php

                    $sumApply = 0;
                    $sumDeposit = 0;

                    if ($year == date('Y') && $month == date('m')) { //ตรวจสอบว่าเป็นเดือนปัจจุบันหรือไม่ ถ้าใช่จะวนถึงแค่วันปัจจุบัน ถ้าไม่ใช่จะวนถึงวันสุดท้ายของเดือน
                        $countDayNow = date("d");
                    }else {
                        $countDayNow = $countDay;
                    }

                    $day = 1;
                    $valDivTr = "divSubOverTb"; //สลับ class divSubOverTb และ divOverTb เพื่อให้สีพื้นหลังแถวสลับกัน
                    while ($day < $countDay + 1) {

                        if ($valDivTr == "divSubOverTb") {
                            $valDivTr = "divOverTb";
                            $valImgCycle = "boxprofile_l.png";
                        } else {
                            $valDivTr = "divSubOverTb";
                            $valImgCycle = "boxprofile_w.png";
                        }

                        $arrTeam = getTeamToArray($masterkey);        //สำคัญ: เรียกใช้ฟังก์ชัน getTeamToArray (จาก config.php) เพื่อดึง ID ของ Team ทั้งหมดที่อยู่ภายใต้ Master Key ปัจจุบัน (HA หรือ HB)               
                        // $arrSell = getSellToArray($masterkey);                             
                        
                        if ($day <= $countDayNow +1) {  
                            $apply = countRegister($year, $month, $day, $arrTeam);  //สำคัญ: เรียกใช้ฟังก์ชัน countRegister (จาก config.php) เพื่อนับ ยอดรวมการสมัคร ของทุก Team ($arrTeam) ในวันนั้นๆ
                            $deposit = countDeposit($year, $month, $day, $arrTeam);     //สำคัญ: เรียกใช้ฟังก์ชัน countDeposit (จาก config.php) เพื่อนับ ยอดรวมการฝาก ของทุก Team ($arrTeam) ในวันนั้นๆ 
                        }else{
                            $apply = 0;
                            $deposit = 0;
                        }
                        

                        $sumApply += $apply; //แสดงผล วันที่, ยอดสมัครรวม ($apply), ยอดฝากรวม ($deposit) ของวันนั้น //บวกสะสมยอดรวมของเดือน
                        $sumDeposit += $deposit;

                    ?>
                        <tr class="<?php echo  $valDivTr ?> content"> 

                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo  $day . "/" . $month . "/" . $year ?></span>
                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo $apply ?></span>
                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo $deposit ?></span>
                            </td>

                        </tr>

                    <?php
                        $day++;
                    } ?>


                    <tr class="table-sum"> <!--Summary Row: แสดงแถวสรุปยอดรวมของเดือน ($sumApply, $sumDeposit)-->
                        <td class="divRightContantOverTb" valign="top" align="center">
                            <span class="fontContantTbTime"><?php echo  $countDay ?></span>
                        </td>
                        <td class="divRightContantOverTb" valign="top" align="center">
                            <span class="fontContantTbTime"><?php echo  number_format($sumApply, 0) ?></span>
                        </td>

                        <td class="divRightContantOverTb" valign="top" align="center">
                            <span class="fontContantTbTime"><?php echo  number_format($sumDeposit, 0) ?></span>
                        </td>
                    </tr>


                    <tr class="head"> <!--Footer: แสดงหัวคอลัมน์ซ้ำอีกครั้งด้านล่าง-->
                        <td width="10%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:date-cn"] ?></span></td>
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:regis"] ?></span></td>
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:deposit"] ?></span></td>

                    </tr>
                    <tr class="head">
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center" colspan="3"><span class="fontTitlTbRight"><?php echo $langMod["tit:total"] ?></span></td>
                    </tr>


                </table>
            </div>

            <?php
            //เตรียมข้อมูลทีมและพนักงานขาย
            $arrSellID = getSellTeam($masterkey); //เรียกฟังก์ชัน getSellTeam (จาก config.php) เพื่อดึงรายชื่อพนักงานขาย (Sell ID) ที่อยู่ภายใต้ Master Key ปัจจุบัน

            foreach ($arrSellID as $key => $value) { //วนลูปเพื่อนำข้อมูลพนักงานขายที่ได้ ไปต่อท้าย Array $arrTeamDV (ที่เก็บข้อมูลทีมหลักอยู่แล้ว) ทำให้ $arrTeamDV ตอนนี้มีทั้งข้อมูลทีมหลักและข้อมูลพนักงานขายย่อย
                array_push($arrTeamDV, $value );
            }

            ?>

            <div class="table-scoll">  <!--ตารางด้านขวา (รายละเอียดแยกตามทีม/พนักงานขาย) (<div class="table-scoll"> และ <table class="table-main">)-->

                <table class="table-main" border="0" cellspacing="0" cellpadding="0">
                    <!-- หัวข้อ -->
                    <tbody>
                        <tr class="table-header"> <!-- Header (Team/Sell): ใช้ foreach วนลูป $arrTeamDV (ที่ตอนนี้มีทั้งทีมและพนักงานขาย) เพื่อสร้างหัวตาราง 2 แถวแรก แสดงชื่อทีม/พนักงานขาย ($value['subject'], $value['title']) และใช้สีพื้นหลังตามที่กำหนดใน $arrTeamDV ($value['color1'], $value['color2']) -->
                       
                        <?php
                        foreach ($arrTeamDV as $key => $value) {  ?> <!--สร้างหัวคอลัมน์สำหรับแต่ละทีม/พนักงานขายใน $arrTeamDV-->
                            <th width="20%"  colspan="2" <?php if (!$value['title']) { echo 'rowspan="2"'; } ?> class="divRightTitleTb" style="background-color: <?php echo $value['color1'] ?>;"> <?php echo $value['subject'] ?>  </th>
                        <?php } ?>
                            
                        </tr>
                        <tr class="table-header"> 
                        <?php
                        foreach ($arrTeamDV as $key => $value) {    
                            if ($value['title']) {  ?>
                            <th width="20%" colspan="2" class="divRightTitleTb" style="background-color:<?php echo $value['color2'] ?>;"> <?php echo $value['title'] ?> </th>
                        <?php } } ?>

                    </tr>

                    <tr class="table-sub-header"> <!-- Header (Register/Deposit): สร้างหัวคอลัมน์ "สมัคร" และ "ฝาก" สำหรับแต่ละทีม/พนักงานขายใน $arrTeamDV -->

                    <?php
                        foreach ($arrTeamDV as $key => $value) { ?>
                                <td width="12%" class="divRightTitleTb left" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:regis"] ?></span></td>
                                <td width="12%" class="divRightTitleTb right" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:deposit"] ?></span></td>
                        <?php } ?>

                    </tr>

                    <?php 
                    $sumApply = 0;
                    $sumDeposit = 0;

                    $day = 1;
                    $valDivTr = "divSubOverTb";
                    $listSumApply = array();
                    $listSumDeposit = array();

                    while ($day < $countDay + 1) { //Data Rows: ใช้ while loop วนตามจำนวนวันในเดือน ($day < $countDay + 1)

                        if ($valDivTr == "divSubOverTb") {
                            $valDivTr = "divOverTb";
                            $valImgCycle = "boxprofile_l.png";
                        } else {
                            $valDivTr = "divSubOverTb";
                            $valImgCycle = "boxprofile_w.png";
                        }
                    ?>
                        <tr class="<?php echo  $valDivTr ?> table-list">
                        <?php

                        foreach ($arrTeamDV as $key => $value) {   ?>  
                                <td class="divRightContantOverTb"> <span class="reg-<?php echo $value['id'] ?>-date-<?php echo $year ?>-<?php echo $month ?>-<?php echo $day ?>" > 0 </span>  </td>
                                <td class="divRightContantOverTb"> <span class="dep-<?php echo $value['id'] ?>-date-<?php echo $year ?>-<?php echo $month ?>-<?php echo $day ?>" > 0 </span> </td>
                                <?php  } ?>
                                <!-- สำคัญ: ในส่วนนี้ ไม่ได้คำนวณค่าสมัครหรือฝากด้วย PHP แต่จะสร้างแท็ก <span> ที่มี class ที่ระบุข้อมูลเฉพาะ (เช่น reg-{$value['id']}-date-{$year}-{$month}-{$day} และ dep-...) และใส่ค่าเริ่มต้นเป็น "0" ไว้ก่อน -->
                                <!-- โครงสร้าง class นี้ถูกออกแบบมาเพื่อให้ JavaScript (script.js) ไปเรียก apiloadListDaily.php ผ่าน AJAX โดยส่ง $value['id'], $year, $month, $day ไป แล้วนำผลลัพธ์ที่ได้ (ยอดสมัคร/ฝากของทีม/พนักงานขายนั้นๆ ในวันนั้น) มาใส่ใน <span> ที่มี class ตรงกัน (ดังนั้น ตัวเลขจริงๆ จะถูกโหลดด้วย AJAX ทีหลัง) -->
                        </tr>
                    <?php

                        $day++;
                    } ?>

                    <tr class="table-sum"> <!-- Summary Row: สร้างแถวสรุปยอดรวมของเดือนสำหรับแต่ละทีม/พนักงานขาย โดยสร้าง <span> ที่มี class เฉพาะ (เช่น sumReg-{$value['id']} และ sumDep-...) และใส่ค่าเริ่มต้น "0" ไว้ (ข้อมูลสรุปนี้ก็จะถูกคำนวณและใส่โดย JavaScript หลังจากโหลดข้อมูลรายวันครบแล้ว) -->

                    <?php  foreach ($arrTeamDV as $key => $value) {  ?> 

                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime sumReg-<?php echo $value['id'] ?>"> 0 </span>
                            </td>

                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime sumDep-<?php echo $value['id'] ?>"> 0 </span>
                            </td>
                            <?php  } ?> 
                    </tr>
                    <tr class="table-sub-header"> <!--Footer: แสดงหัวตารางซ้ำอีกครั้งด้านล่าง-->
                    <?php foreach ($arrTeamDV as $key => $value) { ?>
                                <td width="12%" class="divRightTitleTb left" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:regis"] ?></span></td>
                                <td width="12%" class="divRightTitleTb right" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:deposit"] ?></span></td>
                        <?php } ?>
                    </tr>

                    <tr class="table-header">
                       
                    <?php   foreach ($arrTeamDV as $key => $value) { ?>
                            <th width="20%" colspan="2" <?php if (!$value['title2']) { echo 'rowspan="2"'; } ?> class="divRightTitleTb" style="background-color:<?php echo $value['color2'] ?>;"> <?php echo $value['subject2'] ?> </th>
                        <?php } ?>
                            
                        </tr>

                    <tr class="table-header">
                            
                    <?php   foreach ($arrTeamDV as $key => $value) {
                            if ($value['title2']){
                            ?>
                            <th width="20%" colspan="2" class="divRightTitleTb" style="background-color: <?php echo $value['color1'] ?>;"> <?php echo $value['title2'] ?>  </th>
                        <?php } } ?>

                    </tr>
                    
                   
                    </tbody>
                </table>
            </div>
        </div>

    </form>
    <?php if ($_SESSION[$valSiteManage . 'core_session_language'] == "Thai") { ?>
        <script language="JavaScript" type="text/javascript" src="../js/datepickerThai.js"></script>
    <?php  } else { ?>
        <script language="JavaScript" type="text/javascript" src="../js/datepickerEng.js"></script>
        <?php  } ?>

        <?php include("../lib/disconnect.php"); ?>

</body>

</html>