<?php

//identifier votre BDD
$database = "midgard";
//connectez-vous dans votre BDD
//Rappel: votre serveur = localhost |votre login = root |votre password = <rien>
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$ancienSolde = '';

$solde = isset($_POST["solde"])? $_POST["solde"] : "";


if($db_found){
	$sql ="SELECT Solde FROM acheteur WHERE Etat = 1";
	$result = mysqli_query($db_handle,$sql);
	if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'acheteur connecté
	echo "Erreur : pas d'utilisateur connecté";
	}else{//on trouve un acheteur connecté
		if ($solde !=0) {
			$data = mysqli_fetch_assoc($result);
			$ancienSolde = $data['Solde'];
			$nouveauSolde = $solde + $ancienSolde;
			$sql = "UPDATE acheteur SET Solde = '$nouveauSolde' WHERE Etat = 1";
			$result = mysqli_query($db_handle,$sql);
			header('Location: monCompteAcheteur.php');
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
	<title>Mon Compte</title>
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
					<li><a href="acheter.php">Acheter</a></li>

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
					<li><a href="moncompteAcheteur.php"><span class="glyphicon glyphicon-user"></span> Mon compte</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Votre panier</a></li>
					<li><a href="deco.php"><span class="glyphicon glyphicon-off"></span> Déconnexion</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<form action="ajouterSolde.php" method="post">
		<div class="argent">
			<label for="solde">Ajouter des Øre à votre solde : </label><br>
			<input type="number" placeholder="Entrez un montant" name="solde">
		</div>

		<br><p style="text-align: center;"><input type="submit" name="ajouter" value="Déposer de l'argent"></p>
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