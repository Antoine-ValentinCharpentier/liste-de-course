<?php
	include "db.php";

	//redirige vers la page avec les profils lors de la première redirection
	if(!isset($_GET['profil'])){
		header("Location: index.php?profil=1");
	}
	
	//Si l'utilisateur supprime un achat a faire
	if(isset($_POST['article_suppr'])){
		echo "delete début";
		$suppr_achat = $bdd->prepare('DELETE FROM achat_a_faire WHERE id_achat = ?');
		$suppr_achat->execute(array($_POST['id_achat']));
		echo "delete fin";
	}

	//Si l'utilisateur appui sur le bouton pour indiquer que le produit associé a été acheté
	if(isset($_POST['article_achete'])){
		//on insert le produit dans la base de données (pour éventuellement ajouter par la suite une fonctionalité pour voir les produits déjà acheté)
		$add_achate = $bdd->prepare('INSERT INTO achat_realiser(id_produit,quantite, prix, profil) VALUES (?,?,?,?)');
		//on regarde s'il a saisi le prix du produit
		if(!empty($_POST['prix'])){
			//dans le cas où il a renseigné le prix lorsqu'il l'a acheté
			//on utilise alors le prix de la requête POST
			$add_achate->execute(array($_POST['id_produit'],$_POST['quantity'],$_POST['prix'],$_GET['profil']));
		}else{
			//dans le cas où il n'a pas saisi le prix du produit
			//on considère alors que le prix vaut 0
			$add_achate->execute(array($_POST['id_produit'],$_POST['quantity'],0,$_GET['profil']));
		}

		//Ensuite, on supprime le produit de la liste des produits restant à acheter
		$suppr_achat = $bdd->prepare('DELETE FROM achat_a_faire WHERE id_achat = ?');
		$suppr_achat->execute(array($_POST['id_achat']));	
	}

	//Si une demande d'achat est envoyé
	if(isset($_POST['submit_achat'])){
		//on regarde s'il a sélectionné un produit
		if(!empty($_POST['produit'])){
			//on prépare la commande d'insertion dans la bd
			$add_achat = $bdd->prepare('INSERT INTO achat_a_faire(id_achat, id_produit,quantite, profil) VALUES (NULL,?,?,?)');
			//on regarde s'il a sélectionné une quantité
			if(empty($_POST['quantity'])){
				echo "null";
				//s'il n'a pas sélectionné de quantité, on mets alors la valeur null dans la bd
				//on execute alors l'insertion
				$add_achat->execute(array($_POST['produit'],"",$_GET['profil']));
			}else{
				//s'il a sélectionné une quantité
				//on execute alors l'insertion
				$add_achat->execute(array($_POST['produit'],$_POST['quantity'],$_GET['profil']));	
			}
			
			$error = "Votre demande d'achat a bien été prit en compte.";
		}else{
			$error = "Veuillez saisir un produit dans le menu déroulant.";
		}
    }

    //s'il envoit un formulaire pour créer un nouveau produit
	if(isset($_POST['submit_produit'])){
      if(!empty($_POST['name_produit'])){ 
      	$req_id_last_produit = $bdd->prepare("SELECT max(id_produit) FROM produit");
		$req_id_last_produit->execute();
		$id_last_produit = $req_id_last_produit->fetch();
		//on ajoute + 1 car on a récupéré le dernier produit ajouter précédemment, donc l'id de celui que l'on va rajouté aura un id+1
		$id_new_produit = $id_last_produit['max(id_produit)']+1;

      	$nom_produit = htmlspecialchars($_POST['name_produit']);
		//on regarde s'il n'est pas trop long
		if(strlen($nom_produit) > 255){
    		$error = "Le nom du produit rentré est trop long (MAX 255 caractère)";
    	}
    	//on récupère la remarque associé au produit, celui-ci est vide s'il n'y a rien écrit dans ce champ
    	$remarque_produit = htmlspecialchars($_POST['remarque_produit']);
    
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

					$chemin_photo_produit = "./photo/produit/".$id_new_produit.".".strtolower(end($extension));

	                // On bouge l'image uploadé dans le dossier upload
	                move_uploaded_file($tmpFile, $chemin_photo_produit);
	            }
	        }
	    }

		//on ajoute le produit dans la bdd
		if(strlen($nom_produit) <= 255){
    		$add_produit = $bdd->prepare('INSERT INTO produit(id_produit,nom, remarque, photo, profil) VALUES (?,?,?,?,?)');
			$add_produit->execute(array($id_new_produit,$nom_produit,$remarque_produit,$chemin_photo_produit,$_GET['profil']));
			$error = "Le produit vient d'être ajouté dans la liste des produits.";
    	}

      }else{
      	$error="Veuillez écrire le nom du produit (MAX 255 caractères)";
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
	
	<link rel="stylesheet" type="text/css" href="./css/anim.css"/>
	<link rel="stylesheet" type="text/css" href="./css/style.css"/>
	<link rel="stylesheet" type="text/css" href="./css/menu.css"/>
	
</head>

<body>

	<?php
	$title = "ACHETER";
	include "./fragments/menu.php";
	?>

	<div class="add_produit_achat">
		<!-- formulaire ajout produit dans la liste des différent produits -->
		<div class="ajout_produit">
			<center><p class="title">Ajouter un produit</p></center>
			<form method="POST" action="" enctype="multipart/form-data">
				<div class="flex-container">
					<div>
						<p><strong>Nom Produit (*)</strong></p>
						<input type="text" name="name_produit" placeholder="name">
					</div>
					<div>
						<p><strong>Remarque</strong></p>
						<input type="text" name="remarque_produit" placeholder="remarque">
					</div>
					<div>
						<p><strong>Photo</strong></p>
						<center><label for="photo_produit_id"><p>Photo</p></label><input type="file" name="photo_produit" value="upload une photo" id="photo_produit_id"></center>
					</div>
					<div>
						<p style="opacity: 0;">Quantité</p>
						<input type="submit" name="submit_produit" value="Ajouter">
					</div>
				</div>
			</form>
		</div>

		<!-- TRAIT DE SEPARATION des deux formulaires -->
		<center>
			<div class="petit_trait"></div>
		</center>

		<!-- formulaire ajout produit a acheter -->
		<div class="ajout_achat">
			<center><p class="title">Ajouter un achat</p></center>
			<form method="POST" action="" enctype="multipart/form-data">
				<div class="flex-container">
					<div>
						<p><strong>Produit (*)</strong></p>
						<div class="box_select">
							<select name="produit"><!-- menu déroulant des produit --> 
								<?php
									//on récupère tout les produits 
									$all_produit = $bdd->prepare("SELECT * FROM produit WHERE profil = ? ORDER BY nom ASC");
									$all_produit->execute(array($_GET['profil']));

									while ($produit = $all_produit->fetch()){//affichage de la liste des produit que peut rajouter l'utilisateur
										if($produit['remarque']!=NULL){
										?>
											<option value="<?php echo $produit['id_produit']; ?>"><?php echo $produit['nom']." (".$produit['remarque'].")"; ?></option><!-- si le produit a une remarque particulière -->
										<?php
										}else{
											?>
											<option value="<?php echo $produit['id_produit']; ?>"><?php echo $produit['nom']; ?></option><!-- si le produit n'a pas de remarque -->
											<?php
										}
									}
								?>
							</select>
						</div>
					</div>
					<div>
						<p><strong>Quantité (*)</strong></p>
						<div><input type="text" name="quantity" placeholder="Quantité"></div>
					</div>
					<div>
						<p style="opacity: 0;">Quantité</p>
						<div><input type="submit" name="submit_achat" value="Ajouter"></div>
					</div>
				</div>
			</form>
		</div>
		
	</div>
		
	<!-- BANDEAU NB ACHAT RESTANT -->
	<div class="nb_achat_restant">
		<center>
			<p class="title">A acheter</p>
			<p>Vous allez trouver la liste des achats à effectuer.</p>
			<p>Il y a eu un total de <strong><?php echo  $cptnbachatrestant;?></strong> achats à effectuer.</p>
		</center>
	</div>


	<!-- On affiche tout les produit a acheter -->
	<?php
		$all_achat = $bdd->prepare("SELECT * FROM achat_a_faire WHERE profil = ?");
		$all_achat->execute(array($_GET['profil']));
		$i=0;
		while ($achat = $all_achat->fetch()){
			$i=$i+1;
			$products = $bdd->prepare("SELECT * FROM produit WHERE id_produit = ?");
			$products->execute(array($achat['id_produit']));
			$product = $products->fetch();
			?>
			
			<div class="trait">
				<p>Article n°<strong><?php echo $i;?></strong></p>
			</div>

			<div class="article_container">

				<div class="left">
					<p class="article_name_produit"><strong>Nom Produit | </strong><?php echo $product['nom'];?></p>
					<?php
						if($achat['quantite'] != ""){
					?>
							<p class="article_quantite_produit"><strong>Quantité | </strong><?php echo $achat['quantite'];?></p>
					<?php
						}else{
							?>
							<p class="article_quantite_produit"><strong>Quantité | </strong>...</p>
							<?php
						}

						if($product['remarque'] != ""){
					?>
							<p class="article_remarque_produit"><strong>Remarque | </strong><?php echo $product['remarque'];?></p>
					<?php 
						}else{
					?>
							<p class="article_remarque_produit"><strong>Remarque | </strong>...</p>
					<?php
						}
					?>
				</div>

				<div class="article_form">
					<p><strong>Action</strong></p>
					<form action="" method="POST">
						<input type="hidden" name="id_achat" value="<?php echo $achat['id_achat'];?>">
						<!-- <input type="image" name="article_suppr" src="./delete.svg" alt="Supprimer"> -->
						<input type="submit" name="article_suppr" value="" style="background-image: url('./icone/delete.svg')">
					</form>
					<form action="" method="POST">
						<input type="hidden" name="id_achat" value="<?php echo $achat['id_achat'];?>">
						<input type="hidden" name="id_produit" value="<?php echo $product['id_produit'];?>">
						<input type="hidden" name="quantity" value="<?php echo $achat['quantite'];?>">
						<!-- <input type="image" name="article_achete" src="./buy.svg" alt="Acheter"><br> -->
						<input type="submit" name="article_achete" value=""  style="background-image: url('./icone/buy.svg')"><br>
						<input type="text" name="prix" placeholder="Prix ..." style="margin-top: 0.4em;">
					</form>
				</div>
				
				<?php
					if ($product['photo'] != NULL) {
				?>
						<div class="article_photo_produit">
							<center><img src="<?php echo $product['photo'];?>"></center>
						</div>
				<?php
					}else{
				?>
						<div class="article_photo_produit">
							<center><img src="./photo/produit/0.svg" class="sac"></center>
						</div>
				<?php
					}
				?>
			</div>
			<div class="trait"></div>

			<?php
		}
	?>

	<br><br><br><br>
</body>
</html>

<script type="text/javascript" src="./js/menu.js"></script>