<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>inscription</title>
	  <link rel="stylesheet" type="text/css" href="Monstyle.css"> 
	</head>
	<body>
		<?php
			/*************************************************************************
				nom du script : inscription.php
				Description   : Ce script propose un exemple de formulaire d'inscription.
								Une fois le formulaire soumis les données sont vérifiées et
								les éléments ajoutés à la base de données.
								Le mot sera enregistré sous une forme criptée.
				Version : 1.0
				Date	: 13/12/2019
				Auteur	: prof
			*************************************************************************/
			
			// on determine si on doit afficher ou traiter le formulaire
			if (isset($_POST["Valider"]))
			{
				// traitement des données envoyées par le formulaire
				
				/* on recupere les données du formulaire et on les "aseptise" avant de les utiliser 
				   pour cela on va creer une fonction de nettoyage qu'on va utiliser
				*/
				  /* on recupere de manière brut les données */
				$email_Lue 			=utf8_decode($_POST['zoneEmail']);
				$ConfirmEmail_Lue 	= utf8_decode($_POST['zoneConfirmEmail']);
				$Mdp_Lue 			= $_POST['zoneMdp'];
				$ConfirmMdp_Lue 	= $_POST['zoneConfirmMdp'];
				
				/* on aseptise les données récupérées avant de les utiliser pour 
				   lutter contre la faille XSS */
				$email_Lue  		= sanitizeString($email_Lue);
				$ConfirmEmail_Lue 	= sanitizeString($ConfirmEmail_Lue);
				$Mdp_Lue  			= sanitizeString($Mdp_Lue);
				$ConfirmMdp_Lue   	= sanitizeString($ConfirmMdp_Lue);
								
				// on se connecte au SGBD
				
				// paramètres de connexion
				$host 	= 'localhost';   
				$user 	= 'user' ;   
				$passwd = 'snir@snir2019';
				$mabase = 'biblio';
			
				/* verifier les données : 
				      - l'email et sa confirmation sont identique
					  - le mot et sa confirmation sont identique 
				*/
				
				//tentative de connexion au SGBD MySQL  
				if ($conn = mysqli_connect($host,$user,$passwd,$mabase))
				{
					// on hache le mot de passe
					$Mdp_hash = password_hash($Mdp_Lue, PASSWORD_DEFAULT);
					
					// preparation de la requete d'insertion des données
					$reqInsert = "INSERT INTO connexion(email,mdp)
					              VALUES ('$email_Lue','$Mdp_hash')";
					// on tente d'envoyer la requête
					if($result = mysqli_query($conn, $reqInsert, MYSQLI_USE_RESULT))
					{
						// requete on appelle le script "affiche_livre.php"
						echo " inscription réalisée vous pouvez vous connecter ";
						echo'<A href="connexion.php">connexion</a>';
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
				<h1>Inscription  </h1>
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						<!-- zone de l'émail -->
						<label for="zoneEmail">Email : </label>
						<input type="email" id="zoneEmail" placeholder="Entrez votre émail"
						  name = "zoneEmail" required>
					</div>
					<div>
						<!-- zone confirmation  -->
						<label for="zoneConfirmEmail">Confirmation émail : </label>
						<input type="email" id="zoneConfirmEmail" placeholder="Confirmer votre émail"
						  name = "zoneConfirmEmail" required>
					</div>
					<div>
						<label for="zoneMdp">Mot de passe : </label>
						<input type="password" id="zoneMdp" placeholder="Entrez votre mot de passe"
						  name = "zoneMdp" required>
					</div>
					<div>
						<label for="zoneConfirmMdp">Mot de passe : </label>
						<input type="password" id="zoneConfirmMdp" placeholder="Confirmer votre mot de passe"
						  name = "zoneConfirmMdp" required>
						
					</div>
					<div class="button">
						<!-- Zone du bouton valider -->
						<button type="submit" name= "Valider"> Valider </button>
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
	
	</body>
</html>