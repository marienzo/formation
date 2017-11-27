<?php


echo "<h1>manipulations de données: le modèle <a href='https://fr.wikipedia.org/wiki/CRUD'>CRUD</a></h1>";
echo "lien vers la <a href='http://php.net/manual/fr/class.pdo.php'>doc PDO de PHP</a> <br> <br>";

echo "<h3>Paramètre possibles dans l'URL: fruit | par | efface </h3>";
echo "<strong>exemple:</strong> ".basename(__FILE__)."?fruit=pomme&par=figue&efface=poire";

// On vérifie que le nom de base de données correspond, mais également le nom d'utilisateur et mot de passe

require_once('./connexion.php');
//ou
//$bdd = new PDO('mysql:host=localhost;dbname=formation;charset=utf8', 'root', '');


echo "<h2>Que récupère t'on comme variables envoyées?</h2>";

$Trecup = array();
if (isset($_GET))
	$Trecup = $_GET;
elseif (isset($_POST))
	$Trecup = $_POST;
if (count($Trecup)) 
	foreach ($Trecup as $cle=>$val) 
		echo "clé: $cle => val: $val<br>";
else echo 'pas de $_GET ou $_POST';


echo "<h2>Lire la BDD (Read)</h2>";

$requete = "SELECT * FROM fruits";
/*
 * méthode avec fetch() : boucler dans les lignes
 */
if ($req_fruits = $bdd->query($requete)) {
	while ($ligne = $req_fruits->fetch()) {
		//var_dump($ligne);
		echo 'ligne: '.$ligne['id_fruit'].' '.$ligne['nom'].'<br>';
	}
	
/* 
 * méthode avec fetchAll() : créer un array de tous les résultats qu'on exploite après
 * 
	$les_fruits = $req_fruits->fetchAll();
	foreach  ($les_fruits as $fruit) {
		print $fruit['id_fruit'] . ": ";
		print $fruit['nom'] . "<br>";
	}
*/
}


if (isset($_GET['fruit']) and !isset($_GET['par'])) {
	$nouveau_fruit = $_GET['fruit'];
	$nouveau_fruit = strip_tags(trim($nouveau_fruit));
	
	// protection variables
	$nouveau_fruit = $bdd->quote($nouveau_fruit);
	echo "<br>le nouveau fruit à enregistrer est : $nouveau_fruit <br>";

	$requete3 = "INSERT INTO fruits (nom) VALUE ($nouveau_fruit)";
	if(!$bdd->query($requete3))
		echo($bdd->errorInfo()[2]);

	afficher_toutes_les_lignes();
}
else {
	echo "<br> Pas de nouveau fruit <br>";
}


echo "<h2>Mise à jour en BDD (Update)</h2>";
if (isset($_GET['fruit']) and isset($_GET['par'])) {
	$fruit_a_modifier = strip_tags(trim($_GET['fruit']));
	$nouveau_fruit = strip_tags(trim($_GET['par']));
	echo "<br> modifier le fruit : $fruit_a_modifier par $nouveau_fruit<br>";

	$requete4 = "UPDATE fruits SET nom = '$nouveau_fruit' WHERE nom = '$fruit_a_modifier'";
	if(!$bdd->query($requete4))
		print_r($bdd->errorInfo());

	afficher_toutes_les_lignes();
}
else {
	echo "<br> Rien a modifier <br>";
}

echo "<h2>Effacer en BDD (Delete)</h2>";
if (isset($_GET['efface'])) {
	$fruit_a_effacer = strip_tags(trim($_GET['efface']));
	echo "<br> effacer le fruit : $fruit_a_effacer <br>";

	$requete5 = "DELETE FROM fruits WHERE nom = '$fruit_a_effacer'";
	if(!$bdd->query($requete5))
		print_r($bdd->errorInfo());

	afficher_toutes_les_lignes();
}
else {
	echo "<br> Rien a effacer <br>";
}


function afficher_toutes_les_lignes(){
	global $bdd;
	$les_fruits = array();

	$requete = "SELECT * FROM fruits";
	if ($req_fruits = $bdd->query($requete)) {
		$les_fruits = $req_fruits->fetchAll();
//	var_dump($les_fruits);

		foreach  ($les_fruits as $row) {
			print $row['id_fruit'] . " : ";
			print $row['nom'] . "<br>";
		}
	}
}
