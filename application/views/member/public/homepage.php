<div class="container">

    <div id="page-backoffice">             
        <div id="home-office">
            <div id="home-top">
                <h2>
                    Home Office <?php echo "(" . $p['package'] . ")"; ?>
                </h2>
                <div id="show-message">
                    <div class="tx-rwmembermlm-pi1">
                        <div class="not_null">
                            <a href="<?php echo site_url('member/list-member-request'); ?>"><?php echo $mreq['req']; ?> Members Request</a>
                        </div>
                    </div>
                </div>						
            </div>
            <div id="home-bottom">

                <p>
                    Welcome <b><?php echo $this->session->userdata('name'); ?></b>, 
                    <?php if ($this->session->userdata('ucat') != '4') : ?>
                        Our Main Regional Distributor of <b><?php
                    echo $this->session->userdata('regional');
                endif;
                    ?></b>. 
                    <br />
                    By clicking 
                    <a target="_blank" href="<?php echo site_url("member/post_data/join-now/" . $this->session->userdata('member')); ?>">
                        <strong style="color: red; font-size: 16px;">HERE</strong>
                    </a> 
                    You can register and fill in your new member's profile completely.

                </p>
                <br />
                <p>
                    This page facilitates you to edit your existing profile, updating your genealogy, confirming your simply reservations, mastering your compensation plans and updating your direct members and Cycle Bonuses achievements. Kindly remind to 
                    <a class="internal-link" title="Logout" href="<?php echo site_url('member/logout'); ?>">
                        <b style="color: red; font-size: 16px;">LOGOUT</b>
                    </a>
                    when it's done.
                <pre style="display:none;">
                        	  Conratulation on achieving your 6000 poin point rewards, you've entitle to have your 1 (one) complimentary of VIP Package.
                </pre>
                </p>
                <div id="download">
                    <p><a href="<?php echo base_url(); ?>upload/document/application_form.doc" class="download" title="Download Application Form" target="_blank">*Download Application Form</a></p>
                </div>
            </div>
        </div> 
        <div class="garis-homeoffice"></div>
        <div class="left-backoffice">
            <div class="box-home-office geneology">
                <div class="heading">
                    <h2>Geneology Information</h2>
                </div>
                <div class="section-cont" id="genelogy-cepat">
                    <!-- geneology view -->
                    <?php echo $this->mlm_member->get_binary_tree($this->session->userdata('member')); ?>
                    <!-- stop of geneology view -->     
                </div>
            </div>
            <div class="box-home-office cycle">
                <div class="heading">
                    <h2>10 Latest Cycle</h2>
                </div>
                <div class="section-cont" id="genelogy-cepat"> 
                    <?php
                    $sql = "select crdate, bonus from tx_rwmembermlm_historycycle where uid_member = '" . $this->session->userdata('member') . "' order by uid limit 0,10";
                    $cycle = $this->Mix->read_more_rows_by_sql($sql);
                    ?>  
                    <table id="myTable2" class="tablesorter">
                        <thead>
                            <tr>

                                <th>Date Time</th>
                                <th>Bonus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cycle as $row) { ?>
                                <tr>
                                    <td><strong><?php echo date('Y-m-d H:i:s', $row['crdate']); ?></strong></td>

                                    <td><strong>$<?php echo $row['bonus']; ?></strong></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>              
                </div>
            </div>
        </div>
        <div class="right-backoffice">
            <div class="box-home-office binary">
                <div class="heading">
                    <h2>Binary Information </h2>
                </div>
                <div class="section-cont" id="info-binary">

                    <p> Current Level :                                   
                        <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'grade', $this->session->userdata('member'), 'uid'); ?>
                        <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_grade', 'simbol', $d['grade'], 'uid'); ?>
                        <img src="<?php echo base_url(); ?>/asset/theme/old-site/images/icon/<?php echo $d['simbol'] ?>" style="vertical-align:middle; margin-left:20px;" />

                        <?php
                        $sql = "select sum(point) as point_rewards from `tx_rwmembermlm_pointrewards` where uid_member = '" . $this->session->userdata('member') . "' and hidden = '0'";
                        $point = $this->Mix->read_rows_by_sql($sql);
                        ?>
                    <div style="float:right; margin-top:-55px; margin-bottom:10px; margin-right:10px;">
                        <img src="<?php echo base_url(); ?>upload/pics/gift.png" style="vertical-align:middle;" />
                        <b>Point Rewards : <font color="red" ><?php echo $point['point_rewards']; ?></font></b>
                        <br />
                        <a href="#fitur" rel="facebox">
                            <strong style="color: red; font-size: 12px; float:right;">click here to redeem points</strong>
                        </a> 
                    </div>
                    <div style="display:none" id="fitur">
                        Features not yet available for now.
                    </div>
                    </p>
                    <p>
                    <table width="100%" border="0">
                        <tr>
                            <td>Left Poin : <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'point_left', $this->session->userdata('member'), 'uid');
                        echo "<b>" . $d['point_left'] . "</b>"; ?></td>
                            <td>Right Point: <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'point_right', $this->session->userdata('member'), 'uid');
                                echo "<b>" . $d['point_right'] . "</b>"; ?></td>
                        </tr>
                        <tr>
                            <?php $d = getDirectSponsored($this->session->userdata('member'), '67'); ?>
                            <td>Direct Sponsored - Left : <b><?php
                            if (isset($d['kiri'])):
                                echo count($d['kiri']);
                            endif;
                            ?></b></td>
                            <td>Direct Sponsored - Right : <b><?php
                                    if (isset($d['kanan'])) :
                                        echo count($d['kanan']);
                                    endif;
                            ?></b></td>
                        </tr>
                        <tr>
                            <td>Commision: <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'commission', $this->session->userdata('member'), 'uid');
                                    echo "<b>$" . $d['commission'] . "</b>"; ?></td>
                            <td>CV Point: <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'cv', $this->session->userdata('member'), 'uid');
                                echo "<b>" . $d['cv'] . "</b>"; ?></td>
                        </tr>

                    </table>
                    </p>
                </div>
            </div>

            <div class="box-home-office sponsor">
                <div class="heading">
                    <h2>Direct Sponsors (10 Latest)</h2>
                </div>
                <div class="section-cont" id="direct-sponsored">  
                    <?php
                    $sql = "select uid from tx_rwmembermlm_member where sponsor = '" . $this->session->userdata('member') . "' and hidden = '0' and valid ='1' order by uid limit 0,10";
                    $direct_sponsor = $this->Mix->read_more_rows_by_sql($sql);
                    ?>
                    <table id="myTable2" class="tablesorter">
                        <thead>
                            <tr>
                                <th>Username</th>

                                <th>Full Name</th>
                                <th>Sponsors</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($direct_sponsor as $row) { ?>
                                <tr>
                                    <td width="30%">
                                        <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'username', $row['uid'], 'uid');
                                        echo $d['username']; ?>
                                    </td>
                                    <td>
                                        <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'firstname', $row['uid'], 'uid');
                                        echo $d['firstname']; ?>
                                        <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'lastname', $row['uid'], 'uid');
                                        echo $d['lastname']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $dsp = getDirectSponsored($row['uid'], '67');
                                        if (!empty($dsp)) :
                                            $sum = 0;
                                            if (isset($dsp['kiri'])) :
                                                $sum = count($dsp['kiri']) + $sum;
                                            endif;

                                            if (isset($dsp['kanan'])):
                                                $sum = count($dsp['kanan']) + $sum;
                                            endif;
                                            echo $sum;
                                        else:
                                            echo "0";
                                        endif;
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>          
                </div>
            </div>
        </div>

    </div>
    <div class="clear"></div>
</div>