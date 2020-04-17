<?php
error_reporting(E_ALL & ~E_NOTICE);

//recuperer les données venant de la page HTML
$identifiant = isset($_POST["identifiant"])? $_POST["identifiant"] : "";
$password = isset($_POST["mdp"])? $_POST["mdp"] : "";
$erreur = '';
$connexion ='';

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($_POST["connexion"]) { //bouton se connecter enclenché

	if ($db_found) { //si la base de données est bien connectée

		$sql = "SELECT * FROM admin WHERE Pseudo = '$identifiant'"; //on recherche le pseudo dans la table admin
		$result = mysqli_query($db_handle, $sql);
		if (mysqli_num_rows($result) == 0) { // si le pseudo n'est pas dans la table admin
			$sql = "SELECT * FROM vendeur WHERE Pseudo = '$identifiant'"; //on cherche le pseudo dans la page vendeur
			$result = mysqli_query($db_handle, $sql);
			if (mysqli_num_rows($result) == 0) {// si le pseudo n'est pas dans la table vendeur
				$sql = "SELECT * FROM acheteur WHERE Pseudo = '$identifiant'";//on cherche le pseudo dans la page acheteur
				$result = mysqli_query($db_handle, $sql);
				if (mysqli_num_rows($result) == 0) {// si le pseudo n'est pas dans la table acheteur, il n'est dans aucune table
					$erreur = "User not found"; // on ne trouve pas ce pseudo
				}else {// si le pseudo est trouvé dans la base acheteur
					$sql .= " AND Password = '$password'"; // on confirme son mot de passe
					$result = mysqli_query($db_handle, $sql);
					if (mysqli_num_rows($result) == 0) { // si le mot de passe renseigné n'est pas le bon
						$erreur = "Mot de passe erroné"; //on affiche un message d'erreur de mot de passe
					}
					else { // si le mot de passe renseigné est le bon
						$erreur = "connexion autorisée <br>"; //connexion autorisée pour acheteur
						header('Location: indexConnecteAcheteur.php');
						$sql = "UPDATE acheteur SET Etat = 1 WHERE Pseudo = '$identifiant'";
						$result = mysqli_query($db_handle, $sql);
					}
				}
			}else { // si le pseudo est trouvé dans la base vendeur
				$sql .= " AND Password = '$password'"; // on confirme son mot de passe
				$result = mysqli_query($db_handle, $sql);
				if (mysqli_num_rows($result) == 0) { // si le mot de passe renseigné n'est pas le bon
					$erreur = "Mot de passe erroné"; //on affiche un message d'erreur de mot de passe
				}else { // si le mot de passe renseigné est le bon
					$erreur = "connexion autorisée <br>"; //connexion autorisée pour vendeur
					header('Location: indexConnecteVendeur.php');
					$sql = "UPDATE vendeur SET Etat = 1 WHERE Pseudo = '$identifiant'";
					$result = mysqli_query($db_handle, $sql);
				}
			}
		}else{// si le pseudo est trouvé dans la base admin
			$sql .= " AND Password = '$password'";// on confirme son mot de passe
			$result = mysqli_query($db_handle, $sql);
			if (mysqli_num_rows($result) == 0) {// si le mot de passe renseigné n'est pas le bon					
				$erreur = "Mot de passe erroné";//on affiche un message d'erreur de mot de passe
			}else {// si le mot de passe renseigné est le bon
				$erreur = "connexion autorisée <br>";//connexion autorisée pour admin
				header('Location: indexadmin.php');
				$sql = "UPDATE admin SET Etat = 1 WHERE Pseudo = '$identifiant'";
				$result = mysqli_query($db_handle, $sql);
			}
		}
	}else {
		$erreur = "Database not found";
	}
}
//fermer la connexion
mysqli_close($db_handle);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Connectez-vous</title>
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
      <a class="navbar-brand" href="index.php"><img src="logo.png" style="margin-top: -11px" width="40px" height="40px"></a>

  		<div class="collapse navbar-collapse" id="myNavbar">
        	<ul class="nav navbar-nav">
          		<li class="active"><a href="index.php">Retour Page Accueil</a></li>
		</div>

    </div>
</nav>

<form action="connect.php" method="post">
	<div class="img">
		<img src="avatar.png" alt="Avatar" class="avatar">
	</div>

	<div class="container">
		<label for="identifiant"><b>Adresse e-mail ou pseudo : </b></label>
		<input type="text" placeholder="Entrez votre e-mail ou pseudo" name="identifiant" required>

		<label for="mdp"><b>Mot de Passe : </b></label>
		<input type="password" placeholder="Entrez votre mot de passe" name="mdp" required>
		<div class="erreur">
			<?php if( !empty( $erreur ) ) echo '<p style="text-align: center;" >', $erreur, '</p>' ?>
		</div>
		<p style="text-align: center;"><input type="submit" name="connexion" value="Se connecter"></p>
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