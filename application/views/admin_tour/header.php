<script type="text/javascript">
    jQuery(function(){
       jQuery('#<?php echo $nav;?>').addClass('active'); 
    });
</script>
<?php
$site = site_url()."admin-tour";
$name = $this->session->userdata('nama_agen');
$o = <<<HTML
    <div id="header">
    <div class="container">
        <!--<div id="logo_GoldenVIP">$logo</div>-->
        <div id="kotak-menu">
            <div id="menu-top"><span id="logout"><a id="c136"></a>
                    <div class="tx-felogin-pi1">
                        <!-- logout form -->
                        <form action="$site/logout" target="_top" method="post">
                            <fieldset style="border: none;"><legend>Logout</legend>
                                <div style="display: none;"><label>Username:</label> akmani </div>
                                <div><input type="submit" name="submit" value="Logout" /></div>
                                <div class="felogin-hidden">
                                    <input type="hidden" name="logintype" value="logout" />
                                    <input type="hidden" name="pid" value="66" />
                                    <input type="hidden" name="tx_felogin_pi1[noredirect]" value="0" />
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </span></div>
            <div class="clear"></div>
        </div>
    </div>
</div>
HTML;

$j = <<<HTML
<div class="content">
    <div class="container">
        <div id="admin-hotel-top"></div>
        <div id="admin-hotel-middle">
            <div id="admin-left">
                <h2>Menu:</h2>
                <ul id="menu-admin">
                    <li><a href="$site/package-management" id="pm">Package Management</a></li>
                    <li><a href="$site/booking" id="booking_member">Booking</a></li>
                    <li><a href="$site/set-schedule" id="set_sch">Time Schedule</a></li>
                    <li><a href="$site/last-schedule" id="last_sch">Update Report</a></li>
                    
                </ul>
                <ul id="logo_core"><a id="c175"></a>
                    <div class="tx-rwadminhotelmlm-pi1"></div>
                </ul>
            </div>
            <div id="admin-right">
                <div id="welcome-to-hotel"><a id="c173"></a>
                    <div class="tx-rwadminhotelmlm-pi1"><marquee>Welcome to $name </marquee></div>
                </div>
HTML;


if($this->session->userdata('admin-tour')=='aktif'):
    echo $o;
    echo $j;
endif;
        
        