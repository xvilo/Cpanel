<?php require('header.php'); ?>
    <div id="main-content">
        <div id="guts">
	        <?php
		        if($_GET['id'] == ""){
		        ?>
            <div class="container">
                <div class="row">
                    <div class="twelve columns">
                        <div class="element nopadding">
                            <table class="table table-cp" id="invoices-table">
		                        <thead>
		                            <tr>
		                                <th>Nummer</th>
		                                <th>Naam</th>
		                                <th>Email</th>
		                                <th>Telefoon</th>
		                                <th><i class="fa fa-pencil-square-o"></i></th>
		                            </tr>
		                        </thead>
		                        <tbody>
			                        <?php 
				                        foreach (getAllUsers() as $user){ 
				                        ?>
			                        <tr>
										<th><a class='invoice number' href='<?php echo $user['usercustnum'] ?>'><?php echo $user['usercustnum'] ?></a></th>
										<th><a class='invoice name' href='<?php echo $user['usercustnum'] ?>'><?php echo $user[10] ?></a></th>
										<th><a class='invoice email' href='mailto:<?php echo $user['user_email'] ?>'><?php echo $user['user_email'] ?></a></th>
										<th><a class='invoice phone' href='tel:<?php echo $user[9] ?>'><?php echo $user[9] ?></a></th>
										<th><a class='invoice edit' href='<?php echo $user['usercustnum'] ?>'><i class="fa fa-pencil-square-o"></i></a></th>
		                           	<tr>
			                           	<?php
			                           	}?>
		                        </tbody>
		                    </table>
		                    <br>
		                     <center><a class="button button-primary" href="/admin/users/add">Voeg gebruiker toe</a></center>
		                     <br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
	        }elseif($_GET['id'] == "add"){
		    ?>
		        <div class="container">
            	<div class="row">
	            	<form method="post">
		            	<div class="eight columns">
			            	<div class="element">
				            	<h5>Account toevoegen</h5>
				            	<p>Het is nog niet mogelijk om een account toe te voegen. Dit graag direct in de database te doen</p>
				            	<!-- The above form looks like this -->
								  <div class="row">
								    <div class="six columns">
								    	<label for="userdetails-name">Naam</label>
										<input class="u-full-width" type="text" placeholder="Uw naam" id="userdetails-name" name="meta_key[full_name]">
										<label for="userdetails-email">E-mail</label>
										<input class="u-full-width" type="email" placeholder="Uw e-mail adres" id="userdetails-email" name="meta_key[company_name]">
										<label for="userdetails-phone">Telefoon</label>
										<input class="u-full-width" type="tel" placeholder="Uw Telefoonnummer" id="userdetails-phone" name="meta_key[user_phone]">
										<label for="userdetails-country">Land</label>
										<input class="u-full-width" type="text" placeholder="Uw land" id="userdetails-country" name="meta_key[adress_country]">
								    </div>
								    <div class="six columns">
									    <label for="userdetails-adress-*">Bedrijf</label>
										<input class="u-full-width" type="text" placeholder="Straatnaam 134" id="userdetails-adress-1" name="meta_key[adress_street]">
									    <label for="userdetails-adress-*">Adres</label>
										<input class="u-full-width" type="text" placeholder="Straatnaam 134" id="userdetails-adress-1" name="meta_key[adress_street]">
								        <label for="userdetails-zip">Postcode</label>
										<input class="u-full-width" type="text" placeholder="Postcode" id="userdetails-zip" name="meta_key[adress_zip]">
										<label for="userdetails-city">Plaats</label>
										<input class="u-full-width" type="text" placeholder="Plaatsnaam" id="userdetails-city" name="meta_key[adress_city]">
								    </div>
								  </div>
								  <input disabled="" class="button-primary" type="submit" value="Opslaan" name="userdatasubmit">
			            	</div>
			            	<div class="element">
				            	<h5>Betalingsvoorkeuren</h5>
				            	<label><input checked="checked" type="radio" class="payment-method-radio" id="payment-method-sepa-73441" name="meta_key[payment_type]" value="manual"><span> Overboeking</span></label>
				            	<label><input disabled="" type="radio" class="payment-method-radio" id="payment-method-sepa-73441" name="meta_key[payment_type]" value="sepa"><span> Automatische incasso</span></label>
				            	<p><i>Automatische incasso is op dit moment niet mogelijk voor uw account</i>
				            	<label for="ibanInput">IBAN</label>
								<input disabled="" class="u-full-width" type="text" placeholder="IBAN" id="ibanInput" name="meta_key[payment_iban]">
								<label for="ibanNameInput">Op naam van</label>
								<input class="u-full-width" type="text" placeholder="Uw naam" id="ibanNameInput" name="meta_key[payment_name]">
								<input class="button-primary" type="submit" value="Opslaan" name="userdatasubmit">
			            	</div>
		            	</div>
		            	<div class="four columns">
			            	<div class="element">
				            	<h5>Controlepaneel opties</h5>
				            	<p><i>Deze optie is nog niet voor jou beschikbaar</i></p>
				            	<input disabled="" class="button-primary" type="submit" value="Opslaan" name="userdatasubmit">
			            	</div>
			            	<div class="element">
				            	<h5>E-mail voorkeuren</h5>
				            	<p><i>Deze optie is nog niet voor jou beschikbaar</i></p>
				            	<input disabled="" class="button-primary" type="submit" value="Opslaan" name="userdatasubmit">
			            	</div>
		            	</div>
	            	</form>
            	</div>
		    </div>
			<?php
	        }else{
		        $userdata = getUserData($_GET['id']);
		        ?>
		    <div class="container">
            	<div class="row">
	            	<form method="post">
		            	<div class="eight columns">
			            	<div class="element">
				            	<h5>Account gegevens</h5>
				            	<!-- The above form looks like this -->
								  <div class="row">
								    <div class="six columns">
								    	<label for="userdetails-name">Naam</label>
										<input class="u-full-width" type="text" placeholder="Uw naam" id="userdetails-name" name="meta_key[full_name]" value="<?php echo $userdata[14] ?>">
										<label for="userdetails-email">E-mail</label>
										<input class="u-full-width" type="email" placeholder="Uw e-mail adres" id="userdetails-email" name="meta_key[company_name]" value="<?php echo $userdata['user_email'] ?>">
										<label for="userdetails-phone">Telefoon</label>
										<input class="u-full-width" type="tel" placeholder="Uw Telefoonnummer" id="userdetails-phone" name="meta_key[user_phone]" value="<?php echo $userdata[13] ?>">
										<label for="userdetails-country">Land</label>
										<input class="u-full-width" type="text" placeholder="Uw land" id="userdetails-country" name="meta_key[adress_country]" value="<?php echo $userdata[12] ?>">
								    </div>
								    <div class="six columns">
									    <label for="userdetails-company">Bedrijf</label>
										<input class="u-full-width" type="text" placeholder="Bedrijf" id="userdetails-company" name="meta_key[user_company]" value="<?php echo $userdata[15] ?>">
									    <label for="userdetails-adress-1">Adres</label>
										<input class="u-full-width" type="text" placeholder="Straatnaam 134" id="userdetails-adress-1" name="meta_key[adress_street]" value="<?php echo $userdata[9] ?>">
								        <label for="userdetails-zip">Postcode</label>
										<input class="u-full-width" type="text" placeholder="Postcode" id="userdetails-zip" name="meta_key[adress_zip]" value="<?php echo $userdata[10] ?>">
										<label for="userdetails-city">Plaats</label>
										<input class="u-full-width" type="text" placeholder="Plaatsnaam" id="userdetails-city" name="meta_key[adress_city]" value="<?php echo $userdata[11] ?>">
								    </div>
								  </div>
								  <input class="button-primary" type="submit" value="Opslaan" name="userdatasubmit">
			            	</div>
			            	<div class="element">
				            	<h5>Betalingsvoorkeuren</h5>
				            	<label><input checked="checked" type="radio" class="payment-method-radio" id="payment-method-sepa-73441" name="meta_key[payment_type]" value="manual"><span> Overboeking</span></label>
				            	<label><input disabled="" type="radio" class="payment-method-radio" id="payment-method-sepa-73441" name="meta_key[payment_type]" value="sepa"><span> Automatische incasso</span></label>
				            	<p><i>Automatische incasso is op dit moment niet mogelijk voor uw account</i>
				            	<label for="ibanInput">IBAN</label>
								<input class="u-full-width" type="text" placeholder="IBAN" id="ibanInput" name="meta_key[payment_iban]">
								<label for="ibanNameInput">Op naam van</label>
								<input class="u-full-width" type="text" placeholder="Uw naam" id="ibanNameInput" name="meta_key[payment_name]">
								<input class="button-primary" type="submit" value="Opslaan" name="userdatasubmit">
			            	</div>
		            	</div>
		            	<div class="four columns">
			            	<div class="element">
				            	<h5>Controlepaneel opties</h5>
				            	<p><i>Deze optie is nog niet voor jou beschikbaar</i></p>
				            	<input class="button-primary" type="submit" value="Opslaan" name="userdatasubmit">
			            	</div>
			            	<div class="element">
				            	<h5>E-mail voorkeuren</h5>
				            	<p><i>Deze optie is nog niet voor jou beschikbaar</i></p>
				            	<input class="button-primary" type="submit" value="Opslaan" name="userdatasubmit">
			            	</div>
		            	</div>
		            	<input hidden="" class="u-full-width" type="text" placeholder="Uw naam" id="userdetails-name" name="id" value="<?php echo $userdata['ID'] ?>">
	            	</form>
            	</div>
		    </div>
		    <?php
	        }
	        ?>
        </div>
    </div>
 <?php require('footer.php'); ?>