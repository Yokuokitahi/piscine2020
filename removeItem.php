<?php

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$ID = $_GET['id'];

if ($db_found) { //si la base de données est bien connectée
	if ($ID == 'Skaway' || $ID == 'Drakking') {
		$sql = "DELETE FROM item WHERE IDVendeur = '$ID'";
		$result = mysqli_query($db_handle, $sql);
		header('Location: indexadmin.php');
	}else{
		$sql = "DELETE FROM item WHERE ID = '$ID'";
		$result = mysqli_query($db_handle, $sql);
		header('Location: indexConnecteVendeur.php');
	}
}else{
	echo "Dtatabase not found";
}

//fermer la connexion
mysqli_close($db_handle);
?>