<?php

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$IDAcheteur ='';
$erreurObjet ='';
$erreurObjetPanier ='';
$erreurObjetNegoEnCours ='';
$erreurObjetNegoReponse ='';
$erreurObjetNegoFin ='';
$erreurObjetEnchereFin ='';
$prixTotal = 0;

if ($db_found) {
  $sql ="SELECT * FROM acheteur WHERE Etat = 1";
  $result = mysqli_query($db_handle,$sql);
  if (mysqli_num_rows($result) == 0) {//on ne trouve pas de vendeur connecté
    echo "Erreur : pas d'utilisateur connecté";
  }else{//on trouve un vendeur connecté
    $data = mysqli_fetch_assoc($result);
    $IDAcheteur = $data['ID'];
    $sql ="SELECT * FROM item WHERE IDAcheteur = '$IDAcheteur'";
    $result = mysqli_query($db_handle,$sql);
    $result2 = mysqli_query($db_handle,$sql);
    $result3 = mysqli_query($db_handle,$sql);
    $result4 = mysqli_query($db_handle,$sql);
    $result5 = mysqli_query($db_handle,$sql);
    if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objets à vendre
    $erreurObjet = "Vous n'avez pas d'objets dans votre panier, parcourez le site pour en trouver !";
    }else{//on trouve des objets à vendre
      $sql = "SELECT SUM(prix) AS prix_total FROM item WHERE IDAcheteur = '$IDAcheteur' AND Offre = '0'";
      $result = mysqli_query($db_handle,$sql);
      $total = mysqli_fetch_assoc($result);
      $prixTotal = $total['prix_total'];
      $sql =  "SELECT * FROM item WHERE IDAcheteur = '$IDAcheteur' AND Offre = '0'";
      $result = mysqli_query($db_handle,$sql);
      if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objets à vendre
        $erreurObjetPanier = "Vous n'avez pas ajouté d'objets dans votre panier";
      }
      $sql =  "SELECT * FROM item WHERE IDAcheteur = '$IDAcheteur' AND Nego = '1'";
      $result2 = mysqli_query($db_handle,$sql);
      if (mysqli_num_rows($result2) == 0) {//on ne trouve pas d'objets à vendre
        $erreurObjetNegoFin = "Vous n'avez pas encore conclu de négociations";
      }
      $sql =  "SELECT * FROM item WHERE IDAcheteur = '$IDAcheteur' AND Offre != '0' AND ContreOffre = '0'";
      $result3 = mysqli_query($db_handle,$sql);
      if (mysqli_num_rows($result3) == 0) {//on ne trouve pas d'objets à vendre
        $erreurObjetNegoEnCours = "Vous n'avez pas commencé à négocier pour un objet";
      }
      $sql =  "SELECT * FROM item WHERE IDAcheteur = '$IDAcheteur' AND ContreOffre != '0'";
      $result4 = mysqli_query($db_handle,$sql);
      if (mysqli_num_rows($result4) == 0) {//on ne trouve pas d'objets à vendre
        $erreurObjetNegoReponse = "Vous n'attendez pas de réponse d'un vendeur pour une négociation";
      }
      $sql =  "SELECT * FROM item WHERE IDAcheteur = '$IDAcheteur' AND EtatEnchere = '1'";
      $result5 = mysqli_query($db_handle,$sql);
      if (mysqli_num_rows($result5) == 0) {//on ne trouve pas d'objets à vendre
        $erreurObjetPanier = "Vous n'avez pas encore conclu d'enchères";
      }
    }
  }
}else{
  echo "Database not found";
}
mysqli_close($db_handle);
?>



<!DOCTYPE html>
<head>
  <title>Midgard</title>
  <meta charset="utf-8">
  <!--  intégration de Bootstrap *-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- Fichier css *-->
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="jumbotron">
    <div class="container text-center">
      <h1>&nbsp &nbsp &nbsp M I D G A R D</h1>
    </div>
  </div>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <a class="navbar-brand" href="indexConnecteAcheteur.php?erreur=0"><img src="images/logo.png" style="margin-top: -11px" width="40px" height="40px"></a>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="indexConnecteAcheteur.php?erreur=0">Home</a></li>
          <li><a href="acheter.php">Acheter</a></li>
          <li class="dropdown" >
            <a class="dropdown-toggle" data-toggle="dropdown">Catégories
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="tresor.php">Objets communs</a></li>
              <li><a href="relique.php">Reliques</a></li>
              <li><a href="vip.php">Objets de valeur</a></li>
            </ul>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li><a href="monCompteAcheteur.php?erreur=0"><span class="glyphicon glyphicon-user"></span> Mon compte</a></li>
          <li><a href="deco.php"><span class="glyphicon glyphicon-off"></span> Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container"> 
    <div class="lepanier">
      <?php
      echo "<p>Votre panier <span class='glyphicon glyphicon-shopping-cart'></span></p>";
      echo "<p>" .$erreurObjetPanier . "</p>";
      while ($objets = mysqli_fetch_assoc($result)) {
        if ($objets['Nego'] == 0 && $objets['EtatEnchere'] != 1) {
          echo "<div class='col-sm-4'>";
          echo "<div class='panel panel-default'>";
          echo"<div class='panel-heading'>" .$objets['Nom'] . "<a href='removeItemPanier.php?id=" . $objets['ID'] . "'><span class='glyphicon glyphicon-remove' title='Supprimer article'></span></a>" . "</div>";
          echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
          echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['Prix'] . " Ø" . "</div>";
          echo "</div>";
          echo "</div>";
        }
      }
      ?>
    </div>
  </div>

  <div class="container"> 
    <div class="lepanier">
      <?php
      echo "<p>Vos négociations en cours <span class='glyphicon glyphicon-time'></span></p>";
      echo "<p>" .$erreurObjetNegoEnCours . "</p>";
      while ($objets = mysqli_fetch_assoc($result3)) {
          echo "<div class='col-sm-4'>";
          echo "<div class='panel panel-default'>";
          echo"<div class='panel-heading'>" .$objets['Nom'] . "<a href='removeItemPanier.php?id=" . $objets['ID'] . "'><span class='glyphicon glyphicon-remove' title='Supprimer article'></span></a>" . "</div>";
          echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
          echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['Prix'] . " Ø" . "</div>";
          echo "</div>";
          echo "</div>";
      }
      ?>
    </div>
  </div>

  <div class="container"> 
    <div class="lepanier">
      <?php
      echo "<p>Réponse du vendeur pour vos négociations <span class='glyphicon glyphicon-time'></span></p>";
      echo "<p>" .$erreurObjetNegoReponse . "</p>";
      while ($objets = mysqli_fetch_assoc($result4)) {
          echo "<div class='col-sm-4'>";
          echo "<div class='panel panel-default'>";
          echo"<div class='panel-heading'>" .$objets['Nom'] . '<a title="Accepter l\'offre " href="accepterOffre.php?id=' . $objets['ID'] . '"><span class="glyphicon glyphicon-ok-sign"></span></a> <a title="Proposer une contre-offre " style="margin-left: 16px" href="refuserOffreAcheteur.php?id=' . $objets['ID'] . '"><span class="glyphicon glyphicon-remove-sign"></span></a>' . "</div>";
          echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
          echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['ContreOffre'] . " Ø" . "</div>";
          echo "</div>";
          echo "</div>";
      }
      ?>
    </div>
  </div>

  <div class="container"> 
    <div class="lepanier">
      <p>Vos négociations abouties <span class='glyphicon glyphicon-ok'></span></p>
      <?php
      echo "<p>" .$erreurObjetNegoFin . "</p>";
      while ($objets = mysqli_fetch_assoc($result2)) {
          echo "<div class='col-sm-4'>";
          echo "<div class='panel panel-default'>";
          echo"<div class='panel-heading'>" .$objets['Nom'] . "</div>";
          echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
          echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['Prix'] . " Ø" . "</div>";
          echo "</div>";
          echo "</div>";
        }
      ?>
    </div>
  </div>

  <div class="container"> 
    <div class="lepanier">
      <p>Vos enchères réussies <span class='glyphicon glyphicon-ok'></span></p>
      <?php
      echo "<p>" .$erreurObjetEnchereFin . "</p>";
      while ($objets = mysqli_fetch_assoc($result5)) {
          echo "<div class='col-sm-4'>";
          echo "<div class='panel panel-default'>";
          echo"<div class='panel-heading'>" .$objets['Nom'] . "</div>";
          echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
          echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['Prix'] . " Ø" . "</div>";
          echo "</div>";
          echo "</div>";
        }
      ?>
    </div>
  </div>

  <div class="totalPaiement">
    <?php echo $erreurObjet; ?>
    <?php 
    if ($erreurObjet == '') {
      echo "<p>Le montant de votre panier est de :". $prixTotal . " Øre</p>";
      echo "<a href='paiementImmediat.php?total=". $prixTotal . "'><input type='submit' name='payer' value='Effectuer le paiement'></a>";
    }
    ?>            
  </div>
  
  <footer class="page-footer">
    <div class="container-fluid">
      <img src="images/logo.png" width="100px" height="100px">
      <p><strong>M I D G A R D</strong></p>  
      <div class="cvg">
        <p>
          <a href="#" class ="cvg">Conditions générales de vente</a>
          &nbsp &nbsp &nbsp
          <a href="#" class ="cvg">Vos informations personnelles</a>
          &nbsp &nbsp &nbsp
          © 2020, Midgard Inc. 
        </p>
      </div>
    </div>

  </footer>

</body>
</html>