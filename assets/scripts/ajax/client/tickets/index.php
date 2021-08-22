<?php  include($_SERVER['DOCUMENT_ROOT']."/core/init.php"); ?>
<?php
// Objects
$customer = new \Pushfully\Customer;
$ticket = new \Pushfully\Ticket;
$messages = new \Pushfully\Message;

// Validate

// Function



// Assign Values To template Object

//
// // Invoices
$tickets = $ticket->all(['author' => $_SESSION['customer']['id'], 'status' => $_POST['flt']]);
?>

<?php foreach ($tickets as $key => $ticket): ?>
<tr class="clickable-row" data-href="/client/tickets/item.php?id=<?php echo $ticket['id'] ?>">
  <td><?php echo $ticket['subject'] ?></td>
  <td><?php echo formatDate($ticket['created']) ?></td>
  <td></td>
  <td><?php echo $ticket['status'] ?></td>
</tr>
<?php endforeach; ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
  $(".clickable-row").click(function() {
      window.location = $(this).data("href");
  });
});
</script>
