<?php
    session_start();
    // Include functii conectare la baza de date folosind PDO MySQL
    include 'conectare.php';
    $pdo = pdo_connect_mysql();
    // home este pgina start
    $page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';
    // Includeti si afisati pagina solicitata
    include $page . '.php';
?>
