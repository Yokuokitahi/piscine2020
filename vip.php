<?php
//identifier votre BDD
$database = "midgard";
//connectez-vous dans votre BDD
//Rappel: votre serveur = localhost |votre login = root |votre password = <rien>
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$nbItems ='';
$erreurObjet ='';

if ($db_found) {
  $sql ="SELECT COUNT(*)-1 AS count FROM item";
  $result = mysqli_query($db_handle,$sql);
  $data = mysqli_fetch_assoc($result);
    $nbItems = $data['count']; //UTILE POUR LE RANDOM

    $sql ="SELECT * FROM item";
    $result = mysqli_query($db_handle,$sql);
    if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objets à vendre
    $erreurObjet = "Il n'y a pas d'objets à vendre actuellement";
    }else{//on trouve des objets à vendre
      $sql =  "SELECT * FROM item WHERE ID > 0 AND Categorie = 'vip' ";
      $result = mysqli_query($db_handle,$sql);
      $dateAjd = new DateTime("now");
    }
  }else{
    echo "Database not found";
  }
  mysqli_close($db_handle);
  ?>


  <!DOCTYPE html>
  <html>
  <head>
   <title>Objets de valeur </title>
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
          <li><a href="moncompteAcheteur.php?erreur=0"><span class="glyphicon glyphicon-user"></span> Mon compte</a></li>
          <li><a href="panier.php"><span class="glyphicon glyphicon-shopping-cart"></span> Votre panier</a></li>
          <li><a href="deco.php"><span class="glyphicon glyphicon-off"></span> Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
   <div class="enchere">
    <p>Objets de valeur</p> 
    <?php
    while ($objets = mysqli_fetch_assoc($result)) {
      $dateFinEnchere = date_create($objets['DureeEnchere']);
      if ($objets['TypeVente'] == 'comptant' && $objets['IDAcheteur'] == 0) {
        echo "<div class='col-sm-4'>";
        echo "<div class='panel panel-default'>";
        echo"<div class='panel-heading'>" .$objets['Nom'] . "<a href='ajouterPanier.php?id=" . $objets['ID'] . "&page=vip.php'><span class='glyphicon glyphicon-plus-sign'></span></a>" . "</div>";
        echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
        echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['Prix'] . " Ø" . "</div>";
        echo "</div>";
        echo "</div>";
      }elseif ($objets['TypeVente'] == 'enchere' && $objets['EtatEnchere'] != 1 && $objets['IDAcheteur'] == 0) {
        echo "<div class='col-sm-4'>";
        echo "<div class='panel panel-default'>";
        echo"<div class='panel-heading'>" .$objets['Nom'] . "<a href='acheterEnchere.php?id=" . $objets['ID'] . "'><span class='glyphicon glyphicon-hourglass'></span></a>". "</div>";
        echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
        echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['Prix'] . " Ø" . "</div>";
        echo "</div>";
        echo "</div>";
      }elseif ($objets['TypeVente'] == 'nego' && $objets['IDAcheteur'] == 0) {
        echo "<div class='col-sm-4'>";
        echo "<div class='panel panel-default'>";
        echo"<div class='panel-heading'>" .$objets['Nom'] . "<a href='ajouterNego.php?id=" . $objets['ID'] . "&page=vip.php'><span class='glyphicon glyphicon-send'></span></a>". "</div>";
        echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
        echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['Prix'] . " Ø" . "</div>";
        echo "</div>";
        echo "</div>";
      }
    }
    ?>
  </div>
</div>

<footer class="page-footer">

  <div class="container-fluid">
    <img src="images/logo.png" width="100px" height="100px">
    <p><strong>M I D G A R D</strong></p>  
    <div class="cvg">
      <p>
        <a href="#" class ="cvg">Conditions générales de vente</a>
        &nbsp &nbsp &nbsp
        <a href="moncompteAcheteur.php?erreur=0" class ="cvg">Vos informations personnelles</a>
        &nbsp &nbsp &nbsp
        © 2020, Midgard Inc. 
      </p>
    </div>
  </div>

</footer>

</body>
</html>