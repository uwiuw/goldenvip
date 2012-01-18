<div class="container">
    <div id="show-ctn-member">
        <div class="tx-rwmembermlm-pi1">
            <div id="home-office" class="sponsor">
                <div id="home-top">
                    <h2>Report Commision</h2>
                </div>
                <div id="home-bottom">
                    <div class="csc-textpic-text">
                        <p style="margin-bottom: 10px;margin-top: 10px;"><strong>Fast Bonus : unpaid $<?php echo $total_fastbonus['fast']; ?></strong></p>
                        <?php
                        # awal dari fast bonus

                        if (!empty($fast_bonus)) {
                            ?>
                            <div style="border:1px solid #ccc; width:98%; padding: 10px;">
                                <table id="myTable2" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date Time</th>
                                            <th>Username</th>
                                            <th>Package</th>
                                            <th>Bonus</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 1;
                                        foreach ($fast_bonus as $row) {
                                            ?>
                                            <tr>
                                                <td width="30px"><?php echo $i; ?>.</td>
                                                <td><?php echo date('Y-m-d H:i:s', $row['crdate']); ?></td>
                                                <td><?php echo $row['downline_name'] ?></td>
                                                <td><?php echo $row['package'] ?></td>
                                                <td>$ <?php echo $row['bonus']; ?></td>
                                                <td><strong><?php
                                    if ($row['paid'] == '1') {
                                        echo "paid";
                                    } else {
                                        echo "unpaid";
                                    };
                                            ?></strong></td>
                                            </tr>
                                            <?php $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "<div class=\"error\">Data Not Found</div>";
                        }
                        # akhir dari fast bonus
                        ?>

                        <p style="margin-bottom: 10px;margin-top: 10px;"><strong>Cycle Bonus : unpaid $<?php echo $total_cycle['cycle']; ?></strong></p>
                        <?php
                        # awal dari cycle bonus

                        if (!empty($cycle_bonus)) {
                            ?>
                            <div style="border:1px solid #ccc; width:98%; padding: 10px;">
                                <table id="myTable1" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date Time</th>
                                            <th>Bonus</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($cycle_bonus as $row) {
                                            ?>
                                            <tr>
                                                <td width="30px"><?php echo $i; ?>.</td>
                                                <td><?php echo date('Y-m-d H:i:s', $row['crdate']); ?></td>
                                                <td>$ <?php echo $row['bonus']; ?></td>
                                                <td><strong><?php
                                    if ($row['paid'] == '1') {
                                        echo "paid";
                                    } else {
                                        echo "unpaid";
                                    };
                                            ?></strong></td>
                                            </tr>
                                            <?php $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "<div class=\"error\">Data Not Found</div>";
                        }
                        # akhir dari cycle bonus
                        ?>

                        <p style="margin-bottom: 10px;margin-top: 10px;"><strong>Matching Bonus : unpaid $<?php echo $total_matching['matching']; ?></strong></p>
                        <?php
                        # awal dari matching bonus

                        if (!empty($matching_bonus)) {
                            ?>
                            <div style="border:1px solid #ccc; width:98%; padding: 10px;">
                                <table id="myTable1" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date Time</th>
                                            <th>Bonus</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($matching_bonus as $row) {
                                            ?>
                                            <tr>
                                                <td width="30px"><?php echo $i; ?>.</td>
                                                <td><?php echo date('Y-m-d H:i:s', $row['crdate']); ?></td>
                                                <td>$ <?php echo $row['bonus']; ?></td>
                                                <td><strong><?php
                                    if ($row['paid'] == '1') {
                                        echo "paid";
                                    } else {
                                        echo "unpaid";
                                    };
                                            ?></strong></td>
                                            </tr>
                                            <?php $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "<div class=\"error\">Data Not Found</div>";
                        }
                        # akhir dari matching bonus
                        ?>
                        <p style="margin-bottom: 10px;margin-top: 10px;"><strong>Mentor Bonus : unpaid $<?php echo $total_mentor['mentor']; ?></strong></p>
                        <?php
# awal dari mentor bonus 
                        if (!empty($mentor_bonus)) {
                            ?>
                            <div style="border:1px solid #ccc; width:98%; padding: 10px;">
                                <table id="myTable2" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date Time</th>
                                            <th>Downline</th>
                                            <th>Bonus</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($mentor_bonus as $row) {
                                            ?>
                                            <tr>
                                                <td width="30px"><?php echo $i; ?>.</td>
                                                <td><?php echo date('Y-m-d H:i:s', $row['crdate']); ?></td>
                                                <td><?php echo $row['downline_name']; ?></td>
                                                <td>$ <?php echo $row['bonus']; ?></td>
                                                <td><strong><?php
                                    if ($row['paid'] == '1') {
                                        echo "paid";
                                    } else {
                                        echo "unpaid";
                                    };
                                            ?></strong></td>
                                            </tr>
                                            <?php $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "<div class=\"error\">Data Not Found</div>";
                        }
                        # akhir dari matching bonus
                        ?>
                        <p style="margin-bottom: 10px;margin-top: 10px;"><strong>Retail Rates Bonus</strong></p>
                        <?php
# awal dari retail rates bonus

                        if (!empty($retail_bonus)) {
                            ?>
                            <div style="border:1px solid #ccc; width:98%; padding: 10px;">
                                <table id="myTable4" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date Booking</th>
                                            <th>Name</th>
                                            <th>Hotel</th>
                                            <th>Room Type</th>
                                            <th>Qty</th>
                                            <th>Nights</th>
                                            <th>Profit</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($retail_bonus as $row) {
                                            ?>
                                            <tr>
                                                <td width="30px"><?php echo $i; ?>.</td>
                                                <td><?php echo $row['date_booking']; ?></td>
                                                <td><?php echo $row['name_reservation']; ?></td>
                                                <td><?php echo $row['hotel_name']; ?></td>
                                                <td><?php echo $row['category_name']; ?></td>
                                                <td><?php echo $row['qty']; ?></td>
                                                <td><?php $night = diffDay($row['check_in'], $row['check_out']);
                                    echo $night; ?></td>
                                                <td><?php $rate = $row['rate'] - $row['GVIP_Rate'];
                                            echo "IDR " . number_format($rate); ?></td>
                                                <td><strong><?php
                                            if ($row['payed'] == '1') {
                                                echo "paid";
                                            } else {
                                                echo "unpaid";
                                            }
                                            ?></strong></td>
                                            </tr> 
                                            <?php $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "<div class=\"error\">Data Not Found</div>";
                        }
# akhir dari retail bonus
                        ?>
                        <p style="margin-bottom: 10px;margin-top: 10px;"><strong>Retail Travel</strong></p>
                        <?php
# awal dari retail travel bonus

                        if (!empty($retail_travel)) {
                            ?>
                            <div style="border:1px solid #ccc; width:98%; padding: 10px;">
                                <table id="myTable4" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Depart</th>
                                            <th>Destination</th>
                                            <th>Package Type</th>
                                            <th>Ticket</th>
                                            <th>Profit</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($retail_travel as $row) {
                                            ?>
                                            <tr>
                                                <td width="30px"><?php echo $i; ?>.</td>
                                                <td><?php echo $row['time_sch']; ?></td>
                                                <td><?php echo $row['destination']; ?></td>
                                                <td><?php echo $row['package']; ?></td>
                                                <td><?php echo $row['tiket']; ?></td>
                                                <td><?php echo $row['profit']; ?> USD</td>
                                                <td><?php echo $row['payed']; ?></td>
                                            </tr> 
                                            <?php $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "<div class=\"error\">Data Not Found</div>";
                        }
# akhir dari retail travel
                        ?>
                        <p style="margin-bottom: 10px;margin-top: 10px;"><strong>Retail VIP</strong></p>
                        <?php
# awal dari retail rates VIP

                        if (!empty($retail_vip)) {
                            ?>
                            <div style="border:1px solid #ccc; width:98%; padding: 10px;">
                                <table id="myTable4" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Depart</th>
                                            <th>Destination</th>
                                            <th>Package Type</th>
                                            <th>Ticket</th>
                                            <th>Profit</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($retail_vip as $row) {
                                            ?>
                                            <tr>
                                                <td width="30px"><?php echo $i; ?>.</td>
                                                <td><?php echo $row['time_sch']; ?></td>
                                                <td><?php echo $row['destination']; ?></td>
                                                <td><?php echo $row['package']; ?></td>
                                                <td><?php echo $row['tiket']; ?></td>
                                                <td><?php echo $row['profit']; ?> USD</td>
                                                <td><?php echo $row['payed']; ?></td>
                                            </tr> 
                                            <?php $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "<div class=\"error\">Data Not Found</div>";
                        }
# akhir dari retail vip
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>