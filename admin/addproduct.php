<!doctype html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/administration.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>  
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
    

    <link rel="stylesheet" href="css/stylesx.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
 </head>



 
 <header>
            <a class="logo" href="home.php">Smartech</a>

            <nav>
                <ul class="nav__links">
                    <li><a href="home.php" > <i class="fas fa-home"> </i> Accueil</a></li>
                    <li><a href="produits.php"><i class="fas fa-cogs"> </i> Produits</a></li>
                    <li><a href="#"><i class="fas fa-th-list"></i> Catégories</a></li>
                    <li><a href="#"><i class="far fa-handshake"></i> Clients</a></li> 
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

<?php session_start(); 
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit(); 
  }  
  if (isset($_POST['username'])) { $username = $_POST['username']; }
require  '../config.php';
require_once '../Classes/conn.php';
$conn = new conn();

if(!empty($_POST)){
  $validate =true;
  if(empty($_POST['name'])){
    $validate =false;
    $erreur_name="Le nom du produit est requis.";
  }

   if(empty($_POST['description'])){
    $validate =false;
    $erreur_description="La description du produit est requise.";
  }

   if(empty($_POST['price'])) {
    $validate =false;
    $erreur_price="Veuillez entrer Le prix du produit .";
  }

   if(empty($_POST['qte'])){
    $validate =false;
    $erreur_qte="Veuillez entrer la quantité en stock du produit.";
  }

  if(empty($_FILES['photo']['name'])){
    $validate =false;
    $erreur_photo ="Veuillez entrer le visuel du produit";
  }

  if(!empty($_FILES['photo']['name']) && $validate){
    $extension = strrchr($_FILES['photo']['name'], '.');
    $dossier =UPLOAD;

    $photo = md5($_FILES['photo']['name'])."$extension";
    if(!move_uploaded_file($_FILES['photo']['tmp_name'], '../'.$dossier.$photo)){
      $validate = false;
      $_SESSION['erreur'] ="Un problème est survenu lors de l'Upload de l'image";
    }else 
        $photo = $dossier.$photo;
      
  }

  // validation
  if($validate){
    $data=array(
        'name'=>$_POST['name'],
         'description'=>$_POST['description'],
        'price'=>$_POST['price'],
         'qte'=>$_POST['qte'],
         'category_id'=>$_POST['categorie'],
         'photo'=>$photo
      );
    $rep = $conn->insert("INSERT INTO products (name,description,price,qte,photo,category_id) VALUES (:name,:description,:price,:qte,:photo,:category_id) ",$data);
    if($rep){
      $_SESSION['message']="Le produit à été ajouté avec succès";
      header('location:produits.php');
      exit();
    }else{
         $_SESSION['erreur'] ="Un problème est survenu lors de la sauvegarde";
    }
  }else{
       $_SESSION['erreur'] ="Veuillez corriger les érreurs indiquées ci dessous";
  }
}
$categories = $conn->query("SELECT * from categories"); 
 ?> 
<!-- message de session -->
<?php if (isset($_SESSION['message'])): ?>
  <div class="message"> <?php echo $_SESSION['message']; ?></div>
  <?php unset($_SESSION['message']) ?>
<?php endif ?>
<?php if (isset($_SESSION['erreur'])): ?>
  <div class="errorMessage"> <?php echo $_SESSION['erreur']; ?></div>
  <?php unset($_SESSION['erreur']) ?>
<?php endif ?>
    <h2>Ajouter un produit </h2>
     <form action="addProduct.php" method="POST" enctype="multipart/form-data">
      <p>
        <label for="name">Nom </label>
        <input type="text" name="name" value="<?php echo isset($_POST['name'])?$_POST['name']:''; ?>">
      </p>
      <?php if (!empty($erreur_name)): ?>
        <div class="error"><?php echo $erreur_name; ?></div>
      <?php endif ?>
      <p>
        <label for="description">la déscription du produit</label>
        <textarea name="description" ><?php echo isset($_POST['description'])?$_POST['description']:'' ?></textarea>
      </p>
      <?php if (!empty($erreur_description)): ?>
        <div class="error"><?php echo $erreur_description; ?></div>
      <?php endif ?>
      <p>
        <label for="price">Prix  </label>
        <input type="text" name="price" value="<?php echo isset($_POST['price'])?$_POST['price']:'' ?> " >
     
      </p>
      <?php if (!empty($erreur_price)): ?>
        <div class="error"><?php echo $erreur_price; ?> 
      </div>
      <?php endif ?>
      <p>
        <label for="qte">Quantité </label>
        <input type="text" name="qte" value="<?php echo isset($_POST['qte'])?$_POST['qte']:'' ?>">
      </p>
      <?php if (!empty($erreur_qte)): ?>
        <div class="error"><?php echo $erreur_qte; ?></div>
      <?php endif ?>

      <p>
        <label for="photo">Photo </label>
        <input type="file" name="photo" >
      </p>
      <?php if (!empty($erreur_photo)): ?>
        <div class="error"><?php echo $erreur_photo; ?></div>
      <?php endif ?>

      <label for="categorie"> Choisissez la catégorie</label>

      <select name="categorie" id="categorie">
        <?php foreach ($categories as $c): ?>
            <option value="<?php echo $c->id ?>" <?php echo (isset($_POST['categorie']) && $_POST['categorie'] == $c->id)?"Selected":""?> > 
              <?php echo $c->name; ?></option>
        <?php endforeach ?>

      </select>

      
</p>
        <input class="enregistrer" type="submit" onclick="javascript:if(confirm('vous êtes sur le point d''jouter un nouveau produit ));" value="Enregistrer" >
              
     
      <p>
      <input class="annuler" type="button" onclick="javascript:if(confirm('vous êtes sûr ?')) location.href = 'produits.php';" value="Annuler">  
</p>

     </form>


      <div class="clearfix"></div>
  
      <footer class="smart">
          	<p>Copyright Smartech © 2020</p>
      </footer> 