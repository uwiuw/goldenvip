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
  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/public.js"></script>
  <script type="text/javascript">
  	var site = "<?php echo site_url(); ?>";
    var jQuery = $.noConflict();    
	jQuery(document).ready(function(){
			jQuery("li#nav-<?php echo $nav; ?> a").addClass('active');
			
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
                        <a class="back-office" href="http://mygoldenvip.com/member/back-office/">BACK OFFICE</a>
                    </span>
                    <span id="JNMenu" class="join-now"><a href="http://mygoldenvip.com/member/join-now/" class="join-now">JOIN NOW</a></span>
				</div>
				<div class="clear"></div>
				<ul id="nav">
                	<li class="list-home"><a href="index.html">HOME</a></li>
					<li><a href="#">ABOUT US</a>
						<ul>
							<li class="atas"><a href="about-us-story.html">The GVIP Story</a></li>
							<li><a href="#">Vision and Mission</a></li>
							<li><a href="#">Corporate Overview</a></li>
							<li class="bawah"><a href="#">Why GVIP</a></li>
						</ul>
					</li>
					<li><a href="#">NEWS</a></li>
					<li><a href="#">OPPORTUNITY</a>
					</li>
					<li><a href="#">FAQ</a></li>
					<li><a href="#">CONTACT US</a></li>               
				</ul>
			</div>
		</div>
	</div>