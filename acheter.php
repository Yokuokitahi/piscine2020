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
      $sql1 =  "SELECT * FROM item WHERE ID > 0 AND TypeVente = 'enchere' ";
      $result1 = mysqli_query($db_handle,$sql1);
      $sql2 =  "SELECT * FROM item WHERE ID > 0 AND TypeVente = 'nego' ";
      $result2 = mysqli_query($db_handle,$sql2);
      $sql3 =  "SELECT * FROM item WHERE ID > 0 AND TypeVente = 'comptant' ";
      $result3 = mysqli_query($db_handle,$sql3);
    }
}else{
  echo "Database not found";
}
mysqli_close($db_handle);
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Acheter un article</title>
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
      <a class="navbar-brand" href="indexConnecteAcheteur.php"><img src="logo.png" style="margin-top: -11px" width="40px" height="40px"></a>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="indexConnecteAcheteur.php">Home</a></li>
          <li><a href="#">Acheter</a></li>

          <li class="dropdown" >
            <a class="dropdown-toggle" data-toggle="dropdown">Catégories
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="tresor.php">Trésors</a></li>
              <li><a href="relique.php">Reliques</a></li>
              <li><a href="vip.php">VIP</a></li>
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
		<p>Items aux enchères <span class='glyphicon glyphicon-hourglass'></span></p> 
      <?php
          while ($objets1 = mysqli_fetch_assoc($result1)) {
              echo "<div class='col-sm-4'>";
              echo "<div class='panel panel-default'>";
              echo"<div class='panel-heading'>" .$objets1['Nom'] . "<a href='AJOUTER_ENCHERE.php?id=" . $objets1['ID'] . "'><span class='glyphicon glyphicon-hourglass'></span></a>" . "</div>";
              echo "<div class='panel-body'> <img src=' ". $objets1['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
              echo "<div class='panel-footer'>" . $objets1['Description'] . "&nbspau prix de : " . $objets1['Prix'] . " Ø" . "</div>";
              echo "</div>";
              echo "</div>";
            }
          ?>
  	</div>
  </div>


  <div class="container">
  	<div class="nego">
  		<p>Items à négocier auprès du vendeur <span class='glyphicon glyphicon-send'></span></p> 
      <?php
          while ($objets2 = mysqli_fetch_assoc($result2)) {
              echo "<div class='col-sm-4'>";
              echo "<div class='panel panel-default'>";
              echo"<div class='panel-heading'>" .$objets2['Nom'] . "<a href='AJOUTER_NEGO.php?id=" . $objets2['ID'] . "'><span class='glyphicon glyphicon-send'></span></a>". "</div>";
              echo "<div class='panel-body'> <img src=' ". $objets2['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
              echo "<div class='panel-footer'>" . $objets2['Description'] . "&nbspau prix de : " . $objets2['Prix'] . " Ø" . "</div>";
              echo "</div>";
              echo "</div>";
            }
          ?>
      </div>
  </div>


  <div class="container">
  	<div class="comptant"> 
  		<p>Items en achat immédiat <span class='glyphicon glyphicon-plus-sign'></span></p>
      <?php
          while ($objets3 = mysqli_fetch_assoc($result3)) {
            if ($objets3['IDAcheteur'] == 0) {
              echo "<div class='col-sm-4'>";
              echo "<div class='panel panel-default'>";
              echo"<div class='panel-heading'>" .$objets3['Nom'] . "<a href='ajouterPanier.php?id=" . $objets3['ID'] . "&page=acheter.php'><span class='glyphicon glyphicon-plus-sign'></span></a>" . "</div>";
              echo "<div class='panel-body'> <img src=' ". $objets3['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
              echo "<div class='panel-footer'>" . $objets3['Description'] . "&nbspau prix de : " . $objets3 ['Prix'] . " Ø" . "</div>";
              echo "</div>";
              echo "</div>";
            }
            }
          ?>
  	</div>
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