<?php
    // Afisarea celor mai recente 4 produse
    $stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT 4');
    $stmt->execute();
    $recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?=template_header('Home')?>
    <div class="featured">
        <h2>Gadgets/Accessories</h2>
        <p>Gadgets That Will Make Your Everyday Life Easier</p>
    </div>
    <div class="content-wrapper">
        <h2>RECENTLY ADDED PRODUCTS</h2>
    </div>
    <div class="product content-wrapper">
        <?php foreach ($recently_added_products as $product): ?>
            <a href="index.php?page=product&id=<?php echo $product['id']?>" class="product">
                <img src="imgs/<?php echo $product['img']?>" width="200" height="200"  alt="<?php echo
                $product['name']?>">
                <span class="name"><?php echo $product['name']?></span>
                <span class="price">
 &dollar;<?php echo $product['price']?>
                    <?php if ($product['rrp'] > 0): ?>
                        <span class="rrp">&dollar;<?php echo $product['rrp']?></span>
                    <?php endif; ?>
 </span>
            </a>
        <?php endforeach; ?>
    </div>
<?=template_footer()?>
