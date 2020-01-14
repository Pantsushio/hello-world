<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Accueil du site</title>
	  <link rel="stylesheet" type="text/css" href="Monstyle.css"> 
	</head>
	<body>
			<h1>Livres de la bibliothèque </h1>
			<!--Définition d'un tableau HTML -->
			<table> 
				<tr><th>Numlivre</th><th>Titre</th><th>Auteur</th><th>Genre</th><th>Prix</th></tr>
		   
		  <?php
			/*************************************************************************
				nom du script : affiche_livre.php
				Description : ce script se connecte au SGBD MySQL,
				              envoie une requête pour recuperrer les données
							  de la table livre et affiche le résultat dans un
							  tableau HTML
				Version : 1.0
				Date	: 15/11/2019
				Auteur	: laurent
			*************************************************************************/
			
			// paramètres de connexion
			$host 	= 'localhost';
			$user 	= 'user' ;   
			$passwd = 'snir@snir2019';
			$mabase = 'biblio';
			
			//tentative de connexion au SGBD MySQL  
			if ($conn = mysqli_connect($host,$user,$passwd,$mabase))
			{
				// connexion à la base de données OK
				// preparation de la requête
				$req = "SELECT * FROM livre";	
				
				// envoie de la requete
				if($result = mysqli_query($conn, $req, MYSQLI_USE_RESULT))
				{
					// requête ok il faut traiter la réponse
					// tant qu'il y a des ligne à traiter
					while ( $row =mysqli_fetch_assoc($result))
					{
						// on recupere les champs de la ligne
						$numLivreLue 	= $row['numlivre'];
						$titreLue 		= utf8_encode ($row['titre']);
						$auteurLue 		= utf8_encode ($row['auteur']);
						$genreLue 		= utf8_encode ($row['genre']);
						$prixLue 		= $row['prix'];
						
						// afficher la ligne
						echo "<tr><td>$numLivreLue</td><td>$titreLue</td><td>$auteurLue</td> 
						<td>$genreLue</td><td>$prixLue</td></tr>";
					}
				}
				else{
					// erreur de requête
					die ("erreur de requête");
				}
			}
			else{
					// echec de la connexion à la BD 
				die("problême de connexion au serveur de base de données");	
			}
				
			
		  
		  <a href="index.html">menu</a> <br>
		  
		  
		  ?>
			</table>
	</body>
</html>
