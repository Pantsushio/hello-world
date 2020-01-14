<!doctype html>
<HTML lang="fr">
	<meta charset="utf-8">
	<HEAD>
		<TITLE> Inscription  </TITLE>
		<link rel="stylesheet" href="StyleFormExo2.css">
	</HEAD>
	<BODY>
	<?php
	/****************************************************************************************
	nom du script : inscription.php
	objectif: ce script propose un formulaire d'inscription. Une fois le formulaire soumis
		les données sont enregistrées dans la base de donnée. Le mot de passe est crypté.
	version 1.0
	date 13/12/2019
	auteur: Célia Mailfert
	profession: élève BTS SNIR
	****************************************************************************************/
	
	if (isset($_POST["Valider"]))
	{
	/* récup des données*/
	$email_Lu=utf8_decode($_POST['zoneEmail']);
	$confirmationEmail_Lu=utf8_decode($_POST['zoneConfirmEmail']);
	$mdp_Lu=utf8_decode($_POST['zoneMdp']);
	$confirmationMdp_Lu=utf8_decode($_POST['zoneConfirmMdp']);
	
	/*eviter les fraudes*/
	$email_Lu				=sanitizeString($email_Lu);
	$confirmationEmail_Lu	=sanitizeString($confirmationEmail_Lu);
	$mdp_Lu					=sanitizeString($mdp_Lu);
	$confirmationMdp_Lu		=sanitizeString($confirmationMdp_Lu);
	
	/*parametre de connexion*/
	$host			='localhost';
	$user			='User';
	$password		='snir@snir2019';
	$mabase			='biblio';
	
	
	//tentative de connexion au SGBD
				if ($conn = mysqli_connect($host,$user,$password,$mabase))
				{
					// on hache le mot de passe
					$Mdp_hash = password_hash($mdp_Lu, PASSWORD_DEFAULT);
					
							
					
					// preparation de la requete d'insertion des données
					$reqInsert = "INSERT INTO connexion(email,mdp)
					              VALUES ('$email_Lu','$Mdp_hash')";
					// on tente d'envoyer la requête
					if($result = mysqli_query($conn, $reqInsert, MYSQLI_USE_RESULT))
					{
						// requete on appelle le script "affiche_livre.php"
						echo " inscription réalisée ";
						echo '<a href="index.html">retour au menu</a>';
					}
					else
					{
						// erreur de requête
						echo $reqInsert ;
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
		<h1> Inscription </h1>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<!-- définition des éléments du formulaire -->
			<div><!-- zone de l'email -->
				<tr>
					<th><label for="zoneEmail"> Email : </label></th>
					<td><input type="email"  id="zoneEmail" name="zoneEmail" placeholder="votre email ?" required>	</td>
				</tr>				
			</div>
			<div><!-- zone confirmation -->
				<tr>
					<th><label for="zoneConfirmEmail"> confirmer l'email : </label></th>
					<td><input type="email"  id="zoneConfirmEmail" name="zoneConfirmEmail" placeholder="confirmation email" required></td>
				</tr>
			</div>
			<div><!-- zone du mdp -->
				<tr>
					<th><label for="zoneMdp"> Mot de passe : </label></th>
					<td><input type="password"  id="zoneMdp" name="zoneMdp" placeholder="votre mot de passe ?" required></td>
				</tr>
			</div>
			<div><!-- zone confirmation -->
				<tr>
					<th><label for="zoneConfirmMdp"> confirmer mot de passe : </label></th>
					<td><input type="password" id="zoneConfirmMdp" name="zoneConfirmMdp" placeholder="confirmation de votre mot de passe" 
				    name="user_prenom" required></td>
				</tr>
			</div>
			<div class="button">
				<button type="submit" name="Valider"> Valider </button>
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