<?php require('header.php'); ?>
			<div id="main-content">
				<div id="guts">
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
					              <label for="exampleEmailInput">Gebruikersnaam</label>
					              <input class="u-full-width" type="text" name="login_user" placeholder="Gebruikersnaam" id="exampleEmailInput">
					              <label for="exampleEmailInput">Wachtwoord</label>
					              <input class="u-full-width" type="password" name="login_pass" placeholder="Wachtwoord" id="exampleEmailInput">
						          <input class="button-primary" type="submit" value="Submit" name="loginsubmit">
        					</form>
						</div>
					</div>
				</div>
			</div>
<?php require('footer.php'); ?>