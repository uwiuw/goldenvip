<?php
$o = <<<HTML
    <div id="header">
    <div class="container">
        <div id="logo_GoldenVIP">$logo</div>
        <div id="kotak-menu">
            <div id="menu-top"><span id="logout"><a id="c136"></a>
                    <div class="tx-felogin-pi1">
                        <!-- logout form -->
                        <form action="$logout_url" target="_top" method="post">
                            <fieldset style="border: none;"><legend>Logout</legend>
                                <div style="display: none;"><label>Username:</label> akmani </div>
                                <div><input type="submit" name="submit" value="Logout" /></div>
                                <div class="felogin-hidden"><input type="hidden" name="logintype" value="logout" />
                                <input type="hidden" name="pid" value="66" />
                                <input type="hidden" name="tx_felogin_pi1[noredirect]" value="0" /></div>
                            </fieldset>
                        </form>
                    </div>
                </span></div>
            <div class="clear"></div>
        </div>
    </div>
</div>
HTML;

echo $o;