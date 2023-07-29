<?php
session_start();
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addemployee.css">
<title>Add New Sales to Database</title>
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

	<section class = "addemployeebanner">
		<div id="center">
			<div class="addemployeeform">
				<h1>Welcome to Sales Database</h1>
				<h2>Add New Sales</h2>
				<div class="formna">
				<form action="./addsales.php" method="post">
					<?php 
							$server = "localhost:3306";
							$user = "root";
							$pass = "";
							$db = "phase2";
							$conn = mysqli_connect($server, $user, $pass, $db);
							$query1 = "select * from customer";
					        $results = mysqli_query($conn,$query1);
							if(mysqli_num_rows($results) > 0){
								echo "Customer ID: <select name='cusid' ><option value='0'></option>";
								while($row1 = mysqli_fetch_assoc($results)){
									echo "<option value='".$row1['cus_ID']."'>"
									.$row1['cus_ID']."</option>";
								}
								echo "</select><br>";
							}
						 ?>
						Customer First Name: <input type="text" name="cus_fname" ><br>
						Customer Middle Initial: <input type="text" name="cus_mname" ><br>
						Customer Last Name: <input type="text" name="cus_lname" ><br>
						Customer Street Number: <input type="number" name="cus_streetNum" ><br>
						Customer Baranggay: <input type="text" name="cus_baranggay" ><br>
						Customer City: <input type='text' name='city' ><br>
						Customer Province: <input type='text' name='province'  ><br>
						Customer Zip Code: <input type='tel'  pattern='[0-9]{1}[0-9]{3}' name="cus_zipCode" ><br>
						Customer 1st Contact Number : <input type="number" name="cnum" ><br> 
						<div id="addcontact2" style="display:none">
							Customer 2nd Contact Number : <input type="number" name="cnum2" >
						</div>
						<?php 
							$server = "localhost:3306";
							$user = "root";
							$pass = "";
							$db = "phase2";
							$conn = mysqli_connect($server, $user, $pass, $db);
							$query1 = "select * from automobile";
					        $results = mysqli_query($conn,$query1);
							if(mysqli_num_rows($results) > 0){
								echo "Car Bought: <select name='car' >";
								while($row1 = mysqli_fetch_assoc($results)){
									echo "<option value='".$row1['vehi_identi_num']."'>"
									.$row1['automobile_modelname']."</option>";
								}
								echo "</select><br>";
							}
						 ?>
						 
						Quantity: <input type='number' name='quantity' required=""><br>
						Purchase Date: <input type='date' name='date' required=""><br>
						<?php 
		                   	$server = "localhost:3306";
							$user = "root";
							$pass = "";
							$db = "phase2";
							$conn = mysqli_connect($server, $user, $pass, $db);
							if(!$conn) die(mysqli_error($conn));
							$query = "select branch_ID from branch ";
							$result = mysqli_query($conn,$query);
							if(mysqli_num_rows($result) > 0){
								echo "Assosiated Branch: <select name='branch'>";
								while($row = mysqli_fetch_assoc($result)){
									echo "<option value='".$row['branch_ID']."'>"
									.$row['branch_ID']."</option>";
								}
								echo "</select><br>";
							}
						?>
						<input type="submit" value="Add New Sales">
	<?php echo "<button type='button' onclick=\"location.href='../sales.php?year=" .$_SESSION['year']."'\" >Go back</button>"; ?>
						</form>
						<hr>
						<button id="buttonadd" onclick="myFunction();return false;">Add Customer 2nd Contact Number  </button>
						
					</div>
			</div>
		</div>
	</section>



<?php
	if(isset($_POST["cus_fname"])){
		// This part will only execute if $_POST variables are passed
		$fname=$_POST["cus_fname"];
        $mname=$_POST["cus_mname"];
        $lname =$_POST["cus_lname"];
        $street= $_POST["cus_streetNum"];
        $brgy=  $_POST["cus_baranggay"];
        $city =$_POST["city"];
        $province=$_POST["province"];
        $zip  =$_POST["cus_zipCode"];
        $cnum=$_POST["cnum"];
        $cnum2=$_POST["cnum2"];
        $car=$_POST["car"];
        $date=$_POST["date"];
        $quantity=$_POST["quantity"];
		$check = 1;
        $branch=$_POST["branch"];
        $cusid=$_POST["cusid"];
		if($check == 0) echo "One or more of your inputs are wrong<br>";
		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));

			if ($cusid==0) {
				$query = "insert into customer values (null, '"
	            .$_POST["cus_fname"]."', '"
	            .$_POST["cus_mname"]."','"
	            .$_POST["cus_lname"]."', '"
	            .$_POST["cus_streetNum"]."', '"
	            .$_POST["cus_baranggay"]."', '"
	            .$_POST["cus_zipCode"]."', '"
	            .$_POST["city"]."', '"
	            .$_POST["province"]."')";
				mysqli_query($conn, $query);
				$id=mysqli_insert_id($conn);
				$query = "insert into customer_contact values ($id, $cnum)";
				mysqli_query($conn, $query);
				if ($cnum2!=0){
					$query = "insert into customer_contact values ($id, $cnum2)";
					mysqli_query($conn, $query);
				}
			}else{
				$id=$cusid;
			}

			$query = "select * from automobile natural join automobile_specs where vehi_identi_num=$car";
			$result = mysqli_query($conn,$query);
			$row = mysqli_fetch_assoc($result);
			$price=$row['automobile_price'];
			$total=$price*$quantity;
			$query = "insert into buys_at values ($branch, $id,$car,'$date',$quantity,$total)";
			mysqli_query($conn, $query);
			mysqli_close($conn);
			// Redirection to main.php
			header('Location: ../sales.php?year=' .$_SESSION["year"]);
			exit;
		}
	}
	
?>

   


<script>
function myFunction() {
  var x = document.getElementById("addcontact2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  hidebutton();
}
function hidebutton() {
  var z = document.getElementById("buttonadd");
  z.style.display = "none";
  
}
</script>
</body>
</html>