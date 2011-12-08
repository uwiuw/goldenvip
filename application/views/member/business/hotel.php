<script type="text/javascript">
	jQuery(function(){
		jQuery('.button-price').hide();
	});
	function cek_book(el,f){
		if(document.getElementById(el).value=="null"){
			alert('sorry you have not entered the number of rooms');
		}else{
			document.forms[f].submit();
		}
	}
	function select_to_booking(sel,compl)
	{
		jQuery(sel).hide();
		jQuery(compl).fadeIn();
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
									<h2> <?php echo $hotel['hotel_name']?>
                                    <span class="nowrap"><img title="4 star hotel" src="<?php echo base_url(); ?>upload/tx_rwadminhotel_mlm/star_hotel/start<?php echo $hotel['star']?>.png"></span>
										<div style="float: right; display:none;" class="maping"><a href="#93" class="example8 cboxElement">Show Map</a></div>
									</h2>
									<div class="location"><?php echo $hotel['location']?></div>
									<div id="availability">Overview and availability</div>
									<div class="overview"><span class="banner">
											<ul id="ticker">
                                                <li 0.267424;="" opacity:="" list-item;="" style="display: block;">
                                                	<img width="250px" height="250px" alt="" src="<?php echo base_url(); ?>upload/tx_rwadminhotel_mlm/<?php echo $hotel['image']?>">
                                                </li>
                                            </ul>
										</span><span class="listImage">
											<ul></ul>
										</span>
										<div id="summary"><?php echo $hotel['description']?></div>
										<div class="containh2" id="availability_target">
											<h2><a name="rooms" id="rooms">Prices and availability</a></h2>
										</div>
										<div class="roomArea" id="maxotelRoomArea">
                                        <?php
											foreach($room_types as $row)
											{
										?>
                                        	<form id="book<?php echo $row['uid']; ?>" method="POST" action="<?php echo site_url(); ?>member/1/use-this-reservation-for">
                                            <input type="hidden" name="uid_room" value="<?php echo $row['uid']; ?>" />
											<table cellspacing="0" style="width: 100%;" class="featureRooms">
												<thead>
													<tr>
														<th class="firstThFeatRms">
															<div>Rooms Types</div>
														</th>
														<th class="conditions">
															<div>Max</div>
														</th>
														<th class="maxPersons">
															<div>Published Rates (USD)</div>
														</th>
														<th class="roomAvailability">
															<div>Available</div>
														</th>
														<th class="roomPrice">
															<div>Qty</div>
														</th>
														<th class="roomPrice">
															<div>Reservation</div>
														</th>
													</tr>
												</thead>
												<tbody>
														<tr>
															<td class="roomtype"><?php echo $row['category_name']; ?></td>
															<td class="maxPeople"><?php echo $row['max_people']; ?> People</td>
															<td style="color: red; font-size: 16px; font-weight: bold;" class="maxPeople"><?php echo $row['published_rate']; ?></td>
															<td class="maxPeople"><?php echo $row['stok']; ?></td>
															<td class="maxPeople">
                                                            	<select id="jumlah_book<?php echo $row['uid']; ?>" name="jumlah">
                                                                	<option value="null" selected="selected">0</option>
                                                                    <?php for($i=1;$i<=$row['stok'];$i++) { ?>
                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																	<?php } ?>
                                                                </select>
                                                            </td>
															<input type="hidden" value="1" name="compliment_type">
															<td align="center" id="buttonRes" class="maxPeopleReservation" rowspan="3">
                                                            <a href="javascript:void(select_to_booking('#select<?php echo $row['uid']; ?>','#compliment_button<?php echo $row['uid']; ?>'));" id="select<?php echo $row['uid']; ?>">Select</a>
                                                            <input type="button" onclick="cek_book('jumlah_book<?php echo $row['uid']; ?>','book<?php echo $row['uid']; ?>')" value="Book now" id="compliment_button<?php echo $row['uid']; ?>" name="compliment_button" class="button-price">
                                                            <input type="hidden" value="<?php 
																			$profit = $row['rate']-$row['retail_rate'];
																			if($profit < 0)
																			{
																				$profit = -1 * $profit;
																			}
																			echo $profit;
															?>" name="profit" />
                                                            </td>
														</tr>
														<tr>
															<td class="fotoPerRooms" colspan="5"></td>
														</tr>
														<tr>
															<td class="fasilitas" colspan="5">
																<div style="font-weight: bold; text-align: left">Room Facilities :</div>
																<?php echo $row['facilities']; ?>
                                                            </td>
														</tr>
													
												</tbody>
											</table>
                                            </form>
                                            <?php } ?>
										</div> 
										<div class="containh2" id="availability_target">
											<h2><a name="rooms" id="rooms">Hotel Facilities</a></h2>
										</div>
                                        <?php if(!empty($hotel_facilities)) { ?>
										<div id="facilities_hotel" style="float:left; width:100%;">
											<div id="isi">
												<h4>general :</h4>
												<span class="isinya">
                                                	<?php echo $hotel_facilities['general']; ?>
                                                </span>
                                            </div>
											<div id="isi">
												<h4>activities :</h4>
												<span class="isinya">
                                                	<?php echo $hotel_facilities['activities']; ?>
                                                </span>
                                            </div>
											<div id="isi">
												<h4>services :</h4>
												<span class="isinya">
                                                	<?php echo $hotel_facilities['services']; ?>
                                                </span>
                                            </div>
										</div> 
                                        <?php } ?>
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