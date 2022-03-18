<?php	
	include "../db.php";
	//si il envoit un formulaire
	if(isset($_POST['submit_achat'])){
		if (isset($_POST['quantity'])) {
			if($_POST['produit'] != NULL){
				$add_achat = $bdd->prepare('INSERT INTO achat_a_faire(id_achat, id_produit,quantite, profil) VALUES (NULL,?,?,?)');
				$add_achat->execute(array($_POST['produit'],$_POST['quantity'],$_GET['profil']));
				$error = "Votre demande d'achat a bien été prit en compte.";
			}else{
				$error = "Veuillez saisir un produit dans le menu déroulant.";
			}
		}else{
			$error = "Veuillez saisir une quantité";
		}
    }
    header("Location: ../index.php?profil".$_GET['profil'])
?>