<?php
session_start();
?>
<!DOCTYPE html>
<!-- CUSTOMER DATABASE EDIT -->
<html>
<head>
<link rel="stylesheet" href="editemployees.css">
<title>Edit Inventory Information</title>
</head>
<body><?php if (isset($_SESSION["id"])){ $year=$_SESSION['taon']; ?>
    <header>
        <div class="logo"><a href="../../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
               <li><a href="../adminapproval.php">REQUESTS</a></li>
                <li><div class="where"><a href="../employee.php">EMPLOYEES</a></li></div>
                <?php echo "<li><a href='../customer.php?year=$year' >CUSTOMER</a></li>"?>
                <li><a href="../branches.php">BRANCHES</a></li>
                <li><a href="../supplier.php">SUPPLIER</a></li>
                <li><a href="../cars.php">CARS</a></li>
                <li><a href="../manufacturer.php">MANUFACTURER</a></li>
                <?php echo "<li><a href='../sales.php?year=$year' >SALES</a></li>"?>
                <?php echo "<li><a href='../inventory.php?year=$year' >INVENTORY</a></li>"?>
                <?php echo "<li><a href='../report.php?year=$year' >REPORT </a></li>"?>
                <li><a href="../../logout.php">LOG OUT</a></li>
            </ul>
        </nav>
    </header>

	<section class="editemployeebanner">
		<div id="center">
			<div class="editemployeeform">
				<h1>Welcome to Inventory Database</h1>
				<h2>Edit Info of Inventory  <?php echo $_GET['id']; ?>
				<?php
	// Redirecto main if GET and POST variables are not s back tset
	if(!isset($_POST['id']) && !isset($_GET['id'])){
		header("Location: ./main.php");
		exit;
	}
?>
</h2>
					<div class="formna">
                    <?php
	if(isset($_POST["nabenta"])){
		// This part will only execute if $_POST variables are passed to this page
		$check = 1;	
		$id=$_POST['id'];
		$in_id=$_POST['in_id'];
		$nabenta=$_POST['nabenta'];
		$stock=$_POST['stock'];
		$presyo=$_POST['presyo'];
		$natira=$stock-$nabenta;
		$benta=$nabenta*$presyo;
		$year=$_POST['year'];
		if($nabenta>$stock){
			$check = 0;
		}
		
		if($check == 0) {
			echo "One or more of your inputs are wrong<br>";
			header('Location: ../edit/editinventory.php?id=' .$id);
		}

		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));
			$query = "UPDATE tracks set in_solditems='$nabenta',in_quantity='$natira',in_stock='$stock',in_sales='$benta' where vehi_identi_num='$id' and in_ID='$in_id' and in_year='$year'";
			mysqli_query($conn, $query);

			mysqli_close($conn);

			header('Location: ../inventory.php?year=' .$_SESSION["year"]);
			exit;
		}
	}
	
?>
<form action="./editinventory.php" method="post">
	<!-- Use hidden input if you want to pass POST variables that are not inputted by user -->
	<input type="hidden" name="id" value=<?php echo  $_GET['id']; ?>>
	<input type="hidden" name="year" value=<?php echo  $_GET['year']; ?>>
	<?php
		$server = "localhost";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		$brid= $_GET["branch"];
		$crid= $_GET["id"];
		$years= $_GET["year"];

		$query = "select * from automobile natural join automobile_specs natural join tracks natural join has_inventory natural join branch where branch_id =$brid and vehi_identi_num=$crid and in_year=$years";
		$result = mysqli_query($conn,$query);
		$orig = mysqli_fetch_assoc($result);
		// Set original info of pet as default inputs
		echo "<input type='hidden' name='presyo' value='".$orig['automobile_price']."'>";
		echo "<input type='hidden' name='in_id' value='".$orig['in_ID']."'>";
		echo "Remaining Stock<input type='number' name='stock' value='".$orig['in_stock']."'><br>";
		echo "Sold Item: <input type='number' name='nabenta' value='".$orig['in_solditems']."' required><br>";
        ?>
	<input type="submit" value="Edit Inventory Info">
	<?php echo "<button type='button' onclick=\"location.href='../inventory.php?year=" .$_SESSION['year']."'\" >Go back</button>"; ?>
</form>
			</div>
			</div>
		</div>
	</section>
	<?php  } else{ header("Location: ../inventory.php");}?>
</body>
</html>