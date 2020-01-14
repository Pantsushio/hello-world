<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title> Acceuil du site </title>
		<link rel="stylesheet" type="text/css" href="Monstyle.css">
	</head>
	
	<body>
		<h1>emprunt de la bibliothèque</h1>
		<!--Définition d'un tableau HTML -->
		<table>
			<tr><th>numlivre</th> <th>numpersonne</th> <th> sortie </th> <th>nom</th><th>prenom</th><th>ville</th><th>titre</th><th>auteur</th><th>genre</th><th>prix</th></tr>
		 <?php
			/********************************************************
				nom du script : affiche_livre.php
				Description : ce script se connecte au SGBD MySQL
							 envoie une requête pour recuperrer les 
							 données de la table livre et affiche 
							 le résultat dans un tableau HTML
				Version : 1.0
				Date 	: 15/11/2019
				Auteur  : Laurent
			*********************************************************/
			
			session_start();
			// on verifie qu'il existe une variable de session nommée "emailUser"
			if (isset($_SESSION['emailUser']))
			{
			
				//parametre de connexion
				$host = 'localhost';
				$user = 'user'; // /!\ on n'utilise pas le compte root dans un script
				$passwd = 'snir@snir2019';
				$mabase = 'biblio';
				
				// tentative de connexion au SGBD MySQL
				
				if ($conn = mysqli_connect($host,$user,$passwd,$mabase))
				{
					//connexion à la base de données OK
					//preparation de la requête
					
					$req = "SELECT emprunt.numpersonne, emprunt.numlivre, sortie, nom, prenom, ville, titre, auteur, genre, prix
	from emprunt
			join personne on emprunt.numpersonne=personne.numpersonne
			join livre on emprunt.numlivre=livre.numlivre
			order by (nom) asc";
					
					//envoie de la requête
					
					if($result = mysqli_query($conn, $req, MYSQLI_USE_RESULT))
					{
						// requête ok il faut traiter la réponse
						// tant qu'il y a des ligne à traiter
						while ( $row =mysqli_fetch_assoc($result))
						{
							// on recupere les champs de la ligne
							$numLivreLue 	= $row['numlivre'];
							$numpersonne 		= utf8_encode ($row['numpersonne']);
							$sortie		= utf8_encode ($row['sortie']);

							$nomLue		= utf8_encode ($row['nom']);
							$prenomLue		= utf8_encode ($row['prenom']);
							$villeLue = utf8_encode ($row['ville']);
							$titreLue = utf8_encode ($row['titre']);
							$auteurLue = utf8_encode ($row['auteur']);
							$genreLue = utf8_encode ($row['genre']);
							$prixLue = utf8_encode ($row['prix']);

							
							// afficher la ligne
							echo "<tr> <td>$numLivreLue</td> <td>$numpersonne</td> <td>$sortie</td>  <td>$nomLue</td> 
							<td>$prenomLue</td><td>$villeLue</td><td>$titreLue</td><td>$auteurLue</td><td>$genreLue</td><td>$prixLue</td></tr>";
						}
					}
					else {
						//erreur de requête
						die ("erreur de requête");
					}
				}
				else{
					// echec de la connexion à la BD
					die("erreur de connexion au serveur");
				}
			}
			else
			{
				// variable de session absente
				echo "il faut se connecter pour afficher les livres <BR>";
				echo '<a href ="connexion.php"> se connecter </a>';
			}
			?>
			<br>
			<a href="index.html">menu</a> <br>
	</body>
</html>