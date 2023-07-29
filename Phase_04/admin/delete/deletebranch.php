<?php
if(isset($_GET["id"])){
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "phase2";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	$id = $_GET['id'];
	$query ="delete from branch where branch_ID = '$id'" ;
	mysqli_query($conn, $query);
	mysqli_close($conn);
}
			header("Location: ../branches.php");
exit;
?>