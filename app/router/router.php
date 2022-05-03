
<!-- ----- debut Router -->
<?php
require ('../controller/Controller.php');

// --- récupération de l'action passée dans l'URL
$query_string = $_SERVER['QUERY_STRING'];

// fonction parse_str permet de construire 
// une table de hachage (clé + valeur)
parse_str($query_string, $param);

// --- $action contient le nom de la méthode statique recherchée
if(!isset($param['action'])){
	$param["action"] = "listPurchaseOrder";
}

$action = htmlspecialchars($param["action"]);

//Modification du routeur pour prendre en compte l'ensemble des paramètres
$action = $param['action'];

//On supprime l'élément action de la structure
unset($param['action']);

//Tout ce qui reste sont des arguments
$args = $param;

// --- Liste des méthodes autorisées
switch ($action) {
	case 'listProduct':
 	case 'editProduct':
	case 'newProduct':
	case 'listPurchaseOrder':
	case 'removePurchaseOrder':
	case 'responsePurchaseOrder':
	case 'newPurchaseOrder':
		Controller::$action($args);
  		break;

	// Tache par défaut
	default:
		$action = "listPurchaseOrder";
		Controller::$action($args);
}
?>
<!-- ----- Fin Router -->