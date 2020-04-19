<?php

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$prixTotal = $_GET['total'];
$solde = '';
$ID = '';
$erreur ='';

if ($db_found) {
  $sql ="SELECT * FROM acheteur WHERE Etat = 1";
  $result = mysqli_query($db_handle,$sql);
  if (mysqli_num_rows($result) == 0) {//on ne trouve pas de vendeur connecté
    echo "Erreur : pas d'utilisateur connecté";
  }else{//on trouve un vendeur connecté
      $data = mysqli_fetch_assoc($result);
      $solde = $data['Solde'];
      $ID = $data['ID'];
      $difference = $solde - $prixTotal;

      if ($difference < 0) {
        $erreur= "Vous n'avez pas assez d'argent sur votre compte, veuillez en rajouter via le bouton \"Déposer de l'argent\"";
        header('Location: monCompteAcheteur.php?erreur=' . $erreur);
      }else{
        $sql = "UPDATE acheteur SET Solde = '$difference' WHERE Etat = 1";
        $result = mysqli_query($db_handle,$sql);
        $sql = "DELETE FROM item WHERE IDAcheteur = '$ID' AND Offre ='0'";
        $result = mysqli_query($db_handle,$sql);
        $erreur = "Paiement accepté";
        header('Location: indexConnecteAcheteur.php?erreur=' . $erreur);

    }
  }
}else{
  echo "Database not found";
}
mysqli_close($db_handle);
?>