<script type="text/javascript">
	function kirim_data()
	{
		//alert(document.selected_value);
		//alert(jQuery('#pilihan').val());
		send_form(document.selected_value,"_admin/comision_payment","#respon_div");
	}
	function payed()
	{
		//alert(document.payment_action);
		send_form(document.payment_action,"_admin/comision_payed","#respon_div");
	}
</script>
<style>
	#comision_box
	{
		border:1px solid #CCC;
		padding:5px;
		margin-top:20px;
	}
	th.manage-action{width:30px;}
	td.no-color{background:none;}
	table.wp-list-table tr:hover{background:#DFDFDF; cursor:pointer;}
	.error {
		background: none repeat scroll 0 0 red;
		color: white;
		font-weight: bold;
		margin: 10px 10px 10px 0;
		padding: 5px;
		text-align: center;
		width: 99%;
	}
</style>
<div id="comision_box">
	<center><strong>Commission Payments</strong></center>
    <br>
    <form name="selected_value">
    	<label>Select Type</label>
        <select name="pilihan" id='pilihan' onChange="kirim_data()">
        	<option value="null"> -- select -- </option>
            <option value="all"> All Bonus </option>
            <option value="fast"> Fast Bonus </option>
            <option value="cycle"> Cycle Bonus </option>
            <option value="matching"> Matching Bonus </option>
            <option value="mentor"> Mentor Bonus </option>
        </select>
    </form>
    <br>
    <?php //debug_data($record); ?>
    <form name="payment_action">
    <div id="respon_div"></div>
    </form>
</div>