<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/hotel/public.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/hotel/app_hotel.js.js" /></script>
<script type="text/javascript">
    function cek_data_inputan_area_in_detail()
    {
        var area_detail = jQuery('#area_in_detail').val();
        var destination = jQuery('#destination').val();
        jQuery('#error_destination').text("");
        jQuery('#error_area').text("");
        if(!destination){
            jQuery('#error_destination').text("can't be empty");
            return false;
        }
        if(!area_detail){
            jQuery('#error_area').text("can't be empty");
            return false;
        }
        jQuery("#info-saving").addClass('update-nag');
        send_form(document.area_in_detail_form,'_admin/hotel/<?php echo $action; ?>',"#info-saving");
        return true;
    }
</script>
<p>&Colon; Hotel &gg; Add new area in detail</p>
<form name="area_in_detail_form">
    <table>
        <tr>
            <td>Destination</td>
            <td>
                <?php $id = "id='destination' ";
                echo form_dropdown('destination', $destination, $uid_destination, $id); ?>
                <input type="hidden" name="read_data" value="<?php echo $uid; ?>"/>
            </td>
            <td id="error_destination"></td>
        </tr>
        <tr>
            <td>Area in detail</td>
            <td><input type="text" name="area_in_detail" id="area_in_detail" value="<?php echo $destination_detail;?>" /></td>
            <td id="error_area"></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><input type="button" value="<?php echo $val_btn; ?>" onclick="cek_data_inputan_area_in_detail();" class="button"></td>

        </tr>
    </table>
</form>