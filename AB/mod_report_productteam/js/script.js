$(document).ready(function() {    
    loadListTeam();
});

// function promise() {
// return new Promise(function (resolve, reject){
//     resolve(sumDaily());
// })
// }

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


function loadListDaily(data) { 
var TYPE="POST";
var URL='apiloadListDaily.php';
var year= $('#valYear').val();
var month= $('#valMonth').val();
var countDay= $('#countDay').val();

var dataSet= {id:0,data:data,year:year,month:month,countDay:countDay};

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
            });
            $('.'+data.reg.id).text(numberWithCommas(data.reg.sum));    
            $('.'+data.dep.id).text(numberWithCommas(data.dep.sum));    
        }
    }
});
}



function loadListTeam() { 

var TYPE="POST";
var URL='apiloadListTeam.php';
var year= $('#valYear').val();
var month= $('#valMonth').val();
var countDay= $('#countDay').val();
var masterkey= $('#masterkey').val();
var dataSet= {id:9999,year:year,month:month,countDay:countDay,masterkey:masterkey};

    jQuery.ajax({
        type:TYPE,
        url:URL,
        data:dataSet,
    success:function(data){
        var data = JSON.parse(data);
        // console.log(data);
        if (data.status) {     
            var p = $.when();
            $.each(data.list_data, function (key, value) {
                // console.log(value);
                p = p.then(function() { 
                    return loadListDaily(value);
                });
                                               
            });
        }
    }
});
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}