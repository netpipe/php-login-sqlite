<?php
	session_start();
	require_once 'conn.php';
	
	if(ISSET($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$query = "SELECT COUNT(*) as count FROM `member` WHERE `username` = :username AND `password` = :password";
		$stmt = $GLOBALS['conn']->prepare($query);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password);
		$stmt->execute();
		$row = $stmt->fetch();
		
		$count = $row['count'];
		
		if($count > 0){
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			require_once('home.php');
		}else{
			$_SESSION['error'] = "session val ::: Invalid username or password";
			header('location:login.php');
		}
	}
$GLOBALS['conn']->close();
?>
