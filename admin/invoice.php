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
										echo "<th><a class='invoice customer' href='/admin/invoices/{$invoices['invoice_number']}'>{$invoices['invoice_recipient']}</a></th>";
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
										echo "<th><a class='invoice status' href='/invoice/{$invoices['invoice_number']}'>{$invoiceStatus}</a></th>";
										echo "<th><a class='invoice number' href='/invoice/{$invoices['invoice_number']}'>{$invoices['invoice_number']}</a></th>";
										echo "<th><a class='invoice customer' href='/invoice/{$invoices['invoice_number']}'>{$invoices['invoice_recipient']}</a></th>";
										echo "<th><a class='invoice number' href='/invoice/{$invoices['invoice_number']}'>{$invoices['invoice_number']}</a></th>";
										echo "<th><a class='invoice total' href='/invoice/{$invoices['invoice_number']}'>&euro; {$totalAmount}</a></th>";
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
								$invoiceData = getFullInvoiceData($_GET['id']);
								$invoice_adress = unserialize($invoiceData['invoice_adress']);
								$productsData = unserialize($invoiceData['invoice_products']);
								?>
									
		                        <div class="element">
								<table id="invoice-table" align="center" border="0" cellpadding="0" cellspacing="0" width="700">
									<tr style="width: 350px; float: left;">
										<td style="display:block;border: none;">
											<h1>Factuur</h1>
										</td>
										<td class="resp" style="display:block;border: none;">
											<p><?php echo $invoice_adress['Company'];?><br>
											<?php echo $invoice_adress['Full Name'];?><br>
											<?php echo $invoice_adress['Adress'];?> <?php echo $invoice_adress['AdressExtra'];?><br>
											<?php echo $invoice_adress['Zipcode'];?> <?php echo $invoice_adress['City'];?></p>
										</td>
										<td class="desc" style="display:block; margin-top: 50px; border: none;">
											<p><b>Klantnummer:</b> <?php echo $_SESSION['user_num'] ?><br>
											<b>Factuurnummer:</b> <?php echo $invoiceData['invoice_number'] ?><br>
											<b>Factuurdatum:</b> <?php echo $invoiceData['invoice_date'] ?><br>
											<b>Ordernummer:</b> <?php echo $invoiceData['invoice_ordernum'] ?></p>
										</td>
									</tr>
									<tr style="width: 220px; float:right;">
										<td class="sender" style=
										"border-left: 3px #00A1DA solid; padding-left: 10px; margin-top: 40%; display: block;">
										<p><b>D3 - Creative agency</b><br>
											Kloppenburgstraat 7<br>
											8302GE Emmeloord<br>
											Nederland</p>
											<p>Tel: (+31) (0)85 888 1917<br>
											Int: +1 336-383-1183<br>
											Mail: sem@thisisd3.com<br>
											KVK: 64482316<br>
											BTW: NL221845124B01</p>
										</td>
									</tr>
									<tr style="clear:both;">
										<td></td>
									</tr>
									<tr style="width: 700px; float: left; margin-top:30px; margin-bottom: 10px;">
										<td style="width:363px; float:left; display:block;border: none;">
											Artikel
										</td>
										<td style="width: 125px; float:left; display:block;border: none;">
											Prijs per stuk
										</td>
										<td style="width: 115px; float:left; display:block;border: none;">
											Aantal
										</td>
										<td style="width: 97px; float:left; display:block;border: none;">
											Prijs totaal
										</td>
										<td style="clear: both; height: 0px; display: block;">&nbsp;</td>
										<td style="display:block;">
											<hr style="margin:0px;">
										</td>
									</tr>
									<tr style="clear:both;">
										<td></td>
									</tr>
									<?php foreach($productsData as $product){
										?>
									<!-- Begin product -->
									<tr style="width: 700px; float: left; margin-top:0px;">
										<td style="width:363px; float:left; display:block;border: none;">
											<?php echo $product['name'] ?>
										</td>
										<td style="width: 125px; float:left; display:block;border: none;">
											&euro; <?php echo number_format($product['priceOne'], 2, ',', '.') ?>
										</td>
										<td style="width: 115px; float:left; display:block;border: none;">
											<?php echo $product['amount'] ?>
										</td>
										<td style="width: 97px; float:left; display:block;border: none;">
											&euro; <?php echo number_format($product['priceTot'], 2, ',', '.') ?>
										</td>
										<td style="clear: both; height: 0px; display: block;">&nbsp;</td>
										<td style="display:block;"></td>
									</tr>
									<!-- end product -->
									<?php	
									}
									?>
									<tr>
										<td style="clear: both; height: 0px; display: block;">&nbsp;</td>
										<td style="display:block; margin-top:60px; margin-bottom: 15px;">
											<hr style="margin:0px;">
										</td>
									</tr>
									<tr style="width: 220px; float:right;">
										<td class="sender" style="padding-left: 10px;display: block;">
											<p>Subtotaal : &euro; <span style="text-align: right;"><?php echo number_format($invoiceData['invoice_subtotal'], 2, ',', '.') ?></span><br>
											Btw (21%): &euro; <?php echo number_format($invoiceData['invoice_tax'], 2, ',', '.') ?></p>
											<p></p>
											<hr>
											<p><b>Totaal: &euro; <?php echo number_format($invoiceData['invoice_total'], 2, ',', '.') ?></b></p>
										</td>
									</tr>
									<tr style="clear:both;">
										<td>
											<p style="margin-top:60px;"><b>Betaling factuur</b><br>
											Is deze factuur nog niet betaald, dan zien we de betaling graag voor
											16-12-2015 tegemoet op IBAN / rekening <b><i>NL33 ABNA 0448 1553 89</i></b>
											ten name van <b><i>Sem Schilder</i></b> onder vermelding van het kenmerk
											<b><i>0405150/0212150</i></b></p>
										</td>
									</tr>
								</table>
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