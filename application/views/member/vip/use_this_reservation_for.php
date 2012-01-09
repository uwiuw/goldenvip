<style type="text/css">
	#quest{
    font-size: 40px;
    text-align: center;
	font-family:"Times New Roman", Times, serif;
}
#button{
    text-align: center;
    margin-left:350px;
}
a.et-form-btn{
    padding-top: 50px;
    padding-left: 350px;
    width: 100px;
    float: left;
    -moz-border-radius-bottomleft:15px;
    -moz-border-radius-bottomright:15px;
    -moz-border-radius-topleft:15px;
    -moz-border-radius-topright:15px;
    background-color:#666666;
    border:2px solid #CCCCCC;
    color:#CCCCCC;
    cursor:pointer;
    display:block;
    font-size:16px;
    font-weight:bold;
    padding:10px 0px;
    margin-right: 10px;
    margin-top: 50px;
	color:#FFF;
	text-decoration:none;
}
.button1{
    margin-left: 350px;
    margin-right: 20px;
}
.button2{
    margin-left: 10px;
}
</style>
<div class="container">
				<div id="hotel-detail">
					<div id="detail-top"></div>
					<div id="detail-hotel">
						<h1></h1>
						<div class="box-detail-hotel"><a id="c122"></a>
							<div class="tx-rwadminhotelmlm-pi1">
								<div id="quest"><?php echo $tulisan; ?></div>
									<div id="button">
                                    	<a href="<?php echo site_url("member/reservation/vip/set-for-other/?uid=".$uid_sch."&qty=".$qty."&uidnum=".$uidnum."");?>" class="et-form-btn"> Others </a>
                                        <a href="<?php echo site_url("member/reservation/vip/set-for-myself/?uid=".$uid_sch."&qty=".$qty."&uidnum=".$uidnum."");?>" class="et-form-btn"> Myself </a>
									</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div id="detail-bottom"></div>
				</div>
				<div class="clear"></div>
			</div>