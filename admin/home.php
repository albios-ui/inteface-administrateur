<?php
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit(); 
  }  
  if (isset($_POST['username'])) { $username = $_POST['username']; }
?>
<!doctype html>
<html lang="en" dir="ltr">
  <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/administration.css">

    <link href="css/styles.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>  

 

    <link rel="stylesheet" href="css/stylesx.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
 </head>

 
 <header >
            <a class="logo" href="home.php">Smartech</a>
            <nav>
                <ul class="nav__links">
                    <li><a href="home.php" >  <i class="fas fa-home"></i>  Accueil  </a> </li>
                    <li><a href="produits.php">  <i class="fas fa-cogs"></i>  Produits  </a> </li>
                    <li><a href="#">  <i class="fas fa-th-list"></i>  Catégories  </a> </li>
                    <li><a href="#">  <i class="far fa-handshake"></i>  Clients  </a> </li> 

                </ul>
            </nav>
            <a class="cta "  href="#"><i class="fas fa-user"></i> profil</a>
            <a class="cta " href="../logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            <p class="menu cta">Menu</p>
</header>

        <div id="mobile__menu" class="overlay">
            <a class="close">&times;</a>
            <div class="overlay__content">
                <a href="home.php"><i class="fas fa-home"> </i>  Accueil</a>
                <a href="produits.php"> <i class="fas fa-cogs"></i>   Produits</a>
                <a href="#"> <i class="fas fa-th-list"></i>  Catégories</a>
                <a href="#"><i class="far fa-handshake"></i>  Clients</a>
              

                <a href="#"><i class="fas fa-user"></i>  profil</a>
                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i>  logout</a>

            </div>
        </div> 

        <script type="text/javascript" src="css/mobile.js"></script>

        <div class="smart">
  	<h1 class="smart">
  		<i class="fa fa-cog" style="font-size:48px;color:white"></i>
  		 Smartech 
  		 <small> Gérer votre site</small> 
  	</h1>
  	
  </div>
  <ol class="breadcrumb">
  	<li class="beadrcumb"> <?php echo $_SESSION['username']; ?> - Bienvenue dans l'espace d'administration</li>
  </ol>

<div class ="messages">


<div class="container">


</div>




</div>





    <script>
     CKEDITOR.replace( 'editor1' );
 </script>
<script>
    const menuBtn = document.querySelector(".menu-icon span");
    const searchBtn = document.querySelector(".search-icon");
    const cancelBtn = document.querySelector(".cancel-icon");
    const items = document.querySelector(".nav-items");
    const form = document.querySelector("form");
    menuBtn.onclick = ()=>{
      items.classList.add("active");
      menuBtn.classList.add("hide");
      searchBtn.classList.add("hide");
      cancelBtn.classList.add("show");
    }
    cancelBtn.onclick = ()=>{
      items.classList.remove("active");
      menuBtn.classList.remove("hide");
      searchBtn.classList.remove("hide");
      cancelBtn.classList.remove("show");
      form.classList.remove("active");
      cancelBtn.style.color = "#ff3d00";
    }
    searchBtn.onclick = ()=>{
      form.classList.add("active");
      searchBtn.classList.add("hide");
      cancelBtn.classList.add("show");
    }
  </script>


<footer class="smart">
  	<p> Copyright Smartech © 2020 </p>
  </footer> 



  </body>
</html>

  