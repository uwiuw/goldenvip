<?php

$o = <<<HTML
    <!-- booking.php -->
    <div class="content-admin-right"><a id="c120"></a>
        <div class="tx-rwadminhotelmlm-pi1">
            <link type="text/css" href="$asset_url/admin_hotel/styleTableSorter1.css" rel="stylesheet" />
            <link type="text/css" href="$asset_url/admin_hotel/style.css" rel="stylesheet" />
            <link type="text/css" href="$asset_url/admin_hotel/form.css" rel="stylesheet" />
            <script type="text/javascript" src="$asset_url/admin_hotel/jquery-latest.js"></script>
            <script type="text/javascript" src="$asset_url/admin_hotel/jquery.js"></script>
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
            $table
        </div>
    </div>
</div>
</div>
<div id="admin-hotel-bottom"></div>
</div>
</div>
HTML;
echo $o;