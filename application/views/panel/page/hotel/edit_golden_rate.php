<br />
<script type="text/javascript" src="<?php echo base_url();?>asset/js/script/hotel/app_hotel.js.js" />
<form name="update_data_golden_rate">
<table>
        <tr>
            <td colspan="3" align="left">&Colon; Golden VIP Rate &gg; Edit Rate</td>
        </tr>
        <tr>
            <td height="25px" id="reload_data"></td>
            <td colspan="2"></td>
        </tr>
   
        <tr>
            <td>Type Room</td>
            <td>
                <input id="category_name" type="text" name="category_name" value="<?php echo $data['category_name']; ?>" />
                <input id="uid_hotel" type="hidden" name="uid" value="<?php echo $data['uid']; ?>" />
            </td>
            <td id="error_category_name"></td>
        </tr>
        
        <tr>
            <td>Hotel Name</td>
            <td><input id="hotel_name" type="text" name="hotel_name" value="<?php echo $data['hotel_name']; ?>" readonly="readonly" /></td>
            <td id="error_hotel_name"></td>
        </tr>
        
        <tr>
            <td>Retail Rate</td>
            <td><input id="retail" type="text" name="retail" value="<?php echo $data['retail']; ?>" /></td>
            <td id="error_retail"></td>
        </tr>
        
        <tr>
            <td>Golden VIP Rate</td>
            <td><input id="golden_rate" type="text" name="golden_rate" value="<?php echo $data['golden_rate']; ?>" /></td>
            <td id="error_golden_rate"></td>
        </tr>
        
        <tr>
            <td colspan="2" align="right"><input type="button" class="button" value="Update data" onclick="golden_rate_cek_form();"/></td>
        </tr>
</table>
</form>