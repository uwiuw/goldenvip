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
			scroll : {
				fx : "fade"
			}
		});
		$("#slider-business").carouFredSel({
			auto : 5000,
			items:1,
			infinite: false,
			scroll : {
				fx : "fade"
			}
		});
		$("#slider-travel").carouFredSel({
			auto : 5000,
			items:1,
			infinite: false,
			scroll : {
				fx : "fade"
			}
		});
		$("#slider-vip").carouFredSel({
			auto : 5000,
			items:1,
			infinite: false,
			scroll : {
				fx : "fade"
			}
		});
	});
</script>
<body>
	<div id="header">
        <div id="top-line"></div>
      	<div id="part-of-header">
        	<div class="area-button-top">
            	<div id="btn-gold" class="alignleft">
                	<a href="<?php echo site_url('member/back-office'); ?>" id="">Back Office</a>
                </div>
                <div id="btn-gold" class="alignleft">
                	<a href="<?php echo site_url('member/join-now'); ?>" id="">Join Now</a>
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
                        <a href="<?php echo site_url('home-page'); ?>">home</a>
                    </li>
                    <li id="about">
                        <a href="<?php echo site_url('about-us'); ?>">about us</a>
                    </li>
                    <li id="products">
                        <a href="<?php echo site_url('products'); ?>">products</a>
                    </li>
                    <li id="news">
                        <a href="<?php echo site_url('news'); ?>">news</a>
                    </li>
                    <li id="faq">
                        <a href="<?php echo site_url('faq'); ?>">faq</a>
                    </li>
                    <li id="contact">
                        <a href="<?php echo site_url('contact-us'); ?>">contact us</a>
                    </li>
                </ul>
        </div>
    </div>
    <!-- end of header -->