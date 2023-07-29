<?php
session_start();
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addemployee.css">
<title>Add New Branch to Database</title>
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
		<div id="center">
			<div class="addemployeeform">
				<h1>Welcome to Branch Database</h1>
				<h2>Add New Branch</h2>
				<div class="formna">
				<?php
					$conn = mysqli_connect("localhost","root","","phase2");
					$contact = $_POST["cnum"] ?? "";
					$contact2 = $_POST["cnum2"] ?? "";
					$query = "SELECT * FROM branch_contact WHERE branch_cnum = '$contact' OR branch_cnum = '$contact2'"; 
					$result = mysqli_query($conn,$query);
					if(mysqli_num_rows($result) != 0){
						echo '<script>alert("number already taken");</script>';
						mysqli_close($conn);
					}
					else{
						if(isset($_POST["name"])){
						// This part will only execute if $_POST variables are passed
						$check = 1;
						$name =$_POST["name"];
						$street= $_POST["street"];
						$brgy=  $_POST["brgy"];
						$city =$_POST["city"];
						$province=$_POST["province"];
						$zip  =$_POST["zipcode"];
						$cnum=$_POST["cnum"];
						$cnum2=$_POST["cnum2"];
						if(!preg_match("/^[a-zA-Z \-'_  ]+$/",$_POST["name"])){
							$check = 0;
						}
						if(!preg_match("/^[a-zA-Z \-'_ ]+$/",$_POST["city"])){
							$check = 0;
						}
						if(!preg_match("/^[a-zA-Z \-'_  ]+$/",$_POST["province"])){
							$check = 0;
						}
						if($check == 0) {
							echo "<script>";
							echo "alert('Wrong Input, Branch not added');";
							echo "</script>";
						}
						else{
							$server = "localhost:3306";
							$user = "root";
							$pass = "";
							$db = "phase2";
							$conn = mysqli_connect($server, $user, $pass, $db);
							if(!$conn) die(mysqli_error($conn));
							$query = "insert into branch values (null, '$name', '$zip', '$brgy', '$street', '$city', '$province')";
							mysqli_query($conn, $query);
							$id=mysqli_insert_id($conn);
							$query = "insert into branch_contact values ($id, $cnum)";
							mysqli_query($conn, $query);
							if ($cnum2!=0){
								$query = "insert into branch_contact values ($id, $cnum2)";
							mysqli_query($conn, $query);
							}
							$query = "insert into provide_cars values (1, $id)";
							mysqli_query($conn, $query);
							mysqli_close($conn);
							// Redirection to main.php
							header("Location: ../branches.php");
							exit;
						}
						
					}
	}
	
?>
<form action="addbranch.php" method="post" required>
    Branch Name: <input type="text" name="name" required><br>
    Branch Baranggay: <input type="text" name="brgy" required><br>
    Branch Street Number: <input type="number" name="street" required><br>
    Branch City: <input type="text" name="city" required><br>
    Branch Province: <input type="text" name="province" required><br>
    Branch Zip Code: <input type="number" name="zipcode" required><br>
	Branch 1st Contact Number : <input type="tel" pattern="[0]{1}[9]{1}[0-9]{9}" name="cnum" required> <button id="buttonadd" onclick="myFunction();return false;">Add Branch 2nd Contact Number  </button>
	<div id="addcontact2" style="display:none">
		Employee Contact Number 2: <input type="tel" pattern="[0]{1}[9]{1}[0-9]{9}" name="cnum2" ><br>
	</div><br>
	<input type="submit" value="Add new Branch">
	<button type="button" onclick="location.href='../branches.php'">Go back </button>
</form>
</div>




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

<?php } else{ header("Location: ../employees.php");}?>
</script>
</body>
</html>