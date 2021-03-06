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
                        <div class="element">
                            <h1>Mijn Facturen</h1>

                            <p>Selecteer hier rechts een factuur om deze te bekijken<!-- , te downloaden of opnieuw per e-mail te versturen-->.</p>
                        </div>
                        
                        <?php 
								if(isset($_GET['no'])){
									$invoice = showInvoice($_GET['no']);
									$invoiceData = getFullInvoiceData($_GET['no']);
								}else{
									$invoice = showInvoice();
									$invoiceData = getFullInvoiceData();
								}
							if($invoiceData['invoice_recipient'] == $_SESSION['user_num']){
								echo $invoice;
						?>
							
                        
					</div>
					<?php
						}else{
							?>
							<div class="element">
								<h1>Error!</h1>
								<p>403 no access. Selecteer links een van de facturen.</p>
							</div>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div><?php require('footer.php'); ?>