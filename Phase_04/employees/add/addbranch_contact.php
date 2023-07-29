
<?php
session_start();
?>
<?php
	if(isset($_POST["branch_ID"])){
		// This part will only execute if $_POST variables are passed
		$check = 1;
		if(!preg_match("/^[a-zA-Z0-9 ]+$/",$_POST["branch_ID"])){
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
			$cnum=$_POST["branch_cnum"];
			$id=$_POST["branch_ID"];
			$query3 = "select * from branch_contact  where branch_cnum = $cnum";
			$result3 = mysqli_query($conn,$query3);
			if (mysqli_num_rows($result3) != 0) {
				function_alert("Contact Number Already Exist",$id);

			}
			else{
				$query = "insert into branch_contact values ('"
	            .$_POST["branch_ID"]."', '"
	            .$_POST["branch_cnum"]."')";
				mysqli_query($conn, $query);
			}
			mysqli_close($conn);
			 echo "<script>";
   			echo "location='../edit/editbranches.php?id=$id';";
    		echo "</script>";
			exit;
		}
	}
	function function_alert($message,$id) {
		   echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./addbranch_contact.php?id=$id';";
    		echo "</script>";
		}
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addcontact.css">
<title>Add New Branch's Contact to Database</title>
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
			<h1>Welcome to Branch's Contact Database</h1>
			<h2>Add New Branch Contact</h2>
			<div class="formna">
			
<form action="./addbranch_contact.php" method="post">
        <?php
		$server = "localhost:3306";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		$query = "select branch_ID from branch where branch_ID=".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$row = mysqli_fetch_assoc($result);
		echo "<input type='hidden' name='branch_ID' value='".$row['branch_ID']."' >";
		
	?>
	    Branch Contact: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}'name="branch_cnum"><br>
		<input type="submit" value="Add new Branch Contact">
		
	<?php
		echo "<button type='button' onclick=\"location.href='../edit/editbranches.php?id=" .$_GET['id']."'\" >Go back</button>";
		mysqli_close($conn);?>
	
</form>
			</div>
			</div>
		</div>
	</section>
	<?php } else{ header("Location: ../employees.php");}?>
</body>
</html>