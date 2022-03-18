<header>
	<div id="hamburger">
		<div id="menu">
			<nav>
				<ul>
					<li class="gauche"><a href="./index.php?profil=1">Profil 1</a></li>
					<li class="gauche"><a href="./index.php?profil=2">Profil 2</a></li>
					<li class="gauche"><a href="./index.php?profil=3">Profil 3</a></li>
					<li class="gauche"><a href="./index.php?profil=4">Profil 4</a></li>
					
					<li class="center active"><a>Profil <?php echo $_GET['profil'];?></a></li>

					<li class="droite lisidebarbutton"><button id="sidebarbutton">&#9776;</button></li>
					<li class="droite"><a href=<?php echo "./modication_produit?profil=".$_GET['profil']?>>Produit</a></li>

				</ul>
			</nav>
		</div>
	
		<div id="sidebar">
			<div id="sidebarbody">
				<div class="sidebodytrait">
					<p>Profil</p>
				</div>
				<a href="./index.php?profil=1" class="item">Profil 1</a>
				<a href="./index.php?profil=2" class="item">Profil 2</a>
				<a href="./index.php?profil=3" class="item">Profil 3</a>
				<a href="./index.php?profil=4" class="item lastitem">Profil 4</a>
				
				<div class="sidebodytrait">
					<p>Modification</p>
				</div>
				<a href=<?php echo "./modication_produit?profil=".$_GET['profil']?> class="item lastitem">Produit</a>
			</div>
		</div>
		<div id="overlay"></div>
	</div>
</header>

<div class="header">
	<center>
		<div class="title_profil">
			<p><strong><?php echo $title;?> | Profil n°<?php echo $_GET['profil'];?></strong></p>
		</div>
		<div class="mid_trait"></div>
	</center>

	
	<div class="boxs">
		<div class="box">
			<div class="left"><input type="image" name="" src="./icone/check.svg"></div>
			<div class="right">
				<h1><strong>Achat Restant</strong></h1>
				<p>Il reste <strong><?php echo $cptnbachatrestant;?></strong> achats.</p>
			</div>
		</div>
		<div class="box boxmargin">
			<div class="left"><input type="image" name="" src="./icone/check.svg"></div>
			<div class="right">
				<h1><strong>Nombre d'achat (total)</strong></h1>
				<p>Il y a eu un total de <strong><?php echo $cptnbachatfait;?></strong> achats.</p>
			</div>
		</div>
		<div class="box boxmargin">
			<div class="left"><input type="image" name="" src="./icone/check.svg"></div>
			<div class="right">
				<h1><strong>Nombre d'achat (mois)</strong></h1>
				<p>Ce mois-ci il y a eu <strong><?php echo $cptnbachatfaitmois;?></strong> achats.</p>
			</div>
		</div>
	</div>
	

</div>