<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/hotel/public.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>asset/js/script/hotel/app_hotel.js.js" />
<p>&Colon; Hotel &gg; Member Profit</p>

<h2 style="display:none;"><a class="button add-new-h2" href="javascript:void();" onclick="test();">Export To Excel</a></h2>
<form name="search_form" onsubmit="searching_data_member_profit();">
	<table width="100%">
    	<tr align="right">
            <td id ="reload_data" align="left"></td>
            <td class="no-color">Search By Member / Username Here : </td>
            <td width="10%" class="no-color"><input type="text" name="search" /></td>
            <td width="5%" class="no-color"><input type="button" name="find" value="Find" onclick="searching_data_member_profit()" class="button" /></td>
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
            <th width="15%">
                <a href="#">Date Booking</a>
            </th>
            <th width="20%">
                <a href="#">Name</a>
            </th> 
            <th width="10%">
                <a href="#">Member Name</a>
            </th> 
            <th width="15%">
                <a href="#">Hotel</a>
            </th>
            <th width="10%">
                <a href="#">Room Type</a>
            </th>
            <th width="8%">
                <a href="#">Paid</a>
            </th>
            <th width="8%">
                <a href="#">Action</a>
            </th>
        </tr>
    </thead>
    
    <tbody id="result-show-finding">
    <?php 
        $i=1;
        foreach($d_member_profit as $row) { 
        if($i>=($limit-9)):
    ?>
        <tr valign="top"> 
            <td width="7%">
                <?php echo $i; ?>.
            </td>
            <td class="name-data">
               <?php echo $row['date_booking']; ?>             
            </td>
            <td>
                <?php echo $row['name_reservation']; ?>
            </td>
            <td>
                <?php echo $row['username']; ?>
            </td>
            <td>
                <?php echo $row['hotel_name']; ?>
            </td>
            <td>
                <?php echo $row['category_name']; ?>
            </td>
            <td>
                <?php echo $row['Paid']; ?>
            </td>
            <td>
                <a id="hide<?php echo $row['uid']; ?>" onclick="load('_admin/hotel/read_address/?uid=<?php echo $row['uid']; ?>&amp;act=paid_profit','#info-saving');" href="javascript:void(0)">Paid</a>
            </td>
        </tr>  
    <?php 
        endif;
        $i++;} 
    ?>
    </tbody>
</table>    
<?php echo $this->pagination->create_links(); ?>

