<script type="text/javascript">
    jQuery(function(){
        jQuery("#myTable").tablesorter();
        jQuery('#myTable tbody tr:odd').addClass('odd');
    });
</script>
<table id="myTable" class="wp-list-table widefat fixed pages tablesorter" cellspacing="0">
    <thead>
        <tr>
            <th width="5%">
                <a href="#"><span>No</span></a>
            </th>
            <th width="7%">
                <a href="#"><span>Id Booking</span></a>
            </th>
            <th width="16%">
                <a href="#"><span>Date Reserved</span></a>
            </th>
            <th width="15%">
                <a href="#">Reserved</a>
            </th>
            <th width="11%">
                <a href="#">Member</a>
            </th> 
            <th width="11%">
                <a href="#">Destination</a>
            </th> 
            <th width="11%">
                <a href="#">Package</a>
            </th>
            <th width="15%"><a href="#">Travel Agen</a></th>
            <th width="4%">
                <a href="#">Paid</a>
            </th>
            <th width="5%">
                <a href="#">Action</a>
            </th>
        </tr>
    </thead>

    <tbody id="result-show-finding">
        <?php $i = 1;
        foreach ($profit_member as $row) { ?>
            <tr valign="top"> 
                <td width="5%">
    <?php echo $i; ?>.
                </td>
                <td><?php echo $row['uid']; ?></td>
                <td>
    <?php echo $row['time_sch']; ?>
                </td>
                <td class="name-data">
    <?php echo $row['reserved']; ?>         
                </td>
                <td>
    <?php echo $row['member']; ?>
                </td>
                <td>
    <?php echo $row['destination']; ?>
                </td>
                <td>
    <?php echo $row['package']; ?>
                </td>
                <td>
    <?php echo $row['travel_agen']; ?>
                </td>
                <td class="paid-<?php echo $p . "" . $row['uid']; ?>">No</td>
                <td>
                    <a href="javascript:void();" onclick="load('_admin/tour_travel/paid_booking/?uid=<?php echo $row['uid']; ?>&p=<?php echo $p; ?>','#info-saving')" class="hide-<?php echo $p . "" . $row['uid']; ?>" >Paid</a>
                </td>
            </tr>  
    <?php $i++;
} ?>
    </tbody>
</table>