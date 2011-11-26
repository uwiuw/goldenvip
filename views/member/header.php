<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
</head>
<link rel="stylesheet" href="<?php echo $template; ?>style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $template; ?>member.css" type="text/css" />
<script type="text/javascript" src="<?php echo $template; ?>jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $template; ?>jquery.carouFredSel-5.1.0-packed.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		 
			$('ul.nav-ul>li:not(:last-child)').addClass('with-separator'); 
			$("li#<?php echo $nav; ?>").addClass('active');
	});
	$(function() {
		$("#slide-content").carouFredSel({
			auto : 5000,
			pagination: {
						container: "#navigation"
					},
			items:1,
			infinite: false
		});
		$("#slider-business").carouFredSel({
			auto : 5000,
			items:1,
			infinite: false
		});
		$("#slider-travel").carouFredSel({
			auto : 5000,
			items:1,
			infinite: false
		});
		$("#slider-vip").carouFredSel({
			auto : 5000,
			items:1,
			infinite: false
		});
	});
</script>
<body>
	<div id="header">
        <div id="top-line"></div>
      	<div id="part-of-header">
        	<div class="area-button-top">
            	<div id="btn-gold" class="alignleft">
                	<a href="<?php echo site_url('member/logout'); ?>" id="">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div id="bottom-line"></div>
    <div id="top-menu-shadow"></div>
    <div id="top-menu-nav">
    	<div id="list-nav">
        	
                <ul class="nav-ul">
                    <li id="homepage">
                        <a href="<?php echo site_url('member/home-page'); ?>">home</a>
                    </li>
                    <li id="profile">
                        <a href="<?php echo site_url('member/profile'); ?>">profile</a>
                    </li>
                    <li id="products">
                        <a href="<?php echo site_url('member/report'); ?>">report</a>
                    </li>
                    <li id="opportunity">
                        <a href="<?php echo site_url('member/opportunity'); ?>">opportunity</a>
                    </li>
                    <li id="reservation">
                        <a href="<?php echo site_url('member/reservation'); ?>">reservation</a>
                    </li>
                    <li id="news">
                        <a href="<?php echo site_url('member/news'); ?>">news</a>
                    </li>
                </ul>
        </div>
    </div>
    <!-- end of header -->