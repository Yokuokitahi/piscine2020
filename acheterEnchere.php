<?php

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$IDAcheteur ='';
$erreurObjet ='';
$erreurPrix ='';
$prixTotal = 0;
$enchere = $_GET['id'];
$surencherir = isset($_POST["surencherir"])? $_POST["surencherir"] : "";
$soldes='';
date_default_timezone_set('Europe/Paris');
$dateAjd = date("yy-m-d H:i:s");

if ($db_found) {
  $sql ="SELECT * FROM acheteur WHERE Etat = 1";
  $result = mysqli_query($db_handle,$sql);
  $data = mysqli_fetch_assoc($result);
  $IDAcheteur = $data['ID'];
  echo $dateAjd;
  if (mysqli_num_rows($result) == 0) {//on ne trouve pas de vendeur connecté
    echo "Erreur : pas d'utilisateur connecté";
  }else{//on trouve un vendeur connecté
    $sql ="SELECT * FROM item WHERE ID = '$enchere'";
    $result = mysqli_query($db_handle,$sql);
    $objets= mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objets à vendre
    $erreurObjet = "Erreur, Cet objet est introuvable";
  }else{
    if (isset($_POST["bouton"])){

      if ($surencherir > $objets['Prix'] && $dateAjd < $objets['DureeEnchere']){
        $sql = "UPDATE item SET Prix = '$surencherir', IDAcheteurEnchere = '$IDAcheteur', EtatEnchere = '2' WHERE ID = '$enchere'";
        $result = mysqli_query($db_handle,$sql);

        header('Location: acheterEnchere.php?id=' . $enchere);
      }else {
        $erreurPrix = "Le prix de votre surenchère est trop bas !";
      }
    }
    if ($dateAjd >= $objets['DureeEnchere'] ) {
      $sql = "UPDATE item SET EtatEnchere = '1', IDAcheteur = '".$objets["IDAcheteurEnchere"]."' WHERE ID = '$enchere'";
      $result = mysqli_query($db_handle,$sql);
      echo "Article plus disponible aux enchères !";
      header('Location: indexConnecteAcheteur.php?erreur=0');
    }
  }
}
}else{
  echo "Database not found";
}
mysqli_close($db_handle);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Acheter un article aux enchères</title>
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
    echo "<div class='col-sm-4'>";
    echo "<div class='panel panel-default'>";
    echo"<div class='panel-heading'>" .$objets['Nom'] . "</div>";
    echo "<div class='panel-body'> <img src='images/". $objets['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
    echo "<div class='panel-footer'>" . $objets['Description'] . "&nbspau prix de : " . $objets['Prix'] . " Ø" . "</div>";
    echo "</div>";
    echo "</div>";

    ?>
  </div>

  <div class="surenchere">
    <?php
    echo "Fin de l'enchère : ". $objets['DureeEnchere']. "<br>";
    echo "Prix de base : ". $objets['Prix'],"<br>"; 
    echo "<p style='color:red;'>",$erreurPrix,"</p>";
    ?>
    <form class="surench" method="post" action="acheterEnchere.php?id=<?php echo $enchere; ?>">
     <p>Souhaitez-vous encherir ?</p>
     <input type="number" name="surencherir" placeholder="Entrez un nombre" style="margin-bottom:10px; " required>
     <br>
     <input type="submit" name="bouton" value="Surencherir" style="background-color: #303030; width: 10%; padding: 4px;">
   </form>
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
        <a href="monCompteAcheteur.php?erreur=0" class ="cvg">Vos informations personnelles</a>
        &nbsp &nbsp &nbsp
        © 2020, Midgard Inc. 
      </p>
    </div>
  </div>

</footer>

</body>
</html>