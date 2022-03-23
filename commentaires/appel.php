<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Document sans titre</title>
<style type="text/css" media="all">
<!--
@import url("../mm_health_nutr.css");
-->
</style>

</head>

<body>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<p align="center"><span class="pageName">Bonjour! </span></p>
<p align="center"><span class="bodyText">Merci</span> <span class="bodyText"><?php echo $_POST['prenom']; ?> <?php echo $_POST['nom']; ?> pour votre message. Il sera lu avec intérêt.</span></p>
<p align="center"><span class="bodyText">P</span><span class="bodyText">our revenir au formulaire <span class="subHeader"><a href="commentaires.htm">cliquez ici</a></span>.</span></p>
<p align="center"><span class="bodyText"> Pour revenir &agrave; l'accueil </span><a href="../index.html"><span class="subHeader">cliquez ici</span></a><span class="bodyText">. </span></p>
<p align="center"><span class="bodyText"> A bientôt sur </span><span class="pageName">Théâtre de sciences</span><span class="bodyText">!</p>
</p>

<?php
// destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
	$destinataire = 'sophcav@yahoo.fr';

	// Messages de confirmation du mail
	$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
	$message_non_envoye = "Le mail a bien été envoyé!";
 

	// Messages d'erreur du formulaire
	$message_erreur_formulaire = "Vous devez d'abord <a href=\"commentaires.htm\">envoyer le formulaire</a>.";
	$message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur. ";

	/*
		********************************************************************************************
		FIN DE LA CONFIGURATION
		********************************************************************************************
	*/

	// on teste si le formulaire a été soumis
	if (!isset($_POST['envoi']))
	{
		// formulaire non envoyé
		echo '<p>'.$message_erreur_formulaire.'</p>'."\n";
	}
	else
	{
		/*
		 * cette fonction sert à nettoyer et enregistrer un texte
		 */
		function Rec($text)
		{
			$text = trim($text); // delete white spaces after & before text
			if (1 === get_magic_quotes_gpc())
			{
				$stripslashes = create_function('$txt', 'return stripslashes($txt);');
			}
			else
			{
				$stripslashes = create_function('$txt', 'return $txt;');
			}

			// magic quotes ?
			$text = $stripslashes($text);
			$text = htmlspecialchars($text, ENT_QUOTES); // converts to string with " and ' as well
			$text = nl2br($text);
			return $text;
		};

		/*
		 * Cette fonction sert à vérifier la syntaxe d'un email
		 */
		function IsEmail($email)
		{
			$pattern = "^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,7}$";
			return (eregi($pattern,$email)) ? true : false;
		};

		// formulaire envoyé, on récupère tous les champs.
		$nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
		$prenom   = (isset($_POST['prenom']))   ? Rec($_POST['prenom'])   : '';
		$email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
		$message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';

		// On va vérifier les variables et l'email ...
		$email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré

		if (($nom != '') && ($prenom != '') && ($email != '') && ($message != ''))
		{
			// les 4 variables sont remplies, on génère puis envoie le mail
			$headers = 'From: '.$nom.' <'.$email.'>' . "\r\n";

			// Remplacement de certains caractères spéciaux
			$message = str_replace("&#039;","'",$message);
			$message = str_replace("&#8217;","'",$message);
			$message = str_replace("&quot;",'"',$message);
			$message = str_replace('<br>','',$message);
			$message = str_replace('<br />','',$message);
			$message = str_replace("&lt;","<",$message);
			$message = str_replace("&gt;",">",$message);
			$message = str_replace("&amp;","&",$message);

			// Envoi du mail
			if (mail($cible, $objet, $message, $headers))
			{ 
		echo '<p>'.$message_envoye.'</p>'."\n";
			}
			else
			{
				echo '<p>'.$message_non_envoye.'</p>'."\n";
			};
		}
		else
		{
			// une des 3 variables (ou plus) est vide ...
			echo '<p>'.$message_formulaire_invalide. '<a href="commentaires.htm">Retour au formulaire</a></p>'."\n";
		};
	}; // fin du if (!isset($_POST['envoi']))
?>


</body>
</html>
