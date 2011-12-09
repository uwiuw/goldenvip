<p>Path : /MLM Management/Distributor </p>
<?php $data = getDistributorMLM(); ?>
<center>
	<strong>List Data Distributor (<?php echo count($data); ?> record)</strong>
</center>
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
<form name="search_form" onsubmit="searching_data();">
	<table width="100%">
    	<tr align="right">
        	<td class="no-color" align="left"> The table only displays data less than 50x records</td>
        	<td class="no-color">Search Distributor Here : </td>
        	<td width="10%" class="no-color"><input type="text" name="reg"  /></td>
            <td width="5%" class="no-color"><a class="button" href="javascript:void();" onclick="searching_data();">Find</a></td>
        </tr>
    </table>
</form>

<form name="form_data">
<table id="myTable" class="tablesorter" cellspacing="0">
    <thead>
        <tr>
            <th width="4%">
                <a href="#"><span>No</span></a>
            </th>
            <th width="20%">
                <a href="#">Nama</a>
            </th>
            <th width="20%">
                <a href="#">Email</a>
            </th> 
            <th width="12%">
                <a href="#">Username</a>
            </th> 
            <th width="17%">
                <a href="#">Mobile Phone</a>
            </th>
            <th width="30%">
                <a href="#">Regional</a>
            </th>
            <th width="8%">
                <a href="#">Action</a>
            </th>
        </tr>
    </thead>
    
    <tbody id="result-show-finding">
    <?php $i=1;foreach($data as $row) { ?>
        <tr valign="top"> 
            <td width="7%">
                <?php echo $i; ?>.
            </td>
            <td class="name-data">
               <?php echo $row['firstname']." ".$row['lastname']; ?>             
            </td>
            <td>
                <?php echo $row['email']; ?>
            </td>
            <td>
                <?php echo $row['username']; ?>
            </td>
            <td>
                <?php echo $row['mobilephone']; ?>
            </td>
            <td>
                <?php echo $row['city']; ?>
            </td>
            <td>
            <a href="javascript:void();" onclick="load('_admin/post_data/get_member/<?php echo $row['uid']; ?>/<?php echo $row['pid']; ?>','#site-content')" class="browse"></a><a href="javascript:void();" onclick="dialog_box_delete('<?php echo $row['uid']; ?>','<?php echo $row['firstname']." ".$row['lastname']; ?>');" class="del-data"></a>
            </td>
        </tr>  
    <?php $i++;} ?>
    </tbody>
</table>    
  
<div id="dialog-confirm" title="Delete item?"> 
	<p>
    	<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
    	These data : <b>"<span class="data-want-to-delete"></span>"</b> will be permanently deleted and cannot be recovered. Are you sure? 
    </p>
</div>    