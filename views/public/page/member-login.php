
<!-- form -->
<div id="contact-form">
    <div id="text-on-form">Member Login</div>
    <div id="shadow-form" class="elips">
    	<form action="<?php echo site_url("member/check-login"); ?>" method="post">
        <div class="field-login">
        	<label class="alignleft">Username </label>
            <input type="text" name="name" class="alignright" />
        </div>
        <div class="field-login">
        	<label class="alignleft">Password  </label>
            <input type="password" name="pwd" class="alignright" />
        </div> 
        <div class="field-login">
        	<input type="submit" name="submit" class="gold-button alignright" value="Login"/>
        </div><br><br>
		</form>
        <div class="field-login">*forget password? <a href="#" class="gold-color">click here</a></div>
    </div>
</div>
<!-- end form -->