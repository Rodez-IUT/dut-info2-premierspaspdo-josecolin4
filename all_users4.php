<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>TD1</title>		
	</head>
	
	<body>
		
		<!-- saisie des informations -->
		<form method="post" action="all_users4.php" ID="formRecherche">
			<select name="actif">
				<option>Active account</option>
				<option>Waiting for account validation</option>
			</select>
			
			<input type="text" name="nom" />

			<input type="submit" />
		</form>
	
	
		<table>
		<?php
		if (isset($_POST['actif']) && isset($_POST['nom'])) {			
			$host = 'localhost';
			$db   = 'my_activities';
			$user = 'root';
			$pass = 'root';
			$charset = 'utf8mb4';
			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
			];
			try {
				$pdo = new PDO($dsn, $user, $pass, $options);
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage(), (int)$e->getCode());
			} 
			
			$stmt = $pdo->prepare('SELECT * FROM users AS u JOIN status AS s ON u.status_id=s.id WHERE s.name = ? AND u.username LIKE ? ORDER BY username');
			$stmt->execute([$_POST['actif'],$_POST['nom'].'%']);	
			while ($row = $stmt->fetch()) {
				echo '<tr>';
				echo '<td>'.$row['id'].'</td>';
				echo '<td>'.$row['username'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				echo '<td>'.$row['name'].'</td>';
				echo '</tr>';
			}
		}
		?>
		</table>
	</body>
	
</html>