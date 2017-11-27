<?php

require('./connexion_sql.php');
echo "lien vers la <a href='http://www.php.net/manual/fr/mysqli.summary.php'>doc</a> mysqli <br> <br>";
echo "Debut du script";
echo " <br> ------- <br>";


// Requete 1 : select tout

//$requete = "SELECT * FROM fruits WHERE 1";
//$resultat     = mysqli_query($conn, $requete);

//echo "<br> On utilise mysqli_fetch_assoc <br>";
//while($donnees = mysqli_fetch_assoc($resultat)) {
	//echo $donnees['id_fruit'];
	//echo ". ". $donnees['nom'];
	//echo "<br>";
//}
//mysqli_free_result($resultat);

//echo "<br><br><br> Requetes préparées <br><br>";
//echo "<table style='border: 1px solid black'>";
//echo "<tr><th>Lettre</th><th>Correspondance</th></tr>";
//echo "<tr><td>i</td> <td>Nombre Entier</td></tr>";
//echo "<tr><td>d</td> <td>Nombre Décimal</td></tr>";
//echo "<tr><td>s</td> <td>String</td></tr>";
//echo "</table>";


//$requete2 = "SELECT * FROM fruits WHERE id_fruit > ?";
//$req_pre = mysqli_prepare($conn, $requete2);

//$id_fruit = 0;
//mysqli_stmt_bind_param($req_pre, "i", $id_fruit);
//mysqli_stmt_execute($req_pre);
//mysqli_stmt_bind_result($req_pre,$donnees['id_fruit'], $donnees['nom'], $donnees['maj']);

//mysqli_stmt_store_result($req_pre);
//$nbr_lignes = mysqli_stmt_num_rows($req_pre);
//echo "<br> Il y a $nbr_lignes ligne(s)<br>";

//while(mysqli_stmt_fetch($req_pre)) {
	//var_dump($donnees);
	  //echo "<br>";
//}

echo "<br> sans requete prepare<br>";
$sql = "SELECT * FROM fruits WHERE id_fruit > 0";
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}
echo 'Total results: ' . $result->num_rows;
while($row = $result->fetch_assoc()){
	var_dump($row);
}
$result->free();


// Insertion en bdd


if (isset($_GET['fruit'])) {
	$nouveau_fruit = $_GET['fruit'];
	$nouveau_fruit = strip_tags(trim($nouveau_fruit));
	echo "<br>le novueau fruit a enregistre est : $nouveau_fruit <br>";

	$requete3 = "INSERT INTO fruits (nom) VALUE (?)";
	$req_pre3 = mysqli_prepare($conn, $requete3);
	mysqli_stmt_bind_param($req_pre3, "s", $nouveau_fruit);
	if (mysqli_stmt_execute($req_pre3)){
		echo "<br>le fruit : $nouveau_fruit a été enregistré <br>";
	}

	echo "<br> On affiche le résultat : <br>";
	afficher_toutes_les_lignes();
} else {
	echo "<br> Pas de nouveau fruit <br>";
}



function afficher_toutes_les_lignes(){
	global $conn;
	$requete = "SELECT * FROM fruits WHERE 1";
	$resultat     = mysqli_query($conn, $requete);

	echo "<br> On utilise mysqli_fetch_assoc <br>";
	while($donnees = mysqli_fetch_assoc($resultat)) {
		echo $donnees['id_fruit'];
		echo ". ". $donnees['nom'];
		echo "<br>";
	}
	mysqli_free_result($resultat);

}
