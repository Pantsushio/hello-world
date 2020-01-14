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
				Auteur	: prof
			*************************************************************************/
			
			// on determine si on doit afficher ou traiter le formulaire
			if (isset($_POST["Valider"]))
			{
				// traitement des données envoyées par le formulaire
				
				/* on recupere les données du formulaire et on les utilise 
				   directement !!!!! danger !!!!!!
				*/
				
				$numlivre_Lue = utf8_decode($_POST['zonenumlivre']);
				$numpersonne_Lue = utf8_decode($_POST['zonenumpersonne']);
				$sortie_Lue = utf8_decode($_POST['zonesortie']);
				// on se connecte au SGBD
				
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
					$reqInsert = " INSERT INTO emprunt (numpersonne, numlivre, sortie)
						           VALUES ('$numlivre_Lue','$numpersonne_Lue','$sortie_Lue')";
								   
					
					// on tente d'envoyer la requête
					if($result = mysqli_query($conn, $reqInsert, MYSQLI_USE_RESULT))
					{
						// requete on appelle le script "affiche_livre.php"
						require_once 'emprunt.php';
						
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
				<h1>nouvelle emprunt  </h1>
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						<!-- zone du nom -->
						<label for="numlivre">numéro du livre: </label>
						<input type="text" id="zonenumlivre" placeholder="Entrez le numéro du livre"
						  name = "zonenumlivre" required>
					</div>
					<div>
						<!-- zone du prenom-->
						<label for="numpersonne">numéro de personne : </label>
						<input type="text" id="zonenumpersonne" placeholder="Entrez le numéro de personne"
						  name = "zonenumpersonne" required>
					</div>

					<div>
						<!-- Zone de la ville-->
						<label for="sortie">Date de sortie : </label>
						<input type="date" id="zonesortie" name = "zonesortie" required>
						
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