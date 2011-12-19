<?php

$o = <<<HTML
<!-- roomspicsupdating.php -->
<div class="content-admin-right"><a id="c132"></a>
    <div class="tx-rwadminhotelmlm-pi1">
        <link type="text/css" href="$asset_url/admin_hotel/styleTableSorter.css" rel="stylesheet" />
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
                <form action="$form_action" method="POST" enctype="multipart/form-data">
                $table
                </form>
            </tbody>
        </table>
        $form_button
    </div>
</div>
</div>
HTML;

echo $o;