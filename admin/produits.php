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
$categorie = 0;
if(!empty($_GET['categorie']) ){
    $categorie = $_GET['categorie'];
    $cond=array('categorie'=>$categorie);
    $nb =$conn->query('SELECT count(*) as nbr FROM products WHERE category_id=:categorie',$cond);
}elseif (!empty($_POST['categorie']) && $_POST['categorie']!=null ) {
  $categorie = $_POST['categorie'];
  $cond=array('categorie'=>$categorie);
  $nb =$conn->query('SELECT count(*) as nbr FROM products WHERE category_id=:categorie',$cond);
}else
    $nb =$conn->query('SELECT count(*) as nbr FROM products');

$perpage = 12;
$nbr_pages = ceil($nb[0]->nbr /$perpage);

if(isset($_GET['page'])){
  $page = intval($_GET['page']);
  if($page>$nbr_pages){
    $page = $nbr_pages;
  } 
}else{
  $page =1;
}

$premierPage = ($page - 1)* $perpage;
 ?>
 

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
        <script type="text/javascript" src="css/mobile.js"></script>

<div class="smart">
<h1 class="smart">
<i class="fa fa-cog" style="font-size:48px;color:white"></i>
Smartech 
<small> Gérer votre site</small> 
</h1>

</div> 
     

<!-- message de session -->
<?php if (isset($_SESSION['message'])): ?>
  <div class="message"> <?php echo $_SESSION['message']; ?></div>
  <?php unset($_SESSION['message']) ?>
<?php endif ?>
<?php if (isset($_SESSION['erreur'])): ?>
  <div class="errorMessage"> <?php echo $_SESSION['erreur']; ?></div>
  <?php unset($_SESSION['erreur']) ?>
<?php endif ?>
    <h2>Gestion des produits 
        <?php 
        $categories = $conn->query('SELECT * FROM categories');
         ?>
        <form id="filtre" action="produits.php" method="post">
          <select name="categorie" id="categorie">
           <option value="0">Tous les produits</option>
           <?php foreach ($categories as $c): ?>
              <option value="<?php echo $c->id ?>"><?php echo $c->name; ?></option>
    
           <?php endforeach ?>
          </select>
          <input type="submit" value="Filtrer">
        </form>
      </h2>
      <?php 
      if(!empty($_GET['categorie'])){
        $products =$conn->query('SELECT * FROM products WHERE category_id=:categorie ORDER By id 
          DESC LIMIT '.$premierPage.','.$perpage.'',$cond);
      }elseif (!empty($_POST['categorie'])) {
          $products =$conn->query('SELECT * FROM products WHERE category_id=:categorie ORDER By id 
          DESC LIMIT '.$premierPage.','.$perpage.'',$cond);
      }
       else {  
           $products =$conn->query('SELECT * FROM products  ORDER By id 
          DESC LIMIT '.$premierPage.','.$perpage.'');
           }
       ?>
       <button><a href="addProduct.php">Ajouter un produit</a></button> 
    <table>
      <thead>
        <tr>
          <th>Image</th>
          <th>Nom du produit</th>
          <th>Prix</th>
          <th>Qte</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><img src="../<?php echo $product->photo ?>"></td>
             <td><?php echo $product->name ?></td>
              <td><?php echo $product->price ?> DZD</td>
               <td><?php echo $product->qte ?></td>
                <td>  
                  <a href="editProduct.php?id=<?php echo $product->id ?>" id="edit" ></a>

                   <a href="delete.php?product=<?php echo $product->id ?>" class="del" onclick="return confirm('voulez-vous vraiment supprimer cet élément ? ')"></a>
                </td>

          </tr>
        <?php endforeach ?>
      </tbody>

    </table>
    <?php if($nbr_pages >1): ?>
      <div class="pagination">
        <ul>
        <?php 
       
          for ($i=1; $i<= $nbr_pages; $i++){
            if($i == $page){
              echo '<li class="active"><a href="">'.$i.'</a></li>';
            }else{
              echo '<li><a href="produits.php?page='.$i.'&categorie='.$categorie.'">'.$i.'</a></li>';
            }
          }
         ?> 
        </ul>
      </div>
      <?php endif ?>


      <div class="clearfix"></div>
  
      <footer class="smart">
  	<p>Copyright Smartech © 2020</p>
  </footer>