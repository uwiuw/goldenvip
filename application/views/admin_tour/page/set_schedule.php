<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/ui-lightness/base/jquery.ui.all.css" type="text/css" media="screen"> 
<script src="<?php echo base_url(); ?>asset/js/lib/jquery-ui-1.8.16.custom.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.dialog.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.core.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
    jQuery(function(){
        jQuery('#travel_pack').hide();
        jQuery('#vip_pack').hide();
        jQuery( "#datepicker" ).datepicker({ 
            minDate:-0,
                changeMonth: false,
                dateFormat:"yy-m-d",
                numberOfMonths: 1,
                showButtonPanel: false
        });
    });
    
    function validate_rate()
    {
        rate = document.getElementById('qty').value;
        if(isNaN(rate))
        {
            alert('Quantity rate is not a number!');
        }
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
        <?php if($this->session->flashdata('info')) echo "<div class=\"error\">".$this->session->flashdata('info')."</div>" ?>
        <form action="<?php echo site_url('admin-tour/set-schedule/save-schedule'); ?>" method="POST" name="edit_data_package" id="edit_data_package"  enctype="multipart/form-data">
            <table cellspacing="1" cellpadding="0" border="0" class="tablesorter" id="tablesorter-demo">
                <tbody>
                    
                    
                    <tr class="odd">
                        <td>My Golden VIP Package</td>
                        <td>
                            <?php $id = "id='mygoldenvippackage' onchange='select_pack()'"; echo form_dropdown('mygoldenvippackage',$mygoldenvip,'',$id); ?>
                        </td>
                        <td>
                            <div style="color: red;" id="errorstok"></div>
                        </td>
                    </tr>
                    
                    <tr class="even" id="travel_pack">
                        <td>Package for Travel</td>
                        <td>
                            <?php echo form_dropdown('destination_travel',$travelpackage); ?>
                        </td>
                        <td>
                            <div style="color: red;" id="errorstok"></div>
                        </td>
                    </tr>
                    
                    <tr class="even" id="vip_pack">
                        <td>Package for VIP</td>
                        <td>
                            <?php echo form_dropdown('destination_vip',$vippackage); ?>
                        </td>
                        <td>
                            <div style="color: red;" id="errorstok"></div>
                        </td>
                    </tr>
                    
                    <tr class="odd">
                        <td>Qty</td>
                        <td><input type="text" name="qty" id="qty" onchange="validate_rate();"></td>
                        <td>
                            <div style="color: red;" id="errorRate"></div>
                        </td>
                    </tr>
                    
                    <tr class="even">
                        <td>Time Schedule</td>
                        <td><input type="text" name="datepicker" id="datepicker" ></td>
                        <td>
                            <div style="color: red;" id="errorRate"></div>
                        </td>
                    </tr>
                    
                    
                    

                </tbody>
            </table>
            <input type="submit" class="et-form-btn" id="submit_photo" name="submit" value="Save" onclick="check_validation();">
        </form>
    </div>
</div>