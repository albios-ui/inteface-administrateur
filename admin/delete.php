<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
   <link rel="stylesheet" href="../css/administration.css">
   <script src="../js/libs/modernizr-2.5.0.min.js"></script>
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
  // supprimer le produit
	
	if(!empty($_GET['product'])){
		$id =intval($_GET['product']);

		$product = $conn->query('SELECT id,photo FROM products WHERE id=:id',array('id'=>$id));

		if(empty($product)){
			$_SESSION['erreur'] = "Produit introuvable dans notre base .";
		}else{
			$nb= $conn->insert('DELETE FROM products WHERE id=:id',array('id'=>$id));
			if($nb){
				unlink('../'.$product[0]->photo);
				$_SESSION['message'] = "Produit  supprimé avec succès";
			}else{
				$_SESSION['erreur'] = "Un problème est survenu lors de la suppression du produit.";
			}
		}

		echo '<script language ="Javascript">
		<!--
		document.location.replace("produits.php");
		-->;
		</script>';
	}

	
	echo '<script language ="Javascript">
		<!--
		document.location.replace("index.php");
		-->;
		</script>';
?>