<?php
session_start();
?>
<?php
	if(isset($_POST["cus_ID"])){
		// This part will only execute if $_POST variables are passed
		$check = 1;
		if(!preg_match("/^[a-zA-Z0-9 ]+$/",$_POST["cus_ID"])){
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
			$cnum=$_POST["cus_cnum"];
			$id=$_POST["cus_ID"];
			$branch=$_POST["branch"];
			$query3 = "select * from customer_contact natural join buys_at natural join customer  where cus_cnum = $cnum and branch_ID=$branch";
			$result3 = mysqli_query($conn,$query3);
			if (mysqli_num_rows($result3) != 0) {
				function_alert("Contact Number Already Exist",$id);

			}
			else{
				$query = "insert into customer_contact values ('"
	            .$_POST["cus_ID"]."', '"
	            .$_POST["cus_cnum"]."')";
				echo $query;
				mysqli_query($conn, $query);
			}
			
			mysqli_close($conn);
			 echo "<script>";
   			echo "location='../edit/editcustomer.php?id=$id';";
    		echo "</script>";
			exit;
		}
	}

	function function_alert($message,$id) {
		   echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./addcustomer_contact.php?id=$id';";
    		echo "</script>";
		}
	
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addcontact.css">
<title>Add New Customer's Contact to Database</title>
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
				<h1>Welcome to Customer's Contact Database</h1>
				<h2>Add New Contact Number For Customer  <?php echo $_GET['id']; ?></h2>
			<div class="formna">
			
<form action="addcustomer_contact.php" method="post">

        <?php
		$server = "localhost:3306";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		$query = "select cus_ID from customer where cus_ID=".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$row = mysqli_fetch_assoc($result);
		echo "<input type='hidden' name='cus_ID' value='".$row['cus_ID']."' >";
		?>
		Customer Contact: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name="cus_cnum" required><br>
		<input type="submit" value="Add new customer Contact">
		
	<?php
		$query = "select branch_ID from customer natural join buys_at where cus_ID=".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$row = mysqli_fetch_assoc($result);	echo "<input type='hidden' name='branch' value='".$row['branch_ID']."' >";
		echo "<button type='button' onclick=\"location.href='../edit/editcustomers.php?id=" .$_GET['id']."'\">Go back to Edit Page</button>";
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