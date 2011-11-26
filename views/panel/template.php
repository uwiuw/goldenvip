<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
</head>
<?php $this->load->view('panel/header'); ?>
<body>
<div id="wpwrap">
	<div id="wpcontent">
        <div id="wphead">
        	 <?php $this->load->view('panel/wphead'); ?>
		</div>
        <div id="wpbody">
        	<?php $this->load->view('panel/wpbody');?>
           	<div id="wpbody-content">
            	<div class="wrap">
					<div id='info-saving'></div>
                    <div id="site-content"></div>
                </div>
           		<div class="clear"></div> 
            </div><!-- wpbody-content -->
           	<div class="clear"></div>
       	</div><!-- wpbody -->
        <div class="clear"></div>
       </div><!-- wpcontent -->
</div><!-- wpwrap -->

<div id="footer">
    <?php $this->load->view('panel/footer'); ?>
</div>
</body>
</html>
