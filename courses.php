<?php 
$bdd = new PDO('mysql:host=localhost;dbname=exo_php;charset=utf8', 'root', '');	

/*pour supprimer un produit avec l'icone poubelle*/
if (isset($_GET['efface'])) {
	$fruit_a_effacer = strip_tags(trim($_GET['efface']));
	$fruit_a_effacer = intval($fruit_a_effacer);
	
	$requete5 = "DELETE FROM mes_courses WHERE id_produit = $fruit_a_effacer";
	if(!$bdd->query($requete5))
		print_r($bdd->errorInfo());

}
// ajouter de nouveaux produits
$Tentrees = ['nx_prod1', 'qt_prod1', 'nx_prod3'];
foreach ($Tentrees as $nx_prod) {
	$$nx_prod = FALSE; 
	if (isset($_GET[$nx_prod])){
		$$nx_prod = $_GET[$nx_prod];
	}
	elseif (isset($_POST[$nx_prod])){
		$$nx_prod = $_POST[$nx_prod];
	}
}

/*requete pour inserer dans ma bdd mes nouveaux produits sans ajout de quantité*/
if ($nx_prod1){ 
$nx_prod1= $bdd->quote($nx_prod1);
$qt_prod1= $bdd->quote($qt_prod1);
	/*je veux savoir s'il existe déjà des fruits du même nom*/
	$req_prod = " SELECT * FROM mes_courses WHERE nom_produit = $nx_prod1";
	if ($req = $bdd->query($req_prod)) {
		$Tlignes = $req->fetchAll();

		if (count($Tlignes) != 0) {
			echo "ce produit existe déjà";
		}

		else { 
			/*j'insère de nouveaux produits*/
			$req_prod = "INSERT INTO mes_courses (nom_produit, quantite_produit) VALUES ($nx_prod1, $qt_prod1)";
				
				if($bdd->query($req_prod)){ 

			}
			else echo('erreur mysql 1:'. $bdd->errorInfo()[2]);
		}
	}
	else {
		echo ('erreur mysql 2:'. $bdd->errorInfo()[2]);
	}
}

?>


<!DOCTYPE html>
<html lang="fr"> 

<head>
	<meta charset="utf-8" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Liste de courses</title>
	
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />

	
</head>


<body>
	<div class="container">
		<header id="header"></header>
	</div>
	<content >

		<?php		

// affiche dans un tableau
		echo '<div class="container">';
		echo '<table class="table table-responsive-xl">';
		echo '<thead>
		<tr>
		<th scope="col">Produits</th>
		<th scope="col">Quantités</th>
		<th scope="col">Fait</th>
		<th scope="col">Suppression</th>
		</tr>
		</thead>';

		/*lien qui efface ma ligne et j'intègre une fontawesome*/
		/*echo '<a href="localhost/php/courses.php?efface=3"><i class="fa fa-trash" aria-hidden="true"></i></a>';*/

		/*affiche ma liste de courses*/
		$requete = "SELECT * FROM mes_courses"; 
		if ($req_course = $bdd->query($requete)) { 
			$liste_course = $req_course->fetchAll(); 

			foreach  ($liste_course as $row) {

/*variable checked pour transformer mes oui/non en bouton coché/non coché
je fais une condition if pour lui dire de remplacer 
ma variable $row[fait] par un bouton*/ 

			$checked = '';
			if ($row['fait'] == "oui") {
				$checked = "checked";
			}
			

		echo "<tr class=".$checked.">";
		echo "<td>".$row['nom_produit']."</td>";
		echo "<td>".$row['quantite_produit']."</td>";
		echo "<td> <input type='checkbox'". $checked ."> </td>";
		echo "<td><a href='http://localhost/php/courses.php?efface=".$row['id_produit']."'><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
		echo "</tr>";

			}
		}

/*je fais la somme totale de la quantité de mes courses*/
		$total = 'SELECT SUM(quantite_produit) AS total FROM mes_courses';
		if ($total_prod = $bdd->query($total)){
			$quantite = $total_prod->fetch();

			echo "<td>".$quantite['total']."</td></tr>";

		}
/*je fais la somme de mes éléments non cochés*/
		$total2 = 'SELECT SUM(quantite_produit) AS fait FROM mes_courses WHERE fait = "non"';
		if ($total_coche = $bdd->query($total2)){
			$quant_coche = $total_coche->fetch();

			echo "<tr><td>".$quant_coche['fait']."</td>";

		}

		echo'<tfoot><tr><td scope="col"></td></tr></tfoot>';
		echo '</table></div>';

?>

		<div class="container col-4">
			<form>

				<label for="nx_produits">je rajoute de nouveaux Produits</label>
				<br>
				Produit 1 : <input type="text" class="form-control" id="nx_produits" name="nx_prod1" value=""> 
				Quantitié : <input type="int" class="form-control" id="nx_produits" name="qt_prod1" value=""> 
				<br>

				<?php echo "le produit : ".$nx_prod1." a été ajouté"?>
				<br>
				<br>
				<br>
				<!-- Produit 2 : <input type="text" class="form-control" id="nx_produits" name="nx_prod2" value="">
				<br>
				Produit 3 : <input type="text" class="form-control" id="nx_produits" name="nx_prod3" value="">
				<br> -->
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>

	</content>

<footer id="footer">
</footer>

</body>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/popper.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/site.js" type="text/javascript"></script>

</html>