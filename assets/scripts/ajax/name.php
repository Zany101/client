<?php  include($_SERVER['DOCUMENT_ROOT']."/core/init.php"); ?>
<?php

$db = new Database;

if (!empty($_POST['username'])) {
  // Fetch username
    $db->query("SELECT * FROM users WHERE username = :username;");
    $db->bind(':username', $_POST['username']);
    $result = $db->single();


  // Generate HTML of state options list
    if ($db->rowCount() >= 1) {
      echo '<div class="alert alert-danger" role="alert">User Already In Use</div>';
    }
}

if (!empty($_POST['email'])) {
  // Fetch Email
    $db->query("SELECT * FROM users WHERE email = :email;");
    $db->bind(':email', $_POST['email']);
    $result = $db->single();

  // Generate HTML of state options list
    if ($db->rowCount() >= 1) {
        echo '<div class="alert alert-danger" role="alert">Email Already In Use</div>';
    }
}


if (!empty($_POST['email'])) {
  // Fetch Email
    $db->query("SELECT * FROM users WHERE email = :email;");
    $db->bind(':email', $_POST['email']);
    $result = $db->single();

  // Generate HTML of state options list
    if ($db->rowCount() >= 1) {
        echo '<div class="alert alert-danger" role="alert">Email Already In Use</div>';
    }
}
