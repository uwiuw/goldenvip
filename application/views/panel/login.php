<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MyGoldenVIP Administrator</title>
</head>
<link rel="stylesheet" href="<?php echo base_url(); ?>/asset/theme/wp/login.css" type="text/css" media="all">
<link rel="stylesheet" id="colors-css" href="<?php echo base_url(); ?>/asset/theme/wp/colors-fresh-login.css" type="text/css" media="all">
<meta name="robots" content="">
<script type="text/javascript">
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
function s(id,pos){g(id).left=pos+'px';}
function g(id){return document.getElementById(id).style;}
function shake(id,a,d){c=a.shift();s(id,c);if(a.length>0){setTimeout(function(){shake(id,a,d);},d);}else{try{g(id).position='static';wp_attempt_focus();}catch(e){}}}
addLoadEvent(function(){ var p=new Array(15,30,15,0,-15,-30,-15,0);p=p.concat(p.concat(p));var i=document.forms[0].id;g(i).position='relative';shake(i,p,20);});
</script>
</head>
<body class="login">
	<div id="login">
		
		<?php if($this->session->flashdata('info')) { ?>
        <div id="login_error">	
        	<strong>ERROR</strong> : <?php echo $this->session->flashdata('info'); ?><br>
		</div>
        
		<?php } ?>
		<form style="position: static; left: 0px;" name="loginform" id="loginform" action="<?php echo site_url('_admin/check_login'); ?>" method="post">
            <p>
                <label>Username<br>
                    <input name="log" id="user_login" class="input" value="" size="20" tabindex="10" type="text">
                </label>
            </p>
            <p>
                <label>
                    Password<br>
                    <input name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" type="password">
                </label>
            </p>
           
            <p class="submit">
                <input name="wp-submit" id="wp-submit" class="button-primary" value="Log In" tabindex="100" type="submit">
                <input name="redirect_to" value="http://localhost/wordpress/wp-admin/" type="hidden">
                <input name="testcookie" value="1" type="hidden">
            </p>
		</form>
	</div>
	<p id="backtoblog"><a href="<?php echo site_url(); ?>" title="Are you lost?">← Back to <?php echo site_url(); ?></a></p>
<script type="text/javascript">
			if(typeof wpOnload=='function')wpOnload();
</script>
</body>
</html>
