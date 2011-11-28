<?php

$o = <<<HTML
<div class="content">
    <div class="container">
        <div id="admin-hotel-top"></div>
        <div id="admin-hotel-middle">
            <div id="admin-left">
                <h2>Menu:</h2>
                <ul id="menu-admin">
                    <li><a href="admin-hotel/login/sub-menu-admin/profile/" >Profile</a></li>
                    <li><a href="admin-hotel/login/sub-menu-admin/bookings/" >Bookings</a></li>
                    <li><a href="admin-hotel/login/sub-menu-admin/room-management/" >Room Management</a></li>
                    <li><a href="admin-hotel/login/sub-menu-admin/rooms-pics-updating/" class="active">Room's Pics Updating</a></li>
                    <li><a href="admin-hotel/login/sub-menu-admin/hotels-pics-updating/" >Hotel's Pics Updating</a></li>
                </ul>
                <ul id="logo_core"><a id="c175"></a>
                    <div class="tx-rwadminhotelmlm-pi1"></div>
                </ul>
            </div>
            <div id="admin-right">
                <div id="welcome-to-hotel"><a id="c173"></a>
                    <div class="tx-rwadminhotelmlm-pi1"><marquee>Welcome to Akmani Hotel</marquee></div>
                </div>
                <div class="content-admin-right"><a id="c132"></a>
                    <div class="tx-rwadminhotelmlm-pi1">
                        <link type="text/css" href="http://wpver.com/typo3conf/ext/rw_admin_hotel_mlm/mod1/css/styleTableSorter.css" rel="stylesheet" />
                        <link type="text/css" href="http://wpver.com/typo3conf/ext/rw_admin_hotel_mlm/mod1/css/style.css" rel="stylesheet" />
                        <link type="text/css" href="http://wpver.com/typo3conf/ext/rw_admin_hotel_mlm/mod1/css/form.css" rel="stylesheet" />
                        <script type="text/javascript" src="http://wpver.com/typo3conf/ext/rw_admin_hotel_mlm/mod1/js/jquery-latest.js"></script>
                        <script type="text/javascript" src="http://wpver.com/typo3conf/ext/rw_admin_hotel_mlm/mod1/js/jquery.js"></script>
                        <script type="text/javascript">

$(function() {
$("#tablesorter-demo").tablesorter({sortList:[[0,0],[2,1]], widgets: ["zebra"]});
$("#options").tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});
});
function deletedRecord(url,name,uid){
var response = confirm("Are you sure to delete '"+name+"' ?")
if (response){
    //window.location.href = url+"?tx_rwadminhotelmlm_pi1[action]=delete";
    window.location.href = url+"?tx_rwadminhotelmlm_pi1[action]=delete&tx_rwadminhotelmlm_pi1[uidRoom]="+uid;
}

};
</script>
                        <table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                            <thead>
                                <tr>
                                    <th class="header">No.</th>
                                    <th class="header headerSortDown">Category</th>
                                    <th class="header headerSortDown">Title</th>
                                    <th class="header headerSortDown">Image</th>
                                    <th class="header headerSortDown" align="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="even">
                                    <td>1</td>
                                    <td>Deluxe Room</td>
                                    <td>deluxe double 1</td>
                                    <td><img src=uploads/tx_rwadminhotel_mlm/4296_deluxedoubleroom.jpg width=150px; height=100px;></td>
                                    <td align="center"><a href="admin-hotel/login/sub-menu-admin/rooms-pics-updating/?tx_rwadminhotelmlm_pi1%5Baction%5D=edit&amp;tx_rwadminhotelmlm_pi1%5Buid%5D=26" ><img src=typo3conf/ext/rw_admin_hotel_mlm/pi1/images/edit-icon.png width=15px; title="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img onclick=deletedRecord("admin-hotel/login/sub-menu-admin/rooms-pics-updating/","deluxe&nbsp;double&nbsp;1","26","Room"); src=typo3conf/ext/rw_admin_hotel_mlm/pi1/images/delete.png width=15px; title="Delete"></td>
                                </tr>
                            </tbody>
                        </table>
                        <form method="POST" action=""><input type="hidden" name="action_foto" value="add"/><input type="submit" value="Add" /></form>
                    </div>
                </div>
            </div>
        </div>
        <div id="admin-hotel-bottom"></div>
    </div>
</div>
<div class="clear"></div>
HTML;

echo $o;
?>