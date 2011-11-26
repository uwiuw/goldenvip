<!-- engine php -->
<?php
	foreach($data as $row)
	{
		$distributor[$row['uid']]=$row['firstname']." ".$row['lastname']." (".$row['username'].")";
	}
?>

<!-- script -->
<script type="text/javascript">
	function generate_vcode()
	{
		jQuery('#info-saving').addClass('update-nag');
		send_form(document.generate_vc,'_admin/generate_vc/generate','#info-saving');
	}
</script>

<p>
	<center><strong>Generate Voucher Code</strong></center>
    <br />
    <strong>*) Field is required</strong>
</p>

<form name="generate_vc">
<table>
	<tr>
    	<td>Distributor</td>
        <td>
        	<?php echo form_dropdown('distributor',$distributor); ?>
        </td>
    </tr>
    
    <tr>
    	<td>Number Of Voucher</td>
        <td><input type="text" name="number_vc"></td>
    </tr>
    <tr height="40px" valign="middle">
    	<td colspan="2" align="right"><a href="javascript:void();" onclick="generate_vcode();" class="button">Generate</a></td>
    </tr>
</table>
</form>