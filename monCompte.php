<?php

//identifier votre BDD
$database = "midgard";
//connectez-vous dans votre BDD
//Rappel: votre serveur = localhost |votre login = root |votre password = <rien>
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$compte = '';

//variables Vendeur
$nomVendeur ='';
//variables Admin
$pseudoAdmin = '';
//variables Acheteur
$nom ='';
$prenom ='';
$adresse ='';
$email ='';
$paiement ='';

if($db_found){
	$sql ="SELECT * FROM vendeur WHERE Etat = 1";
	$result = mysqli_query($db_handle,$sql);
	if (mysqli_num_rows($result) == 0) {//on ne trouve pas de vendeur connecté
		$sql ="SELECT * FROM acheteur WHERE Etat = 1";
		$result = mysqli_query($db_handle,$sql);
		if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'acheteur connecté
			$sql ="SELECT * FROM admin WHERE Etat = 1";
			$result = mysqli_query($db_handle,$sql);
			if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'admin connecté
				echo "Erreur : pas d'utilisateur connecté";
			}else{//on trouve un admin connecté
				$compte = 'admin';
				$data = mysqli_fetch_assoc($result);
				$pseudoAdmin = $data['Pseudo']; 
			}
		}else{//on trouve un acheteur connecté
			$compte = 'acheteur';
			$data = mysqli_fetch_assoc($result);
			$nom = $data['Nom']; 
			$prenom = $data['Prenom']; 
			if ($data['Adresse2'] == "") {
				$adresse = $data['Adresse1'] .", ". $data['Ville'] ." ". $data['CodePostal'] .", ". $data['Pays'];
			}else{
				$adresse = $data['Adresse1'] .", ". $data['Adresse2'] .", ". $data['Ville'] ." ". $data['CodePostal'] .", ". $data['Pays']; 
			}
			$mail = $data['Email']; 
			$paiement = $data['Paiement']; 
		}
	}else{//on trouve un vendeur connecté
		$compte = 'vendeur';
		$data = mysqli_fetch_assoc($result);
		$nomVendeur = $data['Nom']; 
	}
}else{
	echo "Database not found";
}

echo "ADRESSE " . $adresse;
?>