<?php

$o = <<<HTML
<!-- roommanagementpage.php -->
<div class="content-admin-right"><a id="c73"></a>
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
                    window.location.href = url+"?action=delete&buildroom="+uid;
                }
            };
        </script>
        <script type="text/javascript">
            function check(){
                if(document.getElementById("category").value==""){
                    document.getElementById("errorCat").innerHTML = "* This is a required field";
                }
                if(document.getElementById("maxPeople").value==""){
                    document.getElementById("errorMaxPeople").innerHTML = "* This is a required field";
                }

                if(document.getElementById("stok").value==""){
                    document.getElementById("errorstok").innerHTML = "* This is a required field";
                }
                if(document.getElementById("facilities").value==""){
                    document.getElementById("errorFacilities").innerHTML = "* This is a required field";
                }
                if(document.getElementById("published_rate").value==""){
                    document.getElementById("errorPublishedRate").innerHTML = "* This is a required field";
                }
                else{
                    document.forms["add"].submit();
                }
            }

                function validate(evt) {
                  var theEvent = evt || window.event;
                  var key = theEvent.keyCode || theEvent.which;
                  key = String.fromCharCode( key );
                  var regex = /[0-9_-_\b]/;
                  if( !regex.test(key) ) {
                    theEvent.returnValue = false;
                    theEvent.preventDefault();
                  }
                }
        </script>
        $table
    </div>
</div>
HTML;

echo $o;