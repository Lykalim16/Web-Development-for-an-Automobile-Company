<?php
session_start();
?>
  <?php
	if(isset($_POST["fname"])){
		// This part will only execute if $_POST variables are passed to this page
		$check = 1;		
		$fname= $_POST['fname'];
		$mname= $_POST['mname'];
		$lname= $_POST['lname'];
		$streetnum =$_POST['streetnum'];
		$brgy=$_POST['brgy'];
		$city=$_POST['city'];
		$province=$_POST['province'];
		$zip=$_POST['zip'];
		$id=$_POST['id'];
		$cnum1 =$_POST['cnum1'];
		$realcnum1 =$_POST['realcnum1'];
		$cnum2 =$_POST['cnum2'];
		$realcnum2 =$_POST['realcnum2'];
		$branch =$_POST['branch'];
		if(!preg_match("/\d+/",$streetnum)){
			$check = 0;
		}
		if(!preg_match("/\d+/",$zip)){
			$check = 0;
		}if(!preg_match("/^[a-zA-Z \-'_]+$/",$_POST["province"])){
			$check = 0;
		}
		if(!preg_match("/^[a-zA-Z \-'_ ]+$/",$_POST["city"])){
			$check = 0;
		}
		if($check == 0) alerting("One or more input are wrong",$id);
		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));
			if($cnum1!=null ){
				if($cnum1!=$realcnum1){
					$query3 = "select * from employee_contact  where em_cnum = $cnum1";
					$result3 = mysqli_query($conn,$query3);
					if (mysqli_num_rows($result3) != 0) {
						alerting("Contact Number Already Exist",$id,$branch);
					}
					else{
						$query = "UPDATE employee set em_fname = '$fname',em_mname = '$mname',em_lname = '$lname', em_streetNum = $streetnum, em_baranggay = '$brgy' , em_city = '$city' , em_province = '$province' , em_zipCode = '$zip' where em_ID = '$id'";
						mysqli_query($conn, $query);
						$query = "UPDATE works set branch_ID = $branch where em_ID = $id";
						mysqli_query($conn, $query);
						$query = "UPDATE employee_contact set em_ID = $id, em_cnum = $cnum1 where em_cnum = '$realcnum1'";
						mysqli_query($conn, $query);
					}
				}
				else{
					$query = "UPDATE employee set em_fname = '$fname',em_mname = '$mname',em_lname = '$lname', em_streetNum = $streetnum, em_baranggay = '$brgy' , em_city = '$city' , em_province = '$province' , em_zipCode = '$zip' where em_ID = '$id'";
						mysqli_query($conn, $query);
						$query = "UPDATE works set branch_ID = $branch where em_ID = $id";
						mysqli_query($conn, $query);
				}

			}
			else{
				$query = "UPDATE employee set em_fname = '$fname',em_mname = '$mname',em_lname = '$lname', em_streetNum = $streetnum, em_baranggay = '$brgy' , em_city = '$city' , em_province = '$province' , em_zipCode = '$zip' where em_ID = '$id'";
						mysqli_query($conn, $query);

				$query = "UPDATE works set branch_ID = $branch where em_ID = $id";
				mysqli_query($conn, $query);
			}
			if($cnum2!=null ){
				if($cnum2!=$realcnum2){
					$query3 = "select * from employee_contact  where em_cnum = $cnum2";
					$result3 = mysqli_query($conn,$query3);
					if (mysqli_num_rows($result3) != 0) {
						alerting("Contact Number Already Exist",$id,$branch);
					}
					else{
						$query = "UPDATE employee set em_fname = '$fname',em_mname = '$mname',em_lname = '$lname', em_streetNum = $streetnum, em_baranggay = '$brgy' , em_city = '$city' , em_province = '$province' , em_zipCode = '$zip' where em_ID = '$id'";
						mysqli_query($conn, $query);
						$query = "UPDATE employee_contact set em_ID = $id, em_cnum = $cnum2 where em_cnum = '$realcnum2'";
						mysqli_query($conn, $query);
						$query = "UPDATE works set branch_ID = $branch where em_ID = $id";
						mysqli_query($conn, $query);				
					}
				}
				else{
					$query = "UPDATE employee set em_fname = '$fname',em_mname = '$mname',em_lname = '$lname', em_streetNum = $streetnum, em_baranggay = '$brgy' , em_city = '$city' , em_province = '$province' , em_zipCode = '$zip' where em_ID = '$id'";
						mysqli_query($conn, $query);
					$query = "UPDATE works set branch_ID = $branch where em_ID = $id";
					mysqli_query($conn, $query);
				}
			}
			else{
				
				$query = "delete from  employee_contact  where em_cnum = '$realcnum2'";
				mysqli_query($conn, $query);
				$query = "UPDATE employee set em_fname = '$fname',em_mname = '$mname',em_lname = '$lname', em_streetNum = $streetnum, em_baranggay = '$brgy' , em_city = '$city' , em_province = '$province' , em_zipCode = '$zip' where em_ID = '$id'";
						mysqli_query($conn, $query);

				$query = "UPDATE works set branch_ID = $branch where em_ID = $id";
				mysqli_query($conn, $query);
			}
			mysqli_close($conn);
			 echo "<script>";
   			echo "location='../employee.php'";
    		echo "</script>";
			exit;
		}
	}
	function alerting($message,$id,$branch) {
		   echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./editemployees.php?id=$id&branch=$branch';";
    		echo "</script>";
		}
	
?>
<!DOCTYPE html>
<!-- CUSTOMER DATABASE EDIT -->
<html>
<head>
<link rel="stylesheet" href="editemployees.css">
<title>Edit Employee Information</title>
</head>
<body><?php if (isset($_SESSION["id"])){ $year=$_SESSION['taon']; ?>
    <header style = "text-decoration: none">
        <div class="logo"><a href="../../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
               <li><a href="../adminapproval.php">REQUESTS</a></li>
                <li><div class="where"><a href="../employee.php">EMPLOYEES</a></li></div>
                <?php echo "<li><a href='../customer.php?year=$year' >CUSTOMER</a></li>"?>
                <li><a href="../branches.php">BRANCHES</a></li>
                <li><a href="../supplier.php">SUPPLIER</a></li>
                <li><a href="../cars.php">CARS</a></li>
                <li><a href="../manufacturer.php">MANUFACTURER</a></li>
                <?php echo "<li><a href='../sales.php?year=$year' >SALES</a></li>"?>
                <?php echo "<li><a href='../inventory.php?year=$year' >INVENTORY</a></li>"?>
                <?php echo "<li><a href='../report.php?year=$year' >REPORT </a></li>"?>
                <li><a href="../../logout.php">LOG OUT</a></li>
            </ul>
        </nav>
    </header>
	<section class="editemployeebanner">
		<div id="center">
			<div class="editemployeeform">
				<h1>Welcome to Employee Database</h1>
				<h2>Edit Info of Customer  <?php echo $_GET['id']; ?>
				<?php
					// Redirecto main if GET and POST variables are not s back tset
					if(!isset($_POST['id']) && !isset($_GET['id'])){
						header("Location: ./main.php");
						exit;
					}
				?></h2>
					<div class="formna">
                  
<form action="./editemployees.php" method="post">
	<!-- Use hidden input if you want to pass POST variables that are not inputted by user -->
	<input type="hidden" name="id" value=<?php echo  $_GET['id']; ?>>
	<?php
		$server = "localhost";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		
		$query = "select * from employee where em_ID = ".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$orig = mysqli_fetch_assoc($result);
		$x=1;
		// Set original info of pet as default inputs
		echo "Emp First Name: <input type='text' name='fname' value='".$orig['em_fname']."'><br>";
		echo "Emp Middle Initial: <input type='text' name='mname' value='".$orig['em_mname']."'><br>";
		echo "Emp Last Name: <input type='text' name='lname' value='".$orig['em_lname']."'><br>";
		echo "Emp Street Number: <input type='text' name='streetnum' value='".$orig['em_streetNum']."'><br>";
		echo "Emp Baranggay: <input type='text' name='brgy' value='".$orig['em_baranggay']."'><br>";
		echo "Emp City: <input type='text' name='city' value='".$orig['em_city']."'><br>";
		echo "Emp Province: <input type='text' name='province' value='".$orig['em_province']."'><br>";
		echo "Emp Zip Code: <input type='tel'  pattern='[0-9]{1}[0-9]{3}' name='zip' value='".$orig['em_zipCode']."'><br>";
		$query = "select * from employee_contact where em_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if (mysqli_num_rows($result) ==1){
            $row = mysqli_fetch_assoc($result);
           echo "Employee Contact Number #1: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}'   name='cnum1' value='0".$row['em_cnum']."'><br>";
           echo "<input type='hidden' name='cnum2' value='0'>";
           echo "<input type='hidden' name='realcnum1' value='".$row['em_cnum']."'>";
           echo "<input type='hidden' name='realcnum2' value='0'>";
        
		 }
        else{
            while($row = mysqli_fetch_assoc($result)){
            	$cnum='cnum'.$x;
            	$realcnum='realcnum'.$x;
                echo "Employee Contact Number #".$x.": <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}'  name='".$cnum."' value='0".$row['em_cnum']."'><br>";
           		echo "<input type='hidden' name='".$realcnum."' value='".$row['em_cnum']."'>";
                $x=$x+1;
            }
        }
        ?>
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
						echo "Assosiated Branch: <select name='branch'><option value='".$_GET['branch']."'>"
							.$_GET['branch']."</option>";
						while($row = mysqli_fetch_assoc($result)){
							echo "<option value='".$row['branch_ID']."'>"
							.$row['branch_ID']."</option>";
						}
						echo "</select><br>";
					}
				?>
	<input type="submit" value="Edit Employee info">
	<button type="button" onclick="location.href='../employee.php'" >Go back</button>
</form>
        
	<?php
		$query = "select * from employee_contact where em_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) ==0 or mysqli_num_rows($result) < 2){
        	echo "<hr><button onclick=\"location.href='../add/addemployee_contact.php?id=" .$_GET['id']."&branch=" .$_GET['branch']."'\">Add Contact For Employee </button>";
        }
	?>
			</div>
			</div>
		</div>
	</section>
	<?php  } else{ header("Location: ../employees.php");}?> 
</body>
</html>