
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>World Federation of KSIMC Payment System</title>
	<link href="https://demo.world-federation.org/payment_sys/style.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://demo.world-federation.org/payment_sys/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
<div class="col-md-1" style="padding-left: 0px; padding-right: 0px;"><div id="icon-pad"><img src="https://www.world-federation.org/wf_images/home.png">&nbsp;&nbsp;<img src="https://www.world-federation.org/wf_images/basket.png">&nbsp;&nbsp;<img src="https://www.world-federation.org/wf_images/user.png"></div></div>
<div class="col-md-2" style="padding-left: 30px;"><div id="search-pad"><form action="#" method="POST"><input type="text"></div></form></div>
<div class="col-md-2" style="padding-left: 30px;"><img src="https://www.world-federation.org/wf_images/top.png" style="position:relative; bottom: 20px;"></div>
<br>  

	</div>
	<div class="row" id="logo-strip" style="margin-left:10%">
		<img src="images/logi.png">
	</div>
</div>
<div class="container-fluid" id="main-body">
	<div class="row">
		<div class="col-md-3" style="height: 100%;"><br /></div>
		<div class="col-md-6">
			<div id="centerfold" style="margin-bottom:10%; padding: 20px; width: 85%; margin-top:10%; margin-left:auto; margin-right:auto; border:2px solid #93b0d7; -webkit-border-radius: 3px; 
-moz-border-radius: 3px; border-radius: 3px;">
				<br>
				<?php if ($_GET['valid'] == "true") {
						echo "<img src='https://demo.world-federation.org/payment_sys/images/tick.png' style='margin-left:35%;'><br>
						<h3 style='text-align: center; color:#0053a0;'><strong>Thank you, your payment was<br> successful</strong></h3>
						<p style='text-align: center;'>Authorisation Code ".$_GET['auth_code']."</p>";		
					}
				?>	
			</div>
		</div>
</div>

<div class="col-md-3" style="height: 100%;"><br /></div>
</div>

   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
	</body>
</html>
