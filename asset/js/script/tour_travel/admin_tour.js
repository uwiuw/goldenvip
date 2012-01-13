/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(function(){
    //pagination();
});
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
function pagination(){
    alert('test');
   //nav = jQuery('#pagination a').each();
   jQuery('#pagination a').each(function(index) {
        nav = jQuery(this).attr('href');
        teks = "pagination_page('"+nav+"','#site-content','#reload_data')";
        jQuery(this).attr('href','javascript:void(load('+teks+'))');
        //jQuery(this).attr('onclik','pagination_page("'+nav+'","#site-content")');
    });
 }


