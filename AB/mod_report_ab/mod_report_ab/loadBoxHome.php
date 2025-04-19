<?php
include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("../lib/checkMember.php");
include("../core/incLang.php");

$sqlChk = "SELECT ".$core_tb_menu."_id,".$core_tb_menu."_linkpath FROM ".$core_tb_menu;
$sqlChk = $sqlChk."  WHERE ".$core_tb_menu."_masterkey ='".$_REQUEST['masterkey']."'";
$queryChk=wewebQueryDB($coreLanguageSQL,$sqlChk);
$rowChk=wewebFetchArrayDB($coreLanguageSQL,$queryChk);
$pathArr = explode("/",$rowChk[1]);

include("../".$pathArr[1]."/incModLang.php");
include("../".$pathArr[1]."/config.php");

$sqlSelect = "".$mod_tb_root."_id,".$mod_tb_root."_subject,".$mod_tb_root."_lastdate,".$mod_tb_root."_status ";

	if($coreLanguageSQL=="mssql"){
	$valLimitTop ="TOP (5)";
	$valLimitMysql ="";
	}else{
	$valLimitTop ="";
	$valLimitMysql =" LIMIT 0,5";
	}

$sql = "SELECT ".$valLimitTop." ".$sqlSelect."  FROM ".$mod_tb_root;
$sql = $sql."  WHERE ".$mod_tb_root."_masterkey ='".$_REQUEST['masterkey']."'  ORDER BY ".$mod_tb_root."_order DESC ".$valLimitMysql."";
	$query=wewebQueryDB($coreLanguageSQL,$sql) ;
	$recordCount=wewebNumRowsDB($coreLanguageSQL,$query);
	if($recordCount>=1){
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php
    while($row=wewebFetchArrayDB($coreLanguageSQL,$query)) {
		$valID=$row[0];
		$valName=$row[1];
	 	$valDateCredate = dateFormatReal($row[2]);
		 $valTimeCredate = timeFormatReal($row[2]);
		$valStatus=$row[3];
		$valNameShow=$valName;
		
    ?>
  <tr>
    <td width="31" align="center" height="25" valign="top">&bull;</td>
    <td  align="left"  valign="top"><a href="../<?php echo $mod_fd_root?>/viewContant.php?masterkey=<?php echo $_REQUEST['masterkey']?>&menukeyid=<?php echo $_REQUEST['menukeyid']?>&viewID=1&inputLt=<?php echo $_SESSION[$valSiteManage.'core_session_language']?>&valEditID=<?php echo $valID?>" class="moreDetailAb"><?php echo txtLimit($valNameShow,45)?></a></td>
  </tr>
  <?php  } ?>
  </table>

<?php }else{?>
<div style="height:140px; overflow:hidden;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="125" align="center" valign="middle"><?php echo $langTxt["mg:nodate"]?></td>
    </tr>
</table>
</div>
<?php }?>

<script type="text/javascript">
	jQuery(function() {
		jQuery(".moreDetailAb").colorbox({width:"950", height:"600"});
	});
</script>
