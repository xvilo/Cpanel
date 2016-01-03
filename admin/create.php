<?php require('header.php'); ?>
    <div id="main-content">
        <div id="guts">
	        <template id="tempproduct">
		        <!-- product begin -->
				<div class="row">
					<div class="six columns">
						<input type="text" name="products[0][]" class="product product-title" placeholder="Titel">
					</div>
					<div class="three columns">
						<input type="text" name="products[0][]" class="product" placeholder="Aantal">
					</div>
					<div class="three columns">
						<input type="text" name="products[0][]" class="product" placeholder="Prijs per stuk">
					</div>
				</div>
				<!-- product eind -->
		     </template>
            <div class="container">
                <div class="row">
                    <div class="twelve columns">
                        <div class="element">
                            <h1>Create</h1>
                            <form class="form" action="send.php" method="post">
								<select id="user_select">
									<option>Selecteer klant</option>
									<?php
										foreach (getAllUsersOption() as $user){
											echo "<option name='userid' value='{$user['ID']}'>{$user['meta_value']}</option>";
										}
									?>
								</select>
								<div class="row">
			                    <div class="four columns">
				                    <label for="invoice-number">Factuur nummer:</label>
									<input class="u-full-width" type="text" placeholder="Factuurnummer" id="invoice-number" name="invoice_number" value="<?php echo date('mdy0') ?>">
									<label for="invoice-number">Factuur datum:</label>
									<input class="u-full-width" type="date" placeholder="Factuurnummer" id="invoice-number" name="invoice_number" value="<?php echo date('Y-m-d') ?>">	
									<label for="invoice-number">Order nummer</label>
									<input class="u-full-width" type="text" placeholder="Factuurnummer" id="invoice-number" name="invoice_number" value="<?php echo date('mdy0') ?>">	
									<button class="button-primary" name="invoicesubmit" type="Submit">Submit</button> <button type="button" class="button-primary" id="add">Add product</button>
			                    </div>
			                    <div id="products" class="eight columns product-group">
				                    <div class="row">
					                    <div class="six columns">
						                    <h6>Naam</h6>
					                    </div>
					                    <div class="three columns">
						                    <h6>Aantal</h6>
					                    </div>
					                    <div class="three columns">
						                    <h6>Prijs</h6>
					                    </div>
				                    </div>
				                    <!-- product begin -->
				                    <div class="row">
					                    <div class="six columns">
						                    <input type="text" name="products[0][]" class="product product-title" placeholder="Titel">
					                    </div>
					                    <div class="three columns">
						                    <input type="text" name="products[0][]" class="product" placeholder="Aantal">
					                    </div>
					                    <div class="three columns">
						                    <input type="text" name="products[0][]" class="product" placeholder="Prijs per stuk">
					                    </div>
				                    </div>
			                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><?php require('footer.php'); ?>