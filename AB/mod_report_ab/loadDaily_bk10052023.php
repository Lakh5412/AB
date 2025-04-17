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

$valNav1 = $langTxt["nav:home2"];
$valLinkNav1 = "../core/index.php";
$valNav2 = getNameMenu($_REQUEST["menukeyid"]);
$valNav3 = $_REQUEST["dvName"];

$valPermission = getUserPermissionOnMenu($_SESSION[$valSiteManage . "core_session_groupid"], $_REQUEST["menukeyid"]);

//status sell
if ($_SESSION['IN_OUT'] == 0) {
    if ($_SESSION[$valSiteManage . "core_session_storeid"] != 0) {
        $valSellid = $_SESSION[$valSiteManage . "core_session_storeid"];    
    }
    $_SESSION['IN_OUT'] = 1;
}else{
    if ($_REQUEST["inputSellID"] != 0) {
        $valSellid = $_REQUEST["inputSellID"];
    }
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
            height: 46px;
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
    <script type="text/javascript" language="javascript">
        jQuery('.btnExport').click(function(e) {
            var data = $('#export').val();
            jQuery('#sql_export').val(data);
            document.myFormExport.action = 'exportReport.php';
            document.myFormExport.submit();
        });
    </script>
</head>

<body>
    <?php
    // Check to set default value #########################

    if ($_REQUEST['inputSearch'] != "") {
        $inputSearch = trim($_REQUEST['inputSearch']);
    } else {
        $inputSearch = $_REQUEST['inputSearch'];
    }

    // Search Value SQL #########################
    $sqlSearch = "";


    if ($_REQUEST['sdateInputSe'] <> "" && $_REQUEST['edateInputSe'] <> "") {
        $valSdate = DateFormatInsertNoTime($_REQUEST['sdateInputSe']);
        $valEdate = DateFormatInsertNoTime($_REQUEST['edateInputSe']);

        $sqlSearch = $sqlSearch . "  AND  (" . $mod_tb_root . "_credate BETWEEN '" . $valSdate . " 00:00:00' AND '" . $valEdate . " 23:59:59')  ";
    }

    if ($inputSearch <> "") {
        $sqlSearch = $sqlSearch . "  AND  (
		" . $mod_tb_data . "_subject LIKE '%$inputSearch%'  
        ) ";
    }

    if ($_REQUEST['inputSellID'] >= 1) {
        $sqlSearch = $sqlSearch . "  AND " . $mod_tb_root . "_sellid	 ='" . $_REQUEST['inputSellID'] . "'   ";
    }

    if ($_REQUEST['inputStatusID'] >= 1) {
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

    $dvid = $_REQUEST['dvid'];

    ?>
    <form action="?" method="post" name="myFormExport" id="myFormExport">
        <input name="sql_export" type="hidden" id="sql_export" value="<?php echo  $sql_export ?>" />
        <input name="language_export" type="hidden" id="language_export" value="<?php echo  $_SESSION[$valSiteManage . 'core_session_language'] ?>" />
        <input name="masterkey" type="hidden" id="masterkey" value="<?php echo  $_REQUEST["masterkey"] ?>" />
        <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo  $_REQUEST["menukeyid"] ?>" />
        <input name="dateInput" type="hidden" id="dateInput" value="<?php echo  $_REQUEST["dateInput"] ?>" />
        <input name="inputSellID" type="hidden" id="inputSellID" value="<?php echo  $_REQUEST["inputSellID"] ?>" />
        <input name="dvid" type="hidden" id="dvid" value="<?php echo  $_REQUEST["dvid"] ?>" />
        <input name="dvName" type="hidden" id="dvName" value="<?php echo  $_REQUEST['dvName'] ?>" />

    </form>

    <form action="?" method="post" name="myForm" id="myForm">
        <input name="masterkey" type="hidden" id="masterkey" value="<?php echo  $_REQUEST['masterkey'] ?>" />
        <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo  $_REQUEST['menukeyid'] ?>" />
        <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo  $module_pageshow ?>" />
        <input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo  $module_pagesize ?>" />
        <input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo  $module_orderby ?>" />
        <input name="dvid" type="hidden" id="dvid" value="<?php echo  $_REQUEST["dvid"] ?>" />
        <input name="dvName" type="hidden" id="dvName" value="<?php echo  $_REQUEST['dvName'] ?>" />

        <div class="divRightNav">
            <table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td class="divRightNavTb" align="left"><span class="fontContantTbNav"><a href="<?php echo  $valLinkNav1 ?>" target="_self"><?php echo  $valNav1 ?></a> <img src="../img/btn/nav.png" align="absmiddle" vspace="5" /> <a href="javascript:void(0)" onclick="btnBackPage('index.php')" target="_self"><?php echo  $valNav2 ?></a> <img src="../img/btn/nav.png" align="absmiddle" vspace="5" /> <?php echo  $valNav3 ?></span></td>
                    <td class="divRightNavTb" align="right">
                    </td>
                </tr>
            </table>
        </div>
        <div style="clear:both;"></div>
        <div class="divRightHeadSearch">


            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:20px;" align="center">



                <tr>

                    <td class="selectSearch2">
                        <select name="inputSellID" id="inputSellID" onchange="document.myForm.submit();" class="formSelectSearchStyle">
                            <option value="0"><?php echo $langMod["tit:selectsell"] ?></option>
                            <?php

                            if ($explode[0]) {
                                $year = $explode[1];
                                $month = $explode[0];
                                $countDay = date("t", strtotime($year . "-" . $month));
                            }

                            $sqlSelect = "" . $mod_tb_data . "_id as id,              
                            " . $mod_tb_data . "_subject as subject,
                            " . $mod_tb_data . "_dv as dv
                            ";
            
                            // SQL SELECT #########################
                            $sql_sell = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_data;            
                            $sql_sell = $sql_sell . "  INNER JOIN " . $mod_tb_root . " ON ".$mod_tb_root."_sellid = ".$mod_tb_data."_id";            
                            $sql_sell = $sql_sell . "  WHERE " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_sell . "'   ";
                            $sql_sell = $sql_sell . "  AND " . $mod_tb_data . "_status !='Disable' ";

                                        
                          
                            if ($dvid != 0) {
                                if ($dvid == 244 || $dvid == 265 || $dvid == 184 || $dvid == 183 || $dvid == 243) {
                                    $sql_sell = $sql_sell . " AND " . $mod_tb_root . "_dvid = '".$dvid."' ";
                                }else{
                                    $sql_sell = $sql_sell . " AND " . $mod_tb_data . "_dv = '".$dvid."' ";
                                }
                            }

                            $sql_sell = $sql_sell . " AND (YEAR(" . $mod_tb_root . "_date)='" . $year . "'   ";
                            $sql_sell = $sql_sell . " AND MONTH(" . $mod_tb_root . "_date)='" . $month . "')   ";                             
                            
                            if ($valSellid != 0) {
                                $sql_sell_search = $sql_sell . " AND " . $mod_tb_data . "_id ='".$valSellid."'". " " . $sqlSearch . " ". "  GROUP BY subject";                            
                            }else{
                                $sql_sell_search = $sql_sell . " " . $sqlSearch . " ". "  GROUP BY subject";                            
                            }

                            $sql_sell = $sql_sell . "  GROUP BY subject"; 

                            // UNION            
                            $sql_sell = $sql_sell . " UNION ";            
                            $sql_sell = $sql_sell . " SELECT " . $sqlSelect . "    FROM " . $mod_tb_data;            
                            $sql_sell = $sql_sell . "  INNER JOIN " . $mod_tb_root . " ON ".$mod_tb_root."_sellid = ".$mod_tb_data."_id";            
                            $sql_sell = $sql_sell . "  WHERE " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_sell . "'   ";
                            $sql_sell = $sql_sell . "  AND " . $mod_tb_data . "_status !='Disable' ";                                        
                          
                            if ($dvid != 0) {
                                if ($dvid == 244 || $dvid == 265 || $dvid == 184 || $dvid == 183 || $dvid == 243) {
                                    $sql_sell = $sql_sell . " AND " . $mod_tb_root . "_dvid = '".$dvid."' ";
                                }else{
                                    $sql_sell = $sql_sell . " AND " . $mod_tb_data . "_dv = '".$dvid."' ";
                                }
                            }

                            $sql_sell = $sql_sell . " AND (YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
                            $sql_sell = $sql_sell . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "')   "; 
                            
                            // clone
                            $sql_sell_search = $sql_sell_search . " UNION ";            
                            $sql_sell_search = $sql_sell_search . " SELECT " . $sqlSelect . "    FROM " . $mod_tb_data;            
                            $sql_sell_search = $sql_sell_search . "  INNER JOIN " . $mod_tb_root . " ON ".$mod_tb_root."_sellid = ".$mod_tb_data."_id";            
                            $sql_sell_search = $sql_sell_search . "  WHERE " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_sell . "'   ";
                            $sql_sell_search = $sql_sell_search . "  AND " . $mod_tb_data . "_status !='Disable' ";                                        
                          
                            if ($dvid != 0) {
                                if ($dvid == 244 || $dvid == 265 || $dvid == 184 || $dvid == 183 || $dvid == 243) {
                                    $sql_sell_search = $sql_sell_search . " AND " . $mod_tb_root . "_dvid = '".$dvid."' ";
                                }else{
                                    $sql_sell_search = $sql_sell_search . " AND " . $mod_tb_data . "_dv = '".$dvid."' ";
                                }
                            }

                            $sql_sell_search = $sql_sell_search . " AND (YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
                            $sql_sell_search = $sql_sell_search . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "')   ";        
                            // clone                     
                            
                            if ($valSellid != 0) {
                                $sql_sell_search = $sql_sell_search . " AND " . $mod_tb_data . "_id ='".$valSellid."'". " " . $sqlSearch . " ". "  GROUP BY subject ORDER BY dv ASC, subject ASC";                            
                            }else{
                                $sql_sell_search = $sql_sell_search . " " . $sqlSearch . " ". "  GROUP BY subject ORDER BY dv ASC, subject ASC";                            
                            }

                            $sql_sell = $sql_sell . "  GROUP BY subject ORDER BY dv ASC, subject ASC"; 
                            
                            $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell);
                            while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                                $row_sellid = $row_fb[0];
                                $valNamecShow = $row_fb[1];
                            ?>
                                <option value="<?php echo $row_sellid ?>" <?php if ($valSellid == $row_sellid) { ?> selected="selected" <?php  } ?>><?php echo $valNamecShow ?></option>
                            <?php  } ?>

                        </select>
                    </td>

                    
                    <td id="boxSelectTest" class="textSearch2">
                        <input name="dateInput" type="text" id="dateInput" placeholder="<?php echo $langMod["tit:sdate"] ?>" autocomplete="off" value="<?php echo $_REQUEST['dateInput'] ?>" class="formInputSearchStyle dateInput" />
                    <td class="bottonSearchStyle" align="right"><input name="searchOk" id="searchOk" onClick="document.myForm.submit();" type="button" class="btnSearch" value=" " /></td>

                </tr>

            </table>

        </div>

        <input type="hidden" id="sql_countDaily" name="sql_countDaily" value="<?php echo $sql_sell_search; ?>">
        <input type="hidden" id="valYear" name="year" value="<?php echo $year; ?>">
        <input type="hidden" id="valMonth" name="month" value="<?php echo $month; ?>">
        <input type="hidden" id="countDay" name="countDay" value="<?php echo $countDay; ?>">

        <input type="hidden" id="export" value="<?php echo $sql_sell_search ?>">

        <div class="divRightHead">
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
                        if ($explode[0]) {
                            $year = $explode[1];
                            $month = $explode[0];
                            $titleDate = $year . "年" . " " . $coreMonthMemCN[(int)$month] . "的";
                        } else {
                            $titleDate = date("Y") . "年" . " " . $coreMonthMemCN[(int)date('m')] . "的";
                        }
                    }

                    ?>
                    <?php
                    if ($_SESSION[$valSiteManage . "core_session_language"] != "CN") { ?>

                        <td height="77" align="left"><span class="fontHeadRight"><?php echo  $valNav2 ?><?php echo  $titleDate ?></span></td>
                    <?php } else { ?>

                        <td height="77" align="left"><span class="fontHeadRight"><?php echo  $titleDate ?><?php echo  $valNav2 ?></span></td>
                    <?php }
                    ?>

                    <td align="left">
                        <table border="0" cellspacing="0" cellpadding="0" align="right">
                            <tr>
                                <td align="right">
                                    <?php if ($valPermission == "RW") { ?>
                                        <div class="btnExport" title="<?php echo  $langTxt["btn:export"] ?>"></div>
                                    <?php  } ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="divRightMain flexd">
            <div class="table-list">


                <table width="15%" border="0" cellspacing="0" cellpadding="0" align="left" class="tbBoxListwBorder">
                    <tr class="head">
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center" colspan="3"><span class="fontTitlTbRight"><?php echo $langMod["tit:total"] ?></span></td>
                    </tr>
                    <tr class="head">
                        <td width="10%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:date-cn"] ?></span></td>
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:regis"] ?></span></td>
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:deposit"] ?></span></td>
                    </tr>
                    <?php

                    $sumApply = 0;
                    $sumDeposit = 0;

                    $day = 1;
                    $valDivTr = "divSubOverTb";
                    while ($day < $countDay + 1) {

                        if ($valDivTr == "divSubOverTb") {
                            $valDivTr = "divOverTb";
                            $valImgCycle = "boxprofile_l.png";
                        } else {
                            $valDivTr = "divSubOverTb";
                            $valImgCycle = "boxprofile_w.png";
                        }
                        
                        $apply = countRegister($year, $month, $day, $dvid);
                        $deposit = countDeposit($year, $month, $day, $dvid);

                        $sumApply += $apply;
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


                    <tr class="table-sum">
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


                    <tr class="head">
                        <td width="10%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:date-cn"] ?></span></td>
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:regis"] ?></span></td>
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:deposit"] ?></span></td>

                    </tr>
                    <tr class="head">
                        <td width="12%" class="divRightTitleTb" valign="middle" align="center" colspan="3"><span class="fontTitlTbRight"><?php echo $langMod["tit:total"] ?></span></td>
                    </tr>


                </table>
            </div>
            <div class="table-scoll">

                <table class="table-main" border="0" cellspacing="0" cellpadding="0">
                    <!-- หัวข้อ -->
                    <tbody>
                    <tr class="table-header">
                        <?php
                        
                        $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell_search);
                        $count_totalrecord = wewebNumRowsDB($coreLanguageSQL, $query_fb);

                        while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                            $row_sellid = $row_fb[0];
                            $valNamecShow = $row_fb[1];
                        ?>
                            <th width="20%" colspan="2" class="divRightTitleTb"><?php echo $valNamecShow ?></th>
                        <?php  } ?>

                    </tr>

                    <tr class="table-sub-header">
                        <?php
                        for ($i = 0; $i < $count_totalrecord; $i++) {
                        ?>

                            <td width="12%" class="divRightTitleTb left" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:regis"] ?></span></td>
                            <td width="12%" class="divRightTitleTb right" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:deposit"] ?></span></td>
                        <?php  } ?>

                    </tr>

                    <?php
                    $sumApply = 0;
                    $sumDeposit = 0;

                    $day = 1;
                    $valDivTr = "divSubOverTb";
                    $listSumApply = array();
                    $listSumDeposit = array();

                    while ($day < $countDay + 1) {

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
                            $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell_search);
                            while ($row = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {                                
                                $valID = $row[0];
                            ?>
                                <td class="divRightContantOverTb"> <span class="reg-<?php echo $valID ?>-date-<?php echo $year ?>-<?php echo $month ?>-<?php echo $day ?>" > 0 </span>  </td>
                                <td class="divRightContantOverTb"> <span class="dep-<?php echo $valID ?>-date-<?php echo $year ?>-<?php echo $month ?>-<?php echo $day ?>" > 0 </span> </td>
                            <?php } ?>
                        </tr>
                    <?php

                        $day++;
                    } ?>

                    <tr class="table-sum">

                        <?php

                        $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell_search);
                        while ($row = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                            $valID = $row[0];
                        ?>

                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime sumReg-<?php echo $valID ?>"> 0 </span>
                            </td>

                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime sumDep-<?php echo $valID ?>"> 0 </span>
                            </td>
                        <?php  } ?>

                    </tr>
                    <tr class="table-sub-header">
                        <?php
                        for ($i = 0; $i < $count_totalrecord; $i++) {
                        ?>                           
                            <td width="12%" class="divRightTitleTb left" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:regis"] ?></span></td>
                            <td width="12%" class="divRightTitleTb right" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo $langMod["tit:deposit"] ?></span></td>
                        <?php  } ?>
                    </tr>
                    <tr class="table-header">
                        <?php

                        $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell_search);
                        $count_totalrecord = wewebNumRowsDB($coreLanguageSQL, $query_fb);

                        while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                            $row_sellid = $row_fb[0];
                            $valNamecShow = $row_fb[1];
                        ?>
                            <th colspan="2" class="divRightTitleTb"><?php echo $valNamecShow ?></th>
                        <?php  } ?>

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
    <script language="JavaScript" type="text/javascript" src="js/script.js"></script>
    <?php include("../lib/disconnect.php"); ?>

</body>

</html>