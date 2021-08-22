<?php  include("../../../core/init.php"); ?>
<?php
$datacenter = new \Pushfully\Datacenter;
$datacenters = $datacenter->all();
$product = new \Pushfully\Product;
$product = $product->retrieve($_POST['product_id']);



?>
<div class="row">
  <div class="col-lg-12">
    <fieldset>
      <legend>Product Name</legend>
      <input type="text" class="form-control" name="name" value="<?php echo $product['name'] ?> ">
    </fieldset>
  </div>
  <div class="col-lg-3">
    <fieldset class="form-group">
      <legend>Datacenter</legend>
      <?php foreach ($datacenters as $key => $value): ?>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
          <label class="form-check-label" for="defaultCheck1"><?php echo $value['country'] ." / ". $value['ip'] ?></label>
        </div>
      <?php endforeach; ?>
    </fieldset>
  </div>
  <div class="col-lg-3">
    <fieldset class="form-group">
      <legend>Plan</legend>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
        <label class="form-check-label" for="defaultCheck1">Month</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" >
        <label class="form-check-label" for="defaultCheck2">3 Months</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
        <label class="form-check-label" for="defaultCheck1">Half Year</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" >
        <label class="form-check-label" for="defaultCheck2">Year</label>
      </div>
    </fieldset>
  </div>
  <div class="col-3">
    <fieldset class="form-group">
      <legend>Price</legend>
      <label class="form-check-label" for="defaultCheck1">Amount</label>
      <input class="form-control" type="number" name="amount" value="<?php echo $product['amount'] ?>" id="defaultCheck1">
    </fieldset>
  </div>
  <div class="col-3">
    <fieldset class="form-group">
      <legend>Slots:</legend>
      <label class="form-check-label" for="defaultCheck1">Min</label>
      <input class="form-control" type="number" name="min" value="<?php echo $product['min_slots'] ?>" id="defaultCheck1">
      <label class="form-check-label" for="defaultCheck1">Max</label>
      <input class="form-control" type="number" name="max" value="<?php echo $product['max_slots'] ?>" id="defaultCheck1">
    </fieldset>
  </div>
</div>
