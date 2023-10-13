<?php
session_start();
$connexion = mysqli_connect ('localhost', 'root','', 'BLOGS' );
if(!$connexion){
    die('Erreur de connexion à la Base de Donnée');
     }
echo $_SESSION['user_id'];
if(!empty($_SESSION['user_id'])){
$sessionUserId = $_SESSION['user_id'];
$selection="SELECT * FROM user WHERE id='$sessionUserId' ";

 $query=mysqli_query ($connexion,$selection);

 $recuperation=mysqli_fetch_assoc($query);
 if($recuperation){
    var_dump($recuperation);
 }else{
    die("utilisateur inconnu");
 }
}else{
    header('LOCATION:../../connexion.php');
}
if($_GET['id']){
    $id= $_GET['id'];
    $rox = "DELETE  FROM article WHERE id='$id' ";
    $execute = mysqli_query($connexion,$rox);
    if($execute){
        echo "suppression actualisé";
    }else{
        echo "erreur ";
    }
    header('LOCATION:articles.php');
}



?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer</title>
</head>
<body>
    <h1>L'ARTICLE A ÉTÉ SUPPRIMÉ!</h1>
</body>
</html>