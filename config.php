<?php
// clé de cryptage 
define("SALT","une cle de cryptage");
// Informations d'identification
define('HOST', 'localhost');
define('USER', 'root');
define('PWD', '');
define('DBNAME', 'registration');
 
// Connexion à la base de données MySQL 
$conn = mysqli_connect(HOST, USER, PWD, DBNAME);
 
// V�rifier la connexion
if($conn === false){
    die("ERREUR : Impossible de se connecter. " . mysqli_connect_error());
}
// répertoire de téléchargement
define ("UPLOAD",'img/produits/');

?>