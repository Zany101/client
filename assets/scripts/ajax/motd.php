<?php  include("../../../core/init.php"); ?>
<?php
$motd = new \pushfully\Motd;
$motd->update(
  $_POST['id'],
  [
  'html' => $_POST['html'],
  'css'  => $_POST['css']
])
?>

<iframe class="mx-auto" src="http://localhost/test.php?id=4"width="100%" height="1024px"></iframe>
