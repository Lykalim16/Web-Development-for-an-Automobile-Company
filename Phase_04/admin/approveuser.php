<?php
if(isset($_GET["id"])){
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "phase2";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	$id = $_GET['id'];
	$query = "select * from temp_user where id = '$id'";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	$fname=$row['firstname'];
	$mname=$row['midinitial'];
	$lname=$row['lastname'];
	$branch=$row['branchid'];
	$email=$row['email'];
	$pass1=$row['password'];
	$kontact=$row['contactnum'];
	$insertion="INSERT INTO user 
				VALUES (null,'$fname','$mname','$lname',$kontact,'$email',$branch,'$pass1')";
	mysqli_query($conn, $insertion);
	$query ="delete from temp_user where id = '$id'" ;
	mysqli_query($conn, $query);
	mysqli_close($conn);
}
header("Location: adminapproval.php");
exit;
?>