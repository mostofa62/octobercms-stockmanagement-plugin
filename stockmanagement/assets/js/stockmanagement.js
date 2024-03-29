//ux related

function op_type_selection(id){
	e = $('#op_type'+id);
	btn = $('#stkbtn'+id);
	show = $('.btntxtadd'+id);
	hide = $('.btntxtremove'+id);	
	
	if(e.val()==1){
		if(btn.hasClass('btn-danger')){ btn.removeClass('btn-danger') };
		btn.addClass('btn-success');
		show.show(); hide.hide();
	}
	else if(e.val()==2){
		if(btn.hasClass('btn-success')){ btn.removeClass('btn-success') };
		btn.addClass('btn-danger');
		show.hide(); hide.show();
	}else{
		if(btn.hasClass('btn-success') || btn.hasClass('btn-danger')){ btn.removeClass('btn-success').removeClass('btn-danger'); };
		//btn.addClass('btn-default');
		show.show(); hide.hide();
	}
	
	

}
//stock in out saving function
function stock_in_out_save(id){
	data = {
		'item':id,
		'quantity' : $('#quantity'+id).val(),
		'optype' :  $('#op_type'+id).val()
	};
	//alert(onStockInOutUrl);
	stkbtn  = $('#stkbtn'+id);
	$.request('onStockInOut', {
		data :data,
        success: function(info) {
            
            if(info.result == 1){
            	$('#quantity'+id).val(null);
            	$('#op_type'+id).val(null);
            }
            if(isset(info.balance)){
            	$('#blnc'+id+' > .info').text(info.balance);
            }
            notify_for_stock(stkbtn,info);
        }
    }); 


}

function stock_in_out_adjust(id) {
	data = {
		'id':id,
		'quantity' : $('#quantity'+id).val()		
	};

	stkbtn  = $('#quantity'+id);
	$.request('onStockInOutAdjust', {
		data :data,
        success: function(info) {

        	if(isset(info.balance)){
            	$('#blnc'+id+' > .info').text(info.balance);
            }                        
            
            notify_for_stock(stkbtn,info,'bottom');
        }
    }); 
	
}

function stock_in_out_delete(id){
	data = {
		'id':id			
	};
	dltbtn = $('#dltbtn'+id);

	$.request('onStockInOutDelete', {
		data :data,
        success: function(info) {

        	                    
            
            
        }
    }); 

	

}

function notify_for_stock(el,data, notify_pos = 'left'){
		cssclass = 'error';
		switch(data.result){
			case 1: cssclass = 'success'; break;
			case 2: cssclass = 'warn'; break;
			case 3: cssclass = 'info'; break;
		}

		el.notify(
				  data.msg, 
				  { 
				  	position:notify_pos, 
				  	className: cssclass,
				  	autoHideDelay: 3500,
				  	
				  }
		);


}



function isset(object){
    return (typeof object !=='undefined');
}

