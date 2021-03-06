<?php require('header.php'); ?>
    <div id="main-content">
        <div id="guts">
            <div class="leftwrapper">
                <div class="element nopadding">
                    <table class="table table-cp" id="invoices-table">
                        <thead>
                            <tr>
                                <th><i class="fa fa-check"></i></th>
                                <th>Nummer</th>
                                <th>Totaal</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach (getInvoices($_SESSION['user_num']) as $invoices){
	                        $totalAmount = number_format($invoices['invoice_total'], 2, ',', '.');
	                        $invoiceStatus = getInvoiceStatus($invoices['invoice_status']);
	                        echo "<tr>";
							echo "<th><a class='invoice status' href='/invoice/{$invoices['invoice_number']}'>{$invoiceStatus}</a></th>";
							echo "<th><a class='invoice number' href='/invoice/{$invoices['invoice_number']}'>{$invoices['invoice_number']}</a></th>";
							echo "<th><a class='invoice total' href='/invoice/{$invoices['invoice_number']}'>&euro; {$totalAmount}</a></th>";
                           	echo '<tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="four columns original-width">
                        <p>&nbsp;</p>
                    </div>
                    <div class="eight columns">
	                    <?php
								if(isset($_GET['no'])){
									$invoiceData = getFullInvoiceData($_GET['no']);
								}else{
									$invoiceData = getFullInvoiceData();
								}
							if($invoiceData['invoice_recipient'] == $_SESSION['user_num']){
						?>
                        <div class="element">
                            <h1>Mijn Facturen</h1>

                            <p>Selecteer hier rechts een factuur om deze te bekijken<!-- , te downloaden of opnieuw per e-mail te versturen-->.</p>
                        </div>
                        <div class="options-row">
                          <ul class="options clearfix">
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-print"></i></a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                          </ul>
                        </div>

                        <div class="element">
						<?php include('templates/invoice.php') ?>
                        </div>
                        <div class="element">
                        	  <form method="POST" id="payment-form">
							    <span class="payment-errors"></span>
							
							    <div class="form-row">
							      <label>
							        <span>Card Number</span>
							        <input type="text" size="20" data-stripe="number"/>
							      </label>
							    </div>
							
							    <div class="form-row">
							      <label>
							        <span>CVC</span>
							        <input type="text" size="4" data-stripe="cvc"/>
							      </label>
							    </div>
							
							    <div class="form-row">
							      <label>
							        <span>Expiration (MM/YYYY)</span>
							        <input type="text" size="2" data-stripe="exp-month"/>
							      </label>
							      <span> / </span>
							      <input type="text" size="4" data-stripe="exp-year"/>
							    </div>
								<input type="text" size="20" name="payinvoicenum" value="<?php echo $invoiceData['invoice_number'] ?>" hidden/>
							    <button type="submit">Submit Payment</button>
							  </form>
                        </div>
					</div>
					<?php
						}else{
							?>
							<div class="element">
								<h1>Error!</h1>
								<p>403 no access.</p>
							</div>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div><?php require('footer.php'); ?>
