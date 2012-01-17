<br />
<script type="text/javascript" src="<?php echo base_url();?>asset/js/script/hotel/app_hotel.js.js" />
<form name="update_data_hotel">
<table>
        <tr>
            <td colspan="3" align="left">&Colon; Hotel Management &gg; Edit Data Hotel</td>
        </tr>
        <tr>
            <td height="25px" id="reload_data"></td>
            <td colspan="2"></td>
        </tr>
        
        <tr>
            <td>Hotel Name</td>
            <td>
                <input id="hotel_name" type="text" name="hotel_name" value="<?php echo $d_hotel['hotel_name']; ?>" readonly="readonly" />
                <input id="hotel_name" type="hidden" name="uid" value="<?php echo $d_hotel['uid']; ?>" />
                <input id="hotel_name" type="hidden" name="idu" value="<?php echo $d_hotel['idu']; ?>" />
                <input type="hidden" id ="read_data" name="read_data" value="2"> 
            </td>
            <td id="error_hotel_name"></td>
        </tr>
        
        <tr>
            <td>Username to login</td>
            <td><input type="text" id="username" name="username" value="<?php echo $d_hotel['username']; ?>" readonly="readonly"></td>
            <td id="error_username"></td>
        </tr>
        
        <tr>
            <td>email</td>
            <td><input type="text" id="email" name="email" value="<?php echo $d_hotel['email']; ?>"></td>
            <td id="error_email"></td>
        </tr>
        
        <tr>
            <td>Password</td>
            <td><input type="password" id="pwd" name="pwd"></td>
            <td id="error_pwd">Put blank if not changed.</td>
        </tr>
        
        <tr>
            <td>Confirmed Password</td>
            <td><input type="password" id="pwd2" name="pwd2"></td>
            <td id="error_pwd2"></td>
        </tr>
        
        <tr>
            <td>Destination</td>
            <td><?php $id = "id='destination' onchange='management_hotel_cek_detail();' "; echo form_dropdown('destination',$destination,$d_hotel['uid_destination'],$id); ?></td>
            <td id="error_destination"></td>
        </tr>
        
        <tr>
            <td>Destination Detail</td>
            <td id="destination_detail"><?php if(isset($destination_detail)): echo form_dropdown('destination_detail',$destination_detail,$d_hotel['uid_destination_detail']); endif; ?></td>
            <td></td>
        </tr>
        
        <tr>
            <td>Star</td>
            <td><?php $id="id='star'"; echo form_dropdown('star',$star,$d_hotel['star'],$id); ?></td>
            <td id="error_star"></td>
        </tr>
        
        <tr>
            <td>Compliment</td>
            <td><?php $id="id = 'compliment'"; echo form_dropdown('compliment',$compliment,$d_hotel['compliment'],$id); ?></td>
            <td id="error_compliment"></td>
        </tr>
        
        <tr>
            <td>Management by core</td>
            <td><?php $id="id='core'"; echo form_dropdown('management_by',$by_core,$d_hotel['management_by'],$id); ?></td>
            <td id="error_core"></td>
        </tr>
        
        <tr>
            <td colspan="2" align="right"><input type="button" class="button" value="Update data" onclick="management_hotel_cek_form('update');"/></td>
        </tr>
</table>
</form>