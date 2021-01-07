<?php
if(empty($_SESSION['name'])) {
  header('Location: index.php?page=login');
  exit;
  } else {
    // goleste obiecte din cos
    unset($_SESSION['cart']); }
?>
<?=template_header('Order')?>
    <div class="content-wrapper">
        <h1 style="text-align:center;">Order Completed Successfully! </h1>
        <h2 style="text-align:center;"> Thank you for ordering. We received your order and will begin processing it soon.</h2>
    </div>
    <div class="content-wrapper">
        <p>Back to <a href="index.php?page=products">Products</a></p>
<?=template_footer()?>
