<?php
@include("../lib/session.php");
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="report_list_' . date('Y-m-d') . '.xls"'); #ชื่อไฟล์
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

if ($explode[0]) {
    $year = $explode[1];
    $month = $explode[0];
    $countDay = date("t", strtotime($year . "-" . $month));
}

$date_print = DateFormat(date("Y-m-d H:i:s"));

logs_access('3', 'Export');
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">


<HEAD>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style type="text/css">

    </style>
</HEAD>

<BODY>
    <tr>
        <td>
            <table border="1" cellspacing="1" cellpadding="2" align="left">
                <tbody>
                    <tr>
                        <td colspan="3" height="30" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> <?php echo $langMod["tit:total"] ?>
                        </td>
                        <?php
                        $sql_sell = $_REQUEST['sql_export'];                        
                   
                        $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell);
                        $count_totalrecord = wewebNumRowsDB($coreLanguageSQL, $query_fb);                     

                        while ($row_fb = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                            $row_sellid = $row_fb[0];
                            $valNamecShow = $row_fb[1];
                        ?>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> <?php echo $valNamecShow ?>
                            </td>
                        <?php  } ?>
                    </tr>
                    <tr>
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:date-cn"] ?></td>
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:regis"] ?></td>
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:deposit"] ?></td>
                        <?php
                        $i = 0;
                        while ($i < $count_totalrecord) {                           
                        ?>                                               
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:regis"] ?></td>
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:deposit"] ?></td>
                        <?php $i++;  } ?>
                    </tr>

                    <?php


                    

                    $sumApply = 0;
                    $sumDeposit = 0;

                    $day = 1;
                    $valDivTr = "divSubOverTb";
                    
                    while ($day < $countDay + 1) {

                     
                        $apply = countRegister($year, $month, $day, $dvid);
                        $deposit = countDeposit($year, $month, $day, $dvid);

                        $sumApply += $apply;
                        $sumDeposit += $deposit;

                    ?>
                        <tr bgcolor="#ffffff">
                            <td height="30" align="center" valign="middle"><?php echo  $day . "/" . $month . "/" . $year ?></td>
                            <td align="center" valign="middle"><?php echo $apply ?></td>
                            <td align="center" valign="middle"><?php echo $deposit ?></td>
                            <?php
                            $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell);

                            while ($row = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                                $row_sellid = $row[0];
                                $apply = countRegister($year, $month, $day, $dvid, $row_sellid);
                                $deposit = countDeposit($year, $month, $day, $dvid, $row_sellid);

                                $listSumApply[$row_sellid][$day] =  $apply;
                                $listSumDeposit[$row_sellid][$day] =  $deposit;

                            ?>
                            <td width="100" align="center"  class="bold" valign="middle"><?php echo $apply ?></td>
                            <td width="100" align="center"  class="bold" valign="middle"><?php echo $deposit ?></td>
                            <?php } ?>                          

                        </tr>

                    <?php
                        $day++;
                    } ?>

                    <tr bgcolor="#eeeeee">
                        <td height="30" align="center" valign="middle"><?php echo  $countDay ?></td>
                        <td align="center" valign="middle"><?php echo $sumApply ?></td>
                        <td align="center" valign="middle"><?php echo $sumDeposit ?></td>
                        <?php
                            $query_fb = wewebQueryDB($coreLanguageSQL, $sql_sell);
                            while ($row = wewebFetchArrayDB($coreLanguageSQL, $query_fb)) {
                                $row_sellid = $row[0];                               

                            ?>
                            <td width="100" align="center"  class="bold" valign="middle"><?php echo array_sum($listSumApply[$row_sellid]) ?></td>
                            <td width="100" align="center"  class="bold" valign="middle"><?php echo array_sum($listSumDeposit[$row_sellid]) ?></td>
                            <?php } ?> 
                    </tr>
                </tbody>
            </table>
        </td>
       
    </tr>
    <tr>
        <td>
            <table border="0" cellspacing="1" cellpadding="2" align="left">
                <tbody>
                    <tr>
                        <td width="175" align="right" valign="middle" class="bold">Print date : </td>
                        <td width="175" align="left" valign="middle"><?php echo  $date_print ?></td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>

</BODY>

</HTML>