<?php
	namespace controllers;
	
	use yasmf\HttpHelper;
	use yasmf\View; 
	
	public class AllUsersController {
		public function index($pdo) {
			$view = new View("all_users/views/index");
			
			use yasmf\DataSource;
			use yasmf\Router;
			
			$pdo = DataSource::getPD0();
			$stmt = $pdo->prepare('SELECT u.id, username, email, name FROM users AS u JOIN status AS s ON u.status_id=s.id WHERE s.name = ? AND u.username LIKE ? ORDER BY username');
			$stmt->execute([$_POST['actif'],$_POST['nom'].'%']);	
			while ($row = $stmt->fetch()) {
				echo '<td>'.$row['id'].'</td>';
				echo '<td>'.$row['username'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				echo '<td>'.$row['name'].'</td>';
				if (strcmp($row['name'], "Waiting for account deletion") != 0) {
					echo '<td> <a href="all_users.php?status_id=3&user_id='.$row['id'].'&action=askDeletion">Ask delation</a> </td>';					
				}
				echo '</tr>';
			}
			$view.setVar();
			return $view;
		} 
	}	
?>