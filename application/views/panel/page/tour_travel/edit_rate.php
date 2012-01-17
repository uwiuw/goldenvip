<script type="text/javascript">
	function update_vip_rate()
	{
		retail_rate = jQuery('#retail_rate').val();
		
		if(isNaN(retail_rate))
		{
			alert('Retail rate is not a number');
		}
		else
		{
			gvip_rate = jQuery('#gvip_rate').val();
			if(isNaN(gvip_rate))
			{
				alert('Gvip rate is not a number');
			}
			else
			{
				send_form(document.update_rate,'_admin/tour_travel/update_rate',"#info-saving");
				jQuery('#info-saving').addClass('update-nag');
			}
		}
	}
</script>
<style type="text/css">
	#edit-rate{
		border:1px solid #CCC;
		padding:10px;
		margin-top:20px;
	}
</style>
<div id="edit-rate">
<form name="update_rate">
<table cellspacing="1" cellpadding="0" >
        <tbody>
        <tr class="even">
            <td width="108">Destination</td>
            <td width="426"><?php echo $destination; ?></td>
        </tr>
        <tr class="even" >
            <td>Type Package</td>
            <td ><?php echo $package; ?></td>
        </tr>
        <tr class="even">
            <td>Agen</td>
            <td><?php echo $agen; ?></td>
        </tr>
        <tr>
            <td>Published rate</td>
            <td><?php echo $harga; ?> USD</td>
        </tr>
        <tr class="even">
            <td>Retail Rate</td>
            <td><input type="text" value="<?php echo $retail_rate; ?>" onkeypress="validate(event)" name="retail_rate" id="retail_rate">&nbsp;&nbsp;Just Number</td>
        </tr>
        <tr class="odd">
        	<td>GVIP Rate</td>
            <td><input type="text" value="<?php echo $gvip_rate; ?>" onkeypress="validate(event)" name="gvip_rate" id="gvip_rate">&nbsp;&nbsp;Just Number</td>
        </tr>
        </tbody>
</table> 
<input type="hidden" name="vip" value="<?php echo $uid; ?>">
<input type="hidden" name="cat" value="<?php echo $cat; ?>">
<input type="button" value="Save" onClick="update_vip_rate();">
</form>
</div>