<?php
session_start();
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addemployee.css">
<title>Add New Car to Database</title>
</head>
<body><header>
        <div class="logo"><a href="../../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
                <li><a href="../adminapproval.php">Requests</a></li>
                <li><a href="#">Log Out</a></li>
            </ul>
        </nav>
    </header>

	<section class = "addemployeebanner">
		<div id="center">
			<div class="addemployeeform">
				<h1>Welcome to Car Database</h1>
				<h2>Add New Car</h2>
				<div class="formna">
				<form action="./addcars.php" method="post">
					Car Model: <input type="text" name="name" required><br>
					Model Year: <input type="number" name="year" required><br>
					Engine Type: <input type="text" name="engine" required><br>
					Price: <input type="number" name="price" required><br>
					<input type="submit" value="Add new Car">
						<button type="button" onclick="location.href='../cars.php'">Go back</button>
					</form>
					</div>
			</div>
		</div>
	</section>


<?php
	if(isset($_POST["name"])){
		// This part will only execute if $_POST variables are passed
        $check = 1;
		$name=$_POST["name"];
        $year=$_POST["year"];
        $engine=$_POST["engine"];
        $price= $_POST["price"];
		if($check == 0) echo "One or more of your inputs are wrong<br>";
		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));
			$query = "INSERT INTO automobile values (null, '".$_POST["name"]."')";
			mysqli_query($conn, $query);

            $query1 = "INSERT INTO automobile_specs values ('"
            .$_POST["name"]."', '"
            .$_POST["year"]."','"
            .$_POST["engine"]."', '"
            .$_POST["price"]."')";
            mysqli_query($conn, $query1);

			$id=mysqli_insert_id($conn);
			$query = "INSERT INTO automobile values ($id)";

			mysqli_close($conn);
			// Redirection to main.php
			header("Location: ../cars.php");
			exit;
		}
	}
	
?>
</body>
</html>