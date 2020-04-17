<?php

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$ID = $_GET['id'];

if ($db_found) { //si la base de données est bien connectée
		$sql = "DELETE FROM item WHERE ID = '$ID'";
		$result = mysqli_query($db_handle, $sql);
		header('Location: gereVente.php');
}else{
	echo "Dtatabase not found";
}

//fermer la connexion
mysqli_close($db_handle);
?>