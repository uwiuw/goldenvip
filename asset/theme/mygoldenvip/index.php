<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>re-design mygoldenvip</title>
</head>
<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" language="javascript" src="jquery.carouFredSel-5.1.0-packed.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		 
			$('ul.nav-ul>li:not(:last-child)').addClass('with-separator'); 
	});
	$(function() {
		$("#slider ul").carouFredSel({
			circular: true,
			infinite: false,
			auto : false,
			pagination	: "#navigation",
			items:1
		});
	});
</script>
<body>
	<div id="header">
        <div id="top-line"></div>
      	<div id="part-of-header">
        	<div class="area-button-top">
            	<div id="btn-gold" class="alignleft">
                	<a href="#" id="">Back Office</a>
                </div>
                <div id="btn-gold" class="alignleft">
                	<a href="#" id="">Join Now</a>
                </div>
            </div>
        </div>
    </div>
    <div id="bottom-line"></div>
    <div id="top-menu-shadow"></div>
    <div id="top-menu-nav">
    	<div id="list-nav">
        	
                <ul class="nav-ul">
                    <li>
                        <a href="#">home</a>
                    </li>
                    <li>
                        <a href="#">about us</a>
                    </li>
                    <li>
                        <a href="#">products</a>
                    </li>
                    <li>
                        <a href="#">news</a>
                    </li>
                    <li>
                        <a href="#">faq</a>
                    </li>
                    <li>
                        <a href="#">contact us</a>
                    </li>
                </ul>
        </div>
    </div>
    
    <div id="content">
    	<div id="slider">
        	<div id="container-slide">
                <ul class="data-slide">
                    <li><img src="upload/picture.png" /></li>
                    <li><img src="upload/picture.png" /></li>
                </ul>
            </div>
           	<div class="pagination" id="navigation"></div>
        </div>
    </div>
    
</body>
</html>
