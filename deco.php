<?php

//identifier votre BDD
$database = "midgard";
//connectez-vous dans votre BDD
//Rappel: votre serveur = localhost |votre login = root |votre password = <rien>
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

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
			}else{
				$sql = "UPDATE admin SET Etat = 0 WHERE Etat = 1";
				$result = mysqli_query($db_handle, $sql);
				header('Location: index.html');
			}
		}else{
			$sql = "UPDATE acheteur SET Etat = 0 WHERE Etat = 1";
			$result = mysqli_query($db_handle, $sql);
			header('Location: index.html');
		}
	}else{
		$sql = "UPDATE vendeur SET Etat = 0 WHERE Etat = 1";
		$result = mysqli_query($db_handle, $sql);
		header('Location: index.html');
	}
}else{
	echo "Database not found";
}
mysqli_close($db_handle);

?>