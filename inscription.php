<?php
error_reporting(E_ALL & ~E_NOTICE);

//recuperer les données venant de la page HTML
$categorie = isset($_POST["categorie"])? $_POST["categorie"] : "";
//Vendeur
$nomVendeur = isset($_POST["nomVendeur"])? $_POST["nomVendeur"] : "";
$pseudoVendeur = isset($_POST["pseudoVendeur"])? $_POST["pseudoVendeur"] : "";
$mailVendeur = isset($_POST["mailVendeur"])? $_POST["mailVendeur"] : "";
$passwordVendeur = isset($_POST["mdpVendeur"])? $_POST["mdpVendeur"] : "";
$avatar = isset($_POST["avatar"])? $_POST["avatar"] : "";
$fond = isset($_POST["fond"])? $_POST["fond"] : "";


//spécifique à acheteur
$prenom = isset($_POST["prenom"])? $_POST["prenom"] : "";
$password = isset($_POST["mdp"])? $_POST["mdp"] : "";
$mail = isset($_POST["mail"])? $_POST["mail"] : "";
$nom = isset($_POST["nom"])? $_POST["nom"] : "";
$pseudo = isset($_POST["pseudo"])? $_POST["pseudo"] : "";
$adresse1 = isset($_POST["adress1"])? $_POST["adress1"] : "";
$adresse2 = isset($_POST["adress2"])? $_POST["adress2"] : "";
$ville = isset($_POST["ville"])? $_POST["ville"] : "";
$codepostal = isset($_POST["cp"])? $_POST["cp"] : "";
$pays = isset($_POST["pays"])? $_POST["pays"] : "";
$telephone = isset($_POST["tel"])? $_POST["tel"] : "";
$paiement = isset($_POST["paye"])? $_POST["paye"] : "";

$cb = isset($_POST["cb"])? $_POST["cb"] : "";
$nomCb = isset($_POST["nomCb"])? $_POST["nomCb"] : "";
$dateCb = isset($_POST["dateCb"])? $_POST["dateCb"] : "";
$code = isset($_POST["code"])? $_POST["code"] : "";
$contrat = isset($_POST["contrat"])? $_POST["contrat"] : "";

//identifier votre BDD
$database = "midgard";
//connectez-vous dans votre BDD
//Rappel: votre serveur = localhost |votre login = root |votre password = <rien>
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$erreurPseudo ='';
$erreurMail ='';
$erreurInscription ='';
$reussi ='';
$failed ='';

if ($_POST["enregistrer"]) {
	if ($db_found) {
		if($categorie == "vendeur"){
			$sql = "SELECT MAX(ID) FROM vendeur";
			$result = mysqli_query($db_handle, $sql); 
			$data = mysqli_fetch_assoc($result);
			$Identifiant = $data['MAX(ID)'] + 1;

			if($pseudoVendeur!= ""){
				$sql ="SELECT * FROM vendeur WHERE Pseudo = '$pseudoVendeur'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurPseudo = "Pseudo déjà existant";
					$failed = 1;
				}
				$sql ="SELECT * FROM admin WHERE Pseudo = '$pseudoVendeur'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurPseudo = "Pseudo déjà existant";
					$failed = 1;
				}
				$sql ="SELECT * FROM acheteur WHERE Pseudo = '$pseudoVendeur'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurPseudo = "Pseudo déjà existant";
					$failed = 1;
				}
			}
			if ($mailVendeur!= "") {
				$sql ="SELECT * FROM vendeur WHERE Email = '$mailVendeur'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurMail = "Mail déjà existant";
					$failed = 1;
				}
				$sql ="SELECT * FROM acheteur WHERE Email = '$mailVendeur'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurMail = "Mail déjà existant";
					$failed = 1;
				}
			}
			if ($pseudoVendeur != "" && $mailVendeur !="" && $passwordVendeur!="" && $nomVendeur!="" && $failed != 1){
				$sql = "INSERT INTO vendeur(ID, Pseudo, Password, Nom, Email, Etat, Photos, Background)            VALUES('$Identifiant', '$pseudoVendeur', '$passwordVendeur', '$nomVendeur', '$mailVendeur', '1', '$avatar', '$fond')";
				$result = mysqli_query($db_handle,$sql); 
				$reussi = "inscription faite";
				header('Location:indexConnecteVendeur.php');
			}
		}
		elseif ($categorie == "acheteur") {
			$sql = "SELECT MAX(ID) FROM acheteur";
			$result = mysqli_query($db_handle, $sql); 
			$data = mysqli_fetch_assoc($result);
			$Identifiant = $data['MAX(ID)'] + 1;

			if($pseudo!= ""){
				$sql ="SELECT * FROM acheteur WHERE Pseudo = '$pseudo'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurPseudo = "Pseudo déjà existant";
					$failed = 1;
				}
				$sql ="SELECT * FROM vendeur WHERE Pseudo = '$pseudo'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurPseudo = "Pseudo déjà existant";
					$failed = 1;
				}
				$sql ="SELECT * FROM admin WHERE Pseudo = '$pseudo'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurPseudo = "Pseudo déjà existant";
					$failed = 1;
				}
			}
			if ($mailVendeur!= "") {
				$sql ="SELECT * FROM acheteur WHERE Email = '$mail'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurMail = "Mail déjà existant";
				}
				$sql ="SELECT * FROM vendeur WHERE Email = '$mail'";
				$result = mysqli_query($db_handle,$sql);
				if (mysqli_num_rows($result) != 0) {
					$erreurMail = "Mail déjà existant";
					$failed = 1;
				}
			}
			if ($contrat != 'on') {
				$erreurContrat = "Veuillez accepter les conditions d'utilisation";
				$failed = 1;
			}

			if ($pseudo !="" && $nom !="" && $prenom !="" && $password !="" && $mail !="" && $adresse1 !="" && $ville !="" && $codepostal !="" && $pays !="" && $telephone !="" && $paiement !="" && $failed !=1 && $cb !="" && $nomCb !="" && $dateCb !="" && $code !=""){
				$sql = "INSERT INTO acheteur(ID, Pseudo, Nom, Prenom, Password, Email, Adresse1, Adresse2, Ville, CodePostal, Pays, Telephone, Paiement, CarteBancaire, NomCarteB, DateExpCarteB, Crypto, Etat)VALUES('$Identifiant','$pseudo', '$nom', '$prenom', '$password', '$mail','$adresse1','$adresse2','$ville','$codepostal','$pays','$telephone','$paiement', '$cb', '$nomCb', '$dateCb', '$code','1')"; 
				$result = mysqli_query($db_handle,$sql);
				$reussi = "inscription faite";
				header('Location:indexConnecteAcheteur.html');
			}
		}
		else{
			echo "Erreur";
		}
	} else {
		echo "Database not found";
	}
}
//fermer la connexion
mysqli_close($db_handle);

?>

<!DOCTYPE html>
<html>
<head>
	<title>S'inscrire</title>
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

	<form action="inscription.php" method="post">
		<div id="erreur">
			<?php if( !empty( $erreurChamp ) ) echo '<p style="text-align: center;" >', $erreurChamp, '</p>' ?>
			<?php if( !empty( $erreurPseudo ) ) echo '<p style="text-align: center;" >', $erreurPseudo, '</p>' ?>
			<?php if( !empty( $erreurMail ) ) echo '<p style="text-align: center;" >', $erreurMail, '</p>' ?>
			<?php if( !empty( $erreurContrat ) ) echo '<p style="text-align: center;" >', $erreurContrat, '</p>' ?>
			<?php if( !empty( $reussi ) ) echo '<p style="text-align: center;" >', $reussi, '</p>' ?>
		</div>
		<div class="choix" id="cat">
			<p style="text-align: center;"><input type="radio" name="categorie" value="acheteur" onclick="document.getElementById('acheteur').style.display='inline'; document.getElementById('vendeur').style.display='none'">
				<label for="acheteur">Acheteur</label>
				<input type="radio" name="categorie" value="vendeur"  onclick="document.getElementById('acheteur').style.display='none'; document.getElementById('vendeur').style.display='inline'">
				<label for="vendeur">Vendeur</label>
			</p> <br>

		</div>

		<div id = "vendeur" style="display: none;" >
			<label for="nom">Nom</label>
			<input type="text" placeholder="Entrez votre nom" name="nomVendeur">

			<label for="pseudo">Pseudo</label>
			<input type="text" placeholder="Entrez un pseudo" name="pseudoVendeur">

			<label for="mail">E-Mail</label>
			<input type="email" placeholder="Saississez un e-mail valide" name="mailVendeur">

			<label for="mdp">Mot de Passe</label>
			<input type="password" name="mdpVendeur">

			<label for="avatar">Choisissez votre avatar</label>
			<input type="file" name="avatar">
			<br>

			<label for="fond">Choisissez votre fond</label>
			<input type="file" name="fond">

		</div>

		<div class="acheteur" id = "acheteur" style="display: none;">

			<label for="prenom">Prénom</label>
			<input type="text" placeholder="Entrez votre prenom" name="prenom">

			<label for="nom">Nom</label>
			<input type="text" placeholder="Entrez votre nom" name="nom">
			
			<label for="pseudo">Pseudo</label>
			<input type="text" placeholder="Entrez un pseudo" name="pseudo">
			
			<label for="mail">E-Mail</label>
			<input type="email" placeholder="Saissisez un mail valide" name="mail">
			
			<label for="adress1">Adresse 1</label>
			<input type="text" placeholder="Entrez votre adresse" name="adress1">
			
			<label for="adress2">Complément d'adresse</label>
			<input type="text" placeholder="Bis,batiment,etage..." name="adress2">
			
			<label for="ville">Ville</label>
			<input type="text" placeholder="Entrez votre ville" name="ville">
			
			<label for="cp">Code Postal</label>
			<input type="text" placeholder="Entrez votre Code Postal" name="cp">
			
			<label for="pays">Pays</label>
			<input type="text" placeholder="Entrez votre pays" name="pays">
			
			<label for="tel">Téléphone</label>
			<input type="tel" placeholder="Entrez un numéro de téléphone" name="tel" maxlength="10">
			<br><br>

			<label>Moyen de paiement :</label>
			<label for="Visa">Visa</label> <input type="radio" name="paye" value="Visa">
			<label for="Mastercard">Mastercard</label> <input type="radio" name="paye" value="Mastercard">
			<label for="Paypal">Paypal</label> <input type="radio" name="paye" value="Paypal"> 
			<label for="Ore"> Øre</label> <input type="radio" name="paye" value="Ore">
			<br><br>

			<label for="cb">Numéro de Carte </label> <input type="tel" name="cb" maxlength="16">
			<br>

			<label for="nomCb">Nom sur la carte </label><input type="text" name="nomCb" width="50px">
			<br>
			<label for="dateCb">Date expiration </label> <input type="date" name="dateCb">
			<br>
			<label for="code">Cryptogramme visuel </label> <input type="tel" name="code" minlength="3" maxlength="4">
			<br>
			<label for="mdp">Mot de Passe</label>
			<input type="password" name="mdp">
			<br>
			<input type="checkbox" name="contrat">Accepter les conditions d'utilisation.
		</div>

		<p style="text-align: center;"><input type="submit" name="enregistrer" value="S'enregistrer"></p>

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