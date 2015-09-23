<?php 
if (!isset($_COOKIE['currency'])) {
	$_COOKIE['currency'] = "GBP";
	$_COOKIE['currency_symbol'] = "£";
} 



mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>World Federation of KSIMC Payment System</title>
	<link href="style.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
	
  <body>

  <div class="container-fluid">
  <div class="row" id="global-header">
<br>
<div class="col-md-5" style="margin-left:7%">
<ul id="ddmenu-root">	
	<li class="ddmenu-item">Community</li>
	<li class="ddmenu-item">Relief</li>	
	<li class="ddmenu-item">Islamic Education</li>
	<li class="ddmenu-item">MCE</li>
	<li class="ddmenu-item">Secetariat Documents</li>
</ul>
</div>
<div class="col-md-1" style="padding-left: 0px; padding-right:0px;"><div id="icon-pad"><img src="https://www.world-federation.org/wf_images/home.png">&nbsp;&nbsp;<img src="https://www.world-federation.org/wf_images/basket.png">&nbsp;&nbsp;<img src="https://www.world-federation.org/wf_images/user.png"></div></div>
<div class="col-md-2" style="padding-left: 30px;"><div id="search-pad"><form action="#" method="POST"><input type="text"></div></form></div>
<div class="col-md-2" style="padding-left: 30px;"><img src="https://www.world-federation.org/wf_images/top.png" style="position:relative; bottom: 20px;"></div>
<br>  

	</div>
	<div class="row" id="logo-strip" style="margin-left:10%">
		<img src="images/logi.png" class="img-responsive">
	</div>
</div>
<div class="container-fluid" id="main-body">
	<div class="row">
		<div class="col-md-3"><br /></div>
		<div class="col-md-6">
		<section id="currency-section">
		
			<div class="col-md-9"><br></div>
			<div class="col-md-3">
			<form action="index.php" id="switchcurr" method="POST">						
				<div class="col-md-6">
				<label for="currency" id="currency-label">Currency</label>
				</div>
				<div class="col-md-6">
					<select id="currency" name="currency">
						<option value="GBP">GBP</option>
						<option value="USD">USD</option>
						<option value="EUR">EUR</option>
					</select>
				</div>
					<span id="currency-changed"></span>
									
				
		</form>
		</div>
		</section>
		<div id="centerfold" style="margin-left:auto; margin-right:auto; margin-bottom:50%;">			
		<section id="search-fund">
		<h3 id="make-donation-heading">Make a donation or payment</h3>
		<form action="#" method="POST">
		<span class="glyphicon glyphicon-search" id="search-glass" aria-hidden="true"></span><br>
		<input type="text" id="search-input" autocomplete="off" name="search" value="Search for a Donation or Payment"><br>
		<ul id="livesearch" style='list-style-type:none; padding:0px;'>
		</ul>
		</form>
		<br>
		<!-- DO NOT REMOVE THIS, IT'S A SETTER ELEMENT FOR THE CURRENCY. WITHOUT IT CURRENCY WONT CHANGE! -->
		<div id="satay" style="visibility:hidden;">£</div>
		<div id="results">
		
		</div>
			<a href="#" id="show-all" style="">Show all Donations or Payments</a>
		<a href="#" id="hide-link" style="display:none;">Hide Donations or Payments</a>
		<br><br>	
		<h3 id="your-payments">Your donations or payments</h3>
		<div id="my-payments" style=""><?php 
		require_once("functions.class.php");
		$cart = new functions;
		@$cart->addPayment(); 
		$cart->updatePayment();
        $cart->deletePayment();		
		@$cart->setCurrency();
		?></div>
		
		<div class="total-wrap">
		<form action="send_paypoint.php" method="POST">
		<input type="hidden" name="cart_id" value="<?php echo session_id(); ?>">
		<input type="hidden" name="currency" value="<?php if (isset($_COOKIE['currency'])) { echo $_COOKIE['currency']; } else { echo 'GBP'; } ?>">
		<h3>Total: <div class="symbol" style="display:inline"><?php if (isset($_COOKIE['currency_symbol'])) { echo $_COOKIE['currency_symbol']; } else { echo '£'; } ?></div><div id="total" style="display:inline;"><?php echo($cart->total_sum); ?></div></h3><br>
		<input type="submit" id="make-payment" value="Make Payment" style="">
		</form>
		<br><br>
		<form action="send_paypal.php" method="POST">
		<input type="hidden" name="cart_id" value="<?php echo session_id(); ?>">
		<input type="hidden" name="currency" value="<?php if (isset($_COOKIE['currency'])) { echo $_COOKIE['currency']; } else { echo 'GBP'; } ?>">
		<input type="submit" id="make-payment" value="Pay with PayPal" style="">
		</form>
		<br><br>
		</div>		
		
		
		</section>
		</div>
		</div>
		<div class="col-md-3"><br /></div>
	</div>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.appear/0.3.3/jquery.appear.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script>
	

	$(document).on( "change", "select#currency", function() {
			
			currency_code = $(this).val();
			$("#satay").text(currency_code);
			
			text = $("#satay").text();		
		    
				
			
			if (text == "GBP") {				
				$("#satay").siblings("#results").children("#appeal-box").children(".symbol").text('£');
			} else if (text == "USD") {				
				$("#satay").siblings("#results").children("#appeal-box").children(".symbol").text('$');
			} else if (text == "EUR") {
				$("#satay").siblings("#results").children("#appeal-box").children(".symbol").text('€');				
			}
			
			$("#sataybtm").text(currency_code);
				textbtm = $("#sataybtm").text();
				
			if (textbtm == "GBP") {				
				$("#sataybtm").siblings(".add-form").children("#paymentrow").children(".symbol").text('£');
			} else if (textbtm == "USD") {				
				$("#sataybtm").siblings(".add-form").children("#paymentrow").children(".symbol").text('$');
			} else if (textbtm == "EUR") {
				$("#sataybtm").siblings(".add-form").children("#paymentrow").children(".symbol").text('€');				
			}
			
		
			
			
		});
		
		
		$( document ).on( "input", "input#appeal-amount", function() {
			var amount = $('#appeal-amount').val();
			var targetClass = $(this).attr('class');
			
			
				if($.isNumeric($(this).val())){
					$( this ).css( "border-color", "#e5e5e5" );
					$( this ).siblings( "#add-to-payments" ).css( "background", "#1896a2" );
					$( this ).siblings( "#add-to-payments" ).css( "color", "#fff" );					
					$( this ).siblings( "#add-to-payments" ).prop( "disabled", false);					
					$( this ).siblings( "#error" ).text( "" );
					
				} else {
				  $( this ).css("border"," solid 1px #FF0000");
				  $( this ).siblings( "#add-to-payments" ).css( "background", "#e5e5e5" );
				  $( this ).siblings( "#add-to-payments" ).css( "color", "#878484;" );	
				  $( this ).siblings( "#add-to-payments" ).prop( "disabled", true);				  
				  $( this ).siblings( "#error" ).text( "That doesn't look like a valid amount, Please try again in the format 10.00" );
				}
				
					
		});
		
		$( document ).on( "input", "input#my_payments_input", function() {
			var amount = $('#my_payments_input').val();
			var targetClass = $(this).attr('class');
			
			
				if($.isNumeric($(this).val())){
					$( this ).css( "border-color", "#e5e5e5" );
					$( this ).siblings( "#update-payment" ).css( "background", "#1896a2" );					
					$( this ).siblings( "#update-payment" ).css( "color", "#fff" );					
					$( this ).siblings( "#update-payment" ).prop( "disabled", false);					
					$( this ).siblings( "#error" ).text( "" );
					
				} else {
				  $( this ).css("border"," solid 1px #FF0000");
				  $( this ).siblings( "#update-payment" ).css( "background", "#f3fafa" );
				  $( this ).siblings( "#update-payment" ).css( "color", "#878484;" );	
				  $( this ).siblings( "#update-payment" ).prop( "disabled", true);				  
				  $( this ).siblings( "#error" ).text( "That doesn't look like a valid amount, Please try again in the format 10.00" );
				}
		});
		
	//set currency session
	$('#currency').on("change",function(e) {
		var currency_string = $(this).val();			
		//	document.forms['switchcurr'].submit();
		
		$.cookie('currency',currency_string);
		
			if (currency_string == "GBP") {
				$.cookie("currency_symbol","£");
				$(".symbol").val("£");
			} else if (currency_string == "USD") {
				$.cookie("currency_symbol","$");
				$(".symbol").val("$");
			} else if (currency_string == "EUR") {
				$.cookie("currency_symbol","€");
				$(".symbol").val("€");
			}
	//	location.reload(true);
		});
		

		
		$( document ).on( "click", "a.title", function() {
			
			var query = $(this).text();
			$('#livesearch').hide();
		//		if (search_string !==""){
				$.ajax({
					type: "POST",
					url: "campaign_insert.php",
					data: {query:query},
					cache: false,
					success: function(html) {
					$("#results").html(html);
					}
				});
		//	}return false;
			
		});
		
		//Add to My donations or payments with AJAX
		
			$( document ).on( "click", "input#add-to-payments", function() {
			
			var id= $( this ).siblings( "#fund_id" ).val();
			var title = $( this ).siblings( "#fund_title" ).val();
			var amount = $( this ).siblings( "#appeal-amount" ).val();
			var quantity = $( this ).siblings( "#fund_quantity" ).val();
		//	var attribute_name = $( this ).siblings( ".attribute" ).attr("name");
		//	var attribute_value = $( this ).siblings( ".attribute" ).val();
		
			var attributes = {};
			
			$( this ).siblings( ".attribute" ).each(function(e) {
			
						
				var	attribute_name = $(this).attr('name');
				var	attribute_value = $(this).val();
				
				// Having to do this because jQuery fucking sucks and doesn't return the checkboxes state as a bool in val() Clearly this is Obama's fault ;)
				
				if ($(this).attr('class') == "attribute checkbox") {
					var	attribute_value = $(this).is(':checked');
				}
				
				attributes[attribute_name] = attribute_value;
				
			});
			
			console.log(attributes);
			
	//		var attributes = {};
	//		attributes[attribute_name] = attribute_value;
			
						
			
			$('#my-payments').show();			
			$('#your-payments').show();
			$('.total-wrap').show();
			
			
				
			
		//		if (search_string !==""){
				$.ajax({
					type: "POST",
					url: "add_payment.php",
					data: {title:title, sum:amount, quantity:quantity, attribute:attributes},
					cache: false,
					success: function(html) {
					$("#my-payments").html(html);
					}
				});
				
				$.ajax({
					type: "POST",
					url: "get_total.php",					
					cache: false,
					success: function(html) {
					$("#total").html(html);
					}
				});
				
		//	}return false;
			
		});
		
		//Add to My donations or payments with AJAX
		
			$( document ).on( "keypress", "input#appeal-amount", function(e) {
			
			var id= $( this ).siblings( "#fund_id" ).val();
			var title = $( this ).siblings( "#fund_title" ).val();
			var amount = $( this ).val();
			var quantity = $( this ).siblings( "#fund_quantity" ).val();
			if (e.which == 13) {
			$('#my-payments').show();
				
			
		//		if (search_string !==""){
				$.ajax({
					type: "POST",
					url: "add_payment.php",
					data: {title:title, sum:amount, quantity:quantity},
					cache: false,
					success: function(html) {
					$("#my-payments").html(html);
					}
				});
				
		//	}return false;
			}
		});
		
	$( document ).on( "click", "a#clear-all", function(e) {
			
			$('#livesearch').hide();
			$('#search-input').val('');
			
		});
		
	
	
	//send search input to database
		/*
		$('#search-input').on("keyup", function(e) {
			var search_string = $(this).val();
			if (search_string !==""){
				$.ajax({
					type: "POST",
					url: "campaign_insert.php",
					data: {query:search_string},
					cache: false,
					success: function(html) {
					$("#results").html(html);
					}
				});
			}return false;			
		});
		*/
		
		$('#search-input').on("keyup", function(e) {
			$('#livesearch').show();
			$('#livesearch').css('border','solid 1px #ccc');
		
			var search_string = $(this).val();
		//	if (search_string !==""){
				$.ajax({
					type: "POST",
					url: "livesearch.php",
					data: {query:search_string},
					cache: false,
					success: function(html) {
					$("#livesearch").html(html);
					}
				});
		//	}return false;			
		});
		
		$('#search-input').focus(function() {
			$('#search-input').val("");
		});
		
	//send wildcard to database to display all results
	
		$('#show-all').on("click", function(e) {
			var search_string = "*";
			
			$.ajax({
				type: "POST",
				url: "campaign_insert.php",
				data: {query:search_string},
				cache: false,
				success: function(html) {
				$("#results").html(html);
				}
			});					
		});
		
		$('#hide-link').on("click", function(e) {
			var search_string = "";
			
			$.ajax({
				type: "POST",
				url: "campaign_insert.php",
				data: {query:search_string},
				cache: false,
				success: function(html) {
				$("#results").html(html);
				}
			});					
		});
		
	
		
		$('#show-all').click(function() {
			$('#show-all').hide();
			$('#hide-link').show();			
		});
		
		$('#hide-link').click(function() {
			$('#hide-link').hide();
			$('#show-all').show();
		});
		
		
		$(document).ready(function() {
		
		var form_exists = $(".add-form").length;
		alert 
		if (form_exists == 0) {
			$('#my-payments').hide();
			$('#your-payments').hide();
			$('.total-wrap').hide();
		}
		
		$.ajax({
					type: "POST",
					url: "get_total.php",					
					cache: false,
					success: function(html) {
					$("#total").html(html);
					}
				});

		});
		
		
		
	
		
	
		
		
    </script>
   </body>
</html>