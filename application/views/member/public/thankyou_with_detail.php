<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/admin.css" type="text/css">
<style>
	.box-detail-hotel{font-size:14px; padding:0 10px;}
	ol {margin:0 20px;}
</style>
<div class="container">
    <div id="hotel-detail">
        <div id="detail-top"></div>
        <div id="detail-hotel">
            <h1></h1>
            <div class="box-detail-hotel">
                <div class="tx-rwadminhotelmlm-pi1">Congratulations <strong><?php echo $sponsor['username']; ?></strong>, you has been registered <strong><?php echo $downline['username']; ?></strong></div>
                <p>The bonus you get is :<br />
                <ol>
                <?php
						if(!empty($fast_bonus))
						{ 
									echo "<li>Fast Bonus : <ul>";
									foreach($fast_bonus as $row)
									{ 
										echo "<li>$".$row['bonus']." + ".$row['point']."P</li>";
                                    }
									echo "</ul></li>";
						}
						if(!empty($cycle_bonus))
						{ 
									echo "<li>Cycle Bonus : <ul>";
									foreach($cycle_bonus as $row)
									{ 
										echo "<li>$".$row['bonus']."</li>";
                                    }
									echo "</ul></li>";
						}
						if(!empty($mentor_bonus))
						{ 
									echo "<li>Mentor Bonus : <ul>";
									foreach($mentor_bonus as $row)
									{ 
										echo "<li>$".$row['bonus']."</li>";
                                    }
									echo "</ul></li>";
						}
				?>
                </ol>
				</p>
                To see the placement you've got registered
                <a href="<?php echo site_url('member/post_data/get_genealogy/'.$uid['upline']);?>" style="color:#F00;" target="_blank">click here</a>
            </div>
            <div class="clear"></div>
        </div>
        <div id="detail-bottom"></div>
    </div>
    <div class="clear"></div>
</div>