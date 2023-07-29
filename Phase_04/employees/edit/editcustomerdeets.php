<?php
session_start();
?><?php
	if(isset($_POST["id"])){
		// This part will only execute if $_POST variables are passed to this page
		$check = 1;		
		$fname= $_POST['fname'];
		$mname= $_POST['mname'];
		$lname= $_POST['lname'];
		$streetnum =$_POST['streetnum'];
		$city =$_POST['city'];
		$province =$_POST['province'];
		$brgy=$_POST['brgy'];
		$zip=$_POST['zip'];
		$id=$_POST['id'];
		$cnum1 =$_POST['cnum1'];
		$realcnum1 =$_POST['realcnum1'];
		$cnum2 =$_POST['cnum2'];
		$realcnum2 =$_POST['realcnum2'];
		$branch=$_SESSION['id'];
		if(!preg_match("/\d+/",$streetnum)){
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
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			
	
			if(!$conn) die(mysqli_error($conn));
			if($cnum1!=null ){
				if($cnum1!=$realcnum1){
					$query3 = "select * from customer_contact natural join buys_at natural join customer where cus_cnum = $cnum1 and branch_id=$branch";
					$result3 = mysqli_query($conn,$query3);
					if (mysqli_num_rows($result3) != 0) {
						function_alert("Contact Number Already Exist",$id);
					}
					else{
						$query = "UPDATE customer set cus_fname = '$fname',cus_mname = '$mname',cus_lname = '$lname', cus_streetNum = $streetnum, cus_baranggay = '$brgy' , cus_zipCode = '$zip', cus_city = '$city' , cus_province = '$province' where cus_ID = '$id'";
						mysqli_query($conn, $query);
						$query = "UPDATE customer_contact set cus_ID = $id, cus_cnum = $cnum1 where cus_cnum = '$realcnum1'";
						mysqli_query($conn, $query);
					}
				}
				else{
					$query = "UPDATE customer set cus_fname = '$fname',cus_mname = '$mname',cus_lname = '$lname', cus_streetNum = $streetnum, cus_baranggay = '$brgy' , cus_zipCode = '$zip', cus_city = '$city' , cus_province = '$province' where cus_ID = '$id'";
						mysqli_query($conn, $query);
				}

			}
			else{
				$query = "UPDATE customer set cus_fname = '$fname',cus_mname = '$mname',cus_lname = '$lname', cus_streetNum = $streetnum, cus_baranggay = '$brgy' , cus_zipCode = '$zip', cus_city = '$city' , cus_province = '$province' where cus_ID = '$id'";
				mysqli_query($conn, $query);
			}
			if($cnum2!=null ){
				if($cnum2!=$realcnum2){
					$query3 = "select * from customer_contact natural join buys_at natural join customer where cus_cnum = $cnum2 and branch_id=$branch";
					$result3 = mysqli_query($conn,$query3);
					if (mysqli_num_rows($result3) != 0) {
						function_alert("Contact Number Already Exist",$id);
					}
					else{
						$query = "UPDATE customer set cus_fname = '$fname',cus_mname = '$mname',cus_lname = '$lname', cus_streetNum = $streetnum, cus_baranggay = '$brgy' , cus_zipCode = '$zip', cus_city = '$city' , cus_province = '$province' where cus_ID = '$id'";
						mysqli_query($conn, $query);
						$query = "UPDATE customer_contact set cus_ID = $id, cus_cnum = $cnum2 where cus_cnum = '$realcnum2'";
						mysqli_query($conn, $query);				
					}
				}
				else{
					$query = "UPDATE customer set cus_fname = '$fname',cus_mname = '$mname',cus_lname = '$lname', cus_streetNum = $streetnum, cus_baranggay = '$brgy' , cus_zipCode = '$zip', cus_city = '$city' , cus_province = '$province' where cus_ID = '$id'";
					mysqli_query($conn, $query);
				}
			}
			else{
				$query = "delete from  customer_contact  where cus_cnum = '$realcnum2'";
				mysqli_query($conn, $query);
				$query = "UPDATE customer set cus_fname = '$fname',cus_mname = '$mname',cus_lname = '$lname', cus_streetNum = $streetnum, cus_baranggay = '$brgy' , cus_zipCode = '$zip', cus_city = '$city' , cus_province = '$province' where cus_ID = '$id'";
				mysqli_query($conn, $query);
			}
			mysqli_close($conn);
			 echo "<script>";
   			echo "location='../customer1.php'";
    		echo "</script>";
			exit;
		}
	}
	function function_alert($message,$id) {
		   echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./editcustomerdeets.php?id=$id';";
    		echo "</script>";
		}
	
?>
<!DOCTYPE html>
<!-- CUSTOMER DATABASE EDIT -->
<html>
<head>
<link rel="stylesheet" href="editemployees.css">
<script src="city.js"></script>
<title>Edit Customer Information</title>
</head>
<body>

<?php $year=$_SESSION['taon']; ?>
<header>
        <div class="logo"><a href="../../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
                <li><div class='where'><a href="../employee.php">EMPLOYEES</a></li></div>
                <li><a href="../customer1.php">CUSTOMER</a></li>
                <li><a href="../branches.php">BRANCHES</a></li>
                <?php echo "<li><a href='../inventory.php?year=$year' >INVENTORY</a></li>"?>
                <?php echo "<li><a href='../customer.php?year=$year' >SALES</a></li>"?>
                <?php echo "<li><a href='../report.php?year=$year' >REPORT GENERATION</a></li>"?>
                <li><a href="../../logout.php">LOG OUT</a></li>
                <li class="name">Hello, <?php echo $_SESSION['name'];?></li>
            </ul>
        </nav>
    </header>

<?php if (isset($_SESSION["id"])){ ?>
	<section class="editemployeebanner">
		<div id="center">
			<div class="editemployeeform">
				<h1>Welcome to Customer Database</h1>
				<!-- <h2>Edit Info of Customer  <?php echo $_GET['id']; ?> -->
				<?php
					// Redirecto main if GET and POST variables are not s back tset
					if(!isset($_POST['id']) && !isset($_GET['id'])){
						header("Location: ./main.php");
						exit;
					}?></h2>
					<div class="formna">
					
<form action="./editcustomerdeets.php" method="post">
	<!-- Use hidden input if you want to pass POST variables that are not inputted by user -->
	<input type="hidden" name="id" value=<?php echo  $_GET['id']; ?>>
	<?php
		$server = "localhost";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		
		$query = "select * from customer where cus_ID = ".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$orig = mysqli_fetch_assoc($result);
		$x=1;
		// Set original info of pet as default inputs
		echo "First Name: <input type='text' name='fname' value='".$orig['cus_fname']."'><br>";
		echo "Middle Initial: <input type='text' name='mname' value='".$orig['cus_mname']."'><br>";
		echo "Last Name: <input type='text' name='lname' value='".$orig['cus_lname']."'><br>";
		echo "Street Number: <input type='text' name='streetnum' value='".$orig['cus_streetNum']."'><br>";
		echo "Baranggay: <input type='text' name='brgy' value='".$orig['cus_baranggay']."'><br>";
		echo "City: <input type='text' name='city' value='".$orig['cus_city']."'><br>";
		echo "Province: <input type='text' name='province' value='".$orig['cus_province']."'><br>";
		echo "Zip Code: <input type='tel'  pattern='[0-9]{1}[0-9]{3}' onchange='check_zip();' name='zip' value='".$orig['cus_zipCode']."'><br>";
		$query = "select * from customer_contact where cus_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if (mysqli_num_rows($result) ==1){
            $row = mysqli_fetch_assoc($result);
           echo "Customer Contact Number #1: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}'  name='cnum1' id='num1' onchange='check_num1();' value='0".$row['cus_cnum']."'><br>";
           echo "<input type='hidden' name='cnum2' value=''>";
           echo "<input type='hidden' name='realcnum1' value='".$row['cus_cnum']."'>";
           echo "<input type='hidden' name='realcnum2' value=''>";
        
		 }
        else{
            while($row = mysqli_fetch_assoc($result)){
            	$cnum='cnum'.$x;
            	$realcnum='realcnum'.$x;
            	$num='num'.$x;
            	$checknum='check_num'.$x.'();';
                echo "Customer Contact Number #".$x.": <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}'  name='".$cnum."' id='".$num."' onchange='".$checknum."' value='0".$row['cus_cnum']."'><br>";
           		echo "<input type='hidden' name='".$realcnum."' value='".$row['cus_cnum']."'>";
                $x=$x+1;
            }
        }      
           		echo "<p style='color: red' id='message3'></p>"; 
           		echo "<p style='color: red' id='message4'></p>";  ?>
	<input type="submit" id="submit" value="Edit Customer info">
	<?php echo "<button type='button' onclick=\"location.href='../customer1.php'\" >Go back</button>"; ?>
</form>
        
	<?php
		$query = "select * from customer_contact where cus_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) ==0 or mysqli_num_rows($result) < 2){
        	echo "<hr><button onclick=\"location.href='../add/addcontacts.php?id=" .$_GET['id']."'\">Add Contact For Customer </button>";
        }
	?>
			</div>
			</div>
		</div>
	</section>

<?php } else{ header("Location: ../employees.php");}?>
</body>
</html>