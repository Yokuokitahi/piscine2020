<?php

$IDObjet = $_GET['id'];

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$contreOffre = isset($_POST["nouvelleOffre"])? $_POST["nouvelleOffre"] : "";
$erreur = '';
if ($db_found) {
	$sql ="SELECT * FROM vendeur WHERE Etat = 1";
	$result = mysqli_query($db_handle, $sql); 
	if (mysqli_num_rows($result) == 0) {//on ne trouve pas de vendeur connecté
		$sql ="SELECT * FROM acheteur WHERE Etat = 1";
		$result = mysqli_query($db_handle, $sql); 
		if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'acheteur connecté
			$sql = "SELECT * FROM admin WHERE Etat = 1";
			$result = mysqli_query($db_handle, $sql);
			if (mysqli_num_rows($result) == 0) {// on ne trouve pas d'admin connecté
				echo "Erreur : pas d'utilisateur connecté";
			}else{
				$sql ="SELECT * FROM item WHERE ID = '$IDObjet'";
				$result = mysqli_query($db_handle, $sql);
				$data = mysqli_fetch_assoc($result);
				if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objet 
					echo "Erreur : pas d'objet trouvé";
				}else{
					if ($contreOffre != 0) {
						$data = mysqli_fetch_assoc($result);
						$sql = "UPDATE item SET ContreOffre = $contreOffre WHERE ID = '$IDObjet'";
						$result = mysqli_query($db_handle, $sql); 
						header('Location: indexadmin.php');
					}
				}
			}
		}else{//on trouve un acheteur connecté
			$sql ="SELECT * FROM item WHERE ID = '$IDObjet'";
			$result2 = mysqli_query($db_handle, $sql); 
			$data = mysqli_fetch_assoc($result2);
			if (mysqli_num_rows($result2) == 0) {//on ne trouve pas d'objet 
			echo "Erreur : pas d'objet trouvé";
			}else{
				if ($contreOffre != 0 && $data['NbOffre'] < 5) {
					$IDAcheteur = $data['ID'];
					$sql = "SELECT * FROM item WHERE ID = '$IDObjet'";
					$result = mysqli_query($db_handle,$sql);
					$data = mysqli_fetch_assoc($result);
					$NbOffre = $data['NbOffre'];
					$newNbOffre = $NbOffre + 1;
					$sql = "UPDATE item SET Offre = '$contreOffre', ContreOffre = '0', NbOffre = '$newNbOffre' WHERE ID = '$IDObjet'";
					$result = mysqli_query($db_handle,$sql);
					header('Location: indexConnecteAcheteur.php?erreur=0');
				}
				if ($data['NbOffre'] == 5 ) {
					$sql = "UPDATE item SET Offre = '0', ContreOffre = '0', NbOffre = '0', IDAcheteur = '0' WHERE ID = '$IDObjet'";
					$result = mysqli_query($db_handle,$sql);
					$erreur = 'Les négociations sont terminées.';
					header('Location: indexConnecteAcheteur.php?erreur=' . $erreur);
				}
			}
		}
	}else{//on trouve un vendeur connecté
		$sql ="SELECT * FROM item WHERE ID = '$IDObjet'";
		$result = mysqli_query($db_handle, $sql);
		$data = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objet 
		echo "Erreur : pas d'objet trouvé";
		}else{
			if ($contreOffre != 0) {
				$data = mysqli_fetch_assoc($result);
				$sql = "UPDATE item SET ContreOffre = $contreOffre WHERE ID = '$IDObjet'";
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
			<a class="navbar-brand" href="indexConnecteVendeur.php"><img src="images/logo.png" style="margin-top: -11px" width="40px" height="40px"></a>

			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li class="active"><a href="indexConnecteVendeur.php">Home</a></li>
					<li><a href="gereVente.php">Gérer les ventes</a></li>
					<li><a href="vente.php">Vendre</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="monCompteAdmin.php"><span class="glyphicon glyphicon-wrench"></span> Admin</a></li>
					<li><a href="deco.php"><span class="glyphicon glyphicon-off"></span> Déconnexion</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container"> 
		<?php
		echo "<div class='col-sm-4'>";
		echo "<div class='panel panel-default'>";
		echo"<div class='panel-heading'>" .$data['Nom'] . "</div>";
		echo "<div class='panel-body'> <img src='images/". $data['Photos'] ."' class='img-responsive' style='width:100%' alt='Image'> </div>";
		echo "<div class='panel-footer'> L'acheteur propose : " . $data['Offre'] . " Ø" . "<p>Le vendeur propose " . $data['ContreOffre'] . " Ø</p>" . "</div>";
		echo "</div>";
		echo "</div>";
		?>


		<form action="refuserOffre.php?id= <?php echo $IDObjet; ?>" ; method="post">
			<div class="negociation">
				<label for="nouvelleOffre">Veuillez entrer une contre-offre : </label><br>
				<input type="number" placeholder="Entrez un montant (en Øre)" name="nouvelleOffre" style="width: 20%" required>
				<br>
				<p><input type="submit" name="contreOffre" value="Soumettre votre offre" style="width: 20%; background-color: #303030; padding: 4px;"></p>
			</div>
		</form>

	</div>

	<footer class="page-footer">

		<div class="container-fluid">
			<img src="images/logo.png" width="100px" height="100px">
			<p><strong>M I D G A R D</strong></p>  
			<div class="cvg">
				<p>
					<a href="#" class ="cvg">Conditions générales de vente</a>
					&nbsp &nbsp &nbsp
					<a href="monCompteAdmin.php" class ="cvg">Vos informations personnelles</a>
					&nbsp &nbsp &nbsp
					© 2020, Midgard Inc. 
				</p>
			</div>
		</div>

	</footer>


</body>
</html>