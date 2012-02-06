<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/hotel/public.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>asset/js/script/hotel/app_hotel.js.js" />
<p>&Colon; Hotel &gg; Golden VIP Rate</p>

<h2 style="display:none;"><a class="button add-new-h2" href="javascript:void();" onclick="test();">Export To Excel</a></h2>

<form name="form_data">
<table id="myTable" class="wp-list-table widefat fixed pages tablesorter" cellspacing="0">
    <thead>
        <tr>
            <th width="4%">
                <a href="#"><span>No</span></a>
            </th>
            <th width="20%">
                <a href="#">Room Type</a>
            </th>
            <th width="20%">
                <a href="#">Retail Rate </a>
            </th> 
            <th width="20%">
                <a href="#">Golden VIP Rate</a>
            </th> 
            <th width="30%">
                <a href="#">Hotel</a>
            </th>
            <th width="8%">
                <a href="#">Action</a>
            </th>
        </tr>
    </thead>
    
    <tbody id="result-show-finding">
    <?php 
        $i=1;
        foreach($d_golden_rate as $row) { 
        if($i>=($limit-9)):
    ?>
        <tr valign="top"> 
            <td width="7%">
                <?php echo $i; ?>.
            </td>
            <td class="name-data">
               <?php echo $row['category_name']; ?>             
            </td>
            <td>
                <?php echo $row['retail']; ?>
            </td>
            <td>
                <?php echo $row['golden_rate']; ?>
            </td>
            <td>
                <?php echo $row['hotel_name']; ?>
            </td>
            <td>
                <a class="edit-icon" onclick="load('_admin/hotel/get_detail/?uid=<?php echo $row['uid']; ?>&amp;act=edit_golden_rate','#site-content')" href="javascript:void();"></a>
            </td>
        </tr>  
    <?php 
        endif;
        $i++;} 
    ?>
    </tbody>
</table>    
<?php echo $this->pagination->create_links(); ?>

