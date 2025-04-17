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
                        <td colspan="3" rowspan="2" height="30" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> <?php echo $langMod["tit:total"] ?>
                        </td>
                        
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> กีฬา </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> กีฬา </td>

                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> หวย  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> หวย  </td>
                            
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> HX-B  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> SEO  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> SEO  </td>
                            <td colspan="2" rowspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> X-Team  </td>
                            
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> HA-L  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> HX-L  </td>

                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> แนะนำเพื่อน  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> กีฬา(32)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> กีฬา(35)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> หวย(32)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> หวย(35)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> HX-B(35)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> HX-L(35)  </td>

                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> รวม 311  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> กีฬา(32)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> กีฬา(35)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> หวย(32)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> หวย(35)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> HX-B(35)  </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> HX-L(35)  </td>

                        </tr>
                    <tr>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV32 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV35 </td>

                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV32 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV35 </td>
                            
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV35 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV330 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV315 </td>
                            <!-- <td width="20%" colspan="2" rowspan="2" class="divRightTitleTb"> X-Team  </td> -->

                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV35 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV35 </td>

                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV310 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV310 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV310 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV310 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV310 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV310 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV310 </td>

                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV311 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV311 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV311 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV311 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV311 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV311 </td>
                            <td colspan="2" height="30" width="200" align="center" bgcolor="#eeeeee" class="bold" valign="middle"> DV311 </td>

                        </tr>
                    <tr>
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:date-cn"] ?></td>
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:regis"] ?></td>
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:deposit"] ?></td>
                        <?php
                        foreach ($arrTeamDV as $key => $value) {                          
                        ?>                                               
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:regis"] ?></td>
                        <td width="100" align="center" bgcolor="#eeeeee" class="bold" valign="middle"><?php echo $langMod["tit:deposit"] ?></td>
                        <?php  } ?>
                    </tr>

                    <?php

                    $sumApply = 0;
                    $sumDeposit = 0;

                    $day = 1;                    
                    while ($day < $countDay + 1) {

                     
                        $apply = countRegister($year, $month, $day);
                        $deposit = countDeposit($year, $month, $day);

                        $sumApply += $apply;
                        $sumDeposit += $deposit;

                    ?>
                        <tr bgcolor="#ffffff">
                            <td height="30" align="center" valign="middle"><?php echo  $day . "/" . $month . "/" . $year ?></td>
                            <td align="center" valign="middle"><?php echo $apply ?></td>
                            <td align="center" valign="middle"><?php echo $deposit ?></td>
                            <?php
                           foreach ($arrTeamDV as $key => $value) {                            

                                $apply = countRegisterTeam($year, $month, $day, $value['dvid'], $value['teamid']);
                                $deposit = countDepositTeam($year, $month, $day, $value['dvid'], $value['teamid']);

                                $listSumApply[$value][$day] =  $apply;
                                $listSumDeposit[$value][$day] =  $deposit;

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
                           foreach ($arrTeamDV as $key => $value) {                              

                            ?>
                            <td width="100" align="center"  class="bold" valign="middle"><?php echo array_sum($listSumApply[$value]) ?></td>
                            <td width="100" align="center"  class="bold" valign="middle"><?php echo array_sum($listSumDeposit[$value]) ?></td>
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