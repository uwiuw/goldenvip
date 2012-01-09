/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(function(){
        jQuery("#myTable").tablesorter();
        jQuery('#myTable tbody tr:odd').addClass('odd');
        pagination();
});
// cek validasi form
function management_hotel_edit_clear_form(){
    jQuery('#error_hotel_name').text("");
    jQuery('#error_destination').text("");
    jQuery('#error_star').text("");
    jQuery('#error_star').text("");
    jQuery('#error_compliment').text("");
    jQuery('#error_core').text("");
}
function management_hotel_cek_form(){
    hotel_name = jQuery('#hotel_name').val();
    destination = jQuery('#destination').val();
    star = jQuery('#star').val();
    compliment = jQuery('#compliment').val();
    core = jQuery('#core').val();
    read_data = jQuery('#read_data').val();
    
    management_hotel_edit_clear_form();
    if(!hotel_name){
        jQuery('#error_hotel_name').text("can't be empty");
        return false;
    }
    if(!destination){
        jQuery('#error_destination').text("can't be empty");
        return false;
    }
    if(!star){
        jQuery('#error_star').text("can't be empty");
        return false;
    }
    if(!compliment){
        jQuery('#error_compliment').text("can't be empty");
        return false;
    }
    if(!core){
        jQuery('#error_core').text("can't be empty");
        return false;
    }
    if(read_data == 1){
        send_form(document.add_new_data_hotel,'_admin/hotel/update_data_hotel',"#info-saving");
    }else{
        send_form(document.update_data_hotel,'_admin/hotel/update_data_hotel',"#info-saving");
    }
    
    jQuery("#info-saving").addClass('update-nag');
    return true;
}

function golden_rate_edit_clear_form(){
    jQuery('#error_category_name').text("");
    jQuery('#error_hotel_name').text("");
    jQuery('#error_retail').text("");
    jQuery('#error_golden_rate').text("");
}

function golden_rate_cek_form(){
    category_name= jQuery('#category_name').val();
    hotel_name = jQuery('#hotel_name').val();
    retail = jQuery('#retail').val();
    golden_rate = jQuery('#golden_rate').val();
    
    
    golden_rate_edit_clear_form();
    if(!category_name){
        jQuery('#error_category_name').text("can't be empty");
        return false;
    }
    if(!hotel_name){
        jQuery('#error_hotel_name').text("can't be empty");
        return false;
    }
    if(!retail){
        jQuery('#error_retail').text("can't be empty");
        return false;
    }else{
        if(isNaN(retail)){
            jQuery('#error_retail').text("Just number !");
            return false;
        }
    }
    
    if(!golden_rate){
        jQuery('#error_golden_rate').text("can't be empty");
        return false;
    }else{
        if(isNaN(golden_rate)){
            jQuery('#error_golden_rate').text("Just number !");
            return false;
        }
    }
    send_form(document.update_data_golden_rate,'_admin/hotel/update_data_golden_rate',"#info-saving");
    jQuery("#info-saving").addClass('update-nag');
    return true;
}


// cek detail
function management_hotel_cek_detail(){
    uid_destination = jQuery('#destination').val();
    url = site+"_admin/hotel/get_detail?uid="+uid_destination+"&act=get_detail_destination";
    pagination_page(url,"#destination_detail","#reload_data");
}

function searching_data(){
        send_form(document.search_form,'_admin/hotel/searching_form','#site-content');
}

function searching_data_member_profit(){
        send_form(document.search_form,'_admin/hotel/searching_form_member_profit','#site-content');
}
function add_form_new_destination(){
    jQuery('#add_new_data').text("<form onsubmit=\"save_form_inputan();\" name=\"form_inputan_destination\"><table><tr><td colspan=\"2\" height=\"10px\" id=\"error_message\"></td></tr><td>Put new destination here</td> <td><input type=\"text\" value=\"\" name=\"destination\" id=\"destination\"></td><td><input type=\"button\" value=\"Save\" class=\"button\" onclick=\"save_form_inputan()\"></td><td><input type=\"button\" value=\"Cancel\" class=\"button\" onclick=\"cancel_form_inputan()\"></td></tr><tr><td colspan=\"2\" height=\"20px\"></td></tr></table></form>");
}
function edit_destination(){
    
}