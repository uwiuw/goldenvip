<script type="text/javascript">
    jQuery(function(){
        jQuery('#travel_pack').hide();
        jQuery('#vip_pack').hide();
    });
    function check_validity()
    {
        var packages = jQuery('#package').val();
        var prates = jQuery('#published_rate').val();
        var rrates = jQuery('#retail_rate').val();
        var goldenvippackage = jQuery('#mygoldenvippackage').val();
        var travel_pack = jQuery('#destination_travel_pack').val();
        var vip_pack = jQuery('#destination_vip_pack').val();
        
        if(!packages)
        {
            jQuery('#errorpackage').text("can't blank");
            return false;
        }
        else
        {
            jQuery('#errorpackage').text("");
        }
        if(!prates)
        {
            jQuery('#errorpublished_rate').text("can't blank");
            return false;
        }
        
        if(!rrates)
        {
            jQuery('#errorretail_rate').text("can't blank");
            return false;
        }
        if(isNaN(prates))
        {
            jQuery('#errorpublished_rate').text('is not a number');
            return false;
        }
        else{
            jQuery('#errorpublished_rate').text("");
        }
        if(isNaN(rrates))
        {
            jQuery('#errorretail_rate').text('is not a number');
            return false;
        }
        else{
            jQuery('#errorretail_rate').text("");
        }
        
        if(!goldenvippackage){
            jQuery('#errorvippackage').text("can't be empty");
            return false;
        }
        else{
            jQuery('#errorvippackage').text('');
        }
        
        if(goldenvippackage == 1){
            if(!travel_pack){
                jQuery('#errortravel_pack').text("can't be empty");
                return false;
            }
            else{
                jQuery('#errortravel_pack').text('');
            }
        }else{
            if(!vip_pack){
                jQuery('#errorvip_pack').text("can't be empty");
                return false;
            }
            else{
                jQuery('#errorvip_pack').text('');
            }
        }
        jQuery.post("<?php echo site_url('admin-tour/package-management/add_data_package'); ?>",jQuery('#edit_data_package').serialize(), 
               function(data) {
                   jQuery('#add_p').addClass('error');
                   jQuery('#add_p').text('New package has been added. '+data);
               });
    }
    function select_pack()
    {
        pack = jQuery('#mygoldenvippackage').val();
        if(pack == '')
        {
            jQuery('#travel_pack').hide();
            jQuery('#vip_pack').hide();
        }
        else if(pack == '1')
        {
            jQuery('#travel_pack').show();
            jQuery('#vip_pack').hide();
        }
        else
        {
            jQuery('#travel_pack').hide();
            jQuery('#vip_pack').show();
        }
    }
</script>
<div class="content-admin-right">
    <div class="tx-rwadminhotelmlm-pi1 isi-content-admin-tour">
        <div id="add_p"></div>
        
        <form action="" method="POST" name="edit_data_package" id="edit_data_package"  enctype="multipart/form-data">
            <table cellspacing="1" cellpadding="0" border="0" class="tablesorter" id="tablesorter-demo">
                <tbody>
                    <tr class="even">
                        <td>Package</td>
                        <td>
                            <input type="text" id="package" name="package">
                            <input type="hidden" name="uid" />
                        </td>
                        <td>
                            <div style="color: red;" id="errorpackage"></div>
                        </td>
                    </tr>
                    
                    <tr class="odd">
                        <td>Published Rates</td>
                        <td><input type="text" name="published_rate" id="published_rate" onchange="validate_rate();">&nbsp;USD (Just Number)</td>
                        <td>
                            <div style="color: red;" id="errorpublished_rate"></div>
                        </td>
                    </tr>
                    
                    <tr class="even">
                        <td>Retail Rates</td>
                        <td><input type="text" name="retail_rate" id="retail_rate" >&nbsp;USD (Just Number)</td>
                        <td>
                            <div style="color: red;" id="errorretail_rate"></div>
                        </td>
                    </tr>
                    
                    <tr class="odd">
                        <td>My Golden VIP Package</td>
                        <td>
                            <?php $id = "id='mygoldenvippackage' onchange='select_pack()'"; echo form_dropdown('mygoldenvippackage',$mygoldenvip,'',$id); ?>
                        </td>
                        <td>
                            <div style="color: red;" id="errorvippackage"></div>
                        </td>
                    </tr>
                    
                    <tr class="even" id="travel_pack">
                        <td>Destination</td>
                        <td>
                            <?php $id = "id='destination_travel_pack'"; echo form_dropdown('destination_travel',$destination_travel,'',$id); ?>
                        </td>
                        <td>
                            <div style="color: red;" id="errortravel_pack"></div>
                        </td>
                    </tr>
                    
                    <tr class="even" id="vip_pack">
                        <td>Destination</td>
                        <td>
                            <?php $id = "id='destination_vip_pack'"; echo form_dropdown('destination_vip',$destination_vip,'',$id); ?>
                        </td>
                        <td>
                            <div style="color: red;" id="errorvip_pack"></div>
                        </td>
                    </tr>
                    
                    <tr class="odd">
                        <td>Description</td>
                        <td>
                            <textarea id="description" rows="10" cols="40" name="description"></textarea>
                        </td>
                        <td>
                        </td>
                    </tr>
                   
                    <tr class="even">
                        <td>Browse for itienary this package</td>
                        <td><input id="itienary" type="file" name="itienary"> </div></td>
                        <td><div style="color: red;" id="erroritienary"></td>
                    </tr>  
                </tbody>
            </table>
            <input type="button" class="et-form-btn" id="submit_photo" name="submit" value="Save" onclick="check_validity();">
            <input type="button" onclick="history.go(-1);" value="Back">
        </form>
    </div>
</div>