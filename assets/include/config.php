<?php
// method1
$host = "sql313.infinityfree.com";
$dbname = "if0_41153285_fastfit";
$username = "if0_41153285";
$password = "LuKHuCCTUu";
$con = mysqli_connect($host, $username, $password, $dbname);
try {
  $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// method2

$nom_serveur = "sql313.infinityfree.com";
    $nom_utilisateur = "if0_41153285";
    $pw = "LuKHuCCTUu";
    $nom_db = "if0_41153285_fastfit"; 
    $dsn = "mysql:host=$nom_serveur;dbname=$nom_db";

    try {
        $cnx = new PDO($dsn, $nom_utilisateur, $pw);
        
    } catch (PDOException $e) {
        echo "Attention la connexion a la base de donnes echoue" , $e->getMessage();
    }
