
<style>
	th.manage-action{width:30px;}
	td.no-color{background:none;}
	table.wp-list-table tr:hover{background:#CCC; cursor:pointer;}
        .hidden-data{display: none;}
</style>
<script type="text/javascript">
	function searching_data()
	{
		send_form(document.search_form,'_admin/searching_form','#site-content');
	}
	jQuery(function(){
			jQuery("#myTable").tablesorter();
			jQuery('#myTable tbody tr:odd').addClass('odd');
                        pagination();
		});
        function pagination()
       {
           //nav = jQuery('#pagination a').each();
           jQuery('#pagination a').each(function(index) {
            nav = jQuery(this).attr('href');
            teks = "pagination_page('"+nav+"','#site-content','#loading_pagination')";
            jQuery(this).attr('href','javascript:void(load('+teks+'))');           
          });
       }
</script>
<p> &Colon; MLM Management</p>
<h2 style="display:none;"><a class="button add-new-h2" href="javascript:void();" onclick="test();">Export To Excel</a></h2>
<form name="search_form" onsubmit="searching_data();">
	<table width="100%">
    	<tr align="right">
        	<td class="no-color" align="left"><div id="loading_pagination"></div></td>
        	<td class="no-color">Search Name Here : </td>
        	<td width="10%" class="no-color"><input type="text" name="reg"  /><input type="hidden" name="search" value="<?php echo $path; ?>" /></td>
            <td width="5%" class="no-color"><a class="button" href="javascript:void();" onclick="searching_data();">Find</a></td>
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
            <th width="16%">
                <a href="#">Email</a>
            </th> 
            <th width="12%">
                <a href="#">Username</a>
            </th> 
            <th width="10%">
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
    <?php $i=1;foreach($data as $row) { if($i>=($limit-($nilai-1))): ?>
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
            
            <?php 
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','valid',$row['uid'],'uid'); 
				if($d['valid']=='1')
				{
            ?>
            <a href="javascript:void();" onclick="load('_admin/post_data/get_member/<?php echo $row['uid']; ?>/<?php echo $row['pid']; ?>','#site-content')" class="browse" id="browsemember<?php echo $row['uid'];?>" ></a>
            <a href="javascript:void()" onclick="load('_admin/post_data/hide_member/<?php echo $row['uid']; ?>/<?php echo $row['pid']; ?>','#info-saving');" class="lampunyala" id="hide<?php echo $row['uid']; ?>"></a>
            <?php 
				}
				else
				{
			?>
            <a href="javascript:void();" onclick="load('_admin/post_data/get_member/<?php echo $row['uid']; ?>/<?php echo $row['pid']; ?>','#site-content')" class="browse hidden-data" id="browsemember<?php echo $row['uid'];?>" ></a>
            <a href="javascript:void()" onclick="load('_admin/post_data/hide_member/<?php echo $row['uid']; ?>/<?php echo $row['pid']; ?>','#info-saving');" class="lampumati"  id="hide<?php echo $row['uid']; ?>"></a>
            <?php } ?>
            </td>
        </tr>  
    <?php endif;$i++;} ?>
    </tbody>
</table>   
<?php echo $this->pagination->create_links(); ?>
  

