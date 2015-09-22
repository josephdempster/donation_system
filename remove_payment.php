<?php 
		require_once("functions.class.php");
		$cart = new functions;
		@$cart->deletePayment();
		header("location: index.php");
?>
