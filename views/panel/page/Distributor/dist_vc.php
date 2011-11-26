<?php 
		$i=1;
		foreach($data as $row) 
		{ 
	?>
        <tr valign="top"> 
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
                <?php $row['distributor']; ?>
            </td>
            <td>
            	<a href="javascript:void();" onclick="dialog_box_delete('<?php echo $row['uid']; ?>','<?php echo $row['voucher_code']; ?>');" class="del-data"></a>
            </td>
        </tr>  
    <?php 
			$i++;
		} 
	?>