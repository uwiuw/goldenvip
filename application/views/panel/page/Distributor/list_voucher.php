<!-- engine php -->
<?php
	$distributor[0] = "Select";
	foreach($data as $row)
	{
		$distributor[$row['uid']]=$row['firstname']." ".$row['lastname']." (".$row['username'].")";
	}
?>
<!-- script -->
<script type="text/javascript">
	function select_distributor()
	{
		v = jQuery('#distributor').val();
		load_no_image('_admin/post_data/get_vc_by_dist/'+v,'#list_voucher');
	}
	jQuery(function(){
		jQuery("#myTable").tablesorter();
		jQuery('#myTable tbody tr:odd').addClass('odd');
	});
</script>

<!-- style -->
<style>
	th.manage-action{width:30px;}
	td.no-color{background:none;}
	table.wp-list-table tr:hover{background:#CCC; cursor:pointer;}
</style>

<!-- conetent -->
<p>
    <center>
        <strong>List Data Voucher Code</strong>
    </center>
</p>

<table>
	<tr>
    	<td>Select by distributor</td>
    	<td><?php $id=" id = 'distributor' onchange='select_distributor();'"; echo form_dropdown('distributor',$distributor,'0',$id); ?> </td>
    </tr>
    <tr>
        <td>Total Data</td>
        <td>: <?php echo count($total_data); ?></td>
    </tr>    
    <tr>
        <td>Hasn't been used</td>
        <td>: <?php echo $data_unused['data_unused']; ?></td>
    </tr>
    <tr>    
        <td>used</td>
        <td>: <?php echo $data_used['data_used']; ?></td>
    </tr>
</table>
<br />
<h2><a class="button add-new-h2" href="javascript:void();" onclick="load('_admin/generate_vc','#site-content');">Generate Voucher Code</a></h2>
<br />
<table id="myTable" class="wp-list-table widefat fixed pages tablesorter" cellspacing="0">
    <thead>
        <tr>
            <th width="4%">
                <span>No</span>
            </th>
            <th width="20%">
                Voucher Code
            </th>
            <th width="10%">
                Status
            </th> 
            <th width="12%">
                Issued Date
            </th> 
            <th width="25%">
                Distributor
            </th>
            
            <th width="8%">
                Action
            </th>
        </tr>
    </thead>
    
    <tbody id="list_voucher">
    <?php 
		$i=1;
		foreach($total_data as $row) 
		{
			
				
	?>
        <tr valign="top" id="hidevc<?php echo $row['uid']; ?>"> 
            <td width="7%">
                <?php echo $i; ?>.
            </td>
            <td class="name-data">
               <?php echo $row['voucher_code']; ?>             
            </td>
            <td>
                <?php 
					if($row['status']=='0')
					{
						echo "Available"; 
					}
					else
					{
						echo "Used"; 
					}
				?>
            </td>
            <td>
                <?php echo date('d-M-Y H:i:s',$row['crdate']); ?>
            </td>
            <td>
                <?php echo $distributor[$row['distributor']]; ?>
            </td>
            <td>
            <?php 
					if($row['status']=='0')
					{
						?>
                        <a href="javascript:void()" onclick="load('_admin/post_data/del-vc/<?php echo $row['uid']; ?>/<?php echo $row['pid']; ?>','#info-saving');" class="del-data" ></a>
                        <?php
					}
				?>
                
               
            </td>
        </tr>  
    <?php 
			$i++;
			
		
		} 
	?>
    </tbody>
    
</table>
 