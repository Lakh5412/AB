// JavaScript Document
// ####################################### Start Product ################################################# //


function checkCodeProduct(fileAc) {
	
 jQuery.blockUI({
		message: jQuery('#tallContent'),
		css: { border: 'none',padding: '35px',backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .9, color: '#fff'
		}
	});


	var TYPE="POST";
	var URL=fileAc;

	var dataSet= jQuery("#myForm").serialize();

		jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			
			jQuery("#boxCheckCodePro").show();
			jQuery("#boxCheckCodePro").html(html);
			setTimeout(jQuery.unblockUI, 200);
        	
		}
	}); 
}



function openSelectType(fileAc) {
	
 jQuery.blockUI({
		message: jQuery('#tallContent'),
		css: { border: 'none',padding: '35px',backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .9, color: '#fff'
		}
	});


	var TYPE="POST";
	var URL=fileAc;

	var dataSet= jQuery("#myForm").serialize();

		jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			
			jQuery("#boxTypeSelect").show();
			jQuery("#boxTypeSelect").html(html);
			setTimeout(jQuery.unblockUI, 200);
        	
		}
	}); 
}



// ####################################### End Product ################################################# //
