<?php
## Mod Table ###################################
$mod_tb_root = "md_user";
$mod_tb_data = "md_data";
$mod_masterkey_fb = "fb";
$mod_masterkey_sell = "sell";
$mod_masterkey_team = "team";
$mod_masterkey_dv = "dv";

$mod_masterkey_status = "status";

## Mod Folder ###################################
$mod_fd_root = "mod_report_ab";

## Setting Value ###################################
$modTxtTarget=array("","เปิดหน้าต่างเดิม","เปิดหน้าต่างใหม่");
$modTxtPosition=array("","ซ้าย","ขวา");

## Size Pic ###################################
$sizeWidthReal="468";
$sizeHeightReal="60";

$sizeWidthPic="468";
$sizeHeightPic="60";

$sizeWidthOff="50";
$sizeHeightOff="50";

## Mod Path ###################################
$mod_path_office        = $core_pathname_upload."/".$masterkey."/office";
$mod_path_office_fornt  = $core_pathname_upload_fornt."/".$masterkey."/office";

$mod_path_real        = $core_pathname_upload."/".$masterkey."/real";
$mod_path_real_fornt  = $core_pathname_upload_fornt."/".$masterkey."/real";

$mod_path_pictures        = $core_pathname_upload."/".$masterkey."/pictures";
$mod_path_pictures_fornt  = $core_pathname_upload_fornt."/".$masterkey."/pictures";


function countTypeRegister($year = null, $month = null, $day = null, $dvid = 0)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;

    $sql = $sql . " WHERE " . $mod_tb_root . "_dvid = '" . $dvid . "'";
    
        $sql = $sql . " AND YEAR(" . $mod_tb_root . "_date)='" . $year . "'   ";
        $sql = $sql . " AND MONTH(" . $mod_tb_root . "_date)='" . $month . "'   ";   
    
        // $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (1,188)";
    

    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}
function countTypeDeposit($year = null, $month = null, $day = null, $dvid = 0)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;
    $sql = $sql . " WHERE " . $mod_tb_root . "_dvid = '" . $dvid . "'";

 
        $sql = $sql . " AND YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
        $sql = $sql . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "'   ";   
    

        // $sql = $sql . " AND " . $mod_tb_root . "_statusid = '188'";  
        $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (187,188)";
    

    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}


function countRegister($year = null, $month = null, $day = null, $dvid = 0,$sellid = 0, $valSdate = "",$valEdate = "")
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;

    if ($valSdate != "") {
        $sql = $sql . "  WHERE  (" . $mod_tb_root . "_date BETWEEN '" . $valSdate . " 00:00:00' AND '" . $valEdate . " 23:59:59')  ";
    } else {
        $sql = $sql . " WHERE YEAR(" . $mod_tb_root . "_date)='" . $year . "'   ";
        $sql = $sql . " AND MONTH(" . $mod_tb_root . "_date)='" . $month . "'   ";   
        $sql = $sql . " AND DAY(" . $mod_tb_root . "_date)='" . $day . "'   "; 
    }

    // $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (1,188)";  

    if ($dvid != 0) {
        $sql = $sql . " AND " . $mod_tb_root . "_dvid = '" . $dvid . "'";   
    }

    if ($sellid != 0) {
        $sql = $sql . " AND " . $mod_tb_root . "_sellid IN (" . $sellid . ")";
    }

    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}

function countDeposit($year = null, $month = null, $day = null, $dvid = 0,$sellid = 0, $valSdate = "",$valEdate = "")
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;

        if ($valSdate != "") {
            $sql = $sql . "  WHERE  (" . $mod_tb_root . "_edate BETWEEN '" . $valSdate . " 00:00:00' AND '" . $valEdate . " 23:59:59')  ";
        } else {
            $sql = $sql . " WHERE YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
            $sql = $sql . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "'   ";   
            $sql = $sql . " AND DAY(" . $mod_tb_root . "_edate)='" . $day . "'   "; 
        }


    $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (187,188)";  

        if ($dvid != 0) {
            $sql = $sql . " AND " . $mod_tb_root . "_dvid = '" . $dvid . "'";   
        }

        if ($sellid != 0) {
            $sql = $sql . " AND " . $mod_tb_root . "_sellid IN (" . $sellid . ")";
        }

    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}



function countRegisterTotal($year = null, $month = null, $day = null, $valSdate = "",$valEdate = "",$status = 0)
{
    global $coreLanguageSQL, $mod_tb_root, $mod_tb_data;

    $sql = "SELECT 
    " . $mod_tb_root . "_sellid as sellid
      FROM " . $mod_tb_root;
    $sql = $sql . " WHERE " . $mod_tb_root . "_dvid='244' ";

    if ($valSdate != "") {
        $sql = $sql . "  AND  (" . $mod_tb_root . "_date BETWEEN '" . $valSdate . " 00:00:00' AND '" . $valEdate . " 23:59:59')  ";
    } else {
        $sql = $sql . " AND YEAR(" . $mod_tb_root . "_date)='" . $year . "'   ";
        $sql = $sql . " AND MONTH(" . $mod_tb_root . "_date)='" . $month . "'   ";   
        $sql = $sql . " AND DAY(" . $mod_tb_root . "_date)='" . $day . "'   "; 
    }

    // $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (1,188)";
    
    $sql = $sql . " GROUP BY sellid "; 

    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $count_record = wewebNumRowsDB($coreLanguageSQL, $query);

    $arrSell = array();

    if ($count_record >= 1) {
        while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
            array_push($arrSell, $row[0]);
        }
    }
    
    $sql = "SELECT COUNT(" . $mod_tb_root . "_id) as count FROM " . $mod_tb_root;
    $sql = $sql . " WHERE " . $mod_tb_root . "_sellid IN (".implode(",",$arrSell).") ";
    if ($valSdate != "") {
        $sql = $sql . "  AND  (" . $mod_tb_root . "_edate BETWEEN '" . $valSdate . " 00:00:00' AND '" . $valEdate . " 23:59:59')  ";
    } else {
        $sql = $sql . " AND YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
        $sql = $sql . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "'   ";   
        $sql = $sql . " AND DAY(" . $mod_tb_root . "_edate)='" . $day . "'   "; 
    }
    if ($status == 1) {
        // $sql = $sql . " AND " . $mod_tb_root . "_statusid = '188'";  
        $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (187,188)";
    }

    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}

function checkDV($year = null, $month = null, $day = null,$sellid = 0)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;
    $sql = $sql . " WHERE YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
    $sql = $sql . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "'   ";
    $sql = $sql . " AND DAY(" . $mod_tb_root . "_edate)='" . $day . "'   ";
    $sql = $sql . " AND " . $mod_tb_root . "_dvid='244' ";

    if ($sellid != 0) {
        $sql = $sql . " AND " . $mod_tb_root . "_sellid = '" . $sellid . "'";
    }


    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}



function countTotal($year = null, $month = null, $day = null,$status = 0)
{
    global $coreLanguageSQL, $mod_tb_root, $mod_tb_data;

    $sql = "SELECT 
    " . $mod_tb_root . "_sellid as sellid
      FROM " . $mod_tb_root;
    $sql = $sql . " WHERE " . $mod_tb_root . "_dvid='244' ";

   
        $sql = $sql . " AND YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
        $sql = $sql . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "'   ";   
        $sql = $sql . " AND DAY(" . $mod_tb_root . "_edate)='" . $day . "'   "; 
    
    
    $sql = $sql . " GROUP BY sellid "; 

    // print_pre($sql);
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $count_record = wewebNumRowsDB($coreLanguageSQL, $query);

    $arrSell = array();

    if ($count_record >= 1) {
        while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
            array_push($arrSell, $row[0]);
        }
    }else{
        $arrSell[] = 0;
    }
    
    $sql = "SELECT COUNT(" . $mod_tb_root . "_id) as count FROM " . $mod_tb_root;
    $sql = $sql . " WHERE " . $mod_tb_root . "_sellid IN (".implode(",",$arrSell).") ";
   
        $sql = $sql . " AND YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
        $sql = $sql . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "'   ";   
        $sql = $sql . " AND DAY(" . $mod_tb_root . "_edate)='" . $day . "'   "; 
    
    if ($status == 1) {
        $sql = $sql . " AND " . $mod_tb_root . "_statusid = '188'";  
    }

    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}


function sumDaily($year = null, $month = null, $dvid = 0, $sellid = 0,$type = 0)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;

    $sql = $sql . " WHERE " . $mod_tb_root . "_sellid = '" . $sellid . "'";    
    
    if ($type != 0) {
        $sql = $sql . " AND YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
        $sql = $sql . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "'   ";  
    }else{
        $sql = $sql . " AND YEAR(" . $mod_tb_root . "_date)='" . $year . "'   ";
        $sql = $sql . " AND MONTH(" . $mod_tb_root . "_date)='" . $month . "'   ";  
    }

    
    if ($dvid != 0) {
        $sql = $sql . " AND " . $mod_tb_root . "_dvid = '" . $dvid . "'";   
    }
    if ($type != 0) {
        // $sql = $sql . " AND " . $mod_tb_root . "_statusid = '188'";
        $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (187,188)";
    }

    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}


if ($_SESSION[$valSiteManage . "core_session_id"] == 0) { ?>
    <script language="JavaScript"  type="text/javascript">
        document.location.href = "../index.php";
    </script>
<?php } ?>