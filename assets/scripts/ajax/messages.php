<?php  include("../../../core/init.php"); ?>
<?php
$bbcode = new BBCode();

// $rendered = $bbcode->render('[b]Hello world![/b]');

// echo $rendered;
$customer = new \Pushfully\Customer;
$ticket = new \Pushfully\Ticket;
$messages = new \Pushfully\Message;
$author =  $_POST['author'];
$message = $_POST['message'];

if ($message != null) {
  $messages->create([
    'parent_id' => $_POST['id'],
    'author' => $author,
    'created' => time(),
    'message' => $message,
  ]);
}
?>

<?php foreach ($messages->all(['parent_id' => $_POST['id']]) as $key => $value): ?>
  <li class="list-group-item">
    <p>
      <i class="fas fa-user float-left" style="font-size:18px;"></i>
      <a class="pl-2" href=""><?php echo $customer->retrieve($value['author'])['username'] ?></a>
      <span class="badge badge-secondary"><?php echo $customer->retrieve($value['author'])['admin'] == 1 ? "admin" : "client" ?></span>
      <span class="badge badge-dark"><?php echo formatDate($value['created']) ?></span>
    </p>

      <p><?php echo $bbcode->render($value['message']); ?></p>
  </li>
<?php endforeach; ?>
<li class="list-group-item">
  <textarea class="form-control" name="message" rows="8" cols="80"></textarea>
  <input id="test" type="submit" class="btn-primary" name="submit" value="test">
  <input id="test" type="submit" class="btn-secondary" name="submit" value="test">
  <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
</li>
