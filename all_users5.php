<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>TD1</title>		
	</head>
	
	<body>
		
		<!-- saisie des informations -->
		<form method="post" action="all_users5.php" ID="formRecherche">
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
			
		if (isset($_GET['status_id']) && isset($_GET['user_id']) && isset($_GET['action'])) {
				// suppresion de l'utilisateur aprés demande de suppresion
				try {
					$pdo->beginTransaction();
					
					// première requète SQL
					$stmt = $pdo->prepare('UPDATE users SET status_id = 3 WHERE id=?');
					$stmt->execute([$_GET['user_id']]);
					
					lancerException();
					
					// deuxième requète SQL
					$stmt = $pdo->prepare('INSERT INTO action_log (action_date, action_name, user_id) VALUES ("'.date("Y-m-d H:i:s").'", ?, ?) ');
					$stmt->execute([$_GET['action'], $_GET['user_id']]);
					$pdo->commit();
				} catch (Exception $e){
					$pdo->rollBack();
					throw $e;					
				}
		}
		
		if (isset($_POST['actif']) && isset($_POST['nom'])) {			

			
			$stmt = $pdo->prepare('SELECT u.id, username, email, name FROM users AS u JOIN status AS s ON u.status_id=s.id WHERE s.name = ? AND u.username LIKE ? ORDER BY username');
			$stmt->execute([$_POST['actif'],$_POST['nom'].'%']);	
			while ($row = $stmt->fetch()) {
				echo '<tr>';
				echo '<td>'.$row['id'].'</td>';
				echo '<td>'.$row['username'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				echo '<td>'.$row['name'].'</td>';
				if (strcmp($row['name'], "Waiting for account deletion") != 0) {
					echo '<td> <a href="all_users5.php?status_id=3&user_id='.$row['id'].'&action=askDeletion">Ask delation</a> </td>';					
				}
				echo '</tr>';
			}
		}
		?>
		</table>
	</body>
	
</html>