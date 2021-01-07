<?php
// Dacă utilizatorul a dat clic pe butonul Adăugare la coș de pe pagina produsului, putem verifica datele formularului

if(empty($_SESSION['name'])) {
  header('Location: index.php?page=login');
} else {
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {

    // Setați variabilele de postare astfel încât să le identificăm cu ușurință, de asemenea, asigurați-vă că sunt întregi
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Pregătiți instrucțiunea SQL, practic verificăm dacă produsul există în baza noastră de date
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_POST['product_id']]);
   
    // Aduceți produsul din baza de date și returnează rezultatul ca matrice
     $product = $stmt->fetch(PDO::FETCH_ASSOC);
 
     // Se verifica daca produsul exista (array nu este gol)
 if ($product && $quantity > 0) {
     // Produsul există în baza de date, acum putem crea / actualiza variabila de sesiune pentru coș
     if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
         if (array_key_exists($product_id, $_SESSION['cart'])) {
             // Produsul există în coș, așa că trebuie doar să actualizați cantitatea
             $_SESSION['cart'][$product_id] += $quantity;
        } else {
             // Produsul nu este în coș, așa că adăugați-l
             $_SESSION['cart'][$product_id] = $quantity;
        }
    } else {
         // se adauga primul produs in cosul gol
         $_SESSION['cart'] = array($product_id => $quantity);
    }
} //stop retrimiterea

header('location: index.php?page=cart');
exit;
}
}

// Eliminați produsul din coș, verificați dacă URL-ul param „elimină”, acesta este codul produsului, asigurați-vă că este un număr și verificați dacă este în coș
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {

    // Stergere produs din cos
    unset($_SESSION['cart'][$_GET['remove']]);
}


// Actualizați cantitățile de produse în coș dacă utilizatorul face clic pe butonul „Actualizare” de pe pagina coșului de cumpărături
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Buclă prin datele de postare, astfel încât să putem actualiza cantitățile pentru fiecare produs din coș
 foreach ($_POST as $k => $v) {
     if (strpos($k, 'quantity') !== false && is_numeric($v)) {
         $id = str_replace('quantity-', '', $k);
         $quantity = (int)$v;
         // Verifica si validam
         if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
             // Udate cantitate nou
             $_SESSION['cart'][$id] = $quantity;
         }
     }
 }
 
 // stop retrimitere...
 header('location: index.php?page=cart');
 exit;
}
//Trimiteți utilizatorul la pagina comenzii de plasare dacă face clic pe butonul Plasați comanda, de asemenea coșul nu trebuie să fie gol
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=placeorder');
    exit;
}
// Verificați variabila sesiunii pentru produsele din coș
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// Daca exista produse in cos
if ($products_in_cart) {
    // Există produse în coș, așa că trebuie să selectăm acele produse din baza de date
    // Products in cos sunt de tip array deci SQL statement IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks . ')');
    //Avem nevoie doar de cheile matrice, nu de valori, cheile sunt id-urile produselor
    $stmt->execute(array_keys($products_in_cart));
    // Preluează produsele din baza de date și returnează rezultatul ca matrice
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculeaza un subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    }
}
?>
<?=template_header('Cart')?>
    <div class="cart content-wrapper">
        <h1>Shopping Cart</h1>
        <form action="index.php?page=cart" method="post">
            <table>
                <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Pricet</td>
                    <td>Quantity</td>
                    <td>Total</td>
                    <td>Remove</td>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">You have added your product to cart</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="img">
                                <a href="index.php?page=product&id=<?=$product['id']?>">
                                    <img src="imgs/<?=$product['img']?>" width="50" height="50"
                                         alt="<?=$product['name']?>">
                                </a>
                            </td>
                            <td>
                                <a href="index.php?page=product&id=<?=$product['id']?>"><?=$product['name']?></a>
                                <br>

                            </td>
                            <td class="price">&dollar;<?=$product['price']?></td>
                            <td class="quantity">
                                <input type="number" name="quantity-<?=$product['id']?>"
                                       value="<?=$products_in_cart[$product['id']]?>" min="1" max="<?=$product['quantity']?>"
                                       placeholder="Quantity" required>
                            </td>
                            <td class="price">&dollar;<?=$product['price'] * $products_in_cart[$product['id']]?></td>
                            <td> <a href="index.php?page=cart&remove=<?=$product['id']?>"
                                    class="remove">Remove</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
            <div class="subtotal">
                <span class="text">Subtotal</span>
                <span class="price">&dollar;<?=$subtotal?></span>
            </div>
            <div class="buttons">
                <input type="submit" value="Update" name="update">
                <input type="submit" value="Place Order" name="placeorder">
            </div>
        </form>
    </div>
<?=template_footer()?>
