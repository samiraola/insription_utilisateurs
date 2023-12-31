<?php
session_start();
$connexion = mysqli_connect ('localhost', 'root','', 'BLOGS' );
if(!$connexion){
    die('Erreur de connexion à la Base de Donnée');
     }
if(!empty($_SESSION['user_id'])){
$sessionUserId = $_SESSION['user_id'];
$selection="SELECT * FROM user WHERE id='$sessionUserId' ";

 $query=mysqli_query ($connexion,$selection);

 $recuperation=mysqli_fetch_assoc($query);
 
 if($recuperation){
 }else{
    die("utilisateur inconnu");
 }
}else{
    header('LOCATION:../../connexion.php');
}
if (isset($recuperation['id'])) {
    if(!empty($_POST['email']) or !empty($_POST['img_url']) or !empty($_POST['password'])){
        $insertion = "UPDATE user SET ";
        if(!empty($_POST['email'])){
            $email = $_POST['email'];
            $insertion .= "email='$email', ";
        }
        if(!empty($_POST['img_url'])){
            $image = $_POST['img_url'];
            $insertion .= "image='$image', ";
        }
        if(!empty($_POST['password'])){
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            if($password != $cpassword){
                echo "erreur sur le mot de passe";
            }else{
                $insertion .= "password='$password', ";
            }
        }
        $insertion = substr($insertion, 0, -2);
        $insertion .= " WHERE id = '$sessionUserId'";
        echo $insertion;
        $requette = mysqli_query($connexion, $insertion);
        var_dump($requette);
        if($requette){
            $select = " SELECT * FROM user WHERE id = '$sessionUserId' ";
            $requete = mysqli_query($connexion, $select);
            $livre = mysqli_fetch_assoc($requete);
            echo "Modification validée";
        }
        else{
            die("Échec de la mise à jour");
        }
    }
    
} else {
    echo "ID non défini.";
}


?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Lato;
        }

        body {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background: url('https://images.unsplash.com/photo-1604147706283-d7119b5b822c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2487&q=80') no-repeat center/cover;
        }

        header {
            display: flex;
            padding: 20px 30px;
            background-color: #261c85;
            justify-content: space-between;
            gap: 2em;
            align-items: center;
            color: #fff
        }

        header a {
            text-decoration: none;
            color: #fff
        }

        header .logo {
            padding: 10px;
            border: 1px solid #fff;
            font-size: 1.8em;
        }

        header .logo:hover {
            background-color: #fff;
            color: #261c85;
            transition: all .2s ease-in-out;
        }

        header ul {
            display: flex;
            justify-content: space-evenly;
            gap: 1em;
            list-style: none;
            align-items: center;
            flex-grow: 1;
        }

        header ul li {
            min-width: 100px;
            padding: 5px;
        }

        header ul li a {
            font-size: 1.1em;
        }

        main {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2em;
            width: 100%;
            max-width: 1200px;
        }

        #info{
            display: flex;
            flex-direction: column;
            gap: 1.5em;
            width: 100%;
            max-width: 400px;
        }

        #info img{
            width: 100%;
        }

        #info div p:first-child{
            font-weight: 700;
        }

        #content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2em;
            width: 100%;
            max-width: 1200px;
        }

        #content form {
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            gap: 1.5em;
        }

        #content form h4{
            text-align: center;
            text-decoration: underline;
        }

        #content form .group {
            display: flex;
            flex-direction: column;
        }
        #content form label {
            color: #261c85;
            width: fit-content;
        }
        #content form input{
            border: none;
            outline: none;
            border: 1px solid #d4d4d4;
            padding: 10px;
            resize: none;
        }
        #content form input[type='submit']{
            cursor: pointer;
        }
        #content form input[type='submit'] {
            width: 100%;
            max-width: fit-content;
            padding: 10px;
            border-radius: 5px;
            margin: 0 auto;
            background-color: #261c85;
            color: #fff;
            text-align: center;
        }
        #content form input[type='submit']:hover {
            background-color: #3f2fce;
            border: 1px solid #3f2fce;
        }

        @media screen and (max-width: 930px) {
            header {
                flex-direction: column;
            }
        }

        @media screen and (max-width: 730px) {
            ul {
                flex-direction: column;
            }

            header ul form,
            input {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header>
        <a class="logo" href="">myBlog Dashboard</a>
        <ul>
            <li><a href="./dashboard.php">Accueil</a></li>
            <li><a href="./articles.php">Articles</a></li>
            <li><a href="./profil.php">Profil</a></li>
            <li><a href="../index.php">myBlog</a></li>
        </ul>
    </header>
    <main>
        <div id="content">
            <h3>Profil</h3>
            <div id="info">
                <h4>Mes informations</h4>
                <div>
                    <img src="<?php echo $recuperation['image']    ?>" alt="">
                </div>
                <div>
                    <p>Nom</p>
                    <p><?php echo $recuperation['firstname'] ?></p>
                </div>
                <div>
                    <p>Prenoms</p>
                    <p><?php echo $recuperation['lastname'] ?></p>
                </div>
                <div>
                    <p>Email</p>
                    <p><?php echo $recuperation['email'] ?></p>
                </div>
            </div>
            <form action="" method="post">
                <h4>Modifier mes informations</h4>
                <div class="group">
                    <label for="email">Modifier l'email</label>
                    <input type="email" name="email" id="email" placeholder="johnDoe@ex.ci"  value="<?php echo $recuperation['email'] ; ?>">
                </div>
                <div class="group">
                    <label for="img_url">Modifier le lien de la photo</label>
                    <input type="url" name="img_url" id="img_url" placeholder="https://images.unsplash.com/photo-1696185082767-29f8095a22a9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyMHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=700&q=60" value="<?php echo $recuperation['image'] ; ?>"    >
                </div>
                <div class="group">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="nouveau mot de passe"   >
                </div>
                <div class="group">
                    <label for="cpassword">Confirmer mot de passe</label>
                    <input type="text" name="cpassword" id="cpassword" placeholder="confirmer le mot de passe"  >
                </div>
                <input type="submit" value="Modifier mes informations">
            </form>
        </div>
    </main>
</body>

</html>