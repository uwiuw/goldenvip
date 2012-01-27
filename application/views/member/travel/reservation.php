<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/ui-lightness/base/jquery.ui.all.css" type="text/css" media="screen"> 
<script src="<?php echo base_url(); ?>asset/js/lib/jquery-ui-1.8.16.custom.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.dialog.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.core.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.datepicker.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/public.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $template; ?>jquery.carouFredSel-5.1.0-packed.js"></script>
<script type="text/javascript">
    site = "<?php echo site_url(); ?>";
    image = "<?php echo base_url(); ?>asset/images/loading.gif";
    jQuery(function(){
        jQuery("#tablesorter-demo").tablesorter();
        jQuery('#slider').carouFredSel({
            prev: '#next',
            next: '#prev',
        });
        jQuery( "#datepicker" ).datepicker({ 
            changeMonth: false,
            dateFormat:"yy-m-d",
            numberOfMonths: 3,
            showButtonPanel: false,
            beforeShowDay:scheduleDays
        });
        jQuery( "#datepicker1" ).datepicker({ 
            changeMonth: false,
            dateFormat:"yy-m-d",
            numberOfMonths: 3,
            showButtonPanel: false
        });
<?php
$get_compliment = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'compliment', $this->session->userdata('member'), 'uid');
if ($get_compliment['compliment'] == '1' || $set_compliment == '0') {
    ?>
                jQuery('#compliment_true').hide();
    <?php
} else {
    ?>
                jQuery('#payment').hide();
<?php } ?>
        jQuery('#lipo').hide(); 
        jQuery('#cash_payment').hide();
    });
	
    function get_time_sch()
    {
<?php
$data = $this->Mix->read_rows_by_one('pid', $pid, 'tx_rwmembermlm_destination');
foreach ($data as $row) {
    ?>
                if(document.getElementById('packagetravel').value == <?php echo $row['uid']; ?>)
                {
    <?php
    # ambil waktu penerbangan jika ada.
    # uid dari destination yang akan menjadi tolak ukurnya
    # package.destination = destination.uid
    # schedule.package = package.uid
    # ambil time_sch dari schedule
    $day = date('Y-m-d');
    $sql = "select a.time_sch, a.package, b.uid, 
            b.destination, c.uid
            from
            tx_rwagen_travelschedule a, 
            tx_rwagen_travelpackage b,
            tx_rwmembermlm_destination c
            where a.package = b.uid
            and b.destination = c.uid
            and a.hidden = 0
            and a.time_sch > '$day'
            and b.destination = '" . $row['uid'] . "'";
    $sch = $this->Mix->read_more_rows_by_sql($sql);
    ?>
                    schDays = [
    <?php
    $i = 1;
    foreach ($sch as $list) {
        $ambil = date_parse($list['time_sch']);

        echo "[" . $ambil['month'] . "," . $ambil['day'] . ",'sch'],";
        $i++;
    }
    ?>
                    ];
                }
    <?
}
?>
		
    }
	
    // data nantinya akan mengambil dari basis data
	
	
    function scheduleDays(date) {
        for (i = 0; i < schDays.length; i++) {
            if (date.getMonth() == schDays[i][0] - 1
                && date.getDate() == schDays[i][1]) {
                return [true, schDays[i][2] + '_day'];
            }
        }
        return [false, ''];
    }
    function check_destination_detail()
    {
        uid = jQuery('#destination').val();
        load('member/post_data/get_destnation_detail/'+uid,'#destination_detail');
    }
	
    function get_complimentary()
    {
        if(jQuery('#compliment').val()=='Compliment')
        {
            jQuery('#lipo').fadeIn();
            jQuery('#payment').hide();
            jQuery('#cash_payment').hide();
        }
        else if(jQuery('#compliment').val()=='Personal Account')
        {
            jQuery('#lipo').hide();
            jQuery('#payment').fadeIn();
            jQuery('#cash_payment').hide();
        }
        else
        {
            jQuery('#lipo').hide();
            jQuery('#payment').hide();
            jQuery('#cash_payment').hide();
        }
    }
    function get_select_payment()
    {
		
        if(jQuery('#select_payment').val == '1')
        {
            jQuery('#cash_payment').fadeIn();
        }
        else if(jQuery('#select_payment').val == '2')
        {
            jQuery('#cash_payment').fadeIn();
        }
        else
        {
            jQuery('#cash_payment').fadeIn();
        }
    }
    function check()
    {
        if(document.getElementById('packagetravel').value == '')
        {
            document.getElementById("error").innerHTML = "You must fill all data";
        }
        else{
            if(document.getElementById('datepicker').value == '')
            {
                document.getElementById("error").innerHTML = "You must fill all data";
            }
            else
            {
                if(document.getElementById('compliment').value == 'Personal Account' || document.getElementById('compliment').value == '0')
                {
                    if(document.getElementById('select_payment').value == 0)
                    {
                        document.getElementById("error").innerHTML = "You must fill all data";
                    }
                    else
                    {
                        document.forms["reservasi"].submit();
                    }
                }
                else
                {
                    if(document.getElementById('compliment').value == 'Compliment')
                    {
                        document.forms["reservasi"].submit();
                    }
                    else
                    {
                        document.getElementById("error").innerHTML = "You must fill all data";
                    }
                }
            }
        }
    }
</script>
<style type="text/css">
    .line-visit-hotel {
        width: 560px;
        text-align:center;
    }
    .line-visit-hotel ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: block;
    }
    .line-visit-hotel li {
        font-size: 40px;
        color: #999;
        text-align: center; 
        padding: 0;
        margin: 5px;
        display: block;
        float: left;
    }
    .line-visit-hotel li img {width:120px; height:120px;}
    .sch_day{background:#000;}
    .sch_day:hover{background:#f00;}
</style>
<div class="container">
    <div id="box-reservation">
        <div id="reservation-top">
            <div id="home-top"><h2>Reservation :</h2></div>
        </div>
        <div id="reservation">
            <div id="left">
                <div class="res-middle">
                    <div class="tx-rwadminhotelmlm-pi1">
                        <div id="find">
                            <div id="error" style="color: red; text-align: center;font-size: 12px;"></div>
                            <form method="POST" action="<?php echo site_url('member/reservation/travel/package-selected'); ?>" class="et-form" name="reservasi" enctype="multipart/form-data"> 

                                <div>
                                    <label class="desc">Destination :</label>
                                    <?php
                                    $id = "id = 'packagetravel' onchange = 'get_time_sch();'";
                                    echo form_dropdown('destination', $destination, '0', $id);
                                    ?>
                                    <div class="clr"></div>
                                </div>

                                <div>
                                    <label class="desc">Departure:
                                    </label><input id="datepicker" name="datepicker" type="text" onchange= "check_schedule_tour();">
                                    <div class="clr"></div>
                                </div>

                                <div id="compliment_true">
                                    <label class="desc">Booking :</label>
                                    <select id="compliment" name="compliment" onchange="get_complimentary();">
                                        <option selected="selected" value="0">-- using your Complimentary ? --</option>
                                        <option value="Compliment">Yes</option>
                                        <option value="Personal Account">No</option>
                                    </select>
                                    <div class="clr"></div>
                                </div>

                                <div id="lipo">By clicking "yes", <a href="lippo-insurance/">Your Travel Lippo Insurance</a> is authomatically activated</div>

                                <div id="payment">
                                    <label class="desc">Payment :</label>
                                    <select id="select_payment" name="select_payment" onchange="get_select_payment();">
                                        <option selected="selected" value="0">-- Select Payment --</option>
                                        <option value="Cash">Cash</option>
                                        <?php echo $opt_point; ?>
                                    </select>
                                    <div class="clr"></div>
                                </div>

                                <div id="cash_payment">
                                    <div id="lipo" style="font-size: 14px; margin-top: 15px; margin-right: 10px;">
                                        <center>
                                            <font color="#FF0000" style="line-height: 20px;">

                                            IDR payment should be transfered to :<br /> PT. GOLDEN VICTORY INSANI PRATAMAYINTARA (GOLDEN VIP)
                                            <br /><br />
                                            <b style="font-size:larger;">Permata Bank Acct. No. 070.137.5068</b>
                                            </font>
                                        </center>
                                    </div>
                                </div>

                                <div id="creditCardNumber"></div>

                                <div>
                                    <input value="Submit" id="submit_photo" class="et-form-btn" onclick="check()" type="button">
                                    <div class="clr"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="right" style="width:560px;">
                <div class="line-visit-hotel"> 
                    <div class="shadow-left"><a id="prev"></a></div>
                    <ul id="slider" style="float:left;">
                        <li><img src="<?php echo base_url(); ?>upload/reservation/1.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/2.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/3.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/4.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/5.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/6.jpg" /></li>
                    </ul> 
                    <div class="shadow-right"><a id="next"></a></div>
                </div>

                <div class="visit-hotel">
                    <h2>Thank you for making your reservatiion. Your confirmed booking tour as follows :</h2>
                    <div class="box-visit-left"></div>
                    <div class="box-visit-middle">
                        <div class="tx-rwadminhotelmlm-pi1">
                            <table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                                <thead>
                                    <tr>
                                        <th width="24" class="header">No.</th>
                                        <th width="87" class="header headerSortDown">Destination</th>
                                        <th width="72" class="header headerSortDown">Package Type</th>
                                        <th width="60" class="header headerSortDown">Depart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "select a.reservation, 
        c.nama as package, 
        d.name as agen,  
        e.time_sch, 
        f.rate, 
        a.payed, 
        f.nama, 
        g.destination,
        a.qty,
        count(f.uid) as tiket
        from
        tx_rwagen_travelbooking a,
        tx_rwmembermlm_member b,
        tx_rwagen_travelpackage c,
        tx_rwagen_agen d,
        tx_rwagen_travelschedule e,
        tx_rwagen_travelbookingdetails f,
        tx_rwmembermlm_destination g
        where 
        a.uid_member = b.uid and
        a.uid_sch = e.uid and
        c.agen = d.uid and
        e.package = c.uid and
        c.destination = g.uid and
        f.pid = a.uid and 
        a.hidden = '0' and
        f.hidden = '0' and
        a.uid_member = '" . $this->session->userdata('member') . "'
        group by a.uid_sch
        order by a.uid desc
        limit 0,10 ";
                                    $retail = $this->Mix->read_more_rows_by_sql($sql);
                                    if (!empty($retail)) {
                                        $i = 1;
                                        foreach ($retail as $row) {
                                            ?>
                                            <tr class="even">
                                                <td><?php echo $i; ?>.</td>
                                                <td><?php echo $row['destination']; ?></td>
                                                <td><?php echo $row['tiket'] . " ticket " . $row['package']; ?></td>
                                                <td><?php echo $row['time_sch']; ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="box-visit-right"></div>

                </div>

            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>