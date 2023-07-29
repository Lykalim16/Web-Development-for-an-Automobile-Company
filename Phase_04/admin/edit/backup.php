<?php
session_start();
?>
<!DOCTYPE html>
<!-- CUSTOMER DATABASE EDIT -->
<html>
<head>
<link rel="stylesheet" href="editemployees.css">
<title>Edit Customer Information</title>
</head>
<body>
	<header>
        <div class="logo"><a href="#">TOYOTA</a></div>
        <nav>
            <ul>
                <li><a href="#">My Profile</a></li>
                <li><a href="../customer.php">Branch Info</a></li>
                <li><a href="#">Report</a></li>
                <li><a href="#">Log Out</a></li>
            </ul>
        </nav>
    </header>

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
			<?php
	if(isset($_POST["fname"])){
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
		$date =$_POST['date'];
		$date_arr = explode("-", $date);
		$years = $date_arr[0];
		$curryear=date("Y");
		$car =$_POST['car'];
		$branch =$_POST['branch'];
		if(!preg_match("/\d+/",$streetnum)){
			$check = 0;
		}
		if(!preg_match("/\d+/",$zip)){
			$check = 0;
		}
		if(!preg_match("/^[a-zA-Z \-'_]+$/",$_POST["fname"])){
			$check = 0;
		}
		if(!preg_match("/^[a-zA-Z \-'_ ]+$/",$_POST["mname"])){
			$check = 0;
		}
		if(!preg_match("/^[a-zA-Z \-'_ ]+$/",$_POST["lname"])){
			$check = 0;
		}
		if(!preg_match("/^[a-zA-Z \-'_]+$/",$_POST["province"])){
			$check = 0;
		}
		if(!preg_match("/^[a-zA-Z \-'_ ]+$/",$_POST["city"])){
			$check = 0;
		}
		if($years< 2019){
			$check = 0;
		}
		if($years> $curryear){
			$check = 0;
		}
		if($check == 0) {
			echo "<script>";
   			echo "alert('Wrong Input, No Changes To Customer'); ";
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
			$query = "UPDATE customer set cus_fname = '$fname',cus_mname = '$mname',cus_lname = '$lname', cus_streetNum = $streetnum, cus_baranggay = '$brgy' , cus_zipCode = '$zip', cus_city = '$city' , cus_province = '$province' where cus_ID = '$id'";
			
			mysqli_query($conn, $query);
			$query = "UPDATE customer_contact set cus_ID = $id, cus_cnum = $cnum1 where cus_cnum = '$realcnum1'";
			mysqli_query($conn, $query);
			$query = "UPDATE customer_contact set cus_ID = $id, cus_cnum = $cnum2 where cus_cnum = '$realcnum2'";
			mysqli_query($conn, $query);
        	$query = "UPDATE purchase set vehi_identi_num = $car,purchase_date='$date' where cus_ID = '$id'";
			mysqli_query($conn, $query);
			$query = "UPDATE buys_at set branch_ID = $branch where cus_ID = $id";
			mysqli_query($conn, $query);

			if($cnum2==null ){
				$query = "delete from  customer_contact  where cus_cnum = '$realcnum2'";
				mysqli_query($conn, $query);
			}
			if($cnum1==null ){
				$query = "delete from  customer_contact  where cus_cnum = '$realcnum1'";
				mysqli_query($conn, $query);
			}
			mysqli_close($conn);
			header('Location: ../customer.php?year=' .$_SESSION["year"]);
			exit;
		}
	}
	
?>
<form action="./editcustomers.php" method="post">
	<!-- Use hidden input if you want to pass POST variables that are not inputted by user -->
	<input type="hidden" name="id" value=<?php echo  $_GET['id']; ?>>
	<?php
		$server = "localhost";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		$bid=$_GET['branch'];
		$cid=$_GET['id'];
		$query = "select * from customer natural join buys_at where cus_ID = $cid and branch_ID=$bid ";
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
		echo "Zip Code: <input type='text' name='zip' value='".$orig['cus_zipCode']."'><br>";
		$query = "select * from customer_contact where cus_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if (mysqli_num_rows($result) ==1){
            $row = mysqli_fetch_assoc($result);
           echo "customer Contact Number #1: <input type='text' name='cnum1' value='".$row['cus_cnum']."'><br>";
           echo "<input type='hidden' name='cnum2' value=''>";
           echo "<input type='hidden' name='realcnum1' value='".$row['cus_cnum']."'>";
           echo "<input type='hidden' name='realcnum2' value=''>";
        
		 }
        else{
            while($row = mysqli_fetch_assoc($result)){
            	$cnum='cnum'.$x;
            	$realcnum='realcnum'.$x;
                echo "Customer Contact Number #".$x.": <input type='text' name='".$cnum."' value='".$row['cus_cnum']."'><br>";
           		echo "<input type='hidden' name='".$realcnum."' value='".$row['cus_cnum']."'>";
                $x=$x+1;
            }
        }
		$query = "select * from automobile natural join purchase natural join customer where cus_ID=".$_GET['id'];
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($result);
        $id=$_GET['id'];
		
		$query1 = "select * from automobile where vehi_identi_num not in (select vehi_identi_num from  purchase  where cus_ID=$id)";
        $results = mysqli_query($conn,$query1);
		if(mysqli_num_rows($results) > 0){
			echo "Car Bought: <select name='car' ><option value='".$row['vehi_identi_num']."'>"
				.$row['automobile_modelname']."</option>";
			while($row1 = mysqli_fetch_assoc($results)){
				echo "<option value='".$row1['vehi_identi_num']."'>"
				.$row1['automobile_modelname']."</option>";
			}
			echo "</select><br>";
		}
		echo "Purchase Date: <input type='date' name='date' value='".$row['purchase_date']."'><br>";
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
						echo "Assosiated Branch: <select name='branch'><option value='".$bid."'>"
							.$bid."</option>";
						while($row = mysqli_fetch_assoc($result)){
							echo "<option value='".$row['branch_ID']."'>"
							.$row['branch_ID']."</option>";
						}
						echo "</select><br>";
					}
				?>
	<input type="submit" value="Edit Customer info">
	<?php echo "<button type='button' onclick=\"location.href='../customer.php?year=" .$_SESSION['year']."'\" >Go back</button>"; ?>
</form>
        
	<?php
		$query = "select * from customer_contact where cus_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) ==0 or mysqli_num_rows($result) < 2){
        	echo "<hr><button onclick=\"location.href='../add/addcustomer_contact.php?id=" .$_GET['id']."&branch=" .$_GET['branch']."'\">Add Contact For Customer </button>";
        }
	?>
			</div>
			</div>
		</div>
	</section>
</body>
</html>