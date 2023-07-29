<?php
session_start();
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addcontact.css">
<title>Add New Employee's Contact to Database</title>
</head>
<body>
<?php $year=$_SESSION['taon']; ?>
	<header>
        <div class="logo"><a href="../../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
			<li><a href="../employee.php">EMPLOYEES</a></li>
                <li><a href="../customer1.php">CUSTOMER</a></li>
                <li><div class='where'><a href="../branches.php">BRANCHES</a></li></div>
                <?php echo "<li><a href='../inventory.php?year=$year' >INVENTORY</a></li>"?>
                <?php echo "<li><a href='../customer.php?year=$year' >SALES</a></li>"?>
                <?php echo "<li><a href='../report.php?year=$year' >REPORT GENERATION</a></li>"?>
                <li><a href="../../logout.php">LOG OUT</a></li>
                <li class="name">Hello, <?php echo $_SESSION['name'];?></li>
            </ul>
        </nav>
    </header>

<?php if (isset($_SESSION["id"])){ ?>
	<section class = "addemployeebanner">
		<div id = "center">
			<div class="addemployeeform">
				<h1>Welcome to Employee's Contact Database</h1>
				<h2>Add New Contact Number For Employee  <?php echo $_GET['id']; ?></h2>
				<div class="formna">
				<?php
	if(isset($_POST["em_ID"])){
		// This part will only execute if $_POST variables are passed
		$check = 1;
		if(!preg_match("/^[a-zA-Z0-9 ]+$/",$_POST["em_ID"])){
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
			$cnum=$_POST["em_cnum"];
			$id=$_POST["em_ID"];
			$query3 = "select * from employee_contact  where em_cnum = $cnum";
			$result3 = mysqli_query($conn,$query3);
			if (mysqli_num_rows($result3) != 0) {
				function_alert("Contact Number Already Exist",$id);

			}
			else{
				$query = "insert into employee_contact values ('"
	            .$_POST["em_ID"]."', '"
	            .$_POST["em_cnum"]."')";
				echo $query;
				mysqli_query($conn, $query);
			}
			mysqli_close($conn);
			 echo "<script>";
   			echo "location='../edit/editemployees.php?id=$id';";
    		echo "</script>";
			exit;
		}
	}
	function function_alert($message,$id) {
		   echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./addcontacts.php?id=$id';";
    		echo "</script>";
		}
	
?>
<form action="addemployee_contact.php" method="post">

        <?php
		$server = "localhost:3306";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		$query = "select em_ID from employee where em_ID=".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$row = mysqli_fetch_assoc($result);
		echo "<input type='hidden' name='em_ID' value='".$row['em_ID']."' >";
		?>
		Employee Contact: <input type="number" name="em_cnum" required><br>
		<input type="submit" value="Add new Employee Contact">
		
	<?php	
		echo "<button type='button' onclick=\"location.href='../edit/editemployees.php?id=" .$_GET['id']."'\">Go back to Edit Page</button>";
		mysqli_close($conn);
	?>
    
</form>
				</div>
			</div>
		</div>
	</section>
	
<?php } else{ header("Location: ../employees.php");}?>
</body>
</html>