<?php
session_start();
?>
<?php
	if(isset($_POST["em_ID"])){
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
			$branch=$_POST["branch"];
			$query3 = "select * from employee_contact  where em_cnum = $cnum";
			$result3 = mysqli_query($conn,$query3);
			if (mysqli_num_rows($result3) != 0) {
				function_alert("Contact Number Already Exist",$id,$branch);
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
   			echo "location='../edit/editemployees.php?id=$id&branch=$branch';";
    		echo "</script>";
			exit;
		}
	}
	function function_alert($message,$id,$branch) {
		   echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./addemployee_contact.php?id=$id&branch=$branch';";
    		echo "</script>";
		}
	
	
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addcontact.css">
<title>Add New Employee's Contact to Database</title>
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
	<section class = "addemployeebanner">
		<div id = "center">
			<div class="addemployeeform">
				<h1>Welcome to Employee's Contact Database</h1>
				<h2>Add New Contact Number For Employee  <?php echo $_GET['id']; ?></h2>
			<div class="formna">
			
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
		echo "<input type='hidden' name='branch' value='".$_GET['branch']."' >";
		?>
		Employee Contact: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name="em_cnum" required><br>
		<input type="submit" value="Add new Employee Contact">
		
	<?php	
		echo "<button type='button' onclick=\"location.href='../edit/editemployees.php?id=" .$_GET['id']."&branch=".$_GET['branch']."'\">Go back to Edit Page</button>";
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