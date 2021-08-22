<?php  include("../../../core/init.php"); ?>
<?php
$product = new \Pushfully\Product;
$product = $product->retrieve($_POST['item']);

$price = $product['amount'];
$discount = '10';
$qty = $_POST['quantity'];

if ($_POST['plan'] > 1) {
  $price = $product['amount'] * $_POST['plan'] * ((100-$discount) / 100);
}



?>

<p class="mb-0"><?php echo "Slots  ".$_POST['quantity']; ?></p>
<p class="text-theme-color"><?php echo money_formater($_SESSION['currency'], $price, $qty); ?></p>
