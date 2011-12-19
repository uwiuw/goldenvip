<?php

$o = <<<HTML
<!-- periodeprint.php -->
<div class="content-admin-right"><a id="c143"></a>
<div class="tx-rwadminhotelmlm-pi1">
    <script type="text/javascript" src="$asset_url/admin_hotel/jquery.utama.js"></script>
    <link rel="stylesheet" href="$asset_url/admin_hotel/style-nav.css" type="text/css" />
    <link type="text/css" href="$asset_url/admin_hotel/jquery.ui.all.css" rel="stylesheet" />
    <script type="text/javascript" src="$asset_url/admin_hotel/jquery.ui.core.js"></script>
    <script type="text/javascript" src="$asset_url/admin_hotel/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="$asset_url/admin_hotel/jquery.ui.datepicker.js"></script>
    <link type="text/css" href="$asset_url/admin_hotel/demos.css" rel="stylesheet" />
    <link type="text/css" href="$asset_url/admin_hotel/reservation.css" rel="stylesheet" />
    <script type="text/javascript">
$(document).ready(function(){
    $("#country").change(function(){
        var country = $("#country").val();
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "index.php?eID=tx_rwadminhotelmlm_pi1&cmd=getProvince&country="+country,
                //data: "country="+country,
                //cache: false,
                success: function(msg){
                    $("#propinsi").html(msg.valueOf());
                }
        });
    });

      $("#propinsi").change(function(){
    var propinsi = $("#propinsi").val();
    $.ajax({
        type: "GET",
        dataType: "html",
        url: "index.php?eID=tx_rwadminhotelmlm_pi1&cmd=getCity&propinsi="+propinsi,
        //data: "country="+country,
        //cache: false,
        success: function(msg){
            //alert(msg.valueOf());
            $("#kota").html(msg.valueOf());
        }
    });
  });


    $(function() {
		var dates = $( "#datepicker, #datepicker1" ).datepicker({

			changeMonth: true,
            dateFormat:"yy-mm-dd",
			numberOfMonths: 1,

			onSelect: function( selectedDate ) {
				var option = this.id == "datepicker" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" );
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});

		/*$('#datepicker').datepicker({
		    showOn: 'button',
		    numberOfMonths: 3,
			dateFormat:"yy-mm-dd",
            minDate: -0,
            buttonImage: 'typo3conf/ext/rw_admin_hotel_mlm/images/calendar.gif',
            showButtonPanel: true


		});
        $('#datepicker2').datepicker({
		    showOn: 'button',
		    numberOfMonths: 3,
			dateFormat:"yy-mm-dd",
            minDate: 1,
            buttonImage: 'typo3conf/ext/rw_admin_hotel_mlm/images/calendar.gif',
            showButtonPanel: true


		});*/

	});
});
</script>
<script type="text/javascript">
    function check(){

        tglmulai = document.getElementById("datepicker").value;
        tglakhir = document.getElementById("datepicker1").value;

        start_d_arr = tglmulai .split("-");
        end_d_arr = tglakhir.split("-");

        tahun_arr = new Array('January','February','March','april','May','June','July','August','September','October','November','December');

        future0 = new Date(tahun_arr[parseFloat(start_d_arr[1])-1]+" "+parseFloat(start_d_arr[0])+","+parseFloat(start_d_arr[2])+" 01:00:00");
        future1 = new Date(tahun_arr[parseFloat(end_d_arr[1])-1]+" "+parseFloat(end_d_arr[0])+","+parseFloat(end_d_arr[2])+" 01:00:00");

        fut0 = Date.parse(future0);
        fut1 = Date.parse(future1);

        selisih = fut1 - fut0;
        miliday = 24 * 60 * 60 * 1000;
        daysleft = selisih/miliday;
        daysleftint = Math.round(daysleft);
        if(document.getElementById("compliment").value=="1" && daysleftint > document.getElementById("malam").value){
            document.getElementById("error").innerHTML = "you only have "+document.getElementById("malam").value+" nights to compliment";
        }
        else if (document.getElementById("datepicker").value == document.getElementById("datepicker1").value){
            document.getElementById("error").innerHTML = "Minimal 1 Night";
        }

        else if(document.getElementById("country").value=="" || document.getElementById("propinsi").value=="" || document.getElementById("kota").value=="" || document.getElementById("datepicker").value=="" || document.getElementById("datepicker1").value=="" || document.getElementById("compliment").value==""){
             document.getElementById("error").innerHTML = "you must fill all data";
        }else{
            document.forms["reservasi"].submit();
        }
    }
    function checknotkompliment(){
        if(document.getElementById("country").value=="" || document.getElementById("propinsi").value=="" || document.getElementById("kota").value=="" || document.getElementById("datepicker").value=="" || document.getElementById("datepicker1").value==""){
            document.getElementById("error").innerHTML = "you must fill all data";
        }else if (document.getElementById("datepicker").value == document.getElementById("datepicker1").value){
            document.getElementById("error").innerHTML = "Minimal 1 Night";
        }
        else{
            document.forms["reservasiNo"].submit();
        }
    }
    function info(){
        if (document.getElementById("compliment").value=="1"){
            document.getElementById("info").innerHTML = 'By clicking "yes", Your Travel lippo insurance is authomatically activated';
        }
        if (document.getElementById("compliment").value=="0"){
            document.getElementById("info").innerHTML = '';
        }
    }
</script>
                        <div id="find">
                            <div id="error" style="color: red; text-align: center; font-size: 12px;"></div>
                            <form method="POST" action="" class="et-form" name="reservasiNo">
                                <div><label class="desc">Periode 1 :</label><input type="text" id="datepicker" name="datepicker"/>
                                    <div class="clr"></div>
                                </div>
                                <div><label class="desc">Periode2 :</label><input type="text" id="datepicker1" name="datepicker1"/>
                                    <div class="clr"></div>
                                </div>
                                <input type="hidden" name="print_booking_now" value="1" />
                                <div><input type="submit" value="Submit" id="submit_photo" class="et-form-btn"/>
                                    <div class="clr"></div>
                                </div>
                            </form>
                        </div>
							</div>
						</div>
					</div>
				</div>
<div id="admin-hotel-bottom"></div>
</div>
</div>
<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible" style="position: absolute; left: 542px; top: 333px; z-index: 1; display: none; "><div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all"><a class="ui-datepicker-prev ui-corner-all" onclick="DP_jQuery_1324271840895.datepicker._adjustDate('#datepicker', -1, 'M');" title="Prev"><span class="ui-icon ui-icon-circle-triangle-w">Prev</span></a><a class="ui-datepicker-next ui-corner-all" onclick="DP_jQuery_1324271840895.datepicker._adjustDate('#datepicker', +1, 'M');" title="Next"><span class="ui-icon ui-icon-circle-triangle-e">Next</span></a><div class="ui-datepicker-title"><select class="ui-datepicker-month" onchange="DP_jQuery_1324271840895.datepicker._selectMonthYear('#datepicker', this, 'M');" onclick="DP_jQuery_1324271840895.datepicker._clickMonthYear('#datepicker');"><option value="0">Jan</option><option value="1">Feb</option><option value="2">Mar</option><option value="3">Apr</option><option value="4">May</option><option value="5">Jun</option><option value="6">Jul</option><option value="7">Aug</option><option value="8">Sep</option><option value="9">Oct</option><option value="10">Nov</option><option value="11" selected="selected">Dec</option></select>&nbsp;<span class="ui-datepicker-year">2011</span></div></div><table class="ui-datepicker-calendar"><thead><tr><th class="ui-datepicker-week-end"><span title="Sunday">Su</span></th><th><span title="Monday">Mo</span></th><th><span title="Tuesday">Tu</span></th><th><span title="Wednesday">We</span></th><th><span title="Thursday">Th</span></th><th><span title="Friday">Fr</span></th><th class="ui-datepicker-week-end"><span title="Saturday">Sa</span></th></tr></thead><tbody><tr><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">1</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">2</a></td><td class=" ui-datepicker-week-end " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">3</a></td></tr><tr><td class=" ui-datepicker-week-end " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">4</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">5</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">6</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">7</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">8</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">9</a></td><td class=" ui-datepicker-week-end " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">10</a></td></tr><tr><td class=" ui-datepicker-week-end " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">11</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">12</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">13</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">14</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">15</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">16</a></td><td class=" ui-datepicker-week-end " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">17</a></td></tr><tr><td class=" ui-datepicker-week-end " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">18</a></td><td class=" ui-datepicker-days-cell-over  ui-datepicker-today" onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default ui-state-highlight" href="#">19</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">20</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">21</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">22</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">23</a></td><td class=" ui-datepicker-week-end " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">24</a></td></tr><tr><td class=" ui-datepicker-week-end " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">25</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">26</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">27</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">28</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">29</a></td><td class=" " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">30</a></td><td class=" ui-datepicker-week-end " onclick="DP_jQuery_1324271840895.datepicker._selectDay('#datepicker',11,2011, this);return false;"><a class="ui-state-default" href="#">31</a></td></tr></tbody></table></div>
HTML;

echo $o;