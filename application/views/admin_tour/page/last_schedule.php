<div class="content-admin-right">
    <div class="tx-rwadminhotelmlm-pi1 isi-content-admin-tour">
        <?php if(isset($info))echo "<div class=\"error\">".$info."</div>" ?>
        <?php debug_data($last_sch); ?>
        <table id="myTable" class="tablesorter">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Time Schedule</th>
                    <th>Destination</th>
                    <th>Package</th>
                    <th>MyGoldenVIP Pack</th>
                    <th>QTY</th>
                    <th>Booking</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($last_sch_travel as $row): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['time_sch']; ?></td>
                    <td><?php echo $row['destination']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['package']; ?></td>
                    <td><?php echo $row['qty']; ?></td>
                    <td><?php echo $row['booking']; ?></td>
                    <td>
                        <a href="<?php echo site_url('admin-tour/in-active-data?uid='.$row['uid'].'&search='.md5('browse-sch-travel'.$row['uid'])."".$row['uid']); ?>" class="browse" title="browse data"></a>
                        
                        <?php if($row['hidden']==0): ?>
                        <a href="<?php echo site_url('admin-tour/in-active-data?uid='.$row['uid'].'&search='.md5('hidden-sch-travel'.$row['uid'])."".$row['uid']); ?>" class="lampunyala" title="Schedule is active, click here to inactive this package"></a>
                        <?php else: ?>
                        <a href="<?php echo site_url('admin-tour/in-active-data?uid='.$row['uid'].'&search='.md5('active-sch-travel'.$row['uid'])."".$row['uid']); ?>" class="lampumati" title="Schedule is in-active, click here to active this package"></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php $i++; endforeach;?>
                <?php foreach ($last_sch_vip as $row): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['time_sch']; ?></td>
                    <td><?php echo $row['destination']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['package']; ?></td>
                    <td><?php echo $row['qty']; ?></td>
                    <td><?php echo $row['booking']; ?></td>
                    <td>
                        <a href="<?php echo site_url('admin-tour/in-active-data?uid='.$row['uid'].'&search='.md5('browse-sch-vip'.$row['uid'])."".$row['uid']); ?>" class="browse" title="browse data"></a>
                        
                        <?php if($row['hidden']==0): ?>
                        <a href="<?php echo site_url('admin-tour/in-active-data?uid='.$row['uid'].'&search='.md5('hidden-sch-vip'.$row['uid'])."".$row['uid']); ?>" class="lampunyala" title="Schedule is active, click here to inactive this package"></a>
                        <?php else: ?>
                        <a href="<?php echo site_url('admin-tour/in-active-data?uid='.$row['uid'].'&search='.md5('active-sch-vip'.$row['uid'])."".$row['uid']); ?>" class="lampumati" title="Schedule is in-active, click here to active this package"></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>
</div>
