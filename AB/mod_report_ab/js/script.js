
$(document).ready(function() {

    loadTeamSellers()
  //  loadListSell();
// promise().then(function (){
//     loadListSell();
// });
});


function promise() {
return new Promise(function (resolve, reject){
    resolve(sumDaily());
})
}

function countDaily() { 
var TYPE="POST";
var URL='countDaily.php';
var sql= $('#sql_countDaily').val();
var year= $('#valYear').val();
var month= $('#valMonth').val();
var countDay= $('#countDay').val();
var dvid= $('#dvid').val();
var dataSet= {id:0,sql:sql,year:year,month:month,countDay:countDay,dvid:dvid};

    jQuery.ajax({
        type:TYPE,
        url:URL,
        data:dataSet,
    success:function(data){
        var data = JSON.parse(data);
        if (data.status) {
               
            $.each(data.list_data, function (key, value) {
                $.each(value, function (key, val) {       
                    $('.'+val.dep.id).text(val.dep.value);               
                    $('.'+val.reg.id).text(val.reg.value);               
                });
            });
        }
    }
});
}
// function sumDaily() { 
//     var TYPE="POST";
// 	var URL='sumDaily.php';
//     var sql= $('#sql_countDaily').val();
//     var year= $('#valYear').val();
//     var month= $('#valMonth').val();
//     var countDay= $('#countDay').val();
//     var dvid= $('#dvid').val();
// 	var dataSet= {id:0,sql:sql,year:year,month:month,countDay:countDay,dvid:dvid};

// 	return	jQuery.ajax({
//             type:TYPE,
//             url:URL,
//             data:dataSet,
// 		success:function(data){
//             var data = JSON.parse(data);
//             if (data.status) {            
//                 $.each(data.list_data, function (key, value) {
//                         $('.'+value.dep.id).text(value.dep.sum);               
//                         $('.'+value.reg.id).text(value.reg.sum);               
//                 });
//             }
// 		}
// 	});
// }



// ฟังก์ชันสำหรับโหลดรายชื่อ Sellers ทีม A หรือ B
function loadTeamSellers() {
    var TYPE = "POST";
    var URL = 'apiloadSellers.php'; // เรียก API Endpoint ใหม่
    var year = $('#valYear').val();
    var month = $('#valMonth').val();
    var countDay = $('#countDay').val();
    var masterkey = $('#masterkey').val();
    var dataSet = { masterkey: masterkey, year: year, month: month, countDay: countDay };

    console.log("Requesting Seller List...");
    // แสดงสถานะกำลังโหลด
    $('#seller-header-row').html('<th class="divRightTitleTb">Loading Sellers...</th>');
    $('#reg-dep-header-row').html('<td colspan="2" class="divRightTitleTb">Loading...</td>'); // Placeholder
    $('#seller-daily-data-body').empty(); // ล้างข้อมูลเก่า
    $('#total-month-row').html('<td class="divRightContantOverTb">Total</td>');
    $('#reg-dep-footer-row').html('<td class="divRightTitleTb left">สมัคร</td><td class="divRightTitleTb right">ฝาก</td>');
    $('#seller-footer-row').html('<th class="divRightTitleTb">Seller</th>');

    jQuery.ajax({
        type: TYPE,
        url: URL,
        data: dataSet,
        success: function(data) {
            console.log("Seller List Response:", data);
            try {
                var responseData = JSON.parse(data);

                if (responseData.status && responseData.list_data && responseData.list_data.length > 0) {
                    var sellers = responseData.list_data;
                    // สร้าง Header และ Placeholders ในตารางหลัก
                    buildSellerTableStructure(sellers); // เรียกใช้ฟังก์ชันสร้างโครงสร้าง

                    // เริ่มโหลดข้อมูลรายวันสำหรับ Seller แต่ละคน
                    var p = $.when(); // สร้าง Promise chain
                    $.each(sellers, function(key, sellerInfo) {
                        console.log("Queueing daily data load for:", sellerInfo.subject, "(ID:", sellerInfo.id, "Raw ID:", sellerInfo.sellid_raw, ")");
                        p = p.then(function() {
                            return loadSellerDailyData(sellerInfo);
                        });
                    });

                } else {
                    console.error("No sellers found or API error:", responseData.message);
                    $('#seller-header-row').html('<th class="divRightTitleTb">No sellers found for Team</th>');
                    $('#reg-dep-header-row').empty();
                    $('#seller-daily-data-body').html('<tr><td colspan="100%" style="text-align:center; padding: 20px;">No data available</td></tr>');
                    $('#total-month-row').empty();
                    $('#reg-dep-footer-row').empty();
                    $('#seller-footer-row').empty();
                }
            } catch (e) {
                console.error("Error parsing JSON response:", e);
                console.error("Raw response data:", data);
                $('#seller-header-row').html('<th class="divRightTitleTb">Error loading data structure</th>');
                $('#seller-daily-data-body').html('<tr><td colspan="100%" style="text-align:center; padding: 20px;">Error processing data</td></tr>');

            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error requesting seller list:", textStatus, errorThrown);
            $('#seller-header-row').html('<th class="divRightTitleTb">Error connecting to server</th>');
            $('#seller-daily-data-body').html('<tr><td colspan="100%" style="text-align:center; padding: 20px;">Connection Error</td></tr>');
        }
    });
}

// ฟังก์ชันสร้างโครงสร้างตาราง
function buildSellerTableStructure(sellers) {
    var headerRow = '';
    var subHeaderRow = '';
    var footerRow = '';

    $.each(sellers, function(index, seller) {
        headerRow += '<th width="20%" colspan="2" class="divRightTitleTb">' + seller.subject + '</th>';
        subHeaderRow += '<td width="12%" class="divRightTitleTb left" valign="middle" align="center"><span class="fontTitlTbRight">สมัคร</span></td>';
        subHeaderRow += '<td width="12%" class="divRightTitleTb right" valign="middle" align="center"><span class="fontTitlTbRight">ฝาก</span></td>';
        footerRow += '<th colspan="2" class="divRightTitleTb">' + seller.subject + '</th>';
    });

    $('#seller-header-row').html(headerRow);
    $('#reg-dep-header-row').html(subHeaderRow);
    $('#seller-footer-row').html(footerRow);
}

// ฟังก์ชันโหลดข้อมูลรายวันสำหรับ Seller แต่ละคน
function loadSellerDailyData(sellerInfo) {
    var TYPE = "POST";
    var URL = 'apiloadSellerDaily.php'; // เรียก API Endpoint ใหม่
    var year = $('#valYear').val();
    var month = $('#valMonth').val();
    var countDay = $('#countDay').val();
    var masterkey = $('#masterkey').val();
    var dataSet = { year: year, month: month, countDay: countDay, data: sellerInfo, masterkey: masterkey };


    return jQuery.ajax({
        type: TYPE,
        url: URL,
        data: dataSet,
        success: function(data) {
            console.log("Daily Data Response for Seller:", sellerInfo.subject, data);
            try {
                var responseData = JSON.parse(data);

                if (responseData.status && responseData.list_data) {
                    $.each(responseData.list_data, function(day, dayData) {
                        $('.reg-' + dayData.reg.id).text(dayData.reg.value);
                        $('.dep-' + dayData.dep.id).text(dayData.dep.value);
                    });

                    $('.sumReg-' + sellerInfo.id).text(responseData.reg.sum);
                    $('.sumDep-' + sellerInfo.id).text(responseData.dep.sum);
                } else {
                    console.error("No daily data found or API error:", responseData.message);
                }
            } catch (e) {
                console.error("Error parsing JSON response:", e);
                console.error("Raw response data:", data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error requesting daily data:", textStatus, errorThrown);
        }
    });
}


function loadListDaily(sellid) { 
var TYPE="POST";
var URL='loadListDaily.php';
var year= $('#valYear').val();
var month= $('#valMonth').val();
var countDay= $('#countDay').val();
var dvid= $('#dvid').val();
var dataSet= {id:0,sellid:sellid,year:year,month:month,countDay:countDay,dvid:dvid};

return jQuery.ajax({
        type:TYPE,
        url:URL,
        data:dataSet,
    success:function(data){
        var data = JSON.parse(data);
        // console.log(data);
        if (data.status) {   
            $.each(data.list_data, function (key, value) {
                $('.'+value.dep.id).text(value.dep.value);               
                $('.'+value.reg.id).text(value.reg.value);    
                console.log(value);           
            });
            $('.'+data.reg.id).text(data.reg.sum);    
            $('.'+data.dep.id).text(data.dep.sum);    
        }
    }
});
}




function loadListSell() { 
var TYPE="POST";
var URL='loadListSell.php';
var sql= $('#sql_countDaily').val();
var year= $('#valYear').val();
var month= $('#valMonth').val();
var countDay= $('#countDay').val();
var dvid= $('#dvid').val();
var dataSet= {id:0,sql:sql,year:year,month:month,countDay:countDay,dvid:dvid};

    jQuery.ajax({
        type:TYPE,
        url:URL,
        data:dataSet,
    success:function(data){
        var data = JSON.parse(data);
        if (data.status) {     
            var p = $.when();
            $.each(data.list_data, function (key, value) {
                p = p.then(function() { 
                    return loadListDaily(value.id);
                });
                                               
            });
        }
    }
});
}

