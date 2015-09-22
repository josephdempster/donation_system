<?php

class functions {
	protected $db;
	protected $funds;
	protected $attributes;
	public $total_sum;
	public $currency;
	
	public function __construct() {
		//Connect to MySQL
		try {
			$this->db = new PDO('mysql:host=localhost;dbname=donation_system;charset=utf8;', 'josephd', 'purplepills');
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		} catch(PDOException $ex) {
			echo "Unable to connect to MySQL";
		}
	}
	
	public function searchTitle() {
	
	/*
	* Executes a LIKE query based on AJAX populated search string and output title only
	*/
	
		//get posted data from AJAX
		@$title = $_POST['query'];	
		
		//Prepare an SQL statement
		if (!empty($title)) {
			$sql = "SELECT * FROM funds WHERE title LIKE ? LIMIT 3";
			$query = $this->db->prepare($sql);
			$query->execute(array('%'.$title.'%'));
			$this->funds = $query->fetchAll();
			
			foreach ($this->funds as $funds) {
				echo "<li><a href='#' class='title' id='".$funds['title']."'>".$funds['title']."</a></li>";
			}
			echo "<li><strong><a href='#' id='clear-all'>Clear All</a></strong></li>";
		}
		
	}
	
	
	public function searchFunds() {
	
	/*
	* Executes a LIKE query based on AJAX populated search string and make fields available to other functions
	*/
	
		//get posted data from AJAX
		@$title = $_POST['query'];	
		
		//Prepare an SQL statement
		if (!empty($title)) {
			$sql = "SELECT * FROM funds WHERE title LIKE ?";
			$query = $this->db->prepare($sql);
			$query->execute(array('%'.$title.'%'));
			$this->funds = $query->fetchAll();
		}
	}
	
	function getAllFunds() {
		
		/*
		* Process wildcard
		*/
		
		
		//get posted data from AJAX
		@$title = $_POST['query'];	
		
		//Prepare an SQL statement
		if ($title == "*") {
			$sql = "SELECT * FROM funds";
			$query = $this->db->prepare($sql);
			$query->execute(array());
			$this->funds = $query->fetchAll();
		}	

	}

	public function formatOutput() {
		
	/*
	*
	*  Format output for writing campaigns to screen
	*
	*/
		
		foreach ($this->funds as $funds) {
			//Echo out fund title
		//	echo "<form action='#' method='post' class='".$funds['fund_id']."' id='funds'>";
			echo "<div id='appeal-box'>";
			echo "<input type='hidden' name='id' id='fund_id' value='".$funds['fund_id']."'>";
			echo "<input type='hidden' name='title' id='fund_title' value='".$funds['title']."'>";
			echo "<h3><strong>".$funds['title']."</strong></h3>";
			
			//Echo out description
			echo "".$funds['description']."<br><br>";
			
			//Is sum variable? If so display a text box. 
			if ($funds['sum'] == "variable") {
				echo "<label for='appeal-amount'>Payment</label><br><span id='symbol' style='position:relative; left: 4%; top: 38px;'>".$_COOKIE['currency_symbol']."</span><input type='text' name='sum' value='0.00' id='appeal-amount' class=".$funds['fund_id']."><br><br>"; 
				echo "<span id='error' class=".$funds['fund_id']."></span><br><br>";
			} else {
			//otherwise show as a hidden field
				echo "<input type='hidden' name='sum' value='".$funds['sum']."' id='appeal-amount'>"; 
			}
			
			//Can donor pick quantity? If so display a text box
			if ($funds['quantity'] != "0") {
				echo "<br><input type='text' name='qty' value='1' id='fund_quantity'><br><br>"; 
			} else {
			//otherwise show as a hidden field
				echo "<input type='hidden' name='quantity' value='1' class=".$funds['fund_id']." id='fund_quantity'>"; 
			}

			// Now here comes the tricky bit, we need to get the attributes, first lets ignore any funds that don't have attributes
		
			if ($funds['has_attributes'] == '1') {
				//Now lets select attributes where the Foreign key field in the Attributes table matches the fund_id from funds
				$sql = "SELECT * FROM attributes WHERE fund_id = ?";
				$query = $this->db->prepare($sql);
				$query->execute(array($funds['fund_id']));
				$this->attributes = $query->fetchAll();	
				
				//time to get loopy
			
				foreach ($this->attributes as $attributes) {
					//this is where it gets even more convoluted, some attributes are multi-choice so we need to get the options
						if($attributes['has_options'] == '1') {
							$sql = "SELECT * FROM options WHERE parent_id = ?";
							$query = $this->db->prepare($sql);
							$query->execute(array($attributes['attribute_id']));
							$this->options = $query->fetchAll();							
						}				
						
						
				
				
					switch($attributes['type']) {
						case "textfield":
							echo "<label>".$attributes['title']."</label>&nbsp;<input type='text' name='attribute[]' id='textfield'><br><br>";
						break;
						case "checkbox":
							echo "<label>".$attributes['title']."</label>&nbsp;<input type='checkbox' value=".$funds['name']." name='".$attributes['machine_name']."[]'><br><br>";
						break;
						case "select options":
							echo "<label>".$attributes['title']."</label>&nbsp;<select name='".$attributes['machine_name']."[]'>";
							foreach($this->options as $options) {
								if($options['parent_id'] == $attributes['attribute_id']) {
									echo "<option>".$options['title']."</option>";
								}
							}
							echo "</select><br /><br />";
						break;
						}
							
					}
				}
			echo "<input type='submit' id='add-to-payments' class=".$funds['fund_id']." disabled='true'  value='Add to your payments'><br><br>";
			echo "</form></div><br>";
			
		}		
	}
	
	public function addPayment() {
	
	/*
	*
	*  Add Payment to database and format output
	*
	*/
		if (session_id() == '') {
			session_start();
		}
		if (!empty($_POST['title'])){
		$session = session_id();
		
				
		//set payment details		
		$title = $_POST['title'];
		$sum = $_POST['sum'];
		$qty = $_POST['quantity'];
		$attrib = serialize($_POST['attribute']);
		
		
		$sql = "INSERT INTO cart (payment, sum, quantity, attributes, session) VALUES (?,?,?,?,?)";
		$query = $this->db->prepare($sql);
		$query->execute(array($title, $sum, $qty, $attrib, $session));
				
		}
		
		//fetch 
		$sql = "SELECT * FROM cart WHERE session = ?";
		$query = $this->db->prepare($sql);
		$query->execute(array(session_id()));
		$this->cart = $query->fetchAll();	
		
	
		// $this->total_sum = array_sum($this->cart['sum']);
		
		
		foreach ($this->cart as $cart) {
			echo "<form action='index.php' method='POST'>";
			echo "<input type='hidden' name='cart_id' value=".$cart['cart_id'].">";
			echo "<input type='hidden' name='session' value=".$cart['session'].">";
			echo "<div class='row'><div class='col-md-9'><h3>".$cart['payment']."</h3></div>";
			echo "<div class='col-md-3'><input type='submit' name='delete' value='X' id='remove-payment' style='height:30px; width: 65%; margin-top: 15px;'></div></div><br>";
			echo "<div class='row'><span id='error' class=''></span><br><label for='my_payments_input'>Payment</label><span id='symbol' style='position:relative; right: 10%; top: 41px; z-index: 9999;'>".$_COOKIE['currency_symbol']."</span><br><input type='text' name='update_sum' id='my_payments_input' class='col-md-7' value=".$cart['sum'].">";			
			echo "<input type='submit' class='col-md-3' name = 'update' value='Update' id='update-payment'></div><br>";
			echo "</form>";
			$this->total_sum = $this->total_sum + $cart['sum'];
			
		}
	}
	
	public function getTotal() {
	
	/*
	*
	*  container function to retrieve and return total so that it can be accessed by AJAX
	*
	*/
	
		echo $this->total_sum;
		
	}
		
	function updatePayment() {
	/*
	*
	*  Update Payment in database
	*
	*/
		if (!empty($_POST['update'])) {
			$sql = "UPDATE cart SET sum = ? WHERE cart_id = ? AND session = ?";
			$query = $this->db->prepare($sql);
			$query->execute(array($_POST['update_sum'], $_POST['cart_id'], $_POST['session']));	
			header("location:index.php");
		} 
		
		
	}
	
	function deletePayment() {
	/*
	*
	*  Remove payment from database
	*
	*/
		if (!empty($_POST['delete'])) {
			$sql = "DELETE FROM cart WHERE cart_id = ?";
			$query = $this->db->prepare($sql);
			$query->execute(array($_POST['cart_id']));
			header("location:index.php");
		} 
		
		
	}
	
	function setCurrency() {
	
	//this code is redundant due to currency cookie being set in jquery. 
		
	//	if(!empty($_POST['currency'])) {
			
	//	setcookie('currency',$_POST['currency'], time() + (86400 * 30), "/");

	/*		if($_POST['currency'] == "GBP") {
				setcookie('currency_symbol',"£", time() + (86400 * 30), "/");
				header("location:index.php");
			} else if ($_POST['currency'] == "USD") {
				setcookie('currency_symbol',"$", time() + (86400 * 30), "/");
				header("location:index.php");
			} else if ($_POST['currency'] == "EUR") {
				setcookie('currency_symbol',"€", time() + (86400 * 30), "/");
				header("location:index.php");
			}
			
		if(!isset($_POST['currency'])) {		
		
		setcookie('currency',"GBP", time() + (86400 * 30), "/");
		setcookie('currency_symbol',"£", time() + (86400 * 30), "/");
		
		}
		
		if(isset($_POST['currency'])) {
			header("location:index.php");
		}
		*/
	//	header("location:index.php");
	}
	
	
	function formatPaypoint() {
	
	/*
	*
	*  Takes database and session values and commits to a form that can be submitted to paypoint for processing
	*
	*/
	
		$sql = "SELECT session FROM cart WHERE session = ? LIMIT 1";
		$query = $this->db->prepare($sql);
		$query->execute(array($_POST['cart_id']));
		$this->cart = $query->fetchAll();
		
		foreach($this->cart as $cart) {
			$session = $cart['session'];
		}
					
		if (!empty($session)) {
			$merchant = "worldf01";
			$trans_id = md5(mktime());
			$trans_id = substr($trans_id,0,10);		
			
			//echo $trans_id;
			
		$sql = "SELECT * FROM cart WHERE session = ?";
		$query = $this->db->prepare($sql);
		$query->execute(array($_POST['cart_id']));
		$this->cart = $query->fetchAll();	
		
		foreach ($this->cart as $cart) {			
			$this->total_sum = $this->total_sum + $cart['sum'];			
		}
		
						
		$digest = md5($trans_id.$this->total_sum.'worldfp4ym3nts');
		// echo($digest);
		echo "<form action='https://www.secpay.com/java-bin/ValCard' id='submit_paypoint' method='POST'>";
		echo "<input type='hidden' name='merchant' value='".$merchant."'>";
		echo "<input type='hidden' name='trans_id' value='".$trans_id."'>";
		echo "<input type='hidden' name='amount' value='".$this->total_sum."'>";
		echo "<input type='hidden' name='currency' value='".$_POST['currency']."'>";
		echo "<input type='hidden' name='callback' value='https://demo.world-federation.org/payment_sys/callback.php'>";	
		// echo "<input type='hidden' name='digest' value='".$digest."'>";
		echo "<input type='hidden' name='test_status' value='true'>";
		echo "
		<input type=\"hidden\" name=\"order\" value=\"
		<order class='com.secpay.seccard.Order'>
			<orderLines class='com.secpay.seccard.OrderLine'>
				<orderLine>";
				foreach ($this->cart as $cart) {
					$attrib = unserialize($cart['attributes']);
					echo "<prod_code>".$cart['payment']."-</prod_code>";
					echo "<item_amount>".$cart['sum']."</item_amount>";
					echo "<item_amount>".$cart['quantity']."</item_amount>";
					
				}			
								
				echo "</orderLine>
			</orderLines>
		</order>
		\">";		
		echo "<input type='hidden' name='mail_merchants' value='josephd@world-federation.org'>";
		echo "<input type='hidden' name='mail_html' value='full'>";
		
		echo "<input type='hidden' name='template' value='http://www.secpay.com/users/worldf01/paypoint_temp.html'>"; 

		echo "<input type='submit' value='Pay With Paypoint'>";
		echo "</form>";
		} else {
		echo "Error: No valid session detected, Please go back to the <a href='index.php'>homepage</a> and try to make your payment again. We apologise for any inconvenience.";
		}
		
	}
}	



?>