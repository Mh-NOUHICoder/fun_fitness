<?php
$host = "localhost"; 
$dbname = "fun_fitness"; 
$username = "root"; 
$password = ""; 
$con = mysqli_connect($host, $username, $password, $dbname);
try {
  $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// method2

$nom_serveur = "localhost";
    $nom_utilisateur = "root";
    $pw = "";
    $nom_db = "fun_fitness"; 
    $dsn = "mysql:host=$nom_serveur;dbname=$nom_db";

    try {
        $cnx = new PDO($dsn, $nom_utilisateur, $pw);
        
    } catch (PDOException $e) {
        echo "Attention la connexion a la base de donnes echoue" , $e->getMessage();
    }
