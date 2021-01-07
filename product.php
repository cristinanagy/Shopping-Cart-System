<?php
// Verificați pentru a vă asigura că parametrul id este specificat în adresa URL
if (isset($_GET['id'])) {
    // Pregătiți instrucțiunea și executați, previne injecția SQL
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Selectare produs din bd si returnare array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Verific daca produsul exista (array nu este gol)
    if (!$product) {
        // ID-ul produsului nu există (matricea este goală)
        exit('Produs nu exista!');
    }
} else {
    // ID-ul produsului nu este specificat
    exit('Product nu exista!');
}
?>

 <!-- Creating Product Template -->
 
<?php echo template_header('Product')?>
    <div class="product content-wrapper">
        <img src="imgs/<?php echo $product['img']?>" width="500" height="500" alt="<?php echo
        $product['name']?>">
        <div>
            <h1 class="name"><?php echo $product['name']?></h1>
            <span class="price">
 &dollar;<?php echo $product['price']?>
                <?php if ($product['rrp'] > 0): ?>
                    <span class="rrp">&dollar;<?=$product['rrp']?></span>
                <?php endif; ?>
 </span>
            <form action="index.php?page=cart" method="post">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo
                $product['quantity']?>" placeholder="Quantity" is must>
                <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                <input type="submit" value="Add to cart">
            </form>
            <div class="description">
                <?php echo $product['desc']?>
            </div>
        </div>
    </div>
<?=template_footer()?>
