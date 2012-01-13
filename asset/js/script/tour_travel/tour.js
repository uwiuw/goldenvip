jQuery(function(){
        jQuery("#myTable").tablesorter();
        jQuery('#myTable tbody tr:odd').addClass('odd');
        pagination();
});

function tour_travel_cek_form(){
    jQuery('#error_destination').text('');
    destination = jQuery('#destination').val();
    read_data = jQuery('#read_data').val();
    if(!destination){
        jQuery('#error_destination').text("Can't be empty");
        return false;
    }
    if(read_data=='new'){
        send_form(document.form_new_tour_destination,'_admin/tour_travel/saving_new_destination',"#info-saving");
        
    }else{
        send_form(document.form_new_tour_destination,'_admin/tour_travel/update_new_destination',"#info-saving");
    }
    jQuery("#info-saving").addClass('update-nag');
    return true;
}
