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
		$cars =$_POST['cars'];
		$quantity =$_POST['quantity'];
		$origcar=$_POST['origcar'];
		$branch=$_POST['branch'];
		$year=$_SESSION["year"];
		$yr = $_POST['yr'];
		$qty = $_POST['qty'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		$date_arr = explode("-", $date);
        $taon = $date_arr[0];
		$araw=$yr.'-'.$month.'-'.$day;
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
		if($check == 0) function_alert("One or more input are wrong",$id,$origcar,$branch,$qty,$day,$month,$yr);
		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));
			$query="select * from tracks where in_ID = $branch and in_year = '$taon' and vehi_identi_num=$cars";
			$result = mysqli_query($conn,$query); 
			$row = mysqli_fetch_assoc($result);
			if($qty<$quantity){
				$ilan=$quantity-$qty;
			}
			else{
				$ilan=0;
			}
			if($row['in_quantity']<$ilan){
				function_alert("Not Enough Stock",$id,$origcar,$branch,$qty,$day,$month,$yr);
			}
			else{
				if($cnum1!=null ){
					if($cnum1!=$realcnum1){
						$query3 = "select * from  customer_contact natural join buys_at natural join customer where cus_cnum=$cnum1 and branch_id=$branch";
						$result3 = mysqli_query($conn,$query3);
						if (mysqli_num_rows($result3) != 0) {
							function_alert("Contact Number Already Exist",$id,$origcar,$branch,$qty,$day,$month,$yr);
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
						$query3 = "select * from  customer_contact natural join buys_at natural join customer where cus_cnum=$cnum2 and branch_id=$branch";
						$result3 = mysqli_query($conn,$query3);
						if (mysqli_num_rows($result3) != 0) {
							function_alert("Contact Number Already Exist",$id,$origcar,$branch,$qty,$day,$month,$yr);
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

				$query = "select * from automobile natural join automobile_specs where vehi_identi_num=$cars";
				$result = mysqli_query($conn,$query);
				$row = mysqli_fetch_assoc($result);
				$price=$row['automobile_price'];
				$total=$price*$quantity;
	        	$query = "UPDATE buys_at set vehi_identi_num = '$cars', purchase_date = '$date', quantity='$quantity',paid='$total' where cus_ID = '$id' and vehi_identi_num='$origcar' and branch_ID='$branch' and purchase_date ='$araw'";
				mysqli_query($conn, $query);
				if($cars!=$origcar){
					$query="select * from tracks natural join automobile natural join automobile_specs where in_ID = $branch and in_year = '$taon' and vehi_identi_num=$cars";
					$result = mysqli_query($conn,$query); 
					$row = mysqli_fetch_assoc($result);
					$natira=$row['in_quantity']-$quantity;
					$nabenta=$row['in_solditems']+$quantity;
					$benta=$row['automobile_price']*$nabenta;
					$query = "UPDATE tracks set in_solditems='$nabenta',in_quantity='$natira',in_sales='$benta' where vehi_identi_num='$cars' and in_ID='$branch' and in_year='$taon'";
					mysqli_query($conn, $query);

					$query="select * from tracks natural join automobile natural join automobile_specs where in_ID = $branch and in_year = '$taon' and vehi_identi_num=$origcar";
					$result = mysqli_query($conn,$query); 
					$row = mysqli_fetch_assoc($result);
					$natira=$row['in_quantity']+$quantity;
					$nabenta=$row['in_solditems']-$quantity;
					$benta=$row['automobile_price']*$nabenta;
					$query = "UPDATE tracks set in_solditems='$nabenta',in_quantity='$natira',in_sales='$benta' where vehi_identi_num='$origcar' and in_ID='$branch' and in_year='$taon'";
					mysqli_query($conn, $query);
				}else{
					$query="select * from tracks natural join automobile natural join automobile_specs where in_ID = $branch and in_year = '$taon' and vehi_identi_num=$origcar";
					$result = mysqli_query($conn,$query); 
					$row = mysqli_fetch_assoc($result);
					$ilan=$quantity-$qty;
					$natira=$row['in_quantity']-$ilan;
					$nabenta=$row['in_solditems']+$ilan;
					$benta=$row['automobile_price']*$nabenta;
					$query = "UPDATE tracks set in_solditems='$nabenta',in_quantity='$natira',in_sales='$benta' where vehi_identi_num='$origcar' and in_ID='$branch' and in_year='$taon'";
					mysqli_query($conn, $query);
				}
			}
			
			mysqli_close($conn);
			 echo "<script>";
   			echo "location='../sales.php?year=$year'";
    		echo "</script>";
			exit;
		}
	}
	function function_alert($message,$id,$origcar,$branch,$qty,$day,$month,$yr) {
		   echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./editsales.php?id=$id&branch=$branch&car=$origcar&day=$day&month=$month&yr=$yr&qty=$qty';";
    		echo "</script>";
		}
?>
<!DOCTYPE html>
<!-- CUSTOMER DATABASE EDIT -->
<html>
<head>
<link rel="stylesheet" href="editemployees.css">
<title>Edit Sales Information</title>
</head>
<body><?php if (isset($_SESSION["id"])){ $year=$_SESSION['taon']; ?>
    <header>
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
				<h1>Welcome to Sales Database</h1>
				<h2>Edit Info of Sales  <?php echo $_GET['id']; ?>
				<?php
					// Redirecto main if GET and POST variables are not s back tset
					if(!isset($_POST['id']) && !isset($_GET['id'])){
						header("Location: ./main.php");
						exit;
					}?></h2>
					<div class="formna">
                   
<form action="./editsales.php" method="post">
	<!-- Use hidden input if you want to pass POST variables that are not inputted by user -->
	<input type="hidden" name="id" value=<?php echo  $_GET['id']; ?>>
	<input type="hidden" name="origcar" value=<?php echo  $_GET['car']; ?>>
	<input type="hidden" name="branch" value=<?php echo  $_GET['branch']; ?>>
	<input type="hidden" name="yr" value=<?php echo  $_GET['yr']; ?>>
	<input type="hidden" name="month" value=<?php echo  $_GET['month']; ?>>
	<input type="hidden" name="day" value=<?php echo  $_GET['day']; ?>>
	<input type="hidden" name="qty" value=<?php echo  $_GET['qty']; ?>>
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
		echo "Zip Code: <input type='tel'  pattern='[0-9]{1}[0-9]{3}' name='zip' value='".$orig['cus_zipCode']."'><br>";
		$query = "select * from customer_contact where cus_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if (mysqli_num_rows($result) ==1){
            $row = mysqli_fetch_assoc($result);
           echo "Customer Contact Number #1: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name='cnum1' value='0".$row['cus_cnum']."'><br>";
           echo "<input type='hidden' name='cnum2' value=''>";
           echo "<input type='hidden' name='realcnum1' value='".$row['cus_cnum']."'>";
           echo "<input type='hidden' name='realcnum2' value=''>";
        
		 }
        else{
            while($row = mysqli_fetch_assoc($result)){
            	$cnum='cnum'.$x;
            	$realcnum='realcnum'.$x;
                echo "Customer Contact Number #".$x.": <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name='".$cnum."' value='0".$row['cus_cnum']."'><br>";
           		echo "<input type='hidden' name='".$realcnum."' value='".$row['cus_cnum']."'>";
                $x=$x+1;
            }
        }
        $id=$_GET['id'];
        $carid=$_GET['car'];
        $yr = $_GET['yr'];
		$qty = $_GET['qty'];
		$month = $_GET['month'];
		$day = $_GET['day'];
		$araw=$yr.'-'.$month.'-'.$day;
		$query = "select * from automobile natural join buys_at natural join customer where cus_ID=$id and vehi_identi_num=$carid";
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($result);
		$query1 = "select * from automobile ";
        $results = mysqli_query($conn,$query1);
		if(mysqli_num_rows($results) > 0){
			echo "Car Bought: <select name='cars' ><option value='".$row['vehi_identi_num']."'>"
				.$row['automobile_modelname']."</option>";
			while($row1 = mysqli_fetch_assoc($results)){
				if ($row1['vehi_identi_num']!=$row['vehi_identi_num']) {
					echo "<option value='".$row1['vehi_identi_num']."'>"
				.$row1['automobile_modelname']."</option>";
				}
			}
			echo "</select><br>";
		}
		echo "Quantity: <input type='number' name='quantity' value='$qty'><br>";
		echo "Purchase Date: <input type='date' name='date' value='$araw'><br>";
        ?>
	<input type="submit" value="Edit Sales info">
	<?php echo "<button type='button' onclick=\"location.href='../sales.php?year=" .$_SESSION['year']."'\" >Go back</button>"; ?>
</form>
        
	<?php
		$query = "select * from customer_contact where cus_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) ==0 or mysqli_num_rows($result) < 2){
        	echo "<hr><button onclick=\"location.href='../add/addsales_contact.php?id=" .$_GET['id']."&branch=" .$_GET['branch']."&car=" .$_GET['car']."&day=$day&month=$month&yr=$yr&qty=$qty'\">Add Contact For Customer </button>";
        }
	?>
			</div>
			</div>
		</div>
	</section>
	<?php  } else{ header("Location: ../sales.php");}?>
</body>
</html>