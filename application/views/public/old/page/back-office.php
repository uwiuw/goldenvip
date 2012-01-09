<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/admin-hotel.css" type="text/css">
<div class="container">
				<div id="hotel-login-backoffice"><a id="c87"></a>
					<div class="tx-felogin-pi1">
						<h3></h3>
                        <div class="error-msg"><?php echo $this->session->flashdata('info'); ?></div>
						<div class="welcome-msg"></div>
						<form  method="post" target="_top" action="<?php echo site_url("member/check-login"); ?>">
							<fieldset><legend>Login</legend>
								<div><label for="user">Username:</label><input type="text" value="" name="name" id="user"></div>
								<div><label for="pass">Password:</label><input type="password" value="" name="pwd" id="pass"></div>
								<div><input type="submit" value="Login" name="submit"></div>
								<div class="felogin-hidden"><input type="hidden" value="login" name="logintype"><input type="hidden" value="67" name="pid"><input type="hidden" value="member/back-office/menu-back-office/home/" name="redirect_url"><input type="hidden" value="0" name="tx_felogin_pi1[noredirect]">
									<input type="hidden" value="A3766045D66DB30A6A8784D92022E6A9C0C1FF91F29291DC6A75E869FDAF2473063F6AC0B4203CDD3CB2654DB72D570D18BF6FBBCF86D0F27D846017C1411B846A811DFE2063E8A424D4A801C2362173CF8EFADFD4FA25D545F9A5331B107B91FF11B9717A59F8FFAFA504105870CB692A4A67323F5663C2E01C327A9FF032AD" name="n" id="rsa_n"><input type="hidden" value="10001" name="e" id="rsa_e"></div>
							</fieldset>
						</form>
						<p style="display:none"><a href="member/back-office/?tx_felogin_pi1%5Bforgot%5D=1">Forgot your password?</a></p>
					</div>
				</div>
			</div>