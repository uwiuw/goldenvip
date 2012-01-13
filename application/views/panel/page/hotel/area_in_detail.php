<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/hotel/public.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/hotel/app_hotel.js.js" /></script>
<p>&Colon; Hotel &gg; Destination <a tabindex="1" class="button" href="javascript:void(load('_admin/hotel/area_in_detail/destination','#site-content'));">Add new area in detail</a> </p>

<h2 style="display:none;"><a class="button add-new-h2" href="javascript:void();" onclick="test();">Export To Excel</a></h2>

<form name="form_data">
    <table id="myTable" class="wp-list-table widefat fixed pages tablesorter" cellspacing="0">
        <thead>
            <tr>
                <th width="4%">
                    <a href="#"><span>No</span></a>
                </th>
                <th width="20%">
                    <a href="#">Destination</a>
                </th>
                <th width="20%">
                    <a href="#">Area in detail</a>
                </th>
                <th width="8%">
                    <a href="#">Action</a>
                </th>
            </tr>
        </thead>
        
        <tbody id="result-show-finding">
            <?php
            $i = 1;
            foreach ($d_area_in_detail as $row) {
                if ($i >= ($limit - 9)):
                    ?>
                    <tr valign="top"> 
                        <td width="7%">
                            <?php echo $i; ?>.
                        </td>
                        <td class="name-data">
                            <?php echo $row['destination']; ?>             
                        </td>
                        <td class="name-data">
                            <?php echo $row['destination_detail']; ?>             
                        </td>
                        <td>
                            <a class="edit-icon" onclick="load('_admin/hotel/get_detail/?uid=<?php echo $row['uid']; ?>&act=area_in_detail_destination','#site-content')" href="javascript:void();"></a>
                            <a id="hide<?php echo $row['uid']; ?>" class="<?php echo $row['lampu']; ?>" onclick="load('_admin/hotel/get_detail/?uid=<?php echo $row['uid']; ?>&act=lampu_destination_detail','#info-saving');" href="javascript:void(0)"></a>
                        </td>
                    </tr>  
                    <?php
                endif;
                $i++;
            }
            ?>
        </tbody>
    </table>    
    <?php echo $this->pagination->create_links(); ?>