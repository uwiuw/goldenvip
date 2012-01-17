<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/hotel/public.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/tour_travel/tour.js" />
<p>&Colon; Tour & Travel &gg; Administrator <a href="javascript:void()" class="button" onclick="load('_admin/tour_travel/add_new_data_admin','#site-content');">Add new data</a> </p>

<h2 style="display:none;"><a class="button add-new-h2" href="javascript:void();" onclick="test();">Export To Excel</a></h2>
<form name="search_form" onsubmit="searching_data();">
    <table width="100%">
        <tr>
            <td id ="reload_data" align="left" height='30px'></td>
        </tr>
    </table>
</form>

<form name="form_data">
    <table id="myTable" class="wp-list-table widefat fixed pages tablesorter" cellspacing="0">
        <thead>
            <tr>
                <th width="4%">
                    <a href="#"><span>No</span></a>
                </th>
                <th width="20%">
                    <a href="#">Agen Name</a>
                </th>
                <th width="16%">
                    <a href="#">Username</a>
                </th>
                <th width="8%">
                    <a href="#">Action</a>
                </th>
            </tr>
        </thead>

        <tbody id="result-show-finding">
            <?php 
            $i = 1;
            foreach ($agen as $row) {
                if ($i >= ($limit - 9)):
                    ?>
                    <tr valign="top"> 
                        <td width="7%">
                            <?php echo $i; ?>.
                        </td>
                        <td class="name-data">
                            <?php echo $row['agen_name']; ?>             
                        </td>
                        <td>
                            <?php echo $row['username']; ?>
                        </td>
                        <td>
                            <a href="javascript:void(0);" onclick="load('_admin/tour_travel/browse?uid=<?php echo $row['uid']; ?>&act=edit-data-admin','#site-content')" class="edit-icon" ></a>
                            <a href="javascript:void(0)" onclick="load('_admin/tour_travel/browse?uid=<?php echo $row['uid']; ?>&act=status-admin','#reload_data');" class="<?php echo $row['lampu']; ?>"  id="hide<?php echo $row['uid']; ?>"></a>
                        </td>
                    </tr>  
                    <?php
                endif;
                $i++;
            }
            ?>
        </tbody>
    </table>    
</form>
<?php echo $this->pagination->create_links(); ?>