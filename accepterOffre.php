<?php

$IDObjet = $_GET['id'];

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($db_found) {
	$sql ="SELECT * FROM vendeur WHERE Etat = 1";
	$result = mysqli_query($db_handle, $sql); 
	if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'admin connecté
	$sql ="SELECT * FROM acheteur WHERE Etat = 1";
	$result = mysqli_query($db_handle, $sql);
	if (mysqli_num_rows($result) == 0) {
		$sql ="SELECT * FROM admin WHERE Etat = 1";
		$result = mysqli_query($db_handle, $sql);
		if (mysqli_num_rows($result) == 0) {
			echo "Erreur : pas d'utilisateur connecté";
		}else{
			$sql ="SELECT * FROM item WHERE ID = '$IDObjet'";
			$result = mysqli_query($db_handle, $sql); 
			if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objet 
				echo "Erreur : pas d'objet trouvé";
			}else{
				$data = mysqli_fetch_assoc($result);
				$nouveauPrix = $data['Offre'];
				$sql = "UPDATE item SET Prix = '$nouveauPrix', Offre = 0, NbOffre = 0, Nego = 1 WHERE ID = '$IDObjet'";
				$result = mysqli_query($db_handle, $sql); 
				header('Location: indexadmin.php');
			}
		}
		}else{//on trouve un acheteur connecté
			$sql ="SELECT * FROM item WHERE ID = '$IDObjet'";
			$result = mysqli_query($db_handle, $sql); 
			if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objet 
			echo "Erreur : pas d'objet trouvé";
		}else{
			$data = mysqli_fetch_assoc($result);
			$nouveauPrix = $data['ContreOffre'];
			$sql = "UPDATE item SET Prix = '$nouveauPrix', Offre = 0, NbOffre = 0, Nego = 1, ContreOffre = 0 WHERE ID = '$IDObjet'";
			$result = mysqli_query($db_handle, $sql); 
			header('Location: panier.php');
		}
	}
	}else{//on trouve un vendeur connecté
		$sql ="SELECT * FROM item WHERE ID = '$IDObjet'";
		$result = mysqli_query($db_handle, $sql); 
		if (mysqli_num_rows($result) == 0) {//on ne trouve pas d'objet 
		echo "Erreur : pas d'objet trouvé";
	}else{
		$data = mysqli_fetch_assoc($result);
		$nouveauPrix = $data['Offre'];
		$sql = "UPDATE item SET Prix = '$nouveauPrix', Offre = 0, NbOffre = 0, Nego = 1 WHERE ID = '$IDObjet'";
		$result = mysqli_query($db_handle, $sql); 
		header('Location: indexConnecteVendeur.php');
	}
}
}else{
	echo "Database not found";
}

mysqli_close($db_handle);

?>	