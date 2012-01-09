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
function pagination_page(page,div,divloading){
    jQuery.ajax({
            url: page,
            beforeSend: function(){
                    //jQuery(div).html(image_load);
                    jQuery(divloading).html('<img src="'+image+'" class="left" width="18px" align="middle" > Please wait ...');
            },
            success: function(response){
                    jQuery(div).html(response);
                    jQuery(divloading).html('');
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

// routing
function clear_txt()
{
        jQuery('#info-saving').html('');
        jQuery('#info-saving').removeClass('update-nag')
}
// end of routing

jQuery(document).ready(function(){
        load('_admin/home_page','#site-content');
});

// dialog box
function dialog_box_delete(id,val){
        jQuery(".data-want-to-delete").html(val);
        jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
        jQuery( "#dialog-confirm" ).dialog({
                resizable: true,
                modal: true,
                buttons: {
                        Delete: function() {
                                jQuery( this ).dialog( "close" );
                                jQuery('#info-saving').addClass('update-nag')
                                load('_admin/post_data/del_dist/'+id,'#info-saving');
                                load('_admin/distributor','#site-content');
                        },
                        Cancel: function() {
                                jQuery( this ).dialog( "close" );
                        }
                }
        });
}

// end of dialog box

function pagination(){

   //nav = jQuery('#pagination a').each();
   jQuery('#pagination a').each(function(index) {
        nav = jQuery(this).attr('href');
        teks = "pagination_page('"+nav+"','#site-content','#reload_data')";
        jQuery(this).attr('href','javascript:void(load('+teks+'))');
        //jQuery(this).attr('onclik','pagination_page("'+nav+'","#site-content")');
    });
 }