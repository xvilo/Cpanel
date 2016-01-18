<?php
//some extra logic
$date = explode(" ",$invoiceData['invoice_duedate']);
$dueDate = $date[0];
$date = explode(" ",$invoiceData['invoice_date']);
$invoiceDate = $date[0];
?>
<table id="invoice-table" align="center" border="0" cellpadding="0" cellspacing="0" width="700">
							<tr style="width: 350px; float: left;">
								<td style="display:block;border: none;">
									<h1>Factuur</h1>
								</td>
								<td class="resp" style="display:block;border: none;">
									<p><?php foreach (json_decode($invoiceData['invoice_adress']) as $adress) echo "$adress <br>" ?></p>
								</td>
								<td class="desc" style="display:block; margin-top: 50px; border: none;">
									<p><b>Klantnummer:</b> <?php echo $_SESSION['user_num'] ?><br>
									<b>Factuurnummer:</b> <?php echo $invoiceData['invoice_number'] ?><br>
									<b>Factuurdatum:</b> <?php echo $invoiceDate; ?><br>
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
							<?php foreach(json_decode($invoiceData['invoice_products']) as $product){
								?>
							<!-- Begin product -->
							<tr style="width: 700px; float: left; margin-top:0px;">
								<td style="width:363px; float:left; display:block;border: none;">
									<?php echo $product[0] ?>
								</td>
								<td style="width: 125px; float:left; display:block;border: none;">
									&euro; <?php echo number_format($product[2], 2, ',', '.') ?>
								</td>
								<td style="width: 115px; float:left; display:block;border: none;">
									<?php echo $product[1] ?>
								</td>
								<td style="width: 97px; float:left; display:block;border: none;">
									&euro; <?php echo number_format($product[2] * $product[1], 2, ',', '.') ?>
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
									<?php echo $dueDate ?> tegemoet op IBAN / rekening <b><i>NL33 ABNA 0448 1553 89</i></b>
									ten name van <b><i>Sem Schilder</i></b> onder vermelding van het kenmerk
									<b><i>0405150/0212150</i></b></p>
								</td>
							</tr>
						</table>