<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/hotel/public.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/hotel/app_hotel.js.js" />
<script type="text/javascript">
    jQuery(function(){
        jQuery('#add_new_data').hide(); 
    });
    function show_form_inputan(){
        jQuery('#btn_show').hide();
        jQuery('#add_new_data').fadeIn(); 
    }
    function cancel_form_inputan(){
        jQuery('#add_new_data').hide(); 
        jQuery('#btn_show').show();
    }
    function save_form_inputan(){
        destination = jQuery('#destination').val();
        jQuery('#error_message').text("");
        if(!destination){
            jQuery('#error_message').text("Destination can't blank");
            return false;
        }
        jQuery("#info-saving").addClass('update-nag');
        send_form(document.form_inputan_destination,'_admin/hotel/saving_destination',"#info-saving");
        return true;
    }
</script>
<p>&Colon; Hotel &gg; Destination <input type="button" value="Add new destination" onclick="show_form_inputan()" class="button" id="btn_show"> </p>
<div id="add_new_data">
    <form onsubmit="false" name="form_inputan_destination">
        <table>
            <tr><td colspan="2" height="10px" id="error_message"></td></tr>
            <tr>
                <td>Put new destination here</td>
                <td><input type="text" value="" name="destination" id="destination"></td>
                <td><input type="button" value="Save" class="button" onclick="save_form_inputan()"></td>
                <td><input type="button" value="Cancel" class="button" onclick="cancel_form_inputan()"></td>
            </tr>
            <tr><td colspan="2" height="20px"></td></tr>
        </table>
    </form>
</div>
<h2 style="display:none;"><a class="button add-new-h2" href="javascript:void();" onclick="test();">Export To Excel</a></h2>
<form name="form_data">
    <table id="myTable" class="wp-list-table widefat fixed pages tablesorter" cellspacing="0">
        <thead>
            <tr>
                <th width="4%">
                    <a href="#"><span>No</span></a>
                </th>
                <th width="20%">
                    <a href="#">Destination</a>
                </th>
                <th width="8%">
                    <a href="#">Action</a>
                </th>
            </tr>
        </thead>
        
        <tbody id="result-show-finding">
            <?php
            $i = 1;
            foreach ($d_golden_rate as $row) {
                if ($i >= ($limit - 9)):
                    ?>
                    <tr valign="top"> 
                        <td width="7%">
                            <?php echo $i; ?>.
                        </td>
                        <td class="name-data">
                            <?php echo $row['destination']; ?>             
                        </td>
                        <td>
                            <a class="edit-icon" onclick="load('_admin/hotel/get_detail/?uid=<?php echo $row['uid']; ?>&act=edit_destination_hotel','#site-content')" href="javascript:void();"></a>
                            <a id="hide<?php echo $row['uid']; ?>" class="<?php echo $row['lampu']; ?>" onclick="load('_admin/hotel/get_detail/?uid=<?php echo $row['uid']; ?>&act=lampu_destination','#info-saving');" href="javascript:void(0)"></a>
                        </td>
                    </tr>  
                    <?php
                endif;
                $i++;
            }
            ?>
        </tbody>
    </table>    
    <?php echo $this->pagination->create_links(); ?>

