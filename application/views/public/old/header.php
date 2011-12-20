<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title; ?></title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/style.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/form.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/picture.css" type="text/css"> 
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/style-nav.css" type="text/css"> 
  <script type="text/javascript" src="<?php echo base_url(); ?>asset/theme/old-site/js/jquery-1.4.3.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.nivo.slider.pack.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/nivo-slider.css" type="text/css" />
  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/public.js"></script>
  <script type="text/javascript">
  	var site = "<?php echo site_url(); ?>";
    var jQuery = $.noConflict();    
	jQuery(document).ready(function(){
			jQuery("li a#nav-<?php echo $nav; ?>").addClass('active');
			jQuery('#slider').nivoSlider();
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
					<span id="BOMenu">
                        <a class="back-office" href="<?php echo site_url('member/back-office'); ?>">BACK OFFICE</a>
                    </span>
                    <span id="JNMenu" class="join-now"><a href="<?php echo site_url('member/join-now'); ?>" class="join-now">JOIN NOW</a></span>
				</div>
				<div class="clear"></div>
				<ul id="nav">
						<li class="atas"><a id="nav-home" href="<?php echo site_url();?>">HOME</a></li>
						<li><a href="<?php echo site_url('about-us/the-gvip-story');?>" id="nav-about">ABOUT US</a>
							<ul class="about">
								<li style="margin-top: 12px;"><a href="<?php echo site_url('about-us/the-gvip-story');?>" >The GVIP Story</a></li>
								<li class="tengah"><a href="<?php echo site_url('about-us/vision-and-mission');?>">Vision and Mission</a></li>
								<li class="tengah"><a href="<?php echo site_url('about-us/corporate-overview');?>">Corporate Overview</a></li>
								<li class="bawah"><a href="<?php echo site_url('about-us/why-gvip');?>">Why GVIP</a></li>
							</ul>
						</li>
						<li><a href="<?php echo site_url('products/business');?>" id="nav-products">PRODUCTS</a>
							<ul class="about">
								<li style="margin-top: 12px;"><a href="<?php echo site_url('products/business');?>">Business</a></li>
								<li class="tengah"><a href="<?php echo site_url('products/travel');?>">Travel</a></li>
								<li class="tengah"><a href="<?php echo site_url('products/vip');?>">VIP</a></li>
								<li class="bawah"><a href="<?php echo site_url('products/participant-hotels');?>">Participant Hotels</a></li>
							</ul>
						</li>
						<li><a href="<?php echo site_url('news');?>" id="nav-news">NEWS</a></li>
						<li><a href="<?php echo site_url('faq');?>" id="nav-faq">FAQ</a></li>
						<li class="bawah"><a href="<?php echo site_url('contact-us');?>" id="nav-contact">CONTACT US</a></li>
					</ul>
			</div>
		</div>
	</div>