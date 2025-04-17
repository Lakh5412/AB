<?php
include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("../lib/checkMember.php");
include("config.php");

	if($_REQUEST['execute']=="insert"){
		$sql = "SELECT MAX(".$mod_tb_root."_order) FROM ".$mod_tb_root;
		$Query=wewebQueryDB($coreLanguageSQL,$sql);
		$Row=wewebFetchArrayDB($coreLanguageSQL,$Query);
		$maxOrder = $Row[0]+1;
		
		$insert=array();
		$insert[$mod_tb_root."_language"] = "'".$_SESSION[$valSiteManage.'core_session_language']."'";
		$insert[$mod_tb_root."_masterkey"] = "'".$_REQUEST["masterkey"]."'";

		$insert[$mod_tb_root."_subject"] = "'".changeQuot($_REQUEST['inputSubject'])."'";
		$insert[$mod_tb_root."_title"]="'".changeQuot($_REQUEST['inputTitle'])."'";
		$insert[$mod_tb_root."_detail"]="'".changeQuot($_REQUEST['inputDetail'])."'";
		
		$insert[$mod_tb_root."_fbid"]="'".$_REQUEST['inputFbID']."'";
		$insert[$mod_tb_root."_sellid"]="'".$_REQUEST['inputSellID']."'";
		$insert[$mod_tb_root."_dvid"]="'".$_REQUEST['inputDvID']."'";
		$insert[$mod_tb_root."_statusid"]="'".$_REQUEST['inputStatusID']."'";
		
		$insert[$mod_tb_root."_crebyid"] = "'".$_SESSION[$valSiteManage.'core_session_id']."'";
		$insert[$mod_tb_root."_creby"] = "'".$_SESSION[$valSiteManage.'core_session_name']."'";
		$insert[$mod_tb_root."_lastbyid"] = "'".$_SESSION[$valSiteManage.'core_session_id']."'";
		$insert[$mod_tb_root."_lastby"] = "'".$_SESSION[$valSiteManage.'core_session_name']."'";
		
		$insert[$mod_tb_root."_credate"] = "".wewebNow($coreLanguageSQL)."";
		$insert[$mod_tb_root."_lastdate"] = "".wewebNow($coreLanguageSQL)."";
		$insert[$mod_tb_root."_status"] = "'Disable'";
		$insert[$mod_tb_root."_order"] = "'".$maxOrder."'";
		$sql="INSERT INTO ".$mod_tb_root."(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
		$Query=wewebQueryDB($coreLanguageSQL,$sql);
		$contantID = wewebInsertID($coreLanguageSQL,$mod_tb_root,$mod_tb_root."_id");

		 logs_access('3','Insert');
		 } ?>
<?php include("../lib/disconnect.php");?>
<form action="index.php" method="post" name="myFormAction" id="myFormAction">
    <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST['masterkey']?>" />
    <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST['menukeyid']?>" />
    <input name="inputSearch" type="hidden" id="inputSearch" value="<?php echo $_REQUEST['inputSearch']?>" />
    <input name="inputGh" type="hidden" id="inputGh" value="<?php echo $_REQUEST['inputGh']?>" />
    <input name="inputTh" type="hidden" id="inputTh" value="<?php echo $_REQUEST['inputTh']?>" />

</form>
<script language="JavaScript" type="text/javascript"> document.myFormAction.submit(); </script>
