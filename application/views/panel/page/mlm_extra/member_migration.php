<p>&Colon; MLM Extra &gg; Member Migration</p>

<style>
	th.manage-action{width:30px;}
	td.no-color{background:none;}
	table.wp-list-table tr:hover{background:#CCC; cursor:pointer;}
</style>
<script type="text/javascript">
	function searching_data_migration()
	{
		send_form(document.search_form_migration,'_admin/searching_form','#site-content');
	}
	jQuery(function(){
			jQuery("#myTable").tablesorter();
			jQuery('#myTable tbody tr:odd').addClass('odd');
		});
</script>

<h2 style="display:none;"><a class="button add-new-h2" href="javascript:void();" onclick="test();">Export To Excel</a></h2>
<form name="search_form_migration" onsubmit="searching_data();">
	<table width="100%">
    	<tr align="right">
        	<td class="no-color" align="left"></td>
        	<td class="no-color">Search Member Here : </td>
        	<td width="10%" class="no-color"><input type="text" name="reg"  /><input type="hidden" name="search" value="migration" /></td>
            <td width="5%" class="no-color"><a class="button" href="javascript:void();" onclick="searching_data_migration();">Find</a></td>
        </tr>
    </table>
</form>

<form name="form_data">
<table id="myTable" class="wp-list-table widefat fixed pages tablesorter" cellspacing="0">
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
            <th width="8%">
                <a href="#">Action</a>
            </th>
        </tr>
    </thead>
    
    <tbody id="result-show-finding">
    <?php $i=1;foreach($member as $row) { ?>
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
                <?php if($row['package']!=2): if($row['package']!=13): ?>
                <a href="javascript:void();" onclick="
                    if(confirm('Are you sure want to migration this data : <?php echo $row['firstname']." ".$row['lastname']; ?> to Travel Package ?'))
                        load('_admin/member_set_new_grade?id=<?php echo $row['uid'];?>&pack=13','#info-saving');
                        jQuery('#info-saving').addClass('update-nag');
                        jQuery('#t-<?php echo $row['uid']; ?>').hide();
                    endif;" 
                    id="t-<?php echo $row['uid']; ?>">Travel | </a>
                <?php endif; endif; ?>
                <a href="javascript:void();" onclick="
                    if(confirm('Are you sure want to migration this data : <?php echo $row['firstname']." ".$row['lastname']; ?> to VIP Package ?'))
                        load('_admin/member_set_new_grade?id=<?php echo $row['uid'];?>&pack=12','#info-saving');
                        jQuery('#info-saving').addClass('update-nag');
                        jQuery('#t-<?php echo $row['uid']; ?>').hide();
                        jQuery('#v-<?php echo $row['uid']; ?>').hide();
                    endif;"
                    id="v-<?php echo $row['uid']; ?>">VIP</a>
            </td>
        </tr>  
    <?php $i++;} ?>
    </tbody>
</table>    
  

