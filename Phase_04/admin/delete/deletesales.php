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
	$car = $_GET['car'];
	$branch = $_GET['branch'];
	$yr = $_GET['yr'];
	$month = $_GET['month'];
	$day = $_GET['day'];
	$qty = $_GET['qty'];
	$araw=$yr.'-'.$month.'-'.$day;
	$query ="delete from buys_at where cus_ID = '$id'  and vehi_identi_num='$car' and branch_ID='$branch' and purchase_date='$araw'" ;
	mysqli_query($conn, $query);
	
	$query="select * from tracks where in_ID = $branch and in_year = '$yr' and vehi_identi_num=$car";
	$result = mysqli_query($conn,$query); 
	$row = mysqli_fetch_assoc($result);

	$query = "select * from automobile natural join automobile_specs where vehi_identi_num=$car";
	$results = mysqli_query($conn,$query);
	$rows=mysqli_fetch_assoc($results);
	$natira=$row['in_quantity']+$qty;
	$nabenta=$row['in_solditems']-$qty;
	$benta=$rows['automobile_price']*$nabenta;
	$query = "UPDATE tracks set in_solditems='$nabenta',in_quantity='$natira',in_sales='$benta' where vehi_identi_num='$car' and in_ID='$branch' and in_year='$yr'";
	mysqli_query($conn, $query);
	mysqli_close($conn);
}
			header('Location: ../sales.php?year=' .$_SESSION["year"]);
exit;
?>