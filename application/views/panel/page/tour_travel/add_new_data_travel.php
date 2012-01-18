<br />
<script type="text/javascript" src="<?php echo base_url();?>asset/js/script/tour_travel/tour.js" />
<form name="form_new_tour_destination" onsubmit="tour_travel_cek_form()" method="post">
<table>
        <tr>
            <td colspan="3" align="left">&Colon; Tour & Travel &gg; Add New Destination </td>
        </tr>
        <tr>
            <td height="25px" id="reload_data"></td>
            <td colspan="2"></td>
        </tr>
   
        <tr>
            <td>Destination </td>
            <td>
                <input id="destination" type="text" name="destination" value="<?php echo $destination; ?>"  />
                <input id="read_data" type="hidden" name="read_data" value="<?php echo $uid; ?>"  />
            </td>
            <td id="error_destination"></td>
        </tr>
        <tr>
            <td>Point </td>
            <td>
                <input id="point" type="text" name="point" value="<?php echo $point; ?>"  />
            </td>
            <td id="error_point"></td>
        </tr>
        <tr>
            <td>Tour & Travel Package </td>
            <td><?php $id = "id='package' "; echo form_dropdown('package',$package,$pid,$id); ?></td>
            <td id="error_package"></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><input type="button" class="button" value="Save" onclick="tour_travel_cek_form();"/></td>
        </tr>
</table>
</form>