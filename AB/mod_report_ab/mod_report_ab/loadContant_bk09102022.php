<?php
include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("../core/incLang.php");
include("incModLang.php");
include("config.php");

$valNav1 = $langTxt["nav:home2"];
$valLinkNav1 = "../core/index.php";
$valNav2 = getNameMenu($_REQUEST["menukeyid"]);
$valPermission = getUserPermissionOnMenu($_SESSION[$valSiteManage . "core_session_groupid"], $_REQUEST["menukeyid"]);

if ($_SESSION[$valSiteManage . "core_session_language"] != "CN") {

    if ($_REQUEST['sdateInputSe'] <> "" && $_REQUEST['edateInputSe'] <> "") {
        $valSdate = DateFormatInsertNoTime($_REQUEST['sdateInputSe']);
        $valEdate = DateFormatInsertNoTime($_REQUEST['edateInputSe']);

        $titleDate =  " " . $_REQUEST['sdateInputSe'] . " " . $langMod["tit:to"] . " " . $_REQUEST['edateInputSe'];

    } else {
        $titleDate =  " ".date('d') . " " . $coreMonthMem[(int)date('m')] . " " . date('Y');

    }

} else {
    if ($_REQUEST['sdateInputSe'] <> "" && $_REQUEST['edateInputSe'] <> "") {
        $valSdate = DateFormatInsertNoTime($_REQUEST['sdateInputSe']);
        $valEdate = DateFormatInsertNoTime($_REQUEST['edateInputSe']);

        $titleDate =  " " . $_REQUEST['sdateInputSe'] . " " . $langMod["tit:to"] . " " . $_REQUEST['edateInputSe'];
    } else {
        $titleDate =  date('Y') . " 年 " . $coreMonthMemCN[(int)date('m')] . date('d') . " ";
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
    // $module_default_pagesize = $core_default_pagesize;
    $module_default_pagesize = 100;
    $module_default_maxpage = $core_default_maxpage;
    $module_default_reduce = $core_default_reduce;
    $module_default_pageshow = 1;
    $module_sort_number = $core_sort_number;

    if ($_REQUEST['module_pagesize'] == "") {
        $module_pagesize = $module_default_pagesize;
    } else {
        $module_pagesize = $_REQUEST['module_pagesize'];
    }

    if ($_REQUEST['module_pageshow'] == "") {
        $module_pageshow = $module_default_pageshow;
    } else {
        $module_pageshow = $_REQUEST['module_pageshow'];
    }

    if ($_REQUEST['module_adesc'] == "") {
        $module_adesc = $module_sort_number;
    } else {
        $module_adesc = $_REQUEST['module_adesc'];
    }

    if ($_REQUEST['module_orderby'] == "") {
        $module_orderby = $mod_tb_root . "_order";
    } else {
        $module_orderby = $_REQUEST['module_orderby'];
    }

    if ($_REQUEST['inputSearch'] != "") {
        $inputSearch = trim($_REQUEST['inputSearch']);
    } else {
        $inputSearch = $_REQUEST['inputSearch'];
    }

    // Search Value SQL #########################
    $sqlSearch = "";
    if ($_REQUEST['sdateInputSe'] <> "" && $_REQUEST['edateInputSe'] <> "") {
        if ($_SESSION[$valSiteManage . "core_session_language"] != "CN") {
            $valSdate = DateFormatInsertNoTime($_REQUEST['sdateInputSe']);
            $valEdate = DateFormatInsertNoTime($_REQUEST['edateInputSe']);  
        }else{
            $valSdate = DateFormatInsertNoTimeEN($_REQUEST['sdateInputSe']);
            $valEdate = DateFormatInsertNoTimeEN($_REQUEST['edateInputSe']);        
        } 

        $sqlSearch = $sqlSearch . "  AND  (" . $mod_tb_root . "_date BETWEEN '" . $valSdate . " 00:00:00' AND '" . $valEdate . " 23:59:59')  ";
    }

    // if ($inputSearch <> "") {
    //     $sqlSearch = $sqlSearch . "  AND  (
	// 	" . $mod_tb_data . "_subject LIKE '%$inputSearch%'  
    //     ) ";
    // }

    // if ($_REQUEST['inputSellID'] >= 1) {
    //     $sqlSearch = $sqlSearch . "  AND " . $mod_tb_data . "_id	 ='" . $_REQUEST['inputSellID'] . "'   ";
    // }

    // if ($_REQUEST['inputStatusID'] >= 1) {
    //     $sqlSearch = $sqlSearch . "  AND " . $mod_tb_data . "_statusid	 ='" . $_REQUEST['inputStatusID'] . "'   ";
    // }
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

    ?>
    <form action="?" method="post" name="myFormExport" id="myFormExport">
        <input name="sql_export" type="hidden" id="sql_export" value="<?php echo  $sql_export ?>" />
        <input name="language_export" type="hidden" id="language_export" value="<?php echo  $_SESSION[$valSiteManage . 'core_session_language'] ?>" />
        <input name="masterkey" type="hidden" id="masterkey" value="<?php echo  $_REQUEST["masterkey"] ?>" />
        <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo  $_REQUEST["menukeyid"] ?>" />
        <input name="dateInput" type="hidden" id="dateInput" value="<?php echo  $_REQUEST["dateInput"] ?>" />
        <input name="titleDate" type="hidden" id="titleDate" value="<?php echo  $titleDate ?>" />
    </form>

    <form action="?" method="post" name="myForm" id="myForm">
        <input name="masterkey" type="hidden" id="masterkey" value="<?php echo  $_REQUEST['masterkey'] ?>" />
        <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo  $_REQUEST['menukeyid'] ?>" />
        <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo  $module_pageshow ?>" />
        <input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo  $module_pagesize ?>" />
        <input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo  $module_orderby ?>" />

        <div class="divRightNav">
            <table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td class="divRightNavTb" align="left"><span class="fontContantTbNav"><a href="<?php echo  $valLinkNav1 ?>" target="_self"><?php echo  $valNav1 ?></a> <img src="../img/btn/nav.png" align="absmiddle" vspace="5" /> <?php echo  $valNav2 ?></span></td>
                    <td class="divRightNavTb" align="right">
                    </td>
                </tr>
            </table>
        </div>
        <div style="clear:both;"></div>
        <div class="divRightHeadSearch">


            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:20px;" align="center">

                <!-- <tr>
                    <td class="selectSearch2">
                        <select name="inputSellID" id="inputSellID" onchange="document.myForm.submit();" class="formSelectSearchStyle">
                            <option value="0"><?php echo $langMod["tit:selectsell"] ?></option>
                            <?php
                            $sql_sell = "SELECT ";
                            $sql_sell .= "  " . $mod_tb_data . "_id," . $mod_tb_data . "_subject";
                            $sql_sell .= "  FROM " . $mod_tb_data . " WHERE  " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_sell . "'    ";
                            $sql_sell .= "  AND " . $mod_tb_data . "_status !='Disable' ";
                            $sql_sell .= "  ORDER BY " . $mod_tb_data . "_subject ASC  ";

                            $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell);
                            while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                                $row_sellid = $row_fb[0];
                                $valNamecShow = $row_fb[1];
                            ?>
                                <option value="<?php echo $row_sellid ?>" <?php if ($_REQUEST['inputSellID'] == $row_sellid) { ?> selected="selected" <?php  } ?>><?php echo $valNamecShow ?></option>
                            <?php  } ?>

                        </select>
                    </td>
                    <td class="selectSearch2">
                        <select name="inputStatusID" id="inputStatusID" onchange="document.myForm.submit();" class="formSelectSearchStyle">
                            <option value="0"><?php echo $langMod["tit:selectstatus"] ?></option>
                            <?php
                            $sql_status = "SELECT ";
                            $sql_status .= "  " . $mod_tb_data . "_id," . $mod_tb_data . "_subject";
                            $sql_status .= "  FROM " . $mod_tb_data . " WHERE  " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_status . "'    ";
                            $sql_status .= "  AND " . $mod_tb_data . "_status !='Disable' ";
                            $sql_status .= "  ORDER BY " . $mod_tb_data . "_order ASC  ";

                            $query_fb = wewebQueryDB($coreLanguageSQL, $sql_status);
                            while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                                $row_statusid = $row_fb[0];
                                $valNamecShow = $row_fb[1];
                            ?>
                                <option value="<?php echo $row_statusid ?>" <?php if ($_REQUEST['inputStatusID'] == $row_statusid) { ?> selected="selected" <?php  } ?>><?php echo $valNamecShow ?></option>
                            <?php  } ?>

                        </select>
                    </td>
                </tr> -->
                <tr>
                    <td class="selectSearch2">
                        <input name="sdateInput" type="text" id="sdateInput" placeholder="<?php echo $langMod["tit:sSedate"] ?>" autocomplete="off" value="<?php echo trim($_REQUEST['sdateInputSe']) ?>" class="formInputSearchStyle sdateInputSe" style="margin-bottom: 10px;" />


                    </td>
                    <td class="selectSearch4">
                        <input name="edateInput" type="text" id="edateInput" placeholder="<?php echo $langMod["tit:eSedate"] ?>" autocomplete="off" value="<?php echo trim($_REQUEST['edateInputSe']) ?>" class="formInputSearchStyle edateInputSe" style="margin-bottom: 10px;" />

                    </td>

                    <td class="bottonSearchStyle" align="left"><input name="searchOk" id="searchOk" onClick="document.myForm.submit();" type="button" class="btnSearch" value=" " /></td>
                </tr>




            </table>

        </div>
        <div class="divRightHead">
            <table width="96%" border="0" cellspacing="0" cellpadding="0" class="borderBottom" align="center">
                <tr>
                    <?php
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
        <div class="divRightMain">
            <table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" class="tbBoxListwBorder">
                <tr>
                    <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo  $langMod["tit:no"] ?></span></td>
                    <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo  $langMod["tit:dv"] ?></span></td>
                    <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo  $langMod["tit:regis"] ?></span></td>
                    <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo  $langMod["tit:deposit"] ?></span></td>
                    <td width="12%" class="divRightTitleTb" valign="middle" align="center"><span class="fontTitlTbRight"><?php echo  $langMod["tit:perfor"] ?></span></td>
                </tr>
                <?php

                // SQL SELECT #########################

                $sqlSelect = "" . $mod_tb_data . "_id as id,              
                " . $mod_tb_data . "_subject as subject
                ";

                $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_data;

                $sql = $sql . "  WHERE " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_dv . "'   ";
                $sql = $sql . "  AND " . $mod_tb_data . "_status !='Disable' ";

                ?>
                <input type="hidden" id="export" value="<?php echo $sql ?>">
                <input type="hidden" id="valSdate" value="<?php echo $valSdate ?>">
                <input type="hidden" id="valEdate" value="<?php echo $valEdate ?>">
                <?php


                $query = wewebQueryDB($coreLanguageSQL, $sql);
                $count_totalrecord = wewebNumRowsDB($coreLanguageSQL, $query);

                // Find max page size #########################
                if ($count_totalrecord > $module_pagesize) {
                    $numberofpage = ceil($count_totalrecord / $module_pagesize);
                } else {
                    $numberofpage = 1;
                }

                // Recover page show into range #########################
                if ($module_pageshow > $numberofpage) {
                    $module_pageshow = $numberofpage;
                }

                // 

                // Select only paging range #########################
                $recordstart = ($module_pageshow - 1) * $module_pagesize;

                if ($coreLanguageSQL == "mssql") {
                    $sql = "SELECT " . $sqlSelect . " FROM (SELECT RuningCount = ROW_NUMBER() OVER (ORDER BY " . $module_orderby . "  " . $module_adesc . " ),*  FROM   " . $mod_tb_root;
                    $sql .= "  WHERE " . $mod_tb_root . "_masterkey ='" . $_REQUEST['masterkey'] . "'   ";
                    $sql .= "   ) AS LogWithRowNumbers  WHERE   (RuningCount BETWEEN " . $recordstart . "  AND " . $module_pagesize . " )";
                    // $sql .= $sqlSearch;
                } else {
                    $sql .= " ORDER BY $mod_tb_data" . "_order " . " $module_adesc LIMIT $recordstart , $module_pagesize ";
                }

                $query = wewebQueryDB($coreLanguageSQL, $sql);
                $count_record = wewebNumRowsDB($coreLanguageSQL, $query);
                $index = 1;
                $valDivTr = "divSubOverTb";

                $year = date('Y');
                $month = date('m');
                $day = date('d');

                $sumApply = 0;
                $sumDeposit = 0;

                if ($count_record > 0) {
                    while ($index < $count_record + 1) {
                        $row = wewebFetchArrayDB($coreLanguageSQL, $query);

                        $valID = $row[0];
                        $valSubject = rechangeQuot($row['subject']);
                        $valApply = $row['apply'];
                        
                        $apply = countRegister($year, $month, $day, $valID, $valSdate, $valEdate);
                        $deposit = countDeposit($year, $month, $day, $valID, $valSdate, $valEdate);

                        $sumApply += $apply;
                        $sumDeposit += $deposit;

                        $percent = ($deposit / $apply) * 100;
                        if ($apply == 0) {
                            $percent = 0;
                        }

                        if ($valDivTr == "divSubOverTb") {
                            $valDivTr = "divOverTb";
                            $valImgCycle = "boxprofile_l.png";
                        } else {
                            $valDivTr = "divSubOverTb";
                            $valImgCycle = "boxprofile_w.png";
                        }

                ?>
                        <tr class="<?php echo  $valDivTr ?>">

                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo  $index ?></span>
                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class=""><a href="daily.php?menukeyid=<?php echo $_REQUEST['menukeyid'] ?>&dvid=<?php echo $valID ?>&dvName=<?php echo $valSubject ?>&dateInput=<?php echo $month ?>-<?php echo $year ?>" target="_self"><?php echo  $valSubject ?></a></span>

                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo  number_format($apply, 0) ?></span>
                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo  number_format($deposit, 0) ?></span>
                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo  number_format($percent, 2) ?>%</span>
                            </td>

                        </tr>

                    <?php
                        $index++;
                    } ?>

                    <?php 

                    $percentTotal =  ($sumDeposit / $sumApply) * 100;
                    if ($sumApply == 0) {
                        $percentTotal = 0;
                    }
                    if ($valDivTr == "divSubOverTb") {
                        $valDivTr = "divOverTb";
                        $valImgCycle = "boxprofile_l.png";
                    } else {
                        $valDivTr = "divSubOverTb";
                        $valImgCycle = "boxprofile_w.png";
                    }
                    ?>

                        <tr class="<?php echo  $valDivTr ?>">

                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo  $index ?></span>
                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class=""><a href="daily.php?menukeyid=<?php echo $_REQUEST['menukeyid'] ?>&dvid=0&dvName=<?php echo $langMod["tit:total"] ?>&dateInput=<?php echo $month ?>-<?php echo $year ?>" target="_self"><?php echo $langMod["tit:total"] ?></a></span>
                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo  number_format($sumApply, 0) ?></span>
                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo  number_format($sumDeposit, 0) ?></span>
                            </td>
                            <td class="divRightContantOverTb" valign="top" align="center">
                                <span class="fontContantTbTime"><?php echo  number_format($percentTotal, 2) ?>%</span>
                            </td>

                        </tr>

                <?php } else {
                    ?>
                    <tr>
                        <td colspan="6" align="center" valign="middle" class="divRightContantTbRL" style="padding-top:150px; padding-bottom:150px;"><?php echo  $langTxt["mg:nodate"] ?></td>
                    </tr>
                <?php } ?>

               

                <tr>
                    <td colspan="6" align="center" valign="middle" class="divRightContantTbRL">
                        <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                                <td class="divRightNavTb" align="left"><span class="fontContantTbNavPage"><?php echo  $langTxt["pr:All"] ?> <b><?php echo  number_format($count_totalrecord) ?></b> <?php echo  $langTxt["pr:record"] ?> </span></td>
                                <td class="divRightNavTb" align="right">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="right" style="padding-right:10px;"><span class="fontContantTbNavPage"><?php echo  $langTxt["pr:page"] ?>
                                                    <?php if ($numberofpage > 1) { ?>
                                                        <select name="toolbarPageShow" class="formSelectContantPage" onChange="document.myForm.module_pageshow.value = this.value;
                                                                    document.myForm.submit();
                                                                    ">
                                                            <?php
                                                            if ($numberofpage < $module_default_maxpage) {
                                                                // Show page list #########################
                                                                for ($i = 1; $i <= $numberofpage; $i++) {
                                                                    echo "<option value=\"$i\"";
                                                                    if ($i == $module_pageshow) {
                                                                        echo " selected";
                                                                    }
                                                                    echo ">$i</option>";
                                                                }
                                                            } else {
                                                                // # If total page count greater than default max page  value then reduce page select size #########################
                                                                $starti = $module_pageshow - $module_default_reduce;
                                                                if ($starti < 1) {
                                                                    $starti = 1;
                                                                }
                                                                $endi = $module_pageshow + $module_default_reduce;
                                                                if ($endi > $numberofpage) {
                                                                    $endi = $numberofpage;
                                                                }
                                                                //#####################
                                                                for ($i = $starti; $i <= $endi; $i++) {
                                                                    echo "<option value=\"$i\"";
                                                                    if ($i == $module_pageshow) {
                                                                        echo " selected";
                                                                    }
                                                                    echo ">$i</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    <?php } else { ?>
                                                        <b><?php echo  $module_pageshow ?></b>
                                                    <?php } ?>
                                                    <?php echo  $langTxt["pr:of"] ?> <b><?php echo  $numberofpage ?></b></span></td>
                                            <?php if ($module_pageshow > 1) { ?>
                                                <td width="21" align="center"> <img src="../img/controlpage/playset_start.gif" width="21" height="21" onmouseover="this.src = '../img/controlpage/playset_start_active.gif';
                                                                                                this.style.cursor = 'hand';" onmouseout="this.src = '../img/controlpage/playset_start.gif';" onclick="document.myForm.module_pageshow.value = 1;
                                                                                                document.myForm.submit();" style="cursor:pointer;" /></td>
                                            <?php } else { ?>
                                                <td width="21" align="center"><img src="../img/controlpage/playset_start_disable.gif" width="21" height="21" /></td>
                                            <?php } ?>
                                            <?php
                                            if ($module_pageshow > 1) {
                                                $valPrePage = $module_pageshow - 1;
                                            ?>
                                                <td width="21" align="center"> <img src="../img/controlpage/playset_backward.gif" width="21" height="21" style="cursor:pointer;" onmouseover="this.src = '../img/controlpage/playset_backward_active.gif';
                                                                                                this.style.cursor = 'hand';" onmouseout="this.src = '../img/controlpage/playset_backward.gif';" onclick="document.myForm.module_pageshow.value = '<?php echo  $valPrePage ?>';
                                                                                                document.myForm.submit();" /></td>
                                            <?php } else { ?>
                                                <td width="21" align="center"><img src="../img/controlpage/playset_backward_disable.gif" width="21" height="21" /></td>
                                            <?php } ?>
                                            <td width="21" align="center"> <img src="../img/controlpage/playset_stop.gif" width="21" height="21" style="cursor:pointer;" onmouseover="this.src = '../img/controlpage/playset_stop_active.gif';
                                                                                            this.style.cursor = 'hand';" onmouseout="this.src = '../img/controlpage/playset_stop.gif';" onclick="
                                                                                            with (document.myForm) {
                                                                                                module_pageshow.value = '';
                                                                                                module_pagesize.value = '';
                                                                                                module_orderby.value = '';
                                                                                                document.myForm.submit();
                                                                                            }
                                                                                    " /></td>
                                            <?php
                                            if ($module_pageshow < $numberofpage) {
                                                $valNextPage = $module_pageshow + 1;
                                            ?>
                                                <td width="21" align="center"> <img src="../img/controlpage/playset_forward.gif" width="21" height="21" style="cursor:pointer;" onmouseover="this.src = '../img/controlpage/playset_forward_active.gif';
                                                                                                this.style.cursor = 'hand';" onmouseout="this.src = '../img/controlpage/playset_forward.gif';" onclick="document.myForm.module_pageshow.value = '<?php echo  $valNextPage ?>';
                                                                                                document.myForm.submit();" /></td>
                                            <?php } else { ?>
                                                <td width="10" align="center"><img src="../img/controlpage/playset_forward_disable.gif" width="21" height="21" /></td>
                                            <?php } ?>
                                            <?php if ($module_pageshow < $numberofpage) { ?>
                                                <td width="10" align="center"><img src="../img/controlpage/playset_end.gif" width="21" height="21" style="cursor:pointer;" onmouseover="this.src = '../img/controlpage/playset_end_active.gif';
                                                                                               this.style.cursor = 'hand';" onmouseout="this.src = '../img/controlpage/playset_end.gif';" onclick="document.myForm.module_pageshow.value = '<?php echo  $numberofpage ?>';
                                                                                               document.myForm.submit();" /></td>
                                            <?php } else { ?>
                                                <td width="10" align="center"><img src="../img/controlpage/playset_end_disable.gif" width="21" height="21" /></td>
                                            <?php } ?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <input name="TotalCheckBoxID" type="hidden" id="TotalCheckBoxID" value="<?php echo  $index - 1 ?>" />
            <div class="divRightContantEnd"></div>

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