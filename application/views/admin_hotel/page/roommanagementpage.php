<?php

$o = <<<HTML
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
								<div id="pack" style="border: 1px solid rgb(187, 187, 187); overflow: auto; width: 100%; height: 400px;">
									<table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1" width="1000px">
										<thead>
											<tr>
												<th class="header">No.</th>
												<th class="header headerSortDown">Room Type</th>
												<th class="header headerSortDown">Published Rates (USD / IDR)</th>
												<th class="header headerSortDown">Retail Rates (IDR)</th>
												<th class="header headerSortDown">Alot</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<tr class="even">
												<td>1</td>
												<td>Deluxe Room</td>
												<td>750000 </td>
												<td>735.000</td>
												<td>5</td>
												<td><a href="$adminhotel_url/login/sub-menu-admin/room-management/?action=edit&buildroom=31" >
                                                <img src=$asset_url/admin_hotel/edit-icon.png width=15px; title="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <img onclick=deletedRecord("$adminhotel_url/login/sub-menu-admin/room-management/","Deluxe&nbsp;Room","31","Room"); src=$asset_url/admin_hotel/delete.png width=15px; title="Delete">
                                                </td>
											</tr>
										</tbody>
									</table>
									<a href="$adminhotel_url/login/sub-menu-admin/room-management/?action=add" >
										<div id="tk"><img src="$asset_url/admin_hotel/add-icon.png" width=15px; title="Add Room">Add Room</div>
									</a>
                                </div>
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