<?php

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$accueil ='';
$nomVendeur ='';
$IDVendeur ='';
$erreurObjet ='';

if ($db_found) {
  $sql ="SELECT * FROM vendeur WHERE Etat = 1";
  $result = mysqli_query($db_handle,$sql);
  if (mysqli_num_rows($result) == 0) {//on ne trouve pas de vendeur connecté
    echo "Erreur : pas d'utilisateur connecté";
  }else{//on trouve un vendeur connecté
    $data = mysqli_fetch_assoc($result);
    $nomVendeur = $data['Nom']; 
    $IDVendeur = $data['ID'];
    $accueil ="Bonjour M. " .$nomVendeur;
    $sql ="SELECT * FROM item WHERE IDVendeur = '$IDVendeur'";
    $result = mysqli_query($db_handle,$sql);
    if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objets à vendre
      $erreurObjet = "Vous n'avez pas d'objets à vendre, ajoutez-en en cliquant sur le bouton Vendre";
    }else{//on trouve des objets à vendre
      $sql =  "SELECT ID, Nom, Photos, Description, Video, Prix, Categorie FROM item WHERE IDVendeur = '$IDVendeur'";
      $result = mysqli_query($db_handle,$sql);
      $objets = mysqli_fetch_assoc($result);
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
      <a class="navbar-brand" href="indexConnecteVendeur.php"><img src="logo.png" style="margin-top: -11px" width="40px" height="40px"></a>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="indexConnecteVendeur.php">Home</a></li>
          <li><a href="vente.php">Vendre</a></li>

          <li class="dropdown" >
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Catégories
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#">Trésors</a></li>
              <li><a href="#">Reliques</a></li>
              <li><a href="#">VIP</a></li>
            </ul>
          </li>
        </ul>


        <ul class="nav navbar-nav navbar-right">
          <li><a href="monCompteVendeur.php"><span class="glyphicon glyphicon-user"></span> Mon compte</a></li>
          <li><a href="deco.php"><span class="glyphicon glyphicon-off"></span> Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container"> 

      <div class="col-sm-4">
        <div class="panel panel-default">
          <div class="panel-heading"> <?php echo $objets['Nom']; ?> </div>
          <div class="panel-body"> <img src="<?php echo $objets['Photos']; ?>" class="img-responsive" style="width:100%" alt="Image"> </div>
          <div class="panel-footer"> <?php echo $objets['Description']; ?> </div>
        </div>
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