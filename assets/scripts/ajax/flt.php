

<?php foreach ($tickets as $key => $ticket): ?>
<tr class="clickable-row" data-href="/client/tickets/item.php?id=<?php echo $ticket['id'] ?>">
  <td><?php echo $ticket['subject'] ?></td>
  <td><?php echo formatDate($ticket['created']) ?></td>
  <td></td>
  <td><?php echo $ticket['status'] ?></td>
</tr>
<?php endforeach; ?>
