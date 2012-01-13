<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/hotel/public.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>asset/js/script/hotel/app_hotel.js.js" />
<p>&Colon; Hotel &gg; Edit Hotel Destination</p>
<script type="text/javascript">
    function update_form_inputan(){
        destination = jQuery('#destination').val();
        jQuery('#error_message').text("");
        if(!destination){
            jQuery('#error_message').text("Destination can't blank");
            return false;
        }
        jQuery("#info-saving").addClass('update-nag');
        send_form(document.form_inputan_destination,'_admin/hotel/update_destination',"#info-saving");
        return true;
    }
</script>
<form onsubmit="false" name="form_inputan_destination">
    <table>
        <tr><td colspan="2" height="10px" id="error_message"></td></tr>
        <tr>
            <td>Destination</td>
            <td>
                <input type="text" value="<?php echo $destination['destination']; ?>" name="destination" id="destination">
                <input type="hidden" value="<?php echo $destination['uid']; ?>" name="uid">
            </td>
            <td><input type="button" value="Update" class="button" onclick="update_form_inputan()"></td>
        </tr>
        <tr><td colspan="2" height="20px"></td></tr>
    </table>
</form>