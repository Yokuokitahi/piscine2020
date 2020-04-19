<?php

$database = "midgard";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);
$ID = $_GET['id'];

if ($db_found) { //si la base de données est bien connectée
		$sql = "UPDATE item SET IDAcheteur = '0', Offre = '0', ContreOffre = '0' , NbOffre ='0' WHERE ID = '$ID'";
		$result = mysqli_query($db_handle, $sql);
		header('Location: panier.php');
}else{
	echo "Database not found";
}
//fermer la connexion
mysqli_close($db_handle);
?>