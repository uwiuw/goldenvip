<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/hotel/public.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>asset/js/script/hotel/app_hotel.js.js" />
<p>&Colon; Hotel &gg; Hotel Management <a href="javascript:void()" class="button" onclick="load('_admin/hotel/add_new_data_hotel','#site-content');">add new data</a> </p>

<h2 style="display:none;"><a class="button add-new-h2" href="javascript:void();" onclick="test();">Export To Excel</a></h2>
<form name="search_form" onsubmit="searching_data();">
	<table width="100%">
    	<tr align="right">
            <td id ="reload_data" align="left"></td>
            <td class="no-color">Search By Name Here : </td>
            <td width="10%" class="no-color"><input type="text" name="search" /></td>
            <td width="5%" class="no-color"><input type="button" name="find" value="Find" onclick="searching_data()" class="button" /></td>
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
                <a href="#">Hotel Name</a>
            </th>
            <th width="16%">
                <a href="#">Destination</a>
            </th> 
            <th width="12%">
                <a href="#">Destination Detail</a>
            </th> 
            <th width="10%">
                <a href="#">Star</a>
            </th>
            <th width="30%">
                <a href="#">Compliment</a>
            </th>
            <th width="8%">
                <a href="#">Action</a>
            </th>
        </tr>
    </thead>
    
    <tbody id="result-show-finding">
    <?php 
        $i=1;
        foreach($d_hotel as $row) { 
        if($i>=($limit-9)):
    ?>
        <tr valign="top"> 
            <td width="7%">
                <?php echo $i; ?>.
            </td>
            <td class="name-data">
               <?php echo $row['hotel_name']; ?>             
            </td>
            <td>
                <?php echo $row['destination']; ?>
            </td>
            <td>
                <?php echo $row['destination_detail']; ?>
            </td>
            <td>
                <?php echo $row['star']; ?>
            </td>
            <td>
                <?php echo $row['compliment']; ?>
            </td>
            <td>
                <?php if($row['hidden']=='0'): ?>
                    <a href="javascript:void(0);" onclick="load('_admin/hotel/get_detail/?uid=<?php echo $row['uid']; ?>&act=get_detail','#site-content')" class="browse" id="browsemember<?php echo $row['uid'];?>" alt="browse data" ></a>
                    <a href="javascript:void(0)" onclick="load('_admin/hotel/get_detail/?uid=<?php echo $row['uid']; ?>&act=switch_data_hotel','#info-saving');" class="lampunyala" id="hide<?php echo $row['uid']; ?>" alt="Avalaible for now"></a>
                <?php else:?>
                    <a href="javascript:void(0);" onclick="load('_admin/hotel/get_detail/?uid=<?php echo $row['uid']; ?>&act=get_detail','#site-content')" class="browse hidden-data" id="browsemember<?php echo $row['uid'];?>" alt="browse data" ></a>
                    <a href="javascript:void(0)" onclick="load('_admin/hotel/get_detail/?uid=<?php echo $row['uid']; ?>&act=switch_data_hotel','#info-saving');" class="lampumati"  id="hide<?php echo $row['uid']; ?>" alt="Not avalaible for now" ></a>
                <?php endif; ?>
            </td>
        </tr>  
    <?php 
        endif;
        $i++;} 
    ?>
    </tbody>
</table>    
<?php echo $this->pagination->create_links(); ?>