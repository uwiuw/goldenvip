<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title; ?></title>
        <?php if ($this->uri->segment('3') == 'join-now') { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/style.css" type="text/css">
            <?php } else { ?>
                <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/admin.css" type="text/css">
                <?php } ?>
                <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/tipsy.css" type="text/css">
                    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/blue_style.css" type="text/css">
                        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/style-nav.css" type="text/css">
                            <link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/facebox/facebox.css" type="text/css" media="screen"> 
                                <script type="text/javascript" src="<?php echo base_url(); ?>asset/theme/old-site/js/jquery-1.4.3.min.js"></script>
                                <script type="text/javascript" src="<?php echo base_url(); ?>asset/theme/old-site/js/jquery.tipsy.js"></script>
                                <script src="<?php echo base_url(); ?>asset/js/plugin/facebox.js"></script>
                                <script type="text/javascript">
                                    var jQuery = $.noConflict();    
                                    jQuery(document).ready(function(){
                                        jQuery("li#nav-<?php echo $nav; ?> a").addClass('active');
			
                                        jQuery("#halaman2").remove();
                                        jQuery("#halaman1").removeClass('display-none');
                                    });
                                </script>
                                </head>

                                <body>
                                    <div id="presented">
                                    </div>
                                    <div id="header">
                                        <div class="container">            
                                            <div id="logo_GoldenVIP">
                                                <object width="320" height="150" vspace="2">
                                                    <param name=movie value="<?php echo base_url(); ?>asset/theme/old-site/images/logo.swf" />
                                                    <param name=quality value=high />
                                                    <param name=wmode value="transparent" />
                                                    <embed src="<?php echo base_url(); ?>asset/theme/old-site/images/logo.swf" width="320" height="150" vspace="2" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="transparent"> 
                                                    </embed> 
                                                </object>
                                                <!--
                                                <img src="images/logo_GoldenVIP.png" />
                                                -->
                                            </div>
                                            <div id="kotak-menu">
                                                <div id="menu-top">
                                                    <span id="logout">
                                                        <a id="c88"></a>
                                                        <div class="tx-felogin-pi1">
                                                            <a href="<?php echo site_url('member/logout'); ?>">Logout</a>								 
                                                        </div>
                                                    </span>
                                                </div>
                                                <div class="clear"></div>
                                                <ul id="nav">
                                                    <li id="nav-homepage"><a href="<?php echo site_url('member/home-page'); ?>">HOME</a></li>

                                                    <li id="nav-profile"><a href="<?php echo site_url('member/profile'); ?>" rel="facebox" >PROFILE</a></li>
                                                    <li id="nav-report"><a href="<?php echo site_url('member/report/genealogy/'); ?>" >REPORT</a>
                                                        <ul>
                                                            <li style="margin-top: 12px;"><a href="<?php echo site_url('member/report/genealogy'); ?>" >Genealogy</a></li>
                                                            <li class="tengah"><a href="<?php echo site_url('member/report/commision'); ?>" >Commision</a></li>
                                                            <li class="bawah"><a href="<?php echo site_url('member/report/direct-sponsored'); ?>" >Direct Sponsored</a></li>
                                                        </ul>
                                                    </li>
                                                    <li id="nav-opportunity"><a href="<?php echo site_url('member/opportunity'); ?>" >OPPORTUNITY</a></li>
                                                    <?php $uri = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'package', $this->session->userdata('member'), 'uid'); ?>
                                                    <li id="nav-reservation" >
                                                        <a href="<?php echo site_url('member/reservation/business'); ?>" >RESERVATION</a>
                                                        <ul>
                                                            <li style="margin-top: 12px;"><a href="<?php echo site_url('member/reservation/business'); ?>" >BUSINESS</a></li>
                                                            <li><a href="<?php echo site_url('member/reservation/travel'); ?>" >TRAVEL</a></li>
                                                            <li><a href="<?php echo site_url('member/reservation/vip'); ?>" >VIP</a></li>
                                                            <ul>
                                                                <li style="margin-left: 120px; margin-top:-10px;"><a href="<?php echo site_url('member/reservation/vip/holy-land'); ?>" >HOLYLAND</a></li>
                                                                <li style="margin-left: 120px;"><a href="<?php echo site_url('member/reservation/vip/non-holy-land'); ?>" >NON HOLYLAND</a></li>
                                                            </ul>
                                                        </ul>
                                                    </li>                 
                                                </ul>
                                            </div>
                                        </div>
                                    </div>