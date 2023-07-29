<?php
session_start();
?>
<?php
	if(isset($_POST["manu_ID"])){
		// This part will only execute if $_POST variables are passed
		$check = 1;
		if(!preg_match("/^[a-zA-Z0-9 ]+$/",$_POST["manu_ID"])){
			$check = 0;
		}
		if($check == 0) echo "One or more of your inputs are wrong<br>";
		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));
			$query = "insert into manufacturer_contact values ('"
            .$_POST["manu_ID"]."', '"
            .$_POST["manu_cnum"]."')";
			echo $query;
			mysqli_query($conn, $query);
			mysqli_close($conn);
			// Redirection to main.php
			header('Location: ../edit/editmanufacturer.php?id=' .$_POST["manu_ID"]);
			exit;
		}
	}
?>	
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addcontact.css">
<title>Add New Manufacturer's Contact to Database</title>
</head>
<body>
<header>
        <div class="logo"><a href="../../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
                <li><a href="../adminapproval.php">Requests</a></li>
                <li><a href="#">Log Out</a></li>
            </ul>
        </nav>
    </header>
	<?php if (isset($_SESSION["id"])){ ?>
		<section class="addemployeebanner">
			<div class="center">
				<div class="addemployeeform">
					<h1>Welcome to Manufacturer's Contact Database</h1>
					<h2>Add New Contact Number For Manufacturer  <?php echo $_GET['id']; ?></h2>
					<div class="formna">
					<form action="addmanufacturer_contact.php" method="post">

<?php
$server = "localhost:3306";
$user = "root";
$pass = "";
$db = "phase2";
$conn = mysqli_connect($server, $user, $pass, $db);
if(!$conn) die(mysqli_error($conn));
$query = "select manu_ID from manufacturer where manu_ID=".$_GET['id'];
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);
echo "<input type='hidden' name='manu_ID' value='".$row['manu_ID']."' >";
?>
Manufacturer Contact: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name="manu_cnum" required><br>
<input type="submit" value="Add new Manufacturer Contact">

<?php	
echo "<button type='button' onclick=\"location.href='../edit/editmanufacturer.php?id=" .$_GET['id']."'\">Go back to Edit Page</button>";
mysqli_close($conn);
?>

</form>
					</div>
				</div>
			</div>
		</section>
<?php } else{ header("Location: ../manufacturer.php");}?>
</body>
</html>