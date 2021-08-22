<?php  include($_SERVER['DOCUMENT_ROOT']."/core/init.php"); ?>
<?php

$db = new Database;

if (isset($_POST['country_id'])) {
  // Fetch state data based on the specific country
    $db->query("SELECT * FROM states WHERE country_id = :countryID ORDER BY name;");
    $db->bind(':countryID', $_POST['country_id']);
    $result = $db->resultset();


  // Generate HTML of state options list
      echo '<option value="">Select State</option>';
      foreach ($result as $key => $value) {
        echo '<option value="'.$value['name'].'">'.$value['name'].'</option>';
      }
}

if (isset($_POST['search'])) {
    echo "Hello World!";
}

// Handle Plans
if (isset($_POST['test'])) {
  // Decode Full URL and get the id
  $product = explode("?id=", $_POST['product']);

  // Get Currencies
  $db->query("SELECT * FROM currencies WHERE id = :id;");
  $db->bind(':id', $_POST['test']);
  $currency = $db->single();

  // Set Session
  $_SESSION['currency'] = $currency['name'];
  $_SESSION['symbol'] = $currency['symbol'];

  // Get Plans
    $db->query("SELECT * FROM plans WHERE product=:product AND currency=:currency;");
    $db->bind(':product', $product[1]);
    $db->bind(':currency', $currency['name']);
    $result = $db->resultset();

    foreach ($result as $key => $value) {
      echo '<option value="'.$value['id'].'">'.$value['nickname'].'</option>';
    }

}
