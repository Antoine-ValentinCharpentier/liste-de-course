<?php	
	include "../db.php";
	//si il envoit un formulaire
	if(isset($_POST['submit_produit'])){
      if(!empty($_POST['name_produit'])){ 
      	$nom_produit = htmlspecialchars($_POST['name_produit']);
		//on regarde s'il n'est pas trop long
		if(strlen($nom_produit) > 255){
    		$error = "Le nom du produit rentré est trop long (MAX 255 caractère)";
    	}
    	//on récupère la remarque associé au produit, celui-ci est vide s'il n'y a rien écrit dans ce champ
    	$remarque_produit = htmlspecialchars($_POST['remarque_produit']);
    
    	$chemin_photo_produit= "";//stocke le chemin pour aceder a la photo une fois upload

    	if(isset($_FILES['photo_produit']) AND !empty($_FILES['photo_produit']['name'])){//si une photo est rentré
			$taillemax_produit = 25165824; /** Taille maximal de la photo du produit en bits **/
			$extensions_valides = array('jpg','jpeg','png');//les extensions que peuvent prendre les photos des produits

			if($_FILES['photo_produit']['size'] <= $taillemax_produit){//on regarde si la photo n'est pas trop lourde
				$extension_upload = strtolower(substr(strrchr($_FILES['photo_produit']['name'], '.'), 1));//strtolower= tout une minuscule;  subste = ne prend pas en compte un caractère; strrchr : récupère l'extension de la photo du produit, ON NE RECUPERE DOCN QUE L'EXTENSION DE LA PHOTO SANS LE POINT

				if(in_array($extension_upload, $extensions_valides)){//si l'extension de l'image appartient au tableau des extensions valides
					//on recherche l'id du produit que l'on va ajouter, pour se faire on récupère l'id du dernier produit rajouté
					$req_id_last_produit = $bdd->prepare("SELECT max(id_produit) FROM produit");
					$req_id_last_produit->execute();
					$id_last_produit = $req_id_last_produit->fetch();
					//on ajoute + 1 car on a récupéré le dernier produit ajouter précédemment, donc l'id de celui que l'on va rajouté aura un id+1
					$id_new_produit = $id_last_produit['max(id_produit)']+1;

					$chemin_photo_produit = "photo/produit/".$id_new_produit.".".$extension_upload;
					$resultat = move_uploaded_file($_FILES['photo_produit']['tmp_name'], $chemin_photo_produit);

					if($resultat){//si le déplacement a bien était effectué (dans les dossiers du serv)
						$chemin_photo_produit = $id_new_produit.".".$extension_upload;
					}else{
						$error = "Une erreur est survenue lors de l'envoi de l'avatar !";
					}
				}else{
					$error = "Votre avatar doit être au format : jpg, jpeg, png";
				}
			}else{
				$error = "Votre photo du produit est trop lourd ! Celle-ci ne doit pas dépasser 2 Mo !";
			}
		}
		//on ajoute le produit dans la bdd
	    $add_produit = $bdd->prepare('INSERT INTO produit(id_produit, nom, remarque, photo, suppr, profil) VALUES (NULL,?,?,?,?,?)');
		$add_produit->execute(array($nom_produit,$remarque_produit,$chemin_photo_produit,0,$_GET['profil']));
		$error = "Le produit vien d'être ajouté dans la liste des produits.";
		//suppr vaut 0 quand le produit est encore présent et 1 quand il est masqué  

      }else{
      	$error="Veuillez écrire le nom du produit (MAX 255 caractères)";
      }
    }
    header("Location: ../index.php?profil".$_GET['profil'])
?>