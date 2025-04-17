$(document).ready(function() {
    sumDaily();
    countDaily();
});

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
function sumDaily() { 
    var TYPE="POST";
	var URL='sumDaily.php';
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
                    console.log(value.dep);
                        $('.'+value.dep.id).text(value.dep.sum);               
                        $('.'+value.reg.id).text(value.reg.sum);               
                });
            }
		}
	});
}

