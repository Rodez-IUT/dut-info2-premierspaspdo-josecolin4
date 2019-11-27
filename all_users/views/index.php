<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>TD1</title>		
	</head>
	
	<body>
		
		<!-- saisie des informations -->
		<form method="post" action="all_users5.php" ID="formRecherche">
			<input hidden name="action" value="index">
			<input hidden name="controller" value="all_users">
			<select name="actif">
				<option>Active account</option>
				<option>Waiting for account validation</option>
				<option>Waiting for account deletion</option>
			</select>
			
			<input type="text" name="nom" />

			<input type="submit" />
		</form>
	
		<?php
		function lancerException() {
			throw new Exception();
		}
		?>
		
		<table>
		<?php
			// conditions obligatoire car on utilise le même php pour le formulaire et le resultat
			if (HttpHelper::getParam('action') != null) {
				
			}			
		?>
		</table>
	</body>
</html>