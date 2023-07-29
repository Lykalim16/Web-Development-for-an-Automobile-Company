<?php
session_start();
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addcustomer.css">
<title>Add New Customer to Database</title>
</head>
<body><?php $year=$_SESSION['taon']; ?>
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

	<section class="addcustomerbanner">
		<div id="center">
			<div class = "addcustomerform">
				<h1>Welcome to Customer Database</h1>
				<h2>Add New Customer</h2>
					<div class="formna">
					<form action="./addCustomer.php" method="post">
						<?php 
							$server = "localhost:3306";
							$user = "root";
							$pass = "";
							$db = "phase2";
							$conn = mysqli_connect($server, $user, $pass, $db);
							$branch=$_SESSION['id'];
							$query1 = "select * from customer natural join buys_at where branch_ID= $branch";
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
						Customer Zip Code: <input type="number" name="cus_zipCode" ><br>
						Customer 1st Contact Number : <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name="cnum" > 
						<div id="addcontact2" style="display:none">
							Customer Contact Number 2: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}'  name="cnum2" ><br>
						</div><br>
						<?php 
							$server = "localhost:3306";
							$user = "root";
							$pass = "";
							$db = "phase2";
							$conn = mysqli_connect($server, $user, $pass, $db);
							$query1 = "select * from automobile natural join automobile_specs";
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
						Quantity: <input type='number' name='quantity' required><br>
						Purchase Date: <input type='date' name='date' required><br>
						<input type="submit" value="Add New Customer">
	<?php echo "<button type='button' onclick=\"location.href='../customer.php?year=" .$_SESSION['year']."'\" >Go back</button>"; ?>
						</form>
						<br><button id="buttonadd" onclick="myFunction();return false;">Add Customer 2nd Contact Number  </button>
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
		$branch=$_SESSION['id'];
        $cusid=$_POST["cusid"];
        $date_arr = explode("-", $date);
        $yr = $date_arr[0];

		$server = "localhost:3306";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		$query="select * from tracks where in_ID = $branch and in_year = '$yr' and vehi_identi_num=$car";
		$result = mysqli_query($conn,$query); 
		$row = mysqli_fetch_assoc($result);
		if($row['in_quantity']<$quantity){
			function_alert("Not Enough Stock",$id);
		}
		else{
			$query = "select * from automobile natural join automobile_specs where vehi_identi_num=$car";
			$results = mysqli_query($conn,$query);
			$rows=mysqli_fetch_assoc($results);
			$natira=$row['in_quantity']-$quantity;
			$nabenta=$row['in_solditems']+$quantity;
			$benta=$rows['automobile_price']*$nabenta;
			$query = "UPDATE tracks set in_solditems='$nabenta',in_quantity='$natira',in_sales='$benta' where vehi_identi_num='$car' and in_ID='$branch' and in_year='$yr'";
			mysqli_query($conn, $query);
			if ($cusid==0) {
				if(!preg_match("/\d+/",$street)){
					$check = 0;
				}
				if(!preg_match("/\d+/",$zip)){
					$check = 0;
				}
				if(!preg_match("/^[a-zA-Z \-'_]+$/",$_POST["province"])){
					$check = 0;
				}
				if(!preg_match("/^[a-zA-Z \-'_ ]+$/",$_POST["city"])){
					$check = 0;
				}
				if($check == 0) function_alert("One or more input are wrong",$id);
				else{
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
					$query = "select * from  customer_contact natural join buys_at natural join customer where cus_cnum=$cnum and branch_id=$branch";
					$result = mysqli_query($conn,$query);
					if (mysqli_num_rows($result) != 0) {
						function_alert("Contact Number Already Exist",$id);
					}else{
						$query = "insert into customer_contact values ($id, $cnum)";
						mysqli_query($conn, $query);
					}
					if ($cnum2!=null){
						$query = "select * from  customer_contact natural join buys_at natural join customer where cus_cnum=$cnum2 and branch_id=$branch";
						$result = mysqli_query($conn,$query);
						if (mysqli_num_rows($result) != 0) {
							function_alert("Contact Number Already Exist",$id);
						}else{
							$query = "insert into customer_contact values ($id, $cnum2)";
							mysqli_query($conn, $query);
						}
					}
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
			 echo "<script>";
				echo "location='../customer.php?year=$yr';";
			echo "</script>";
			exit;
		}
		
	}
	function function_alert($message,$id) {
		   echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./addcustomer.php';";
    		echo "</script>";
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