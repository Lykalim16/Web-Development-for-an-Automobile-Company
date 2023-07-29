<?php
session_start();
?>
<!DOCTYPE html>
<!-- for admin -->
<html>
<head>
<link rel="stylesheet" href="addemployee.css">
<title>Add New Employee to Database</title>
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
<?php if (isset($_SESSION["id"])){ ?>
	<section class = "addemployeebanner">
		<div id="center">
			<div class="addemployeeform">
				<h1>Welcome to Employee Database</h1>
				<h2>Add New Employee</h2>
				<div class="formna">
				<form action="./addemployee.php" method="post">
					Employee First Name: <input type="text" name="em_fname" required><br>
					Employee Middle Initial: <input type="text" name="em_mname" ><br>
					Employee Last Name: <input type="text" name="em_lname" required><br>
					Employee Street Number: <input type="number" name="em_streetNum" required><br>
					Employee Baranggay: <input type="text" name="em_baranggay" required><br>
					Employee City: <input type='text' name='city' required><br>
					Employee Province: <input type='text' name='province' required ><br>
					Employee Zip Code: <input type="number" name="em_zipCode" required><br>
					Employee 1st Contact Number : <input type="tel" pattern="[0]{1}[9]{1}[0-9]{9}" name="cnum" required> <button id="buttonadd" onclick="myFunction();return false;">Add Employee 2nd Contact Number  </button>
					<div id="addcontact2" style="display:none">
						Employee Contact Number 2: <input type="tel" pattern="[0]{1}[9]{1}[0-9]{9}" name="cnum2" ><br>
					</div><br>
					
					
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
					<input type="submit" value="Add new Employee">
					<button type="button" onclick="location.href='../employee.php'">Go back</button>
					</div>
			</div>
		</div>
	</section>


<?php } else{ header("Location: ../employees.php");}?>
<?php
	$conn = mysqli_connect("localhost","root","","phase2");
	$contact = $_POST["cnum"] ?? "";
	$contact2 = $_POST["cnum2"] ?? "";
	$query = "SELECT * FROM employee_contact WHERE em_cnum = '$contact' OR em_cnum = '$contact2'"; 
	$result = mysqli_query($conn,$query);
	if(mysqli_num_rows($result) != 0){
		echo '<script>alert("number already taken");</script>';
		mysqli_close($conn);
	}
	else{
		if(isset($_POST["em_fname"])){
			$fname=$_POST["em_fname"];
			$mname=$_POST["em_mname"];
			$lname =$_POST["em_lname"];
			$street= $_POST["em_streetNum"];
			$brgy=  $_POST["em_baranggay"];
			$city =$_POST["city"];
			$province=$_POST["province"];
			$zip  =$_POST["em_zipCode"];
			$cnum=$_POST["cnum"];
			$cnum2=$_POST["cnum2"];
			$check = 1;
			$branch=$_POST["branch"];
			if(!preg_match("/^[a-zA-Z \-'_  ]+$/",$_POST["em_fname"])){
				$check = 0;
			}
			if(!preg_match("/^[a-zA-Z \-'_ ]+$/",$_POST["em_mname"])){
				$check = 0;
			}
			if(!preg_match("/^[a-zA-Z \-'_  ]+$/",$_POST["em_lname"])){
				$check = 0;
			}
			if(!preg_match("/^[a-zA-Z \-'_  ]+$/",$_POST["city"])){
				$check = 0;
			}
			if(!preg_match("/^[a-zA-Z \-'_ ]+$/",$_POST["province"])){
				$check = 0;
			}
			if($check == 0) {
				echo "<script>";
				echo "alert('Wrong Input, Employee not added');";
				echo "</script>";
			}
			else{
				$server = "localhost:3306";
				$user = "root";
				$pass = "";
				$db = "phase2";
				$conn = mysqli_connect($server, $user, $pass, $db);
				if(!$conn) die(mysqli_error($conn));
				$query = "insert into employee values (null, '"
				.$_POST["em_fname"]."', '"
				.$_POST["em_mname"]."','"
				.$_POST["em_lname"]."', '"
				.$_POST["em_streetNum"]."', '"
				.$_POST["em_baranggay"]."', '"
				.$_POST["city"]."', '"
				.$_POST["province"]."', '"
				.$_POST["em_zipCode"]."')";
				mysqli_query($conn, $query);
				$id=mysqli_insert_id($conn);
				$query = "insert into employee_contact values ($id, $cnum)";
				mysqli_query($conn, $query);
				if ($cnum2!=0){
					$query = "insert into employee_contact values ($id, $cnum2)";
				mysqli_query($conn, $query);
				}
				$query = "insert into works values ($branch, $id)";
				mysqli_query($conn, $query);
				mysqli_close($conn);
				// Redirection to main.php
				header("Location: ../employee.php");
				exit;
			}
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