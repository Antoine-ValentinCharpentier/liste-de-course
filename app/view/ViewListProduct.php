<html>
<head>
	<title>course</title>
	<meta charset="utf-8">
	
	<link rel="stylesheet" type="text/css" href="../../public/css/anim.css"/>
	<link rel="stylesheet" type="text/css" href="../../public/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="../../public/css/menu.css"/>
	
</head>

<body>

	<?php
	include $root . '/app/view/fragments/menu.php';
	include $root . '/app/view/fragments/header.php';
	?>

	<div class="add_produit_achat">
		<!-- formulaire ajout produit dans la liste des différent produits -->
		<div class="ajout_produit">
			<center><p class="title">Ajouter un produit</p></center>
			<form method="POST" action=<?php echo "router.php?action=newProduct&profil=".$idProfil;?> enctype="multipart/form-data">
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
			<form method="POST" action=<?php echo "router.php?action=newPurchaseOrder&profil=".$idProfil;?> enctype="multipart/form-data">
				<div class="flex-container">
					<div>
						<p><strong>Produit (*)</strong></p>
						<div class="box_select">
							<select name="produit"><!-- menu déroulant des produit --> 
								<?php
									//on récupère tout les produits 
									foreach ($listeProduits as $produit){//affichage de la liste des produit que peut rajouter l'utilisateur
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
			<p>Vous allez accéder à la liste des achats à effectuer.</p>
			<p>Il y a un total de <strong><?php echo  $cptNbAchatRestant;?></strong> achats à effectuer.</p>
		</center>
	</div>


	<!-- On affiche tout les produit a acheter -->
	<?php
		$i = 0;
		foreach($listeAchats as $achat){
			$i = $i+1;
			?>
			
			<div class="trait">
				<p>Article n°<strong><?php echo $i;?></strong></p>
			</div>

			<div class="article_container">

				<div class="left">
					<p class="article_name_produit"><strong>Nom Produit | </strong><?php echo $achat['nom'];?></p>
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

						if($achat['remarque'] != ""){
					?>
							<p class="article_remarque_produit"><strong>Remarque | </strong><?php echo $achat['remarque'];?></p>
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
					<form action=<?php echo "router.php?action=removePurchaseOrder&profil=".$idProfil;?> method="POST">
						<input type="hidden" name="id_achat" value="<?php echo $achat['id_achat'];?>">
						<input type="submit" name="article_suppr" value="" style="background-image: url('../../app/view/icone/delete.svg')">
					</form>
					<form action=<?php echo "router.php?action=responsePurchaseOrder&profil=".$idProfil;?> method="POST">
						<input type="hidden" name="id_achat" value="<?php echo $achat['id_achat'];?>">
						<input type="hidden" name="id_produit" value="<?php echo $achat['id_produit'];?>">
						<input type="hidden" name="quantity" value="<?php echo $achat['quantite'];?>">
						<input type="submit" name="article_achete" value=""  style="background-image: url('../../app/view/icone/buy.svg')"><br>
						<input type="text" name="prix" placeholder="Prix ..." style="margin-top: 0.4em;">
					</form>
				</div>
				
				<?php
					if ($achat['photo'] != NULL) {
				?>
						<div class="article_photo_produit">
							<center><img src="<?php echo "../../public/photo/produit/".$achat['photo'];?>"></center>
						</div>
				<?php
					}else{
				?>
						<div class="article_photo_produit">
							<center><img src="../../app/view/icone/sac.svg" class="sac"></center>
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

<script type="text/javascript" src="../../public/js/menu.js"></script>