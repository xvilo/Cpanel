<?php require('header.php'); ?>
			<div id="main-content">
				<div id="guts">
					<?php if(isset($_POST['reset_user'])){
						?>
						<div class="login-box">
						<div class="element">
							<h5>Wachtwoord vergeten</h5>
							<form method="post">
								  <label for="emailHelp">Stap 2: Check je e-mail. Hier ontvangt u de token</label>
					              <label for="tokenInput">Stap 3: Vul je token en nieuwe wachtwoord in</label>
					              <input class="u-full-width" type="text" name="reset_token" placeholder="Token" id="tokenInput">
					              <input class="u-full-width" type="password" name="reset_pass" placeholder="Wachtwoord" id="resetPassInput">
						          <input class="button-primary" type="submit" value="Submit" name="loginforgotresetsubmit"><br>
        					</form>
						</div>
					</div>
					<?php
						}elseif(!isset($_GET['type']) || !empty($loginsuccess)){	
					?>
					<div class="login-box">
						<div class="element">
							<form method="post">
								<?php
									if (!empty($loginerror)) {
										?>
										<div class="notice error">
											<p><span>Fout:</span> <?php echo $loginerror;?></p>
										</div>
										<?php
									}
									?>
									<?php
									if (!empty($loginsuccess)) {
										?>
										<div class="notice success">
											<p><span></span> <?php echo $loginsuccess;?></p>
										</div>
										<?php
									}
									?>
					              <label for="exampleEmailInput">Gebruikersnaam</label>
					              <input class="u-full-width" type="text" name="login_user" placeholder="Gebruikersnaam" id="exampleEmailInput">
					              <label for="exampleEmailInput">Wachtwoord</label>
					              <input class="u-full-width" type="password" name="login_pass" placeholder="Wachtwoord" id="exampleEmailInput">
					              <label for="Captcha">Bent u een robot?</label>
					              <div class="g-recaptcha" data-sitekey="6Lc5JRQTAAAAAFc5UvrC-MTKiVYHNhQWIq7OzuDC"></div>
						          <input class="button-primary" type="submit" value="Submit" name="loginsubmit"><br>
						          <a href="/login/?type=forgot">Wachtwoord vergeten</a>
        					</form>
						</div>
					</div>
					<?php }elseif($_GET['type']=='forgot'){
						?>
						<div class="login-box">
						<div class="element">
							<h5>Wachtwoord vergeten</h5>
							<form method="post">
					              <label for="usernameInput">Stap 1: Vul uw gebruikersnaam in</label>
					              <input class="u-full-width" type="text" name="reset_user" placeholder="Gebruikersnaam" id="usernameInput">
						          <input class="button-primary" type="submit" value="Submit" name="loginforgotsubmit"><br>
        					</form>
						</div>
					</div>
						<?php
					}
					?>
				</div>
			</div>
<?php require('footer.php'); ?>