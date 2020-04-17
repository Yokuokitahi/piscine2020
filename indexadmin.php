<?php

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$accueil ='';
$nomVendeur ='';
$PseudoAdmin ='';
$erreurObjet ='';

if ($db_found) {
  $sql ="SELECT * FROM admin WHERE Etat = 1";
  $result = mysqli_query($db_handle,$sql);
  if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'admin connecté
    echo "Erreur : pas d'utilisateur connecté";
  }else{//on trouve un admin connecté
    $data = mysqli_fetch_assoc($result); 
    $PseudoAdmin = $data['Pseudo'];
    $sql ="SELECT * FROM vendeur";
    $result = mysqli_query($db_handle,$sql);
    if (mysqli_num_rows($result) == 0) {//on ne trouve pas de vendeurs
      $erreurObjet = "Il n'y a pas de vendeurs actuellement, recrutez-en !";
    }else{//on trouve des vendeurs
      $sql =  "SELECT ID, Pseudo, Nom, Email, Photos FROM vendeur WHERE ID > 0";
      $result = mysqli_query($db_handle,$sql);
    }
    $sql2 ="SELECT * FROM item";
    $result2 = mysqli_query($db_handle,$sql2);
    if (mysqli_num_rows($result2) == 0) {//on ne trouve pas de vendeurs
      $erreurObjet = "Vous n'avez pas d'items en vente actuellement";
    }else{//on trouve des items
      $sql2 =  "SELECT * FROM item WHERE IDVendeur = '$PseudoAdmin'";
      $result2 = mysqli_query($db_handle,$sql2); 
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
      <a class="navbar-brand" href="indexadmin.php"><img src="logo.png" style="margin-top: -11px" width="40px" height="40px"></a>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="gereVente.php">Gérer les ventes</a></li>
          <li><a href="venteAdmin.php">Vendre</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li><a href="monCompteAdmin.php"><span class="glyphicon glyphicon-wrench"></span>Admin</a></li>
          <li><a href="deco.php"><span class="glyphicon glyphicon-off"></span> Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </nav>

      <div class="container"> 
          <?php
          while ($objets = mysqli_fetch_assoc($result)) {
              echo "<div class='col-sm-4'>";
              echo "<div class='panel panel-default'>";

              echo"<div class='panel-heading'>" .$objets['Nom'] . "<a href='removeVendeurs.php?id=" . $objets['ID'] . "'><span class='glyphicon glyphicon-remove'></span></a>" . "</div>";

              echo "<div class='panel-body'> <img src=' ". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
              echo "<div class='panel-footer'>" . $objets['Email'] ."</div>";
              echo "</div>";
              echo "</div>";
            }
            if ($objets = mysqli_fetch_assoc($result) == 0) {
              echo "<p>" . $erreurObjet . "</p>";
            }
          ?>
  </div>

  <div class="container"> 
          <?php
          while ($objets2 = mysqli_fetch_assoc($result2)) {
            if ($objets2['IDAcheteur'] == 0) {
              echo "<div class='col-sm-4'>";
              echo "<div class='panel panel-default'>";
              echo"<div class='panel-heading'>" .$objets2['Nom'] . "<a href='removeItem.php?id=" . $PseudoAdmin . "'><span class='glyphicon glyphicon-remove'></span></a>" . "</div>";
              echo "<div class='panel-body'> <img src=' ". $objets2['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
              echo "<div class='panel-footer'>" . $objets2['Description'] . "&nbspau prix de : " . $objets2['Prix'] . "€" . "</div>";
              echo "</div>";
              echo "</div>";
            }
          }
          ?>
  </div>

  <footer class="page-footer">

    <div class="container-fluid">
      <img src="logo.png" width="100px" height="100px">
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
