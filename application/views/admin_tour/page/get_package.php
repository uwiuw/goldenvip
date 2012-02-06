<div class="content-admin-right">
    <div class="tx-rwadminhotelmlm-pi1 isi-content-admin-tour">
        <a href="<?php echo site_url('admin-tour/package-management/add-package'); ?>">
            <div id="tk"><img width="15px;" title="Add Package" src="<?php echo base_url(); ?>asset/admin_hotel/add-icon.png">Add Package</div>
            <br />
        </a>
        <br />
        <div id="reload_data"></div>

        <div id="site-content">
            <table id="myTable" class="tablesorter">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Package</th>
                        <th>Destination</th>
                        <th>Published Rate (USD)</th>
                        <th>Retail Rate (USD)</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1;
                    foreach ($travelpackage as $row): if (($i >= ($limit - ($nilai - 1))) and ($i <= $limit)): ?>
                            <tr>
                                <td><?php echo $i; ?>.</td>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['tujuan']; ?></td>
                                <td><?php echo $row['harga']; ?></td>
                                <td><?php echo $row['retail_rate']; ?></td>
                                <td>
                                    <a href="<?php echo site_url('admin-tour/edit_data?uid=' . $row['uid'] . "&p='travel'&search=" . md5($row['uid'] . 'travel-edit') . "" . $row['uid']); ?>" class="edit-icon" title="edit this package"></a>
                                    <?php if ($row['hidden'] == 0): ?>
                                        <a href="<?php echo site_url('admin-tour/in-active-data?uid=' . $row['uid'] . '&search=' . md5('hidden-package-travel' . $row['uid']) . "" . $row['uid']); ?>" class="lampunyala" title="package is active, click here to inactive this package"></a>
                                    <?php else: ?>
                                        <a href="<?php echo site_url('admin-tour/in-active-data?uid=' . $row['uid'] . '&search=' . md5('active-package-travel' . $row['uid']) . "" . $row['uid']); ?>" class="lampumati" title="package is in-active, click here to active this package"></a>
        <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                        endif;
                        $i++;
                    endforeach;
                    foreach ($vippackage as $row): if (($i >= ($limit - ($nilai - 1))) and ($i <= $limit)):
                            ?>
                            <tr>
                                <td><?php echo $i; ?>.</td>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['tujuan']; ?></td>
                                <td><?php echo $row['harga']; ?></td>
                                <td><?php echo $row['retail_rate']; ?></td>
                                <td>
                                    <a href="<?php echo site_url('admin-tour/edit_data?uid=' . $row['uid'] . "&p='vip'&search=" . md5($row['uid'] . 'vip-edit') . "" . $row['uid']); ?>" class="edit-icon" title="edit this package"></a>
                                    <?php if ($row['hidden'] == 0): ?>
                                        <a href="<?php echo site_url('admin-tour/in-active-data?uid=' . $row['uid'] . '&search=' . md5('hidden-package-vip' . $row['uid']) . "" . $row['uid']); ?>" class="lampunyala" title="package is active, click here to inactive this package"></a>
        <?php else: ?>
                                        <a href="<?php echo site_url('admin-tour/in-active-data?uid=' . $row['uid'] . '&search=' . md5('active-package-vip' . $row['uid']) . "" . $row['uid']); ?>" class="lampumati" title="package is in-active, click here to active this package"></a>
                            <?php endif; ?>
                                </td>
                            </tr>
                <?php endif;
                $i++;
            endforeach; ?>
                </tbody>
            </table>
<?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
