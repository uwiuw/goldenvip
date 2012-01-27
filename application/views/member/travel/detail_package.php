<script type="text/javascript">
    jQuery(function(){
        jQuery('.button-price').hide();
        jQuery('.qty').hide();
    });
    function cek_book(el,f){
        if(document.getElementById(el).value=="null"){
            alert('sorry you have not entered the number of qty.');
        }else{
            document.forms[f].submit();
        }
    }
    function select_to_booking(sel,compl)
    {
        jQuery(sel).hide();
        jQuery(compl).fadeIn();
        jQuery('.qty').fadeIn();
    }
</script>
<link rel="stylesheet" href="http://wpver.com/typo3conf/ext/rw_admin_hotel_mlm/css/reservation.css" type="text/css">
<div class="container">
    <div id="hotel-detail">
        <div id="detail-top"></div>
        <div id="detail-hotel">
            <h1></h1>
            <div class="box-detail-hotel">
                <div class="tx-rwadminhotelmlm-pi1">
                    <div id="List">
                        <div class="overview">
                            <div class="containh2" id="availability_target">
                                <h2><a name="rooms" id="rooms">Prices and availability</a></h2>
                            </div>
                            <div class="roomArea" id="maxotelRoomArea">
                                <?php
                                foreach ($pack as $row) {
                                    ?>
                                    <form id="book<?php echo $row['uid']; ?>" method="POST" action="<?php echo site_url('member/reservation/travel/use-this-reservation-for'); ?>">
                                        <input type="hidden" name="uid_sch" value="<?php echo $row['uid']; ?>" />
                                        <table cellspacing="0" style="width: 100%;" class="featureRooms">
                                            <thead>
                                                <tr>
                                                    <th class="firstThFeatRms">
                                            <div>Time Schedule</div>
                                            </th> 
                                            <th class="roomAvailability">
                                            <div>Available</div>
                                            </th>
                                            <th class="roomPrice">
                                            <div class="qty">Qty</div>
                                            </th>
                                            <th class="roomPrice">
                                            <div>Retail Rate (USD)</div>
                                            </th>
                                            <th class="roomPrice">
                                            <div>Reservation</div>
                                            </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="roomtype"><?php echo $row['time_sch']; ?></td>
                                                    <td class="maxPeople"><?php echo $row['totaly']; ?></td>
                                                    <td class="maxPeople">
                                                        <select id="jumlah_book<?php echo $row['uid']; ?>" name="qty" class="qty">
                                                            <?php if ($reservation == 'Personal Account' || $reservation == 'Redeem') { ?>
                                                                <option value="null" selected="selected">0</option>
                                                                <?php for ($i = 1; $i <= $total; $i++) { ?>
                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                    <?php
                                                                }
                                                            } else {
                                                                echo "<option value='1'>1</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td class="maxPeople" style="color: red; font-size: 16px; font-weight: bold;"><?php echo $row['retail_rate']; ?></td>
                                            <input type="hidden" value="<?php echo $row['retail_rate']; ?>" name="rate">
                                            <td align="center" id="buttonRes" class="maxPeopleReservation" rowspan="3">
                                                <a href="javascript:void(select_to_booking('#select<?php echo $row['uid']; ?>','#compliment_button<?php echo $row['uid']; ?>'));" id="select<?php echo $row['uid']; ?>">Select</a>
                                                <input type="button" onclick="cek_book('jumlah_book<?php echo $row['uid']; ?>','book<?php echo $row['uid']; ?>')" value="Book now" id="compliment_button<?php echo $row['uid']; ?>" name="compliment_button" class="button-price">

                                            </td>
                                            </tr>
                                            <tr>
                                                <td class="fasilitas" colspan="4">
                                                    <div style="font-weight: bold; text-align: left">Package <?php echo $row['nama']; ?> (<?php echo $row['travel']; ?> Travel) Facilities :</div>
                                                    <?php echo $row['deskripsi']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="maxPeople" colspan="6" id="download">
                                                    <?php if ($row['file']): echo $row['file'] ?>
                                                        <a target="_blank" title="Download Itienary" class="download" href="<?php echo base_url() . "upload/itienary/" . $row['id_agen'] . "/" . $row['itienary']; ?>">*Download Itienary</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </form>
                                <?php } ?>
                            </div>                                        
                        </div>
                    </div>

                    <div id="back"><img width="48" height="34" src="<?php echo base_url(); ?>upload/tx_rwadminhotel_mlm/back/b_back.gif" onmouseover="" onclick="history.go(-1);" style="padding-top: 30px;"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div id="detail-bottom"></div>
    </div>
    <div class="clear"></div>
</div>