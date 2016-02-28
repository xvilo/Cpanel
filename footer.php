			<footer>
				<div class="container">
				</div>
			</footer>
		</div>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
		<script type="text/javascript" src="/js/modernizr.js"></script>
		<script src="/js/intlTelInput.min.js"></script>
		<script>
			Stripe.setPublishableKey('<?php echo $config['stripe']['pubKey'] ?>');
		</script>
		<script type="text/javascript" src="/js/app.js"></script>
	</body>
</html>