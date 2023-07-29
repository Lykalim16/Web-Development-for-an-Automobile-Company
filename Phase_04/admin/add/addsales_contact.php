<?php
session_start();
?>
<?php
	if(isset($_POST["cus_ID"])){
		$origcar=$_POST['origcar'];
		$branch=$_POST['branch'];
		$yr = $_POST['yr'];
		$qty = $_POST['qty'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		$check = 1;
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
				function_alert("Contact Number Already Exist",$id,$origcar,$branch,$qty,$day,$month,$yr);
			}
			else{
				$query = "insert into customer_contact values ('"
	            .$_POST["cus_ID"]."', '"
	            .$_POST["cus_cnum"]."')";
				mysqli_query($conn, $query);
			}
			
			mysqli_close($conn);
			echo "<script>";
   			echo "location='../edit/editsales.php?id=$id&branch=$branch&car=$origcar&day=$day&month=$month&yr=$yr&qty=$qty';";
    		echo "</script>";
			exit;
		}
	}

	function function_alert($message,$id,$origcar,$branch,$qty,$day,$month,$yr) {
		   echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./addsales_contact.php?id=$id&branch=$branch&car=$origcar&day=$day&month=$month&yr=$yr&qty=$qty';";
    		echo "</script>";
		}
	
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addcontact.css">
<title>Add New Sales's Contact to Database</title>
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
				<h1>Welcome to Sale's Contact Database</h1>
				<h2>Add New Contact Number For Sales  <?php echo $_GET['id']; ?></h2>
			<div class="formna">
			
<form action="addsales_contact.php" method="post">

       
        <?php
		$server = "localhost:3306";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$origcar=$_GET['car'];
		$branch=$_GET['branch'];
		$yr = $_GET['yr'];
		$qty = $_GET['qty'];
		$month = $_GET['month'];
		$day = $_GET['day'];
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		$query = "select cus_ID from customer where cus_ID=".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$row = mysqli_fetch_assoc($result);
		echo "<input type='hidden' name='cus_ID' value='".$row['cus_ID']."' >";
		?>
		Customer Contact: <input type="number" name="cus_cnum" required><br>
		<input type="submit" value="Add new customer Contact">
		<input type="hidden" name="origcar" value=<?php echo  $_GET['car']; ?>>
		<input type="hidden" name="branch" value=<?php echo  $_GET['branch']; ?>>
		<input type="hidden" name="yr" value=<?php echo  $_GET['yr']; ?>>
		<input type="hidden" name="month" value=<?php echo  $_GET['month']; ?>>
		<input type="hidden" name="day" value=<?php echo  $_GET['day']; ?>>
		<input type="hidden" name="qty" value=<?php echo  $_GET['qty']; ?>>
	<?php	
		echo "<button type='button' onclick=\"location.href='../edit/editsales.php?id=" .$_GET['id']."&branch=$branch&car=$origcar&day=$day&month=$month&yr=$yr&qty=$qty'\">Go back to Edit Page</button>";
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