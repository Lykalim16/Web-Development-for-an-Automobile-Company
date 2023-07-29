<?php
session_start();
?>

<!DOCTYPE html>
<!-- Edit Employee Details -->
<html>
<head>

<link rel="stylesheet" href="editemployees.css">
<title>Edit Car Information</title>
</head>
<body>
<?php if (isset($_SESSION["id"])){ $year=$_SESSION['taon']; ?>
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
				<h1>Welcome to Car Database</h1>
				<h2>Edit Info of Car  <?php echo $_GET['id'] ?>
				<?php
					// Redirecto main if GET and POST variables are not s back tset
					if(!isset($_POST['id']) && !isset($_GET['id'])){
						header("Location: ../../main.php");
						exit;
					}
				?></h2>
				<div class="formna">
				<?php
	if(isset($_POST["id"])){
		// This part will only execute if $_POST variables are passed to this page
		$check = 1;		
        $id = $_POST['id'];
		$name = $_POST['name'];
		$year = $_POST['year'];
		$engine = $_POST['engine'];
		$price =$_POST['price'];
		if($check == 0) echo "One or more of your inputs are wrong<br>";
		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));
			$query = "UPDATE automobile set automobile_modelname = '$name' where vehi_identi_num = '$id'";
			mysqli_query($conn, $query);
            $query1 = "UPDATE automobile_specs set automobile_year = '$year', automobile_engine = '$engine', automobile_price = '$price' where automobile_modelname = '$name'";
            mysqli_query($conn, $query1);
			mysqli_close($conn);


			header("Location: ../cars.php");
			exit;
		}
	}
	
?>
<form action="./editcar.php" method="post">
	<!-- Use hidden input if you want to pass POST variables that are not inputted by user -->
	<input type="hidden" name="id" value=<?php echo  $_GET['id']; ?>>
	<?php
		$server = "localhost";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		
		$query = "select * from automobile natural join automobile_specs where vehi_identi_num = ".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$orig = mysqli_fetch_assoc($result);
		$x=1;
		// Set original info of pet as default inputs
		echo "Model Name: <input type='text' name='name' value='".$orig['automobile_modelname']."'><br>";
		echo "Model Year: <input type='text' name='year' value='".$orig['automobile_year']."'><br>";
		echo "Engine Model: <input type='text' name='engine' value='".$orig['automobile_engine']."'><br>";
		echo "Price: <input type='text' name='price' value='".$orig['automobile_price']."'><br>";

        ?>
	<input type="submit" value="Edit Car info">
	<button type="button" onclick="location.href='../cars.php'" >Go back</button>
</form>
</div>
			</div>
		</div>
	</section>
	<?php  } else{ header("Location: ../car.php");}?>
</body>
</html>