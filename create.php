<?php 
$host = 'localhost';
$db = 'forms';
$user = 'root';
$password = '';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
try {
	$con = new PDO($dsn, $user, $password);
	if ($con) {
		echo "Connected to the $db database successfully!";
	}
} catch (PDOException $e) {
	echo $e->getMessage();
}

?>