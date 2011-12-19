<?php

$o = <<<HTML
    <div id="header">
    <div class="container">
        <!--<div id="logo_GoldenVIP">$logo</div>-->
        <div id="kotak-menu">
            <div id="menu-top"><span id="logout"><a id="c136"></a>
                    <div class="tx-felogin-pi1">
                        <!-- logout form -->
                        <form action="$logout_url" target="_top" method="post">
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
<div class="content">
    <div class="container">
        <div id="admin-hotel-top"></div>
        <div id="admin-hotel-middle">
            <div id="admin-left">
                $menu
                <ul id="logo_core"><a id="c175"></a>
                    <div class="tx-rwadminhotelmlm-pi1"></div>
                </ul>
            </div>
            <div id="admin-right">
                <div id="welcome-to-hotel"><a id="c173"></a>
                    <div class="tx-rwadminhotelmlm-pi1"><marquee>Welcome to $hotel_name</marquee></div>
                </div>
HTML;

echo $o;