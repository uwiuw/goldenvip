<style type="text/css">
#quest{
    font-size: 20px;
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
</style>
<script type='text/javascript' src="<?php echo base_url(); ?>asset/js/redeem_point.js"></script>
<div class="container">
    <div class="sponsor" id="home-office">
        <div id="home-top">
            <h2>Member Reservation &raquo; Redeem Points</h2>
        </div>
        <div id="home-bottom">
        	<div id="quest">
                    Select destination : 
                    <input type="radio" name="package" value="travel"> Travel
                    or
                    <input type="radio" name="package" value="vip"> VIP                    
                </div>
                <div id="button">
                    <a href="#" class="et-form-btn"> Yes</a>
                    <a href="#" class="et-form-btn"> No</a>
                </div>
        </div>
    </div>
</div>
