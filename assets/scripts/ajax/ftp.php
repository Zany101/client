<?php  include("../../../../../core/init.php"); ?>
<?php
  // Base;

  @$_SESSION['folder'] = $_POST['folder']."\\";
  $path = $base.@$_SESSION['folder'];
  $return = array();

  // Sort Array
  $return[0] = [
    0 => "<tr>",
    1 => "<td colspan=\"5\">".$base.@$_SESSION['folder']."</td>",
    2 => "</tr>",
  ];


  foreach (scandirSorted($path) as $key => $value) {
    // Rebuild Array with required information
    array_push(
      $return,
    [
      0 => "<tr class=\"folder\" data-href=\"{$value}\">",
      1 => "<td><input type=\"checkbox\" name=\"\" value=\"\"></td>",
      2 => "<td class=\"w-25\">{$value}</td>",
      3 => "<td class=\"text-center\">".stat($path.$value)['uid']."</td>",
      4 => "<td class=\"text-center\">".filetype($path.$value)."</td>",
      5 => "<td class=\"text-center\">".formatBytes(stat($path.$value)['size'])."</td>",
      6 => "</tr>",
    ]);
  }
  echo json_encode($return);
