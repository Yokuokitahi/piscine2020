<?php

$nomObjet = isset($_POST["nomObjet"])? $_POST["nomObjet"] : "";
$categorie = isset($_POST["cate"])? $_POST["cate"] : "";
$desc = isset($_POST["description"])? $_POST["description"] : "";
$desc=addslashes($desc);
$prix = isset($_POST["prix"])? $_POST["prix"] : "";
$photo = isset($_POST["photo"])? $_POST["photo"] : "";
$video = isset($_POST["video"])? $_POST["video"] : "";
$typeVente = isset($_POST["typeVente"])? $_POST["typeVente"] : "";
$dureeEnchere = isset($_POST["dureeEnchere"])? $_POST["dureeEnchere"] : "";
$Identifiant ='';
$IDVendeur ='';
$erreur ='';

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($db_found) {
	$sql ="SELECT ID FROM vendeur WHERE Etat = 1";
	$result = mysqli_query($db_handle, $sql); 
	if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'admin connecté
		echo "Erreur : pas d'utilisateur connecté";
	}else{//on trouve un vendeur connecté
		$data = mysqli_fetch_assoc($result);
		$IDVendeur = $data['ID']; 

		$sql = "SELECT MAX(ID) FROM item";
		$result = mysqli_query($db_handle, $sql); 
		$data = mysqli_fetch_assoc($result);
		$Identifiant = $data['MAX(ID)'] + 1;

		if ($nomObjet != ""){
			if ($typeVente == "enchere" && $dureeEnchere !=0) {
				$sql = "INSERT INTO item(ID, Nom, Photos, Description, Video, Prix, Categorie, IDVendeur, TypeVente, DureeEnchere) VALUES('$Identifiant', '$nomObjet', '$photo', '$desc', '$video', '$prix', '$categorie', '$IDVendeur', '$typeVente', '$dureeEnchere')";
				$result = mysqli_query($db_handle, $sql); 
				header('Location: indexConnecteVendeur.php');
			}elseif ($typeVente == "enchere" && $dureeEnchere==0) {
				echo "veuillez renseigner la durée d'enchères";
			}else{
				$sql = "INSERT INTO item(ID, Nom, Photos, Description, Video, Prix, Categorie, IDVendeur) VALUES('$Identifiant', '$nomObjet', '$photo', '$desc', '$video', '$prix', '$categorie', '$IDVendeur')";
				$result = mysqli_query($db_handle, $sql); 
				header('Location: indexConnecteVendeur.php');
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
      <a class="navbar-brand" href="indexConnecteVendeur.php"><img src="logo.png" style="margin-top: -11px" width="40px" height="40px"></a>

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
  
  <!-- FORMULAIRE D'AJOUT D'ITEM -->
  <form action="vente.php" method="post">
	<div class="vente">
		<label for="categorie"><b>En quelle catégorie souhaitez-vous ajouter un objet ? </b></label>
			<label for="tresor">Objet de valeur</label> <input type="radio" name="cate" value="tresor" required> &nbsp
			<label for="relique">Objet ancien</label> <input type="radio" name="cate" value="relique" required> &nbsp
			<label for="vip">Objet VIP </label> <input type="radio" name="cate" value="vip" required> <br> <br>

		<label for="nomObjet"><b>Nom de l'objet : </b></label>
		<input type="text" placeholder="Entrez le nom de l'objet" name="nomObjet" maxlength="20" required><br>

		<label for="description"><b>Donnez nous une petite description de cet objet : </b></label>
		<input type="text" placeholder="Tapez votre description" name="description" required><br>

		<label for="prix"><b> A combien voulez-vous vendre cet objet ? </b></label>
		<input type="text" placeholder="Entrez votre prix" name="prix" required><br><br>

		<label for="typeDeVente"><b>Sous quelle forme souhaitez-vous vendre cet objet ? </b></label><br>
			<label for="comptant">Vente immédiate (paiement comptant) </label> <input type="radio" name="typeVente" value="comptant" required> <br>
			<label for="nego">Vente par meilleure offre (vous acceptez de négocier le prix de vente) </label> <input type="radio" name="typeVente" value="nego" required> <br>
			<label for="enchere">Vente par enchère (Vous cédez cet objet au plus offrant) </label> <input type="radio" name="typeVente" value="enchere" required> <br> <br>

		<label for="dureeEnchere"><b> Si vous choississez la vente aux enchères, veuillez renseigner la date de fin de cette vente :</b></label>
		<input type="datetime-local" placeholder="Entrez la date de fin de vos enchères" name="dureeEnchere"><br><br>

		<label for="avatar">Ajoutez une photo pour mieux décrire votre objet :</label>
			<input type="file" name="photo" required><br>
			<br>

			<label for="fond">Si vous souhaitez mettre en plus de votre photo une courte vidéo, ajoutez-la ici :</label>
			<input type="file" name="video"><br>

		<p style="text-align: center;"><input type="submit" name="ajout" value="Ajouter un objet"></p>
	</div>
  </form>

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
