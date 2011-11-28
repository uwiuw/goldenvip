<?php
//@todo bagian list pd html di id="menu-footer" perlu dikonversi ke alamat yg baru
$o = <<<HTML
<div id="footer">
        <div class="container">
            <div id="social-network">
                <div id="fb"><label>Follow :</label><a href="http://www.facebook.com" target="_blank">
                <img src="$asset_url/admin_hotel/icon_fb.png" alt="facebook logo" /></a><span>facebook</span></div>
                <div id="thawte"><a href="http://www.thawte.com" target="_blank">
                <img src="$asset_url/admin_hotel/logo_thawte.png" alt="thawte logo" /></a></div>
            </div>
            <div id="menu-footer"><span><a href="admin-hotel/login/sub-menu-admin/profile/#">Privacy Police</a> | <a href="admin-hotel/login/sub-menu-admin/profile/#">Term and condition</a></span>
                <ul>
                    <li><a href="fileadmin/templates/currTheme/html/home.html" class="selected">Home Office</a>|</li>
                    <li><a href="fileadmin/templates/currTheme/html/report.html">Report</a>|</li>
                    <li><a href="fileadmin/templates/currTheme/html/badge.html">Badge</a>|</li>
                    <li><a href="fileadmin/templates/currTheme/html/personal-info.html">Personal Info</a>|</li>
                    <li><a href="fileadmin/templates/currTheme/html/point-reward.html">Point Reward</a>|</li>
                    <li><a href="fileadmin/templates/currTheme/html/tree.html">Tree</a>|</li>
                    <li><a href="fileadmin/templates/currTheme/html/shop.html">Shop</a></li>
                </ul>
            </div>
            <div id="develop"><span id="copyright">Copyright &copy; 2011 Golden VIP . All Rights <font class="coba">Reserved</font></span><span id="created"><label>design & development by</label><a target="_blank" href="http://www.pusatmedia.com">
            <img src="$asset_url/admin_hotel/logo_pm.png" /></a></span></div>
        </div>
    </div>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-6038727-2']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
HTML;
echo $o;