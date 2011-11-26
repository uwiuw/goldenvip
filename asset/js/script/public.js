	function load(page,div){
		jQuery.ajax({
			url: site+"/"+page,
			beforeSend: function(){
				//jQuery(div).html(image_load);
				jQuery(div).html('<img src="'+image+'" class="left" width="18px" align="middle" > Loading ...');
			},
			success: function(response){
				jQuery(div).html(response);
			},
			dataType:"html"  		
		});
		return false;
	}
	function load_no_image(page,div){
		jQuery.ajax({
			url: site+"/"+page,
			beforeSend: function(){
				//jQuery(div).html(image_load);
				jQuery(div).html('get data');
			},
			success: function(response){
				jQuery(div).html(response);
				//jQuery(div).html(response);
			},
			dataType:"html"  		
		});
		return false;
	}
	function load_to_val(page,div){
		jQuery.ajax({
			url: site+"/"+page,
			beforeSend: function(){
				//jQuery(div).html(image_load);
				jQuery(div).val('load');
			},
			success: function(response){
				jQuery(div).val(response);
			},
			dataType:"html"  		
		});
		return false;
	}
	function send_form(formObj,action,responseDIV){
		//var image_load = "<div align='center'><img src='"+loading_image+"' /></div>";
		jQuery.ajax({
			url: site+"/"+action, 
			beforeSend: function(){
				jQuery(responseDIV).html('Loading ...');
			},
			data: jQuery(formObj.elements).serialize(), 
			success: function(response){
					if(!response)
					{
						jQuery(responseDIV).html('Please try again.');
					}
					else
					{
						jQuery(responseDIV).html(response); 
					}
				},
			type: "post", 
			dataType: "html"
		});  
		return false;
	} 
	
	function test(){
		alert('test');
	}
	
	// end of basic
	 