<header>
	<div id="hamburger">
		<div id="menu">
			<nav>
				<ul>
					<li class="gauche"><a href="router.php?action=listPurchaseOrder&profil=1">Profil 1</a></li>
					<li class="gauche"><a href="router.php?action=listPurchaseOrder&profil=2">Profil 2</a></li>
					<li class="gauche"><a href="router.php?action=listPurchaseOrder&profil=3">Profil 3</a></li>
					<li class="gauche"><a href="router.php?action=listPurchaseOrder&profil=4">Profil 4</a></li>
					
					<li class="center active"><a>Profil <?php echo $idProfil;?></a></li>

					<li class="droite lisidebarbutton"><button id="sidebarbutton">&#9776;</button></li>
					<li class="droite"><a href=<?php echo "router.php?action=listProduct&profil=".$idProfil?> >Produit</a></li>

				</ul>
			</nav>
		</div>
	
		<div id="sidebar">
			<div id="sidebarbody">
				<div class="sidebodytrait">
					<p>Profil</p>
				</div>
				<a href="router.php?action=listPurchaseOrder&profil=1" class="item">Profil 1</a>
				<a href="router.php?action=listPurchaseOrder&profil=2" class="item">Profil 2</a>
				<a href="router.php?action=listPurchaseOrder&profil=3" class="item">Profil 3</a>
				<a href="router.php?action=listPurchaseOrder&profil=4" class="item lastitem">Profil 4</a>
				
				<div class="sidebodytrait">
					<p>Modification</p>
				</div>
				<a href=<?php echo "router.php?action=listProduct&profil=".$idProfil?> class="item lastitem">Produit</a>
			</div>
		</div>
		<div id="overlay"></div>
	</div>
</header>