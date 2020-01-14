<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Accueil du site</title>
	  <link rel="stylesheet" type="text/css" href="Monstyle.css"> 
	</head>
	<body>
		<?php
			/*************************************************************************
				nom du script : inserrer_livre.php
				Description   : Ce script propose un formulaire pour ajouter les
				     données sur un livre.
					 Lorsque le formulaire est soumis, il recupere les  données,
					 se connecte au serveur de base de données et envoie une 
					 requête d'insertion des données, puis appelle le script
					 qui affiche les livres 
				Version : 1.0
				Date	: 22/11/2019
				Auteur	: moi
			*************************************************************************/
			
			// on determine si on doit afficher ou traiter le formulaire
			if (isset($_POST["Valider"]))
			{
				// traitement des données envoyées par le formulaire
				
				/* on recupere les données du formulaire et on les utilise 
				   directement !!!!! danger !!!!!!
				*/
				
				$nom_Lue = utf8_decode($_POST['zonenom']);
				$prenom_Lue = utf8_decode($_POST['zoneprenom']);
				$ville_Lue = utf8_decode($_POST['zoneville']);
				// on se connecte au SGBD
				
				$nom_Lue = sanitizeString($nom_Lue);
				$prenom_Lue =sanitizeString($prenom_Lue);
				$ville_Lue =sanitizeString($ville_Lue);
				
				// paramètres de connexion
				$host 	= 'localhost';
				$user 	= 'User' ;   
				$passwd = 'snir@snir2019';
				$mabase = 'biblio';
			
				//tentative de connexion au SGBD MySQL  
				if ($conn = mysqli_connect($host,$user,$passwd,$mabase))
				{
					// connexion OK, on prepare la requete et on l'envoie
						
					// préparation de la requête
					$reqInsert = " INSERT INTO personne (nom, prenom, ville)
						           VALUES ('$nom_Lue','$prenom_Lue','$ville_Lue')";
								   
					
					// on tente d'envoyer la requête
					if($result = mysqli_query($conn, $reqInsert, MYSQLI_USE_RESULT))
					{
						// requete on appelle le script "affiche_livre.php"
						require_once 'personnes.php';
						
					}
					else
					{
						// erreur de requête
						die ("erreur de requête");
					}
				}	
				else
				{
					// echec de la connexion à la BD 
					die("problême de connexion au serveur de base de données");	
				}
				
				
				
				
				
				
			}
			else
			{
				// afficher le formulaire
				?>
				<h1>Ajouter une personne  </h1>
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						<!-- zone du nom -->
						<label for="zonenom">nom : </label>
						<input type="text" id="zonenom" placeholder="Entrez votre nom"
						  name = "zonenom" required>
					</div>
					<div>
						<!-- zone du prenom-->
						<label for="zoneprenom">prenom : </label>
						<input type="text" id="zoneprenom" placeholder="Entrez votre prenom"
						  name = "zoneprenom" required>
					</div>

					<div>
						<!-- Zone de la ville-->
						<label for="zoneville">Ville : </label>
						<input type="text" id="zoneville" placeholder="Entrez la ville"
						  name = "zoneville" required>
						
					</div>
					<div class="button">
						<!-- Zone du bouton valider -->
						<button type="submit" name= "Valider"> Valider </button>
					</div>
				</form>
				<?php
				
				
			}
			
			function sanitizeString($var)
			{
				if (get_magic_quotes_gpc())
				{
					// supprimer les slashes
					$var = stripslashes($var);
				}
				// suppression des tags
				$var = strip_tags($var);
				// convertir la chaine en HTML
				$var = htmlentities ($var);
				return $var;
			}
			
			
		?>	
	
	</body>
</html>