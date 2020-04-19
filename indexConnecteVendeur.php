<?php

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$IDVendeur ='';
$erreurObjet ='';

if ($db_found) {
  $sql ="SELECT * FROM vendeur WHERE Etat = 1";
  $result = mysqli_query($db_handle,$sql);
  if (mysqli_num_rows($result) == 0) {//on ne trouve pas de vendeur connecté
    echo "ici";
    echo "Erreur : pas d'utilisateur connecté";
  }else{//on trouve un vendeur connecté
    $data = mysqli_fetch_assoc($result);
    $IDVendeur = $data['ID'];
    $sql ="SELECT * FROM item WHERE IDVendeur = '$IDVendeur'";
    $result = mysqli_query($db_handle,$sql);
    $result2 = mysqli_query($db_handle,$sql);
    $result3 = mysqli_query($db_handle,$sql);
    if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objets à vendre
      $erreurObjet = "Vous n'avez pas d'objets à vendre, ajoutez-en en cliquant sur le bouton Vendre";
    }else{//on trouve des objets à vendre
      $sql =  "SELECT * FROM item WHERE IDVendeur = '$IDVendeur'";
      $result = mysqli_query($db_handle,$sql);
      $sql =  "SELECT * FROM item WHERE IDVendeur = '$IDVendeur' AND IDAcheteur != 0 AND Offre !=0 AND ContreOffre = '0'";
      $result2 = mysqli_query($db_handle,$sql);
      $sql =  "SELECT * FROM item WHERE IDVendeur = '$IDVendeur' AND IDAcheteur != 0 AND ContreOffre !=0";
      $result3 = mysqli_query($db_handle,$sql);
      $dateAjd = new DateTime("now");
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
      <a class="navbar-brand" href="indexConnecteVendeur.php"><img src="images/logo.png" style="margin-top: -11px" width="40px" height="40px"></a>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="indexConnecteVendeur.php">Home</a></li>
          <li><a href="vente.php">Vendre</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li><a href="monCompteVendeur.php"><span class="glyphicon glyphicon-user"></span> Mon compte</a></li>
          <li><a href="deco.php"><span class="glyphicon glyphicon-off"></span> Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="venteencours">
    <p>Vos ventes en cours <span class='glyphicon glyphicon-briefcase'></span></p>
          <?php
          while ($objets = mysqli_fetch_assoc($result)) {
             $dateFinEnchere = date_create($objets['DureeEnchere']);
            if ($objets['IDAcheteur'] == 0 && $objets['EtatEnchere'] != 1) {
              echo "<div class='col-sm-4'>";
              echo "<div class='panel panel-default'>";
              echo"<div class='panel-heading'>" .$objets['Nom'] . "<a href='removeItem.php?id=" . $objets['ID'] . "'><span title ='Supprimer item' class='glyphicon glyphicon-remove'></span></a>" . "</div>";
              echo "<div class='panel-body'> <img src='images/". $objets['Photos']."' class='img-responsive' style='width:100%' alt='Image'> </div>";
              echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['Prix'] . " Ø" . "</div>";
              echo "</div>";
              echo "</div>";
            }
          }
          ?>
        </div>
  </div>

  <div class="container">
    <div class="negoencours">
          <p>Vos négociations en cours <span class='glyphicon glyphicon-time'></span></p>
          <?php
          while ($objets = mysqli_fetch_assoc($result2)) {
              echo "<div class='col-sm-4'>";
              echo "<div class='panel panel-default'>";
              echo'<div class="panel-heading">' .$objets["Nom"] . '<a title="Accepter l\'offre " href="accepterOffre.php?id=' . $objets['ID'] . '"><span class="glyphicon glyphicon-ok-sign"></span></a> <a title="Proposer une contre-offre " style="margin-left: 16px" href="refuserOffre.php?id=' . $objets['ID'] . '"><span class="glyphicon glyphicon-remove-sign"></span></a>' . '</div>';
              echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
              echo "<div class='panel-footer'> Un acheteur vous propose une offre de : " . $objets['Offre'] . " Ø" . "</div>";
              echo "</div>";
              echo "</div>";
          }
          ?>
     </div>
  </div>

  <div class="container">
    <div class="negoencours">
          <p>Vos négociations en attente <span class='glyphicon glyphicon-time'></span></p>
          <?php
          while ($objets = mysqli_fetch_assoc($result3)) {
              echo "<div class='col-sm-4'>";
              echo "<div class='panel panel-default'>";
              echo'<div class="panel-heading">' .$objets["Nom"] . '</div>';
              echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
              echo "<div class='panel-footer'> Un acheteur vous propose une offre de : " . $objets['Offre'] . " Ø" . "</div>";
              echo "</div>";
              echo "</div>";
          }
          ?>
     </div>
  </div>
  <div class="venteencours">
      <p style="text-align: center;"><?php echo $erreurObjet;?></p>
  </div>

  <footer class="page-footer">
    <div class="container-fluid">
      <img src="images/logo.png" width="100px" height="100px">
      <p><strong>M I D G A R D</strong></p>  
        <div class="cvg">
          <p>
            <a href="#" class ="cvg">Conditions générales de vente</a>
            &nbsp &nbsp &nbsp
            <a href="monCompteVendeur.php" class ="cvg">Vos informations personnelles</a>
            &nbsp &nbsp &nbsp
            © 2020, Midgard Inc. 
          </p>
        </div>
    </div>

  </footer>

</body>
</html>