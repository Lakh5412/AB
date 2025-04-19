<?php
include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("../lib/checkMember.php");
include("../core/incLang.php");
include("config.php");
include("incModLang.php");

$valClassNav = 2;
$valNav1 = $langTxt["nav:home2"];
$valLinkNav1 = "../core/index.php";

$myRand = time() . rand(111, 999);
$valPermission = getUserPermissionOnMenu($_SESSION[$valSiteManage . "core_session_groupid"], $_POST["menukeyid"]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
  <link href="../css/theme.css" rel="stylesheet" />
  <link rel="stylesheet" href="../js/select2/css/select2.css">

  <title><?php echo $core_name_title ?></title>
  <script language="JavaScript" type="text/javascript" src="../js/scriptCoreWeweb.js"></script>
  <script language="JavaScript" type="text/javascript" src="../js/select2/js/select2.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="js/script.js"></script>
  <script language="JavaScript" type="text/javascript">
    function executeSubmit() {
      with(document.myForm) {

        // var valCountry= jQuery('input:checkbox[class=formRadioContantTbCountry]').is(':checked');
        // if(valCountry==false){
        // 		jQuery( "input:checkbox[class=formRadioContantTbCountry]" ).focus();
        // 		return false;
        // }
        if (inputFbID.value == 0) {
            inputFbID.focus();
            jQuery("#inputFbID").addClass("formInputContantTbAlertY");
            return false;
        } else {
            jQuery("#inputFbID").removeClass("formInputContantTbAlertY");
        }
        if (inputSellID.value == 0) {
            inputSellID.focus();
            jQuery("#inputSellID").addClass("formInputContantTbAlertY");
            return false;
        } else {
            jQuery("#inputSellID").removeClass("formInputContantTbAlertY");
        }
        if (inputDvID.value == 0) {
            inputDvID.focus();
            jQuery("#inputDvID").addClass("formInputContantTbAlertY");
            return false;
        } else {
            jQuery("#inputDvID").removeClass("formInputContantTbAlertY");
        }

        if (isBlank(inputSubject)) {
          inputSubject.focus();
          jQuery("#inputSubject").addClass("formInputContantTbAlertY");
          return false;
        } else {
          jQuery("#inputSubject").removeClass("formInputContantTbAlertY");
        }
        if (isBlank(inputTitle)) {
          inputTitle.focus();
          jQuery("#inputTitle").addClass("formInputContantTbAlertY");
          return false;
        } else {
          jQuery("#inputTitle").removeClass("formInputContantTbAlertY");
        }
        if (inputStatusID.value == 0) {
            inputStatusID.focus();
            jQuery("#inputStatusID").addClass("formInputContantTbAlertY");
            return false;
        } else {
            jQuery("#inputStatusID").removeClass("formInputContantTbAlertY");
        }
        
      

        // if(isBlank(inputValue)) {
        // 	inputValue.focus();
        // 	jQuery("#inputValue").addClass("formInputContantTbAlertY");
        // 	return false;
        // }else{
        // 	jQuery("#inputValue").removeClass("formInputContantTbAlertY");
        // }

        // if(isBlank(inputTitle)) {
        // 	inputTitle.focus();
        // 	jQuery("#inputTitle").addClass("formInputContantTbAlertY");
        // 	return false;
        // }else{
        // 	jQuery("#inputTitle").removeClass("formInputContantTbAlertY");
        // }



        // if(isBlank(inputurl)) {
        // 	inputurl.focus();
        // 	jQuery("#inputurl").addClass("formInputContantTbAlertY");
        // 	return false;
        // }else{
        // 	jQuery("#inputurl").removeClass("formInputContantTbAlertY");
        // }


        // if(inputurl.value=="http://") {
        // 	inputurl.focus();
        // 	jQuery("#inputurl").addClass("formInputContantTbAlertY");
        // 	return false;
        // }else{
        // 	jQuery("#inputurl").removeClass("formInputContantTbAlertY");
        // }


      }

      insertContactNew('insertContant.php');

    }
  </script>
</head>

<body>
  <form action="?" method="POST" name="myForm" id="myForm" enctype="multipart/form-data">
    <input name="execute" type="hidden" id="execute" value="insert" />
    <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST['masterkey'] ?>" />
    <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST['menukeyid'] ?>" />
    <input name="inputSearch" type="hidden" id="inputSearch" value="<?php echo $_REQUEST['inputSearch'] ?>" />
    <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST['module_pageshow'] ?>" />
    <input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST['module_pagesize'] ?>" />
    <input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST['module_orderby'] ?>" />
    <input name="inputGh" type="hidden" id="inputGh" value="<?php echo $_REQUEST['inputGh'] ?>" />
    <input name="valEditID" type="hidden" id="valEditID" value="<?php echo $myRand ?>" />
    <input name="valDelFile" type="hidden" id="valDelFile" value="" />
    <input name="valDelAlbum" type="hidden" id="valDelAlbum" value="" />
    <input name="inputHtml" type="hidden" id="inputHtml" value="" />
    <input name="inputHtmlDel" type="hidden" id="inputHtmlDel" value="<?php echo $valhtmlname ?>" />
    <input name="inputLt" type="hidden" id="inputLt" value="<?php echo $_REQUEST['inputLt'] ?>" />
    <div class="divRightNav">
      <table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td class="divRightNavTb" align="left" id="defTop"><span class="fontContantTbNav"><a href="<?php echo $valLinkNav1 ?>" target="_self"><?php echo $valNav1 ?></a> <img src="../img/btn/nav.png" align="absmiddle" vspace="5" /> <a href="javascript:void(0)" onclick="btnBackPage('index.php')" target="_self"><?php echo getNameMenu($_REQUEST["menukeyid"]) ?></a> <img src="../img/btn/nav.png" align="absmiddle" vspace="5" /> <?php echo $langMod["txt:titleadd"] ?></span></td>
          <td class="divRightNavTb" align="right">



          </td>
        </tr>
      </table>
    </div>
    <div class="divRightHead">
      <table width="96%" border="0" cellspacing="0" cellpadding="0" class="borderBottom" align="center">
        <tr>
          <td height="77" align="left"><span class="fontHeadRight"><?php echo $langMod["txt:titleadd"] ?></span></td>
          <td align="left">
            <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
                <td align="right">
                  <?php if ($valPermission == "RW") { ?>
                    <div class="btnSave" title="<?php echo $langTxt["btn:save"] ?>" onclick="executeSubmit();"></div>
                  <?php } ?>
                  <div class="btnBack" title="<?php echo $langTxt["btn:back"] ?>" onclick="btnBackPage('index.php')"></div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
    <div class="divRightMain">
      <br />
      <table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" class="tbBoxViewBorder ">
        <tr>
          <td colspan="7" align="left" valign="middle" class="formTileTxt tbBoxViewBorderBottom">
            <span class="formFontSubjectTxt"><?php echo $langMod["txt:subject"] ?></span><br />
            <span class="formFontTileTxt"><?php echo $langMod["txt:subjectDe"] ?></span>
          </td>
        </tr>
        <tr>
          <td colspan="7" align="right" valign="top" height="15"></td>
        </tr>



        <tr>
          <td width="18%" align="right" valign="top" class="formLeftContantTb"><?php echo  $langMod["tit:selectfbn"] ?><span class="fontContantAlert">*</span></td>
          <td width="82%" colspan="6" align="left" valign="top" class="formRightContantTb" id="boxSubSelect">
            <select name="inputFbID" id="inputFbID" class="formSelectContantTb select2">
              <option value="0"><?php echo $langMod["tit:selectfb"] ?></option>
              <?php
              $sql_fb = "SELECT ";
              $sql_fb .= "  " . $mod_tb_data . "_id," . $mod_tb_data . "_subject";
              $sql_fb .= "  FROM " . $mod_tb_data . " WHERE  " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_fb . "'    ";
              $sql_fb .= "  AND " . $mod_tb_data . "_status !='Disable' ";
              $sql_fb .= "  ORDER BY " . $mod_tb_data . "_order DESC  ";

              $query_fb = wewebQueryDB($coreLanguageSQL, $sql_fb);
              while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                $row_fbid = $row_fb[0];
                $valNamecShow = $row_fb[1];
              ?>
                <option value="<?php echo $row_fbid ?>" <?php if ($_REQUEST['inputSG'] == $row_fbid) { ?> selected="selected" <?php  } ?>><?php echo $valNamecShow ?></option>
              <?php  } ?>

            </select>
          </td>
        </tr>
        <tr>
          <td width="18%" align="right" valign="top" class="formLeftContantTb"><?php echo  $langMod["tit:selectselln"] ?><span class="fontContantAlert">*</span></td>
          <td width="82%" colspan="6" align="left" valign="top" class="formRightContantTb" id="boxSubSelect">
            <select name="inputSellID" id="inputSellID" class="formSelectContantTb select2">
              <option value="0"><?php echo $langMod["tit:selectsell"] ?></option>
              <?php
              $sql_sell = "SELECT ";
              $sql_sell .= "  " . $mod_tb_data . "_id," . $mod_tb_data . "_subject";
              $sql_sell .= "  FROM " . $mod_tb_data . " WHERE  " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_sell . "'    ";
              $sql_sell .= "  AND " . $mod_tb_data . "_status !='Disable' ";
              $sql_sell .= "  ORDER BY " . $mod_tb_data . "_order DESC  ";

              $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell);
              while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                $row_sellid = $row_fb[0];
                $valNamecShow = $row_fb[1];
              ?>
                <option value="<?php echo $row_sellid ?>" <?php if ($_REQUEST['inputSG'] == $row_sellid) { ?> selected="selected" <?php  } ?>><?php echo $valNamecShow ?></option>
              <?php  } ?>

            </select>
          </td>
        </tr>
        <tr>
          <td width="18%" align="right" valign="top" class="formLeftContantTb"><?php echo  $langMod["tit:selectdvn"] ?><span class="fontContantAlert">*</span></td>
          <td width="82%" colspan="6" align="left" valign="top" class="formRightContantTb" id="boxSubSelect">
            <select name="inputDvID" id="inputDvID" class="formSelectContantTb select2">
              <option value="0"><?php echo $langMod["tit:selectdv"] ?></option>
              <?php
              $sql_dv = "SELECT ";
              $sql_dv .= "  " . $mod_tb_data . "_id," . $mod_tb_data . "_subject";
              $sql_dv .= "  FROM " . $mod_tb_data . " WHERE  " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_dv . "'    ";
              $sql_dv .= "  AND " . $mod_tb_data . "_status !='Disable' ";
              $sql_dv .= "  ORDER BY " . $mod_tb_data . "_order DESC  ";

              $query_fb = wewebQueryDB($coreLanguageSQL, $sql_dv);
              while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                $row_dvid = $row_fb[0];
                $valNamecShow = $row_fb[1];
              ?>
                <option value="<?php echo $row_dvid ?>" <?php if ($_REQUEST['inputSG'] == $row_dvid) { ?> selected="selected" <?php  } ?>><?php echo $valNamecShow ?></option>
              <?php  } ?>

            </select>
          </td>
        </tr>

        <tr>
          <td width="18%" align="right" valign="top" class="formLeftContantTb"><?php echo $langMod["tit:inpSoc"] ?><span class="fontContantAlert">*</span></td>
          <td width="82%" colspan="6" align="left" valign="top" class="formRightContantTb"><input name="inputSubject" id="inputSubject" type="text" class="formInputContantTb" /></td>
        </tr>

        <tr>
          <td width="18%" align="right" valign="top" class="formLeftContantTb"><?php echo $langMod["tit:inpcuid"] ?><span class="fontContantAlert">*</span></td>
          <td width="82%" colspan="6" align="left" valign="top" class="formRightContantTb"><input name="inputTitle" id="inputTitle" type="text" class="formInputContantTb" /></td>
        </tr>

        <tr>
          <td width="18%" align="right" valign="top" class="formLeftContantTb"><?php echo  $langMod["tit:selectstatusn"] ?><span class="fontContantAlert">*</span></td>
          <td width="82%" colspan="6" align="left" valign="top" class="formRightContantTb" id="boxSubSelect">
            <select name="inputStatusID" id="inputStatusID" class="formSelectContantTb select2">
              <option value="0"><?php echo $langMod["tit:selectstatus"] ?></option>
              <?php
              $sql_status = "SELECT ";
              $sql_status .= "  " . $mod_tb_data . "_id," . $mod_tb_data . "_subject";
              $sql_status .= "  FROM " . $mod_tb_data . " WHERE  " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_status . "'    ";
              $sql_status .= "  AND " . $mod_tb_data . "_status !='Disable' ";
              $sql_status .= "  ORDER BY " . $mod_tb_data . "_order DESC  ";

              $query_fb = wewebQueryDB($coreLanguageSQL, $sql_status);
              while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                $row_statusid = $row_fb[0];
                $valNamecShow = $row_fb[1];
              ?>
                <option value="<?php echo $row_statusid ?>" <?php if ($_REQUEST['inputSG'] == $row_statusid) { ?> selected="selected" <?php  } ?>><?php echo $valNamecShow ?></option>
              <?php  } ?>

            </select>
          </td>
        </tr>

        <tr>
          <td width="18%" align="right" valign="top" class="formLeftContantTb"><?php echo $langMod["tit:detail"] ?><span class="fontContantAlert"></span></td>
          <td width="82%" colspan="6" align="left" valign="top" class="formRightContantTb"><textarea name="inputDetail" id="inputDetail" cols="45" rows="5" class="formTextareaContantTb"></textarea></td>
        </tr>

      </table>


      <br />
      <table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">

        <tr>
          <td colspan="7" align="right" valign="top" height="20"></td>
        </tr>
        <tr>
          <td colspan="7" align="right" valign="middle" class="formEndContantTb"><a href="#defTop" title="<?php echo $langTxt["btn:gototop"] ?>"><?php echo $langTxt["btn:gototop"] ?> <img src="../img/btn/top.png" align="absmiddle" /></a></td>
        </tr>
      </table>
    </div>
  </form>
  <script type="text/javascript" src="../js/ajaxfileupload.js"></script>

  <?php if ($_SESSION[$valSiteManage . 'core_session_language'] == "Thai") { ?>
    <script language="JavaScript" type="text/javascript" src="../js/datepickerThai.js"></script>
  <?php } else { ?>
    <script language="JavaScript" type="text/javascript" src="../js/datepickerEng.js"></script>
  <?php } ?>

  <?php include("../lib/disconnect.php"); ?>

</body>

</html>