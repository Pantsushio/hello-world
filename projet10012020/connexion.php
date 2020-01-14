<!doctype html>
<HTML lang="fr">
	<meta charset="utf-8">
	<HEAD>
		<TITLE> Connexion  </TITLE>
		<link rel="stylesheet" href="StyleFormExo2.css">
	</HEAD>
	<BODY>
	<?php
	/*****************************************************************************************
	nom du script : connexion.php
	objectif: ce script propose un formulaire de connexion. Une fois le formulaire soumis
		les données sont comparées à celle enregistrées dans la base de donnée. 
		Si les settings de co sont corrects, alors on enregistre l'email de l'utilisateur 
		dans une variable de session. et on indique à l'utilisateur qu'il est co.
	version 1.0
	date 13/12/2019
	auteur: Célia Mailfert
	profession: élève BTS SNIR
	*****************************************************************************************/
	
	if (isset($_POST["Valider"]))
	{
	/* récup des données*/
	$email_Lu=utf8_decode($_POST['zoneEmail']);
	$mdp_Lu=utf8_decode($_POST['zoneMdp']);
	
	/*eviter les fraudes*/
	$email_Lu				=sanitizeString($email_Lu);
	$mdp_Lu					=sanitizeString($mdp_Lu);
	
	/*parametre de connexion*/
	$host			='localhost';
	$user			='User';
	$password		='snir@snir2019';
	$mabase			='biblio';
	
	
	//tentative de connexion au SGBD
				if ($conn = mysqli_connect($host,$user,$password,$mabase))
				{
					
					
							
					
					// preparation de la requete de récupération des données de connexion
					$req = "SELECT * FROM connexion WHERE email = '$email_Lu'";
					// on tente d'envoyer la requête
					if($result = mysqli_query($conn, $req))
					{
						/* On test pour voir si la req a renvoyé des éléments
						si c'est le cas on va comparer le mot de passe crypté au mdp saisis
						Si tout est ok on crée une variable de session pour mémoriser de page 
						en page l'email de l'utilisateur
						*/
						//on test que le nombre de lign renvoyée par la requete est > 0
						$nbLignes = mysqli_num_rows($result);
						if($nbLignes ==1)
						{
							//extraction de la ligne envoyé par la requete
							$row =mysqli_fetch_assoc($result);
							//recup du mot de passe dans la ligne
							$mdp_hash_BD = utf8_encode($row['mdp']);
							//extraction des données envoyées par la requete
							//on compare le mdp envoyé à celui enregistré (crypté)//
							if (password_verify($mdp_Lu, $mdp_hash_BD))
							{
								echo 'Vous êtes connecté';
								echo '<a href="index.html">retour au menu</a>';
							}
							else{
								echo 'paramètres de connexion non valides';
							}
						}
						else{
							
						}
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
	
	?>
		<h1> Connexion </h1>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<!-- définition des éléments du formulaire -->
			<div><!-- zone de l'email -->
				<tr>
					<th><label for="zoneEmail"> Email : </label></th>
					<td><input type="email"  id="zoneEmail" name="zoneEmail" placeholder="votre email" required></td>
				</tr>				
			</div>
			<div><!-- zone mot de passe -->
				<tr>
					<th><label for="zoneMdp"> Mot de passe : </label></th>
					<td><input type="password"  id="zoneMdp" name="zoneMdp" placeholder="votre mot de passe" required></td>
				</tr>

			<div class="button">
				<br><button type="submit" name="Valider"> Valider </button>
			</div>
		</form>
		<?php
				
				
			}
			
			
			/* Fonctions pour aseptiser les données utilisateurs */
			// aseptiser les chaines de caractères
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
	</BODY>
</HTML>