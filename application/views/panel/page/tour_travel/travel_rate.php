<br />
<style>
	th.manage-action{width:30px;}
	td.no-color{background:none;}
	table.wp-list-table tr:hover{background:#CCC; cursor:pointer;}
</style>
<script type="text/javascript">
	function searching_data()
	{
		send_form(document.search_form,'_admin/post_data/search_distributor','#result-show-finding');
	}
	jQuery(function(){
			jQuery("#myTable").tablesorter();
			jQuery('#myTable tbody tr:odd').addClass('odd');
		});
</script>

<h2 style="display:none;"><a class="button add-new-h2" href="javascript:void();" onclick="test();">Export To Excel</a></h2>
<form name="search_form" onsubmit="searching_data();" style="display:none;">
	<table width="100%">
    	<tr align="right">
        	<td class="no-color" align="left"> The table only displays data less than 50 records</td>
        	<td class="no-color">Search Distributor Here : </td>
        	<td width="10%" class="no-color"><input type="text" name="reg"  /><input type="hidden" name="cat" value="<?php echo $cat; ?>" /></td>
            <td width="5%" class="no-color"><a class="button" href="javascript:void();" onclick="searching_data();">Find</a></td>
        </tr>
    </table>
</form>

<form name="form_data">
<table id="myTable" class="wp-list-table widefat fixed pages tablesorter" cellspacing="0">
    <thead>
        <tr>
            <th width="5%">
                <a href="#"><span>No</span></a>
            </th>
            <th width="16%">
            	<a href="#"><span>Destination</span></a>
            </th>
            <th width="11%">
                <a href="#">Type Package</a>
            </th>
            <th width="23%">
                <a href="#">Agen</a>
            </th> 
            <th width="11%">
                <a href="#">Retail Rate</a>
            </th> 
            <th width="11%">
                <a href="#">GVIP Rate</a>
            </th>
            <th width="9%">
                <a href="#">Action</a>
            </th>
        </tr>
    </thead>
    
    <tbody id="result-show-finding">
    <?php $i=1;foreach($data as $row) { ?>
        <tr valign="top"> 
            <td width="5%">
            	<?php echo $i; ?>.
            </td>
            <td>
            	<?php echo $row['destination']; ?>
            </td>
            <td class="name-data">
            	<?php echo $row['package']; ?>         
            </td>
           	<td>
            	<?php echo $row['agen']; ?>
            </td>
            <td>
            	<?php echo $row['retail_rate']; ?>
            </td>
            <td>
            	<?php echo $row['gvip_rate']; ?>
            </td>
            <td>
            <a href="javascript:void();" onclick="load('_admin/post_data/edit_travel_rate/<?php echo $row['uid']; ?>','#site-content')" class="edit-icon"></a>
            </td>
        </tr>  
  	 <?php $i++;} ?>
    </tbody>
</table>    
  

