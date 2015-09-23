<?php 
	require_once("functions.class.php");
	$cart = new functions;
	@$cart->formatPaypal();				
?>
<html>
<head>
<title>Loading..</title>
</head>
<body>
<center><img src="http://www.bupa.co.uk/Assets/Global/Components/Img/ajax-loader.gif"></center>
<script type="text/javascript">
window.onload = function(){
  document.forms['submit_paypal'].submit();
}
</script>
</body>
</html>