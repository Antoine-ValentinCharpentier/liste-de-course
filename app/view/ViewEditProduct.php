<html>
<head>
	<title>course</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../public/css/modification.css">
	<link rel="stylesheet" type="text/css" href="../../public/css/anim.css"/>
	<link rel="stylesheet" type="text/css" href="../../public/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="../../public/css/menu.css"/>

	<style type="text/css">
		
	</style>
</head>
<body>
	<?php
	include $root . '/app/view/fragments/menu.php';
	include $root . '/app/view/fragments/header.php';
	?>

	<div class="modic_prod">
		<?php
			$i=0;
			foreach ($listeProduits as $produit){
				$i=$i+1;
				?>
				<div class="trait">
					<p>Produit n°<strong><?php echo $i;?></strong></p>
				</div>
				<form method="POST" action=<?php echo "router.php?action=editProduct&profil=".$idProfil;?> enctype="multipart/form-data">
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
							<center><img src="<?php echo "../../public/photo/produit/".$produit['photo'];?>"></center>
							<center><input type="file" name="photo_produit" value="upload une photo" id="photo_produit_id"></center>
						</div>
						<?php
							}else{
						?>
						<div class="article_photo_produit">
							<center><img src="../../app/view/icone/sac.svg"></center>
							<center><input type="file" name="photo_produit" value="upload une photo" id="photo"></center>
						</div>
						<?php
							}
						?>

						<div class="article_form">
							<p><strong>Action</strong></p>
							<input type="submit" name="submit_supression_produit" value="" style="background-image: url('../../app/view/icone/delete.svg')"><br>
							<input type="submit" name="submit_modification_produit" value="" style="background-image: url('../../app/view/icone/gear.svg')">
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