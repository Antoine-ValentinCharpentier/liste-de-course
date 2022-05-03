
<!-- ----- debut Controller -->
<?php
require_once '../model/ModelProduct.php';

class Controller {

	public static function listProduct($args){

		if(isset($_GET['profil'])){
			$idProfil = $_GET['profil'];
		}else{
			$idProfil = 1;
		}

		$cptNbAchatRestant = ModelProduct::nbAchatRestant($idProfil);
		$cptNbAchatFait = ModelProduct::nbAchatRealise($idProfil);
		$cptNbAchatFaitMois = ModelProduct::nbAchatRealiseMois($idProfil);

		$title = "EDIT PRODUIT";

		$listeAchats = ModelProduct::listeAchats($idProfil);
		$listeProduits = ModelProduct::listeProduits($idProfil);

		// ----- Construction chemin de la vue
		include 'config.php';
		$vue = $root . '/app/view/ViewEditProduct.php';
		require ($vue);
	}

	public static function editProduct($args){

		if(isset($_GET['profil'])){
			$idProfil = $_GET['profil'];
		}else{
			$idProfil = 1;
		}

		$cptNbAchatRestant = ModelProduct::nbAchatRestant($idProfil);
		$cptNbAchatFait = ModelProduct::nbAchatRealise($idProfil);
		$cptNbAchatFaitMois = ModelProduct::nbAchatRealiseMois($idProfil);

		$title = "EDIT PRODUIT";

		$idProduit = htmlspecialchars($_POST['id_produit']);

		if(isset($_POST['submit_supression_produit'])){
			//on supprime les achats associés au produit que l'on veut supprimer
			ModelProduct::suppressionAchatViaProduit($idProduit);
			//on supprime le produit de la base de donnée
			ModelProduct::suppressionProduit($idProduit);
		}

		if (isset($_POST['submit_modification_produit'])) {
			$produit = ModelProduct::getInfosProduit($idProduit)[0];
			print_r($produit);
			echo "nom = ".$produit["nom"];
			if ($_POST['name_produit'] != $produit['nom']) {
				if(strlen($_POST['name_produit']) < 255){
					$name = htmlspecialchars($_POST['name_produit']);
					$idProduit = htmlspecialchars($_POST['id_produit']);
					ModelProduct::updateNomProduit($name,$idProduit);
					echo "Nom update";
				}else{
					$error = "Veuillez saisir un nom avec au maximum 255 caractères.";
				}
			}

			if ($_POST['remarque_produit'] != $produit['remarque']) {
				if(strlen($_POST['remarque_produit']) < 255){
					$remarque = htmlspecialchars($_POST['remarque_produit']);
					$idProduit = htmlspecialchars($_POST['id_produit']);
					ModelProduct::updateRemarqueProduit($remarque,$idProduit);
					echo "remarque update";
				}else{
					$error = "Veuillez saisir une remarque avec au maximum 255 caractères.";
				}
			}



			$chemin_photo_produit= "";//stocke le chemin pour aceder a la photo une fois upload
	    	
	    	if(!empty($_FILES['photo_produit'])){
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
		                $id_new_produit = htmlspecialchars($_POST['id_produit']);

						$chemin_photo_produit = $id_new_produit.".".strtolower(end($extension));

		                // On bouge l'image uploadé dans le dossier upload
		                move_uploaded_file($tmpFile, '../../public/photo/produit/'.$chemin_photo_produit);

		                /**   on retire les images deja présente au paravant, qui ne seront pas écrasée **/
		                if($extension == "jpg"){
		                   if(file_exists('../../public/photo/produit/'.$id_new_produit.".jpeg")) unlink ('../../public/photo/produit/'.$id_new_produit.".jpeg");
		                   if(file_exists('../../public/photo/produit/'.$id_new_produit.".gif")) unlink ('../../public/photo/produit/'.$id_new_produit.".gif");
		                   if(file_exists('../../public/photo/produit/'.$id_new_produit.".png")) unlink ('../../public/photo/produit/'.$id_new_produit.".png");
		                }
		                if($extension == "jpeg"){
		                   if(file_exists('../../public/photo/produit/'.$id_new_produit.".jpg")) unlink ('../../public/photo/produit/'.$id_new_produit.".jpg");
		                   if(file_exists('../../public/photo/produit/'.$id_new_produit.".gif")) unlink ('../../public/photo/produit/'.$id_new_produit.".gif");
		                   if(file_exists('../../public/photo/produit/'.$id_new_produit.".png")) unlink ('../../public/photo/produit/'.$id_new_produit.".png");
		                }
		                if($extension == "png"){
		                   if(file_exists('../../public/photo/produit/'.$id_new_produit.".jpg")) unlink ('../../public/photo/produit/'.$id_new_produit.".jpg");
		                   if(file_exists('../../public/photo/produit/'.$id_new_produit.".jpeg")) unlink ('../../public/photo/produit/'.$id_new_produit.".jpeg");
		                   if(file_exists('../../public/photo/produit/'.$id_new_produit.".gif")) unlink ('../../public/photo/produit/'.$id_new_produit.".gif");
		                }

		               	ModelProduct::updatePhotoProduit($chemin_photo_produit,$id_new_produit);
		            }
		        }
		    }
		}

		$listeAchats = ModelProduct::listeAchats($idProfil);
		$listeProduits = ModelProduct::listeProduits($idProfil);

		// ----- Construction chemin de la vue
		include 'config.php';
		$vue = $root . '/app/view/ViewEditProduct.php';
		require ($vue);
	}

	public static function listPurchaseOrder($args){

		if(isset($_GET['profil'])){
			$idProfil = $_GET['profil'];
		}else{
			$idProfil = 1;
		}

		$cptNbAchatRestant = ModelProduct::nbAchatRestant($idProfil);
		$cptNbAchatFait = ModelProduct::nbAchatRealise($idProfil);
		$cptNbAchatFaitMois = ModelProduct::nbAchatRealiseMois($idProfil);

		$title = "ACHETER";

		$listeAchats = ModelProduct::listeAchats($idProfil);
		$listeProduits = ModelProduct::listeProduits($idProfil);

		// ----- Construction chemin de la vue
		include 'config.php';
		$vue = $root . '/app/view/ViewListProduct.php';
		require ($vue);
	}

	public static function newProduct($args){

		if(isset($_GET['profil'])){
			$idProfil = $_GET['profil'];
		}else{
			$idProfil = 1;
		}

		//s'il envoit un formulaire pour créer un nouveau produit
    	if(!empty($_POST['name_produit'])){ 
			//on ajoute + 1 car on a récupéré le dernier produit ajouter précédemment, donc l'id de celui que l'on va rajouté aura un id+1
			$id_new_produit = ModelProduct::dernierIndiceProduit()+1;

	      	$nom_produit = htmlspecialchars($_POST['name_produit']);
			//on regarde s'il n'est pas trop long
			if(strlen($nom_produit) > 255){
	    		$error = "Le nom du produit rentré est trop long (MAX 255 caractère)";
	    	}
	    	//on récupère la remarque associé au produit, celui-ci est vide s'il n'y a rien écrit dans ce champ
	    	$remarque_produit = htmlspecialchars($_POST['remarque_produit']);
	    
	    	$chemin_photo_produit= "";//stocke le chemin pour aceder a la photo une fois upload
	    	
	    	if(!empty($_FILES['photo_produit'])){
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

						$chemin_photo_produit = $id_new_produit.".".strtolower(end($extension));

		                // On bouge l'image uploadé dans le dossier upload
		                move_uploaded_file($tmpFile, '../../public/photo/produit/'.$chemin_photo_produit);
		            }
		        }
		    }

			//on ajoute le produit dans la bdd
			if(strlen($nom_produit) <= 255){
	    		ModelProduct::ajoutProduit($id_new_produit,$nom_produit,$remarque_produit,$chemin_photo_produit,$idProfil);
				$error = "Le produit vient d'être ajouté dans la liste des produits.";
	    	}

    	}else{
      		$error="Veuillez écrire le nom du produit (MAX 255 caractères)";
    	}

		$cptNbAchatRestant = ModelProduct::nbAchatRestant($idProfil);
		$cptNbAchatFait = ModelProduct::nbAchatRealise($idProfil);
		$cptNbAchatFaitMois = ModelProduct::nbAchatRealiseMois($idProfil);

		$title = "ACHETER";

		$listeAchats = ModelProduct::listeAchats($idProfil);
		$listeProduits = ModelProduct::listeProduits($idProfil);

		// ----- Construction chemin de la vue
		include 'config.php';
		$vue = $root . '/app/view/ViewListProduct.php';
		require ($vue);
	}


    public static function newPurchaseOrder($args){

		if(isset($_GET['profil'])){
			$idProfil = $_GET['profil'];
		}else{
			$idProfil = 1;
		}

		//on regarde s'il a sélectionné un produit
		if(!empty($_POST['produit'])){
			$idProduit = htmlspecialchars($_POST['produit']);
			$quantite = "";
			//on regarde s'il a sélectionné une quantité
			if(!empty($_POST['quantity'])){
				$quantite = htmlspecialchars($_POST['quantity']);
			}
			$result = ModelProduct::ajoutAchat($idProduit,$quantite,$idProfil);
			$error = "Votre demande d'achat a bien été prit en compte.";
		}else{
			$error = "Veuillez saisir un produit dans le menu déroulant.";
		}

		$cptNbAchatRestant = ModelProduct::nbAchatRestant($idProfil);
		$cptNbAchatFait = ModelProduct::nbAchatRealise($idProfil);
		$cptNbAchatFaitMois = ModelProduct::nbAchatRealiseMois($idProfil);

		$title = "ACHETER";

		$listeAchats = ModelProduct::listeAchats($idProfil);
		$listeProduits = ModelProduct::listeProduits($idProfil);

		// ----- Construction chemin de la vue
		include 'config.php';
		$vue = $root . '/app/view/ViewListProduct.php';
		require ($vue);
	}



	public static function removePurchaseOrder($args){

		if(isset($_GET['profil'])){
			$idProfil = $_GET['profil'];
		}else{
			$idProfil = 1;
		}

		if(isset($_POST['id_achat'])){
			$idAchat = htmlspecialchars($_POST['id_achat']);
			ModelProduct::supprimerAchat($idAchat);
		}

		$cptNbAchatRestant = ModelProduct::nbAchatRestant($idProfil);
		$cptNbAchatFait = ModelProduct::nbAchatRealise($idProfil);
		$cptNbAchatFaitMois = ModelProduct::nbAchatRealiseMois($idProfil);

		$title = "ACHETER";

		$listeAchats = ModelProduct::listeAchats($idProfil);
		$listeProduits = ModelProduct::listeProduits($idProfil);

		// ----- Construction chemin de la vue
		include 'config.php';
		$vue = $root . '/app/view/ViewListProduct.php';
		require ($vue);
	}

	public static function responsePurchaseOrder($args){

		if(isset($_GET['profil'])){
			$idProfil = $_GET['profil'];
		}else{
			$idProfil = 1;
		}

		//on insert le produit dans la base de données (pour éventuellement ajouter par la suite une fonctionalité pour voir les produits déjà acheté)
		$idProduit = htmlspecialchars($_POST['id_produit']);
		$quantite = htmlspecialchars($_POST['quantity']);
		$prix = 0;
		if(!empty($_POST['prix'])){
			$prix = htmlspecialchars($_POST['prix']);	
		}
		ModelProduct::ajoutAchatRealise($idProduit,$quantite,$prix,$idProfil);

		if(isset($_POST['id_achat'])){
			$idAchat = htmlspecialchars($_POST['id_achat']);
			ModelProduct::supprimerAchat($idAchat);
		}
		



		$cptNbAchatRestant = ModelProduct::nbAchatRestant($idProfil);
		$cptNbAchatFait = ModelProduct::nbAchatRealise($idProfil);
		$cptNbAchatFaitMois = ModelProduct::nbAchatRealiseMois($idProfil);

		$title = "ACHETER";

		$listeAchats = ModelProduct::listeAchats($idProfil);
		$listeProduits = ModelProduct::listeProduits($idProfil);

		// ----- Construction chemin de la vue
		include 'config.php';
		$vue = $root . '/app/view/ViewListProduct.php';
		require ($vue);
	}


}
?>
<!-- ----- fin Controller -->


