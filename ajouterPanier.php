<?php

//identifier votre BDD
$database = "midgard";

//connectez-vous dans votre BDD
//Rappel: votre serveur = localhost |votre login = root |votre password = <rien>
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$IDAcheteur = '';
$IDObjet = $_GET['id'];
$page = $_GET['page'];


if($db_found){
	$sql ="SELECT * FROM acheteur WHERE Etat = 1";
	$result = mysqli_query($db_handle,$sql);
	if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'acheteur connecté
	echo "Erreur : pas d'utilisateur connecté";
	}else{//on trouve un acheteur connecté
			$data = mysqli_fetch_assoc($result);
			$IDAcheteur = $data['ID'];
			$sql = "UPDATE item SET IDAcheteur = '$IDAcheteur' WHERE ID = '$IDObjet'";
			$result = mysqli_query($db_handle,$sql);
			header('Location: '.$page);
		}	
	}else{
	echo "Database not found";
}
mysqli_close($db_handle);

?>


