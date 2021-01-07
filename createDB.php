<?php
$hostname = 'localhost';
$username = 'root';
$password =  "";
$db = 'shop';

/*** se creeaza un obiect mysqli ***/
$mysqli = new mysqli($hostname,$username,$password,$db);
/* se verifica daca s-a realizat conexiunea */

if (!mysqli_connect_errno())
{
    echo 'Conectat la baza de date: '.$db;
    // $mysqli->close();
}
else
{
    echo 'Conexiune esuata!!!';
    exit();
}
echo '</br>';

// sql to create table
$sql = "";

if ($mysqli->query($sql) === TRUE) {
    echo 'Tabela sa creat cu succes!';

    // $hashed = hash('sha512', $pass1);

} else {
   // echo 'Eroare creare tabela: ' . $conn->error;

}
?>
