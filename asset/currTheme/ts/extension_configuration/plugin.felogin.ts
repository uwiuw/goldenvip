plugin.tx_felogin_pi1 {
   templateFile = {$rwConf.extensiontemplates}fe_login.html
   welcomeMessage_stdWrap {
		wrap = <div class="welcome-msg">|</div>
   }
   errorMessage_stdWrap {
		wrap = <div class="error-msg">|</div>
   }  
   cookieWarning_stdWrap >
}