<?php
session_start();
?>
<!DOCTYPE html>
<!-- ADD NEW AUTOMOBILE -->
<html>
<head>
<link rel="stylesheet" href="addemployee.css">
<title>Add New Inventory to Database</title>
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
				<h1>Welcome to Inventory Database</h1>
				<h2>Add New Inventory</h2>
				<div class="formna">
                <form action="./addinventory.php" method="post">
						<?php 
							$server = "localhost:3306";
							$user = "root";
							$pass = "";
							$db = "phase2";
							$conn = mysqli_connect($server, $user, $pass, $db);
							$query1 = "select * from automobile";
					        $results = mysqli_query($conn,$query1);
							if(mysqli_num_rows($results) > 0){
								echo "Vehicle Name: <select name='car' >";
								while($row1 = mysqli_fetch_assoc($results)){
									echo "<option value='".$row1['vehi_identi_num']."'>"
									.$row1['automobile_modelname']."</option>";
								}
								echo "</select><br>";
							}
						 ?>
						Stock <input type="text" name="stock" required><br>
						No of Sold Cars: <input type="text" name="sold" ><br>
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
						Year: <select name="year" >
		                <?php 
		                   for($i = 2019 ; $i <= date('Y'); $i++){
		                        echo "<option value='$i'>$i</option>";
		                   }
		                ?>
		            </select> <br>
						<input type="submit" value="Add Inventory Information">
	<?php echo "<button type='button' onclick=\"location.href='../inventory.php?year=" .$_SESSION['year']."'\" >Go back</button>"; ?>
						</form>
					</div>
			</div>
		</div>
	</section>



<?php
	if(isset($_POST["car"])){
		// This part will only execute if $_POST variables are passed
		$car=$_POST["car"];
        $stock=$_POST["stock"];
        $branch =$_POST["branch"];
        $sold= $_POST["sold"];
        $year=  $_POST["year"];
        $natira=$stock-$sold;
        $check=1;
		if($check == 0){ 
			echo "<script>";
   			echo "alert('Wrong Input, Customer not added'); ";
   			echo "location='../customer.php?year=".$_SESSION["year"]."';";
    		echo "</script>";
		}
		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));
			$query = "insert into inventory values ($branch, '$year')";
			mysqli_query($conn, $query);
			$query = "insert into has_inventory values ($branch,$branch, '$year')";
			mysqli_query($conn, $query);
			$query = "select * from automobile natural join automobile_specs where vehi_identi_num=$car";
			$result = mysqli_query($conn,$query);
			$orig = mysqli_fetch_assoc($result);
			$price=$orig['automobile_price'];
			$totprice=$price*$sold;
			$query = "insert into tracks values ($car, $branch,$natira,$stock,$totprice,$sold,'$year')";
			mysqli_query($conn, $query);
			mysqli_close($conn);
			// Redirection to main.php
			
			header("Location: ../inventory.php?year=".$year);
			exit;
		}
	}
	
?>

   


<script type="text/javascript">
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