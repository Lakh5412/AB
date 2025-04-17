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
$mod_fd_root = "mod_report_productteam";

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


//นับจำนวนการ "สมัคร" (Register) ในวัน เดือน ปี ที่ระบุ
function countRegister($year = null, $month = null, $day = null, $arrTeam = null)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;
    
    $sql = $sql . " WHERE YEAR(" . $mod_tb_root . "_date)='" . $year . "'   ";
    $sql = $sql . " AND MONTH(" . $mod_tb_root . "_date)='" . $month . "'   ";   
    $sql = $sql . " AND DAY(" . $mod_tb_root . "_date)='" . $day . "'   ";     

    $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (1,188)";  //กรองเฉพาะสถานะ _statusid IN (1, 188) (น่าจะเป็นสถานะสมัครสำเร็จ)
    
    if ($arrTeam) {
        $sql = $sql . " AND " . $mod_tb_root . "_teamid IN (".implode(",",$arrTeam).")   ";  //ถ้ามีการส่ง $arrTeam (Array ของ Team ID) มา จะกรองเฉพาะทีมเหล่านั้น (AND _teamid IN (...))
    } 

    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}

//นับจำนวนการ "ฝาก" (Deposit) ในวัน เดือน ปี ที่ระบุ
function countDeposit($year = null, $month = null, $day = null, $arrTeam = null)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;

    $sql = $sql . " WHERE YEAR(" . $mod_tb_root . "_edate)='" . $year . "'   ";
    $sql = $sql . " AND MONTH(" . $mod_tb_root . "_edate)='" . $month . "'   ";   
    $sql = $sql . " AND DAY(" . $mod_tb_root . "_edate)='" . $day . "'   ";         

    // กรองเฉพาะสถานะ _statusid IN (187, 188) (น่าจะเป็นสถานะฝากสำเร็จ)
    $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (187,188)"; 

    if ($arrTeam) {
        $sql = $sql . " AND " . $mod_tb_root . "_teamid IN (".implode(",",$arrTeam).")   "; //ถ้ามีการส่ง $arrTeam มา จะกรองเฉพาะทีมเหล่านั้น
    } 
     
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count']; //คืนค่าเป็นจำนวนที่นับได้
}

//นับจำนวนการสมัคร โดยสามารถกรองตาม DV, Team ID, และ Sell ID ได้ละเอียดขึ้น
function countRegisterTeam($year = null, $month = null, $day = null, $dvid = null, $teamid = null, $sellid = null)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . " FROM " . $mod_tb_root;
    $sql = $sql . " WHERE DATE(" . $mod_tb_root . "_date)='" . $year . "-" . $month . "-" . $day . "' ";    

    if ($dvid) {
        $sql = $sql . " AND " . $mod_tb_root . "_dvid IN (".implode(",",$dvid).")";  //ถ้ามีการส่ง $dvid (Array ของ DV ID) มา จะกรอง AND _dvid IN (...)
    }
    
    if ($teamid) {
        $sql = $sql . " AND " . $mod_tb_root . "_teamid IN (".implode(",",$teamid).")   "; //ถ้ามีการส่ง $teamid (Array ของ Team ID) มา จะกรอง AND _teamid IN (...)
    }    
    if ($sellid) {
        $sql = $sql . " AND " . $mod_tb_root . "_sellid = $sellid "; //ถ้ามีการส่ง $sellid (ID ของพนักงานขาย) มา จะกรอง AND _sellid = ...
    }    
    
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count']; //คืนค่าเป็นจำนวนที่นับได้
}

//นับจำนวนการฝาก โดยกรองตาม DV, Team ID, Sell ID และสถานะการฝาก
function countDepositTeam($year = null, $month = null, $day = null, $dvid = null, $teamid = null, $sellid = null)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;
    $sql = $sql . " WHERE DATE(" . $mod_tb_root . "_edate)='" . $year . "-" . $month . "-" . $day . "' ";

    if ($dvid) {
        $sql = $sql . " AND " . $mod_tb_root . "_dvid IN (".implode(",",$dvid).")";  
    }
    
    if ($teamid) {
        $sql = $sql . " AND " . $mod_tb_root . "_teamid IN (".implode(",",$teamid).")   "; 
    } 

    if ($sellid) {
        $sql = $sql . " AND " . $mod_tb_root . "_sellid = $sellid "; 
    } 

    // $sql = $sql . " AND " . $mod_tb_root . "_statusid = 188"; 
    $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (187,188)";      
    
  
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}

//คล้ายกับ countRegisterTeam และ countDepositTeam แต่ใช้ฟิลด์วันที่ _reindate ซึ่งน่าจะเป็นวันที่เฉพาะสำหรับกลุ่ม HTS
//การกรอง $sellid ในฟังก์ชัน HTS จะรับเป็น Array (IN (...)) ต่างจากฟังก์ชัน Team ที่รับเป็น ID เดียว
function countRegisterHTS($year = null, $month = null, $day = null, $dvid = null, $teamid = null, $sellid = null)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . " FROM " . $mod_tb_root;
    $sql = $sql . " WHERE DATE(" . $mod_tb_root . "_reindate)='" . $year . "-" . $month . "-" . $day . "' ";    

    if ($dvid) {
        $sql = $sql . " AND " . $mod_tb_root . "_dvid IN (".implode(",",$dvid).")";  
    }
    
    if ($teamid) {
        $sql = $sql . " AND " . $mod_tb_root . "_teamid IN (".implode(",",$teamid).")   "; 
    }    
    if ($sellid) {
        $sql = $sql . " AND " . $mod_tb_root . "_sellid IN (".implode(",",$sellid).")   "; 
    }    
    
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}

function countDepositHTS($year = null, $month = null, $day = null, $dvid = null, $teamid = null, $sellid = null)
{
    global $coreLanguageSQL, $mod_tb_root;

    $sqlSelect = "            
    COUNT(" . $mod_tb_root . "_id) as count
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_root;
    $sql = $sql . " WHERE DATE(" . $mod_tb_root . "_reindate)='" . $year . "-" . $month . "-" . $day . "' ";

    if ($dvid) {
        $sql = $sql . " AND " . $mod_tb_root . "_dvid IN (".implode(",",$dvid).")";  
    }
    
    if ($teamid) {
        $sql = $sql . " AND " . $mod_tb_root . "_teamid IN (".implode(",",$teamid).")   "; 
    } 

    if ($sellid) {
        $sql = $sql . " AND " . $mod_tb_root . "_sellid IN (".implode(",",$sellid).")   "; 
    } 

    // $sql = $sql . " AND " . $mod_tb_root . "_statusid = 188";      
    $sql = $sql . " AND " . $mod_tb_root . "_statusid IN (187,188)"; 
    
 
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $row = wewebFetchArrayDB($coreLanguageSQL, $query);

    return $row['count'];
}
function getTeamToArray($subject)
{
    global $coreLanguageSQL, $mod_tb_data, $mod_masterkey_team;

    $sqlSelect = "            
    " . $mod_tb_data . "_id as id,
    " . $mod_tb_data . "_subject as subject
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_data;
    $sql = $sql . " WHERE " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_team . "' ";
        

    if ($subject) {
        $impSearch = str_replace(",","%' OR " . $mod_tb_data . "_subject LIKE '%",$subject);        
        $sql = $sql . " AND ( " . $mod_tb_data . "_subject LIKE '%".$impSearch."%' ) ";    // (ถ้า $subject เป็น "sub1,sub2")   //คืนค่าเป็น Array ของ Team ID ที่พบ
    }                   
    $sql = $sql . " ORDER BY " . $mod_tb_data . "_subject ASC";   

    
 
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $arrTeamID = array();
    while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
        array_push($arrTeamID, $row['id']);
    }
   
    return $arrTeamID;
}
function getDVToArray($subject)
{
    global $coreLanguageSQL, $mod_tb_data, $mod_masterkey_dv;

    $sqlSelect = "            
    " . $mod_tb_data . "_id as id,
    " . $mod_tb_data . "_subject as subject
    ";

    // SQL SELECT #########################   
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_data;
    $sql = $sql . " WHERE " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_dv . "' ";
        

    if ($subject) {
        $impSearch = str_replace(",","' OR " . $mod_tb_data . "_subject = '",$subject);        
        $sql = $sql . " AND ( " . $mod_tb_data . "_subject = '".$impSearch."' ) ";   //(ใช้ = แทน LIKE)
    }
    $sql = $sql . " ORDER BY " . $mod_tb_data . "_subject ASC";   

    // print_pre($sql);
    // die;
 
    $query = wewebQueryDB($coreLanguageSQL, $sql);      //คืนค่าเป็น Array ของ DV ID ที่พบ
    $arrTeamID = array();
    while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
        array_push($arrTeamID, $row['id']);
    }
   
    return $arrTeamID;
}
function getSellToArray($subject)
{
    global $coreLanguageSQL, $mod_tb_data, $mod_masterkey_sell;

    $sqlSelect = "            
    " . $mod_tb_data . "_id as id,
    " . $mod_tb_data . "_subject as subject
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_data;
    $sql = $sql . " WHERE " . $mod_tb_data . "_masterkey ='" . $mod_masterkey_sell . "' "; 
        
    if ($subject) {
        $impSearch = "".implode(",",$subject)."";        
        $sql = $sql . " AND " . $mod_tb_data . "_team IN ('".$impSearch."' ) ";   //(โดย $subject ที่ส่งมาคือ Array ของ Team ID)
    }
    $sql = $sql . " ORDER BY " . $mod_tb_data . "_subject ASC";     
                                                        //คืนค่าเป็น Array ของ Sell ID ที่พบ
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $arrTeamID = array(); 
    while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
        array_push($arrTeamID, $row['id']);
    }


   
    return $arrTeamID;
}

function getSellTeam($subject) //ค้นหาข้อมูลพนักงานขาย (sellid, subject) ที่อยู่ในทีมที่ชื่อขึ้นต้นด้วย $subject (เช่น 'HA')
{
    global $coreLanguageSQL, $mod_tb_data, $mod_masterkey_sell;

    $sqlSelect = "            
    sell." . $mod_tb_data . "_id as id,
    sell." . $mod_tb_data . "_subject as subject
    ";

    // SQL SELECT #########################
    $sql = "SELECT " . $sqlSelect . "    FROM " . $mod_tb_data ." sell ";
    $sql = $sql . " INNER JOIN " . $mod_tb_data . " team ON sell." . $mod_tb_data . "_team = team.". $mod_tb_data . "_id";
    $sql = $sql . " WHERE sell." . $mod_tb_data . "_masterkey ='" . $mod_masterkey_sell . "' ";
    $sql = $sql . " AND sell." . $mod_tb_data . "_status ='Enable' ";
        
    //คืนค่าเป็น Array ที่มีโครงสร้างซับซ้อนขึ้น ประกอบด้วย id, color1, color2, sellid, subject, subject2 สำหรับนำไปใช้สร้างหัวตารางและ Placeholder ใน loadContant.php
    if ($subject) {
        $sql = $sql . " AND ( team." . $mod_tb_data . "_subject LIKE '%".$subject."%' ) ";   
    }
    $sql = $sql . " ORDER BY sell." . $mod_tb_data . "_subject ASC";       
 
    $query = wewebQueryDB($coreLanguageSQL, $sql);
    $arrSellID = array();
    while ($row = wewebFetchArrayDB($coreLanguageSQL, $query)) {
        array_push($arrSellID, 
        array(
            "id" => "sellid-".$row['id'],
            "color1" =>"#073763",
            "color2" =>"#073763",
    
            
            "sellid" => $row['id'],
            
            "subject" => $row['subject'],
            "subject2" => $row['subject'],
        )   
        );
    }
   
    return $arrSellID;
}

//โครงสร้างนี้จะถูกใช้ใน loadContant.php และ apiloadListTeam.php เพื่อกำหนดว่าจะแสดงคอลัมน์อะไรบ้าง และจะส่ง Parameter อะไรไปให้ฟังก์ชันนับข้อมูล (count...Team) ผ่าน AJAX
$arrTeamA =array(   
    
    // กีฬา DV35  
    array(
        "id" => "sport-dv35",
        "color1" =>"#073763",
        "color2" =>"#0b5394",

        "dv" => "DV35",
        "team" => "HA-F",
        
        "subject" => "กีฬา",
        "title" => "DV35",
        "subject2" => "DV35",
        "title2" => "กีฬา"
    ),   
    array(
        "id" => "sport-dv336",
        "color1" =>"#073763",
        "color2" =>"#0b5394",

        "dv" => "DV336",
        "team" => "HA-F",
        
        "subject" => "กีฬา",
        "title" => "DV336",
        "subject2" => "DV336",
        "title2" => "กีฬา"
    ),   
    // หวย DV35
    array(
        "id" => "lotto-dv35",
        "color1" =>"#38761d",
        "color2" =>"#6aa84f",

        "dv" => "DV35",
        "team" => "HA-L",
        
        "subject" => "หวย",
        "title" => "DV35",
        "subject2" => "DV35",
        "title2" => "หวย"
    ),     
    // หวย DV336
    array(
        "id" => "lotto-dv336",
        "color1" =>"#38761d",
        "color2" =>"#6aa84f",

        "dv" => "DV336",
        "team" => "HA-L",
        
        "subject" => "หวย",
        "title" => "DV336",
        "subject2" => "DV336",
        "title2" => "หวย"
    ),     
    //HX บาคาร่า DV35
    array(
        "id" => "baccarat-dv35",
        "color1" =>"#7f6000",
        "color2" =>"#bf9000",

        "dv" => "dv35",
        "team" => "HA-B",

        "subject" => "บาคาร่า",
        "title" => "DV35",
        "subject2" => "DV35",
        "title2" => "บาคาร่า"
    ), 
    array(
        "id" => "baccarat-dv336",
        "color1" =>"#7f6000",
        "color2" =>"#bf9000",

        "dv" => "dv336",
        "team" => "HA-B",

        "subject" => "บาคาร่า",
        "title" => "DV336",
        "subject2" => "DV336",
        "title2" => "บาคาร่า"
    ), 
    
    //DV310
    array(
        "id" => "dv310-all",
        "color1" =>"#f90",
        "color2" =>"#f90",

        "dv" => "DV310",    
        "team" => "HA",    

        "subject" => "DV310",
        "subject2" => "DV310"
    ) ,   
    //DV310
    array(
        "id" => "dv337-all",
        "color1" =>"#f90",
        "color2" =>"#f90",

        "dv" => "DV337",    
        "team" => "HA",    

        "subject" => "DV337",
        "subject2" => "DV337"
    ) ,   
    //HTS DV335
   array(
    "id" => "hts-dv335",
    "color1" =>"#f0f",
    "color2" =>"#f0f",

    "dv" =>"DV335",        
    // "team" => "XT-TEAM",

    "subject" => "HTS",
    "subject2" => "HTS"
   ),
   //X-Team
   array(
    "id" => "xteam-all",
    "color1" =>"#f0f",
    "color2" =>"#f0f",

    "team" => "X TEAM",

    "subject" => "X-Team",
    "subject2" => "X-Team"
    ),  
    //SEO DV311
    array(
        "id" => "seo-dv311",
        "color1" =>"#f0f",
        "color2" =>"#f0f",

        "dv" =>"DV311",        

        "subject" => "DV311",
        "subject2" => "DV311"
    ), 
   // กีฬา DV32  
   array(
    "id" => "sport-dv32",
    "color1" =>"#073763",
    "color2" =>"#0b5394",

    "dv" => "DV32",
    "team" => "HA-F",
    
    "subject" => "กีฬา",
    "title" => "DV32",
    "subject2" => "DV32",
    "title2" => "กีฬา"
    ),   
    // หวย DV32
    array(
        "id" => "lotto-dv32",
        "color1" =>"#38761d",
        "color2" =>"#6aa84f",

        "dv" => "DV32",
        "team" => "HA-L",
        
        "subject" => "หวย",
        "title" => "DV32",
        "subject2" => "DV32",
        "title2" => "หวย"
    )   
   
);
$arrTeamB =array(   
    
    // กีฬา DV35  
    array(
        "id" => "sport-dv35",
        "color1" =>"#073763",
        "color2" =>"#0b5394",

        "dv" => "DV35",
        "team" => "HB-F",
        
        "subject" => "กีฬา",
        "title" => "DV35",
        "subject2" => "DV35",
        "title2" => "กีฬา"
    ),   
    array(
        "id" => "sport-dv338",
        "color1" =>"#073763",
        "color2" =>"#0b5394",

        "dv" => "DV338",
        "team" => "HB-F",
        
        "subject" => "กีฬา",
        "title" => "DV338",
        "subject2" => "DV338",
        "title2" => "กีฬา"
    ),   
    // หวย DV35
    array(
        "id" => "lotto-dv35",
        "color1" =>"#38761d",
        "color2" =>"#6aa84f",

        "dv" => "DV35",
        "team" => "HB-L",
        
        "subject" => "หวย",
        "title" => "DV35",
        "subject2" => "DV35",
        "title2" => "หวย"
    ),     
    array(
        "id" => "lotto-dv338",
        "color1" =>"#38761d",
        "color2" =>"#6aa84f",

        "dv" => "DV338",
        "team" => "HB-L",
        
        "subject" => "หวย",
        "title" => "DV338",
        "subject2" => "DV338",
        "title2" => "หวย"
    ),     
    //HX บาคาร่า DV35
    array(
        "id" => "baccarat-dv35",
        "color1" =>"#7f6000",
        "color2" =>"#bf9000",

        "dv" => "dv35",
        "team" => "HB-B",

        "subject" => "บาคาร่า",
        "title" => "DV35",
        "subject2" => "DV35",
        "title2" => "บาคาร่า"
    ), 
    array(
        "id" => "baccarat-dv338",
        "color1" =>"#7f6000",
        "color2" =>"#bf9000",

        "dv" => "dv338",
        "team" => "HB-B",

        "subject" => "บาคาร่า",
        "title" => "DV338",
        "subject2" => "DV338",
        "title2" => "บาคาร่า"
    ),     
    //DV310
    array(
        "id" => "dv310-all",
        "color1" =>"#f90",
        "color2" =>"#f90",

        "dv" => "DV310",        
        "team" => "HB",    

        "subject" => "DV310",
        "subject2" => "DV310"
    ) ,   
    array(
        "id" => "dv339-all",
        "color1" =>"#f90",
        "color2" =>"#f90",

        "dv" => "DV339",        
        "team" => "HB",    

        "subject" => "DV339",
        "subject2" => "DV339"
    ) ,   
    //HTS DV331
   array(
    "id" => "hts-dv331",
    "color1" =>"#f0f",
    "color2" =>"#f0f",

    "dv" =>"DV331",        
    // "team" => "XT-TEAM",

    "subject" => "HTS",
    "subject2" => "HTS"
   ),
   //X-Team
   array(
    "id" => "xteam-all",
    "color1" =>"#f0f",
    "color2" =>"#f0f",

    "team" => "X TEAM",

    "subject" => "X-Team",
    "subject2" => "X-Team"
    ),  
    //SEO DV311
    array(
        "id" => "seo-dv311",
        "color1" =>"#f0f",
        "color2" =>"#f0f",

        "dv" =>"DV311",        

        "subject" => "DV311",
        "subject2" => "DV311"
    ), 
   // กีฬา DV32  
   array(
    "id" => "sport-dv32",
    "color1" =>"#073763",
    "color2" =>"#0b5394",

    "dv" => "DV32",
    "team" => "HB-F",
    
    "subject" => "กีฬา",
    "title" => "DV32",
    "subject2" => "DV32",
    "title2" => "กีฬา"
    ),   
    // หวย DV32
    array(
        "id" => "lotto-dv32",
        "color1" =>"#38761d",
        "color2" =>"#6aa84f",

        "dv" => "DV32",
        "team" => "HB-L",
        
        "subject" => "หวย",
        "title" => "DV32",
        "subject2" => "DV32",
        "title2" => "หวย"
    )
);

//ตรวจสอบล็อคอิน
if ($_SESSION[$valSiteManage . "core_session_id"] == 0) { ?>
    <script language="JavaScript"  type="text/javascript">
        document.location.href = "../index.php";
    </script>
<?php } ?>
