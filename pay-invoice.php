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
                        <div class="options-row">
                          <ul class="options clearfix">
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-print"></i></a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                          </ul>
                        </div>

                        <?php
								if(isset($_GET['no'])){
									$invoiceData = getFullInvoiceData($_GET['no']);
								}else{
									$invoiceData = getFullInvoiceData();
								}
							if($invoiceData['invoice_recipient'] == $_SESSION['user_num']){
						?>

                        <div class="element">
						<?php include('templates/invoice.php') ?>
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
