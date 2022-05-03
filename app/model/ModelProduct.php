<!-- ----- debut ModelProduct -->

<?php
require_once 'Model.php';

class ModelProduct {


  public static function nbAchatRestant($idProfil) {
    try {
      $database = Model::getInstance();
      $query = "SELECT * FROM achat_a_faire WHERE profil = ?";
      $statement = $database->prepare($query);
      $statement->execute(array($idProfil));
      $results = $statement->rowCount();

      return $results;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function nbAchatRealise($idProfil) {
    try {
      $database = Model::getInstance();
      $query = "SELECT * FROM achat_realiser WHERE profil = ?";
      $statement = $database->prepare($query);
      $statement->execute(array($idProfil));
      $results = $statement->rowCount();

      return $results;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function nbAchatRealiseMois($idProfil) {
    try {
      $database = Model::getInstance();
      $query = "SELECT * FROM achat_realiser WHERE profil = ? AND MONTH(date_achat) = MONTH(CURDATE())";
      $statement = $database->prepare($query);
      $statement->execute(array($idProfil));
      $results = $statement->rowCount();

      return $results;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function listeAchats($idProfil) {
    try {

      $database = Model::getInstance();
      $query = "SELECT * FROM achat_a_faire a, produit p WHERE a.profil = ? AND a.id_produit = p.id_produit";
      $statement = $database->prepare($query);
      $statement->execute(array($idProfil));
      $results = $statement->fetchAll(PDO::FETCH_ASSOC);

      return $results;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function listeProduits($idProfil) {
    try {

      $database = Model::getInstance();
      $query = "SELECT * FROM produit p WHERE p.profil = ?";
      $statement = $database->prepare($query);
      $statement->execute(array($idProfil));
      $results = $statement->fetchAll(PDO::FETCH_ASSOC);

      return $results;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function dernierIndiceProduit() {
    try {
      $database = Model::getInstance();
      $query = "SELECT max(id_produit) FROM produit";
      $statement = $database->prepare($query);
      $statement->execute();
      $results = $statement->fetch();

      return $results['max(id_produit)'];
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function ajoutProduit($id,$name,$remarque,$url,$idProfil) {
    try {

      $database = Model::getInstance();
      $query = 'INSERT INTO produit(id_produit,nom, remarque, photo, profil) VALUES (?,?,?,?,?)';
      $statement = $database->prepare($query);
      $statement->execute(array($id,$name,$remarque,$url,$idProfil));

      return True;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function ajoutAchat($idProduit,$quantite,$idProfil) {
    try {
      $database = Model::getInstance();
      $query = 'INSERT INTO achat_a_faire(id_produit,quantite, profil) VALUES (?,?,?)';
      $statement = $database->prepare($query);
      $statement->execute(array($idProduit,$quantite,$idProfil));
      return True;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function supprimerAchat($idAchat) {
    try {
      $database = Model::getInstance();
      $query = 'DELETE FROM achat_a_faire WHERE id_achat = ?';
      $statement = $database->prepare($query);
      $statement->execute(array($idAchat));
      return True;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function suppressionProduit($idProduit) {
    try {
      $database = Model::getInstance();
      $query = 'DELETE FROM produit WHERE id_produit = ?';
      $statement = $database->prepare($query);
      $statement->execute(array($idProduit));
      return True;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }
  public static function suppressionAchatViaProduit($idProduit) {
    try {
      $database = Model::getInstance();
      $query = 'DELETE FROM achat_a_faire WHERE id_produit = ?';
      $statement = $database->prepare($query);
      $statement->execute(array($idProduit));

      $query2 = 'DELETE FROM achat_realiser WHERE id_produit = ?';
      $statement2 = $database->prepare($query2);
      $statement2->execute(array($idProduit));
      return True;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }


  public static function ajoutAchatRealise($idProduit,$quantite,$prix,$idProfil) {
    try {
      $database = Model::getInstance();
      $query = 'INSERT INTO achat_realiser(id_produit,quantite, prix, profil) VALUES (?,?,?,?)';
      $statement = $database->prepare($query);
      $statement->execute(array($idProduit,$quantite,$prix,$idProfil));
      return True;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function getInfosProduit($idProduit) {
    try {

      $database = Model::getInstance();
      $query = "SELECT * FROM produit p WHERE p.id_produit = ?";
      $statement = $database->prepare($query);
      $statement->execute(array($idProduit));
      $results = $statement->fetchAll(PDO::FETCH_ASSOC);

      return $results;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function updateNomProduit($name,$idProduit) {
    try {
      $database = Model::getInstance();
      $query = 'UPDATE produit SET nom = ? WHERE id_produit = ?';
      $statement = $database->prepare($query);
      $statement->execute(array($name,$idProduit));
      return True;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }

  public static function updateRemarqueProduit($remarque,$idProduit) {
    try {
      $database = Model::getInstance();
      $query = 'UPDATE produit SET remarque = ? WHERE id_produit = ?';
      $statement = $database->prepare($query);
      $statement->execute(array($remarque,$idProduit));
      return True;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }
  
  public static function updatePhotoProduit($urlPhoto,$idProduit) {
    try {
      $database = Model::getInstance();
      $query = 'UPDATE produit SET photo = ? WHERE id_produit = ?';
      $statement = $database->prepare($query);
      $statement->execute(array($urlPhoto,$idProduit));
      return True;
    } catch (PDOException $e) {
      printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
      return NULL;
    }
  }
}
?>
<!-- ----- fin ModelProduct -->


