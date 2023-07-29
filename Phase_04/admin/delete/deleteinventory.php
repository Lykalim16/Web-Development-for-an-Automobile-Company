<?php
session_start();
?>
<?php
if(isset($_GET["id"])){
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "phase2";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	$id = $_GET['id'];
	$year = $_GET['year'];
	$branch = $_GET['branch'];
	$query ="delete from tracks where in_ID = '$branch' and vehi_identi_num = $id and in_year='$year'" ;
	mysqli_query($conn, $query);
	mysqli_close($conn);
}header('Location: ../inventory.php?year=' .$_SESSION["year"]);
exit;
?>