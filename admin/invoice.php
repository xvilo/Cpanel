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
	                        <h5>Onbetaalde facturen</h5>
                            <table class="table table-cp" id="invoices-table">
		                        <thead>
		                            <tr>
		                                <th><i class="fa fa-check payed"></i></th>
		                                <th>Nummer</th>
		                                <th>Klant</th>
		                                <th>Betaling</th>
		                                <th>Totaal</th>
		                            </tr>
		                        </thead>
		                        <tbody>
			                        <?php
			                        foreach (getInvoices('0') as $invoices){
				                        $totalAmount = number_format($invoices['invoice_total'], 2, ',', '.');
				                        $invoiceStatus = getInvoiceStatus($invoices['invoice_status']);
				                        echo "<tr>";
										echo "<th><a class='invoice status' href='/admin/invoices/{$invoices['invoice_number']}'>{$invoiceStatus}</a></th>";
										echo "<th><a class='invoice number' href='/admin/invoices/{$invoices['invoice_number']}'>{$invoices['invoice_number']}</a></th>";
										echo "<th><a class='invoice customer' target='_blank' href='/admin/users/{$invoices['invoice_recipient']}'>{$invoices['invoice_recipient']}</a></th>";
										echo "<th><a class='invoice number' href='/admin/invoices/{$invoices['invoice_number']}'>{$invoices['invoice_number']}</a></th>";
										echo "<th><a class='invoice total' href='/admin/invoices/{$invoices['invoice_number']}'>&euro; {$totalAmount}</a></th>";
			                           	echo '<tr>';
			                        }
			                        ?>
		                        </tbody>
		                    </table>
                        </div>
	                    <Br>
                        <div class="element nopadding">
	                        <h5>Betaalde facturen</h5>
                            <table class="table table-cp" id="invoices-table">
		                        <thead>
		                            <tr>
		                                <th><i class="fa fa-check payed"></i></th>
		                                <th>Nummer</th>
		                                <th>Klant</th>
		                                <th>Betaling</th>
		                                <th>Totaal</th>
		                            </tr>
		                        </thead>
		                        <tbody>
			                        <?php
			                        foreach (getInvoices() as $invoices){
				                        $totalAmount = number_format($invoices['invoice_total'], 2, ',', '.');
				                        $invoiceStatus = getInvoiceStatus($invoices['invoice_status']);
				                        echo "<tr>";
										echo "<th><a class='invoice status' href='/admin/invoices/{$invoices['invoice_number']}'>{$invoiceStatus}</a></th>";
										echo "<th><a class='invoice number' href='/admin/invoices/{$invoices['invoice_number']}'>{$invoices['invoice_number']}</a></th>";
										echo "<th><a class='invoice customer' target='_blank' href='/admin/users/{$invoices['invoice_recipient']}'>{$invoices['invoice_recipient']}</a></th>";
										echo "<th><a class='invoice number' href='/admin/invoices/{$invoices['invoice_number']}'>{$invoices['invoice_number']}</a></th>";
										echo "<th><a class='invoice total' href='/admin/invoices/{$invoices['invoice_number']}'>&euro; {$totalAmount}</a></th>";
			                           	echo '<tr>';
			                        }
			                        ?>
		                        </tbody>
		                    </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
	        }else{
		        $userdata = getFullInvoiceData($_GET['id']);
		        ?>
		        <div class="container">
	                <div class="row">
	                    <div class="twelve columns">
		                    <div class="element">
			                    <h5>Details factuur: <i><?php echo $_GET['id'] ?></i></h5>
			                    <p>Een rij factuur opties</p>
		                    </div>
				                <?php 
								$invoiceData = getFullInvoiceData($_GET['id']); ?>
									
		                        <div class="element">
								<?php include('../templates/invoice.php') ?>
							</div>
	                    </div>
	                </div>
		        </div>
		    <?php
	        }
	        ?>
        </div>
    </div>
 <?php require('footer.php'); ?>