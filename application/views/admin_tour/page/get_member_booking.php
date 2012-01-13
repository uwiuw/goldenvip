<style type="text/css">
    a.booking_hover:hover{
        color: #000;
        text-decoration: underline;
    }
</style>
<div class="content-admin-right">
    <div class="tx-rwadminhotelmlm-pi1 isi-content-admin-tour">
        <table id="myTable" class="tablesorter">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Id Booking</th>
                    <th>Name</th>
                    <th>Depart</th>
                    <th>Destination</th>
                    <th>Package</th>
                    <th>Reservation</th>
                    <th>Email</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach($booking_travel as $row): if(($i>=($limit-($nilai-1)))and ($i<=$limit)): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['uid']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['depart']; ?></td>
                    <td><?php echo $row['destination']; ?></td>
                    <td><?php echo $row['package']; ?></td>
                    <td><?php echo $row['reservation']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <?php 
                            $num = diffDay2($row['depart'],date('Y-m-d')); 
                            if($num > 1 ):
                        ?>
                        <a href="<?php echo site_url('admin-tour/booking/cancel?uid='.$row['id']."&p=1".'&search='.md5('cancel-booking'.$row['id'])."".$row['id']); ?>" class="booking_hover" alt="Do">
                            Cancel
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php  endif; $i++; endforeach; ?>
                <?php foreach($booking_vip as $row): if(($i>=($limit-($nilai-1)))and ($i<=$limit)): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['uid']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['depart']; ?></td>
                    <td><?php echo $row['destination']; ?></td>
                    <td><?php echo $row['package']; ?></td>
                    <td><?php echo $row['reservation']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <?php 
                            $num = diffDay2($row['depart'],date('Y-m-d')); 
                            if($num > 1 ):
                        ?>
                        <a href="<?php echo site_url('admin-tour/booking/cancel?uid='.$row['id']."&p=2".'&search='.md5('cancel-booking'.$row['id'])."".$row['id']); ?>" class="booking_hover" alt="Do">
                            Cancel
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endif; $i++; endforeach; ?>
            </tbody>
        </table>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>
