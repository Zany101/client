<?php  include("../../../core/init.php"); ?>
<?php
// Stripe
// Key



// Use plans amount to show off price
// Handle price
$plan =\Stripe\Plan::retrieve($_POST['item']);
$currency = $plan['currency'];
$price = $plan['amount'];
$discount = '10';
$qty = $_POST['quantity'];

if ($_POST['plan'] > 1) {
  $price = $plan['amount'] * $_POST['plan'] * ((100-$discount) / 100);
}


$result = money_format($currency, $price,$qty);
echo $result;
