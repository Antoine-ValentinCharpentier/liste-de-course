<div class="header">
	<center>
		<div class="title_profil">
			<p><strong><?php echo $title;?> | Profil n°<?php echo $idProfil;?></strong></p>
		</div>
		<div class="mid_trait"></div>
	</center>

	
	<div class="boxs">
		<div class="box">
			<div class="left"><input type="image" name="" src="../../app/view/icone/check.svg"></div>
			<div class="right">
				<h1><strong>Achat Restant</strong></h1>
				<p>Il reste <strong><?php echo $cptNbAchatRestant;?></strong> achats.</p>
			</div>
		</div>
		<div class="box boxmargin">
			<div class="left"><input type="image" name="" src="../../app/view/icone/check.svg"></div>
			<div class="right">
				<h1><strong>Nombre d'achat (total)</strong></h1>
				<p>Il y a eu un total de <strong><?php echo $cptNbAchatFait;?></strong> achats.</p>
			</div>
		</div>
		<div class="box boxmargin">
			<div class="left"><input type="image" name="" src="../../app/view/icone/check.svg"></div>
			<div class="right">
				<h1><strong>Nombre d'achat (mois)</strong></h1>
				<p>Ce mois-ci il y a eu <strong><?php echo $cptNbAchatFaitMois;?></strong> achats.</p>
			</div>
		</div>
	</div>
	
</div>