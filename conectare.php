<?php
    function pdo_connect_mysql() {
        // Actualizați detaliile de mai jos cu detaliile dvs. MySQL
        $DATABASE_HOST = 'localhost';
        $DATABASE_USER = 'root';
        $DATABASE_PASS = '';
        $DATABASE_NAME = 'shop';


        try {
        return new PDO('mysql:host='.$DATABASE_HOST.';dbname='.$DATABASE_NAME.';charset=utf8',$DATABASE_USER,$DATABASE_PASS);
        } catch (PDOException $exception) {
        // Dacă există o eroare la conexiune, opriți scriptul și afișați eroarea.
        exit('Failed to connect to database!');
        }
    }


    // Template
    function template_header($title) {
        // Obțineți cantitatea de articole din coșul de cumpărături, aceasta va fi afișată în antet.
        $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

        if(empty($_SESSION['name'])) { 
            $loginlogout = '<a href="index.php?page=login">Login</a>';
        } else { 
            $loginlogout = '<a href="index.php?page=logout">Logout</a>';
        }; 
        echo <<<EOT
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>

        <body>
        <header>
            <div class="content-wrapper">
                <h1>Online Shop</h1>
                <nav>
                    <a href="index.php">Home</a>
                    <a href="index.php?page=products">Products</a>
                </nav>
                <div class="link-icons">
                    $loginlogout
                    <a href="index.php?page=cart">
                        <i class="fas fa-shopping-cart"></i>
                        <span>$num_items_in_cart</span>
                    </a>
                </div>
            </div>
        </header>
        <main>
    EOT;
    }
    
    // Template footer
    function template_footer() {
        $year = date('Y');
        echo <<<EOT
        </main>
        <footer>
            <div class="content-wrapper">
                <p> Online Shop - Gadgets/Accessories, $year</p>
            </div>
        </footer>
        </body>
        </html>
        EOT;
    }
?>
