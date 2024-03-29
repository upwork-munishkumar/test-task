<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title;?></title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	table, th, td {
		border: 1px solid black;
	}
	</style>
</head>
<body>

<div id="container">

	<h1>Tasks List</h1>

	<div id="body">
		<p>3.1. Count of all active and verified users.</p>
		<code><b>Active And Verified User Count: </b><?=$acitve_user_count;?></code>

		<p>3.2. Count of active and verified users who have attached active products.</p>
		<code><b>Active And Verified User Attached Product Count: </b><?=$acitve_user_products_count;?></code>

		<p>3.3. Count of all active products (just from products table).</p>
		<code><b>Active Products Count: </b><?=$acitve_products_count;?></code>

		<p>3.4. Count of active products which don't belong to any user.</p>
		<code><b>Products Count which are active but not attached to any user: </b><?=$acitve_products_but_not_attached_count;?></code>

		<p>3.5. Amount of all active attached products (if user1 has 3 prod1 and 2 prod2 which are active, user2 has 7 prod2 and 4 prod3, prod3 is inactive, then the amount of active attached products will be 3 + 2 + 7 = 12).</p>
		<code><b>Active and Attached Products Qunatity: </b><?=$acitve_and_attached_products_quantity;?></code>

		<p>3.6. Summarized price of all active attached products (from the previous subpoint if prod1 price is 100$, prod2 price is 120$, prod3 price is 200$, the summarized price will be 3 x 100 + 9 x 120 = 1380).</p>
		<code><b>Active and Attached Products Price Sum: </b>€<?=$acitve_and_attached_products_price_sum;?></code>

		<p>3.7. Summarized prices of all active products per user. For example - John Summer - 85$, Lennon Green - 107$.</p>
		<code>
			<b>Active and Attached Products Price Sum By User: </b>
			<table>
				<thead>
					<th>Id</th>
					<th>Name</th>
					<th>Total Products Price</th>
				</thead>
				<?php
					if ($acitve_and_attached_products_price_sum_by_user) {
						echo "<tbody>";
						foreach ($acitve_and_attached_products_price_sum_by_user as $userData) {
							echo "<tr><td>".$userData['id']."</td>";
							echo "<td>".$userData['name']."</td>";
							echo "<td> €".$userData['current_user_active_attached_products_price_sum']."</td></tr>";
						}
						echo "</tbody>";
					}
				?>
			</table>
		</code>

		<p>3.8. The exchange rates for USD and RON based on Euro using https://exchangeratesapi.io/ . This is a separated subpoint and isn't related to the previous subpoints.</p>
		<code>
			<b>Exchange Rate from EURO TO USD and RON </b>
			<table>
				<thead>
					<th>Id</th>
					<th>Name</th>
					<th>Total Products Price</th>
					<th>Currency Converter</th>
				</thead>
				<?php
					if ($acitve_and_attached_products_price_sum_by_user) {
						echo "<tbody>";
						foreach ($acitve_and_attached_products_price_sum_by_user as $userData) {
							echo "<tr><td>".$userData['id']."</td>";
							echo "<td>".$userData['name']."</td>";
							echo "<td class='pp_sum'> €".$userData['current_user_active_attached_products_price_sum']."</td>";
							echo "<td>
								<select name='get_currency_rates' class='get_currency_rates'>
									<option selected disabled>Select Currency</option>
									<option value='USD' data-price='".$userData['current_user_active_attached_products_price_sum']."'>USD</option>
									<option value='RON' data-price='".$userData['current_user_active_attached_products_price_sum']."'>RON</option>
								</select> 
							</td></tr>";
						}
						echo "</tbody>";
					}
				?>
			</table>
		</code>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$(".get_currency_rates").on("change", function(){
			var $this 				= $(this);
			var old_text			= $this.parent().parent().find('.pp_sum').text();
			var selected_currency 	= $this.val();
			var current_price 		= $this.find(':selected').data('price');
			$.ajax({
		        type: 'POST',
		        url: "<?php echo base_url('change-currency'); ?>",
		        data: {
		            'selected_currency': selected_currency,
		        	'current_price'	   : current_price
		        },
		        dataType: "JSON",
		        success: function (data) {
		        	if (data.status == 'error') {
		        		alert("There is some error, please try after some time!");
		        		return false;
		        	}
		        	$this.parent().parent().find('.pp_sum').text("€" + current_price + " - " + data.converted_price)
		        }
		    });
		})
	})
</script>
</body>
</html>
