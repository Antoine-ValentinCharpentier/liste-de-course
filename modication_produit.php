<?php
	include "db.php";

	if(!isset($_GET['profil'])){
		header("Location: modification_produit.php?profil=1");
	}

	if(isset($_POST['submit_supression_produit'])){
		$suppr_achat = $bdd->prepare('DELETE FROM produit WHERE id_produit = ?');
		$suppr_achat->execute(array($_POST['id_produit']));
	}

	if (isset($_POST['submit_modification_produit'])) {
		$articles = $bdd->prepare("SELECT * FROM produit WHERE id_profil = ?");
		$articles->execute(array($_POST['id_produit']));
		$article = $articles->fetch();

		if ($_POST['name_produit'] != $article['nom']) {
			if(strlen($_POST['name_produit']) < 255){
				$modification_nom = $bdd->prepare("UPDATE produit SET nom = ? WHERE id_produit = ?");
				$modification_nom->execute(array($_POST['name_produit'],$_POST['id_produit']));
			}else{
				$error = "Veuillez saisir un nom avec au maximum 255 caractères.";
			}
		}

		if ($_POST['remarque_produit'] != $article['remarque']) {
			if(strlen($_POST['remarque_produit']) < 255){
				$modification_nom = $bdd->prepare("UPDATE produit SET remarque = ? WHERE id_produit = ?");
				$modification_nom->execute(array($_POST['remarque_produit'],$_POST['id_produit']));
			}else{
				$error = "Veuillez saisir une remarque avec au maximum 255 caractères.";
			}
		}



		$chemin_photo_produit= "";//stocke le chemin pour aceder a la photo une fois upload
    	
    	if(!empty($_FILES['photo_produit'])){
	        print_r($_FILES['photo_produit']);
	        $nameFile = $_FILES['photo_produit']['name'];
	        $typeFile = $_FILES['photo_produit']['type'];
	        $sizeFile = $_FILES['photo_produit']['size'];
	        $tmpFile = $_FILES['photo_produit']['tmp_name'];
	        $errFile = $_FILES['photo_produit']['error'];
	        
	        // Extensions
	        $extensions = ['png', 'jpg', 'jpeg', 'gif'];
	        // Type d'image
	        $type = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];
	        // On récupère
	        $extension = explode('.', $nameFile);


	        // On vérifie que le type est autorisés

	        if(in_array($typeFile, $type)){
	            // On vérifie que il n'y a que deux extensions
	            if(count($extension) <= 2 && in_array(strtolower(end($extension)), $extensions)){
	                $id_new_produit = $_POST['id_produit'];

					$chemin_photo_produit = "./photo/produit/".$id_new_produit.".".strtolower(end($extension));

	                // On bouge l'image uploadé dans le dossier upload
	                move_uploaded_file($tmpFile, $chemin_photo_produit);

	                /**   on retire les images deja présente au paravant, qui ne seront pas écrasée **/
	                if($extension == "jpg"){
	                   if(file_exists("./photo/produit/".$_POST['id_produit'].".jpeg")) unlink ("./photo/produit/".$_POST['id_produit'].".jpeg");
	                   if(file_exists("./photo/produit/".$_POST['id_produit'].".gif")) unlink ("./photo/produit/".$_POST['id_produit'].".gif");
	                   if(file_exists("./photo/produit/".$_POST['id_produit'].".png")) unlink ("./photo/produit/".$_POST['id_produit'].".png");
	                }
	                if($extension == "jpeg"){
	                   if(file_exists("./photo/produit/".$_POST['id_produit'].".jpg")) unlink ("./photo/produit/".$_POST['id_produit'].".jpg");
	                   if(file_exists("./photo/produit/".$_POST['id_produit'].".gif")) unlink ("./photo/produit/".$_POST['id_produit'].".gif");
	                   if(file_exists("./photo/produit/".$_POST['id_produit'].".png")) unlink ("./photo/produit/".$_POST['id_produit'].".png");
	                }
	                if($extension == "png"){
	                   if(file_exists("./photo/produit/".$_POST['id_produit'].".jpg")) unlink ("./photo/produit/".$_POST['id_produit'].".jpg");
	                   if(file_exists("./photo/produit/".$_POST['id_produit'].".jpeg")) unlink ("./photo/produit/".$_POST['id_produit'].".jpeg");
	                   if(file_exists("./photo/produit/".$_POST['id_produit'].".gif")) unlink ("./photo/produit/".$_POST['id_produit'].".gif");
	                }

	                $modification_photo = $bdd->prepare("UPDATE produit SET photo = ? WHERE id_produit = ?");
					$modification_photo->execute(array($chemin_photo_produit,$_POST['id_produit']));
	            }
	        }
	    }
	}

	//Compte le nb d'achat restant
	$reqnbachatrestant = $bdd->prepare("SELECT * FROM achat_a_faire WHERE profil = ?");
    $reqnbachatrestant->execute(array($_GET['profil']));
    $cptnbachatrestant = $reqnbachatrestant->rowCount();

	//Compte le nb d'achat realisé = TOTAL
    $reqnbachatfait = $bdd->prepare("SELECT * FROM achat_realiser WHERE profil = ?");
    $reqnbachatfait->execute(array($_GET['profil']));
    $cptnbachatfait = $reqnbachatfait->rowCount();    

	//compter le nb d'achat réalisé ce mois-ci
	$reqnbachatfaitmois = $bdd->prepare("SELECT * FROM achat_realiser WHERE profil = ? AND MONTH(date_achat) = MONTH(CURDATE())");
    $reqnbachatfaitmois->execute(array($_GET['profil']));
    $cptnbachatfaitmois = $reqnbachatfaitmois->rowCount();

?>
<html>
<head>
	<title>course</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./css/modification.css">
	<link rel="stylesheet" type="text/css" href="./css/anim.css"/>
	<link rel="stylesheet" type="text/css" href="./css/style.css"/>
	<link rel="stylesheet" type="text/css" href="./css/menu.css"/>

	<style type="text/css">
		
	</style>
</head>
<body>
	<?php
	$title = "LISTE PRODUITS";
	include "./fragments/menu.php";
	?>

	<div class="modic_prod">
		<?php
			$all_products = $bdd->prepare("SELECT * FROM produit WHERE profil = ?");
			$all_products->execute(array($_GET['profil']));
			$i=0;
			while ($produit = $all_products->fetch()){
				$i=$i+1;
				?>
				<div class="trait">
					<p>Produit n°<strong><?php echo $i;?></strong></p>
				</div>
				<form method="POST" action="" enctype="multipart/form-data">
					<input type="hidden" name="id_produit" value="<?php echo $produit['id_produit'];?>">

					<div class="article_container">
	
						<div class="left">
							<p class="article_name_produit"><strong>Nom Produit | </strong><input type="text" name="name_produit" value="<?php echo $produit['nom'];?>" id="name"></p>		
				
							<p class="article_remarque_produit"><strong>Remarque | </strong><input type="text" name="remarque_produit" value="<?php echo $produit['remarque'];?>" id="remarque"></p>

						</div>
						
						<?php 
							if($produit['photo']!= NULL){
						?>
						<div class="article_photo_produit">
							<center><img src="<?php echo $produit['photo'];?>"></center>
							<center><input type="file" name="photo_produit" value="upload une photo" id="photo_produit_id"></center>
						</div>
						<?php
							}else{
						?>
						<div class="article_photo_produit">
							<center><img src="./photo/produit/0.svg"></center>
							<center><input type="file" name="photo_produit" value="upload une photo" id="photo"></center>
						</div>
						<?php
							}
						?>

						<div class="article_form">
							<p><strong>Action</strong></p>
							<input type="submit" name="submit_supression_produit" value="" style="background-image: url('./icone/delete.svg')"><br>
							<input type="submit" name="submit_modification_produit" value="" style="background-image: url('./icone/gear.svg')">
						</div>

					</div>

				</form>
				<div class="trait"></div>
				
				<?php
			}
		?>		
	</div>


</body>
</html>

<script type="text/javascript" src="./js/menu.js"></script>