<?php
@include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("incModLang.php");
include("config.php");
	$sql_cat = "SELECT ".$mod_tb_product."_id,".$mod_tb_product."_subject,".$mod_tb_product."_subjecten  FROM ".$mod_tb_product." WHERE  ".$mod_tb_product."_masterkey ='cr'    ";
$sql_cat = $sql_cat."  AND ".$mod_tb_product."_gid ='".$_REQUEST['inputGroupID']."'   ";
 $sql_cat = $sql_cat."  ORDER BY ".$mod_tb_product."_order DESC  ";

?>
<select name="inputTypeID"  id="inputTypeID"class="formSelectContantTb" >
        <option value="0"><?php echo $langMod["tit:selectt"]?></option>
              <?php 
		$query_cat=wewebQueryDB($coreLanguageSQL,$sql_cat);
		while($row_cat=wewebFetchArrayDB($coreLanguageSQL,$query_cat)) {
		$row_catid=$row_cat[0];
		$row_catname=$row_cat[1];
		$row_catnameeng=$row_cat[2];
					if($_SESSION[$valSiteManage.'core_session_language']=="Thai"){
							$valNamecShow=$row_catname;
					}else if($_SESSION[$valSiteManage.'core_session_language']=="Eng"){
							$valNamecShow=$row_catnameeng;
					}
		?>
        <option value="<?php echo $row_catid?>" <?php  if($_REQUEST['inputTh']==$row_catid){ ?> selected="selected" <?php  }?>><?php echo $valNamecShow?></option>
        <?php  }?>

    </select>
	<?php include("../lib/disconnect.php");?>
