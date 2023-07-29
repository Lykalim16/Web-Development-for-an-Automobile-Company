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
				<h1>Welcome to Supplier Database</h1>
				<!-- <h2>Edit Info of Customer  <?php echo $_GET['id']; ?> -->
				<?php
					// Redirecto main if GET and POST variables are not s back tset
					if(!isset($_POST['id']) && !isset($_GET['id'])){
						header("Location: ./main.php");
						exit;
					}?></h2>
					<div class="formna">
			<?php
	if(isset($_POST["supplier_name"])){
		// This part will only execute if $_POST variables are passed to this page
		$check = 1;		
        $id=$_POST['id'];
		$supplier_name= $_POST['supplier_name'];
		$supplier_streetnum =$_POST['supplier_streetnum'];
		$supplier_baranggay=$_POST['supplier_baranggay'];
		$supplier_zipCode=$_POST['supplier_zipCode'];
        $supplier_city=$_POST['supplier_city'];
        $supplier_province=$_POST['supplier_province'];
		$cnum1 =$_POST['cnum1'];
		$realcnum1 =$_POST['realcnum1'];
		$cnum2 =$_POST['cnum2'];
		$realcnum2 =$_POST['realcnum2'];
		if(!preg_match("/\d+/",$supplier_streetnum)){
			$check = 0;
		}
		if(!preg_match("/\d+/",$supplier_zipCode)){
			$check = 0;
		}
		if($check == 0) echo "One or more of your inputs are wrong<br>";
		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));
			$query = "UPDATE supplier set supplier_name = '$supplier_name',supplier_streetnum = '$supplier_streetnum',supplier_baranggay = '$supplier_baranggay', supplier_zipCode = $supplier_zipCode, supplier_city = '$supplier_city' , supplier_province = '$supplier_province' where supplier_ID = '$id'";
			
			mysqli_query($conn, $query);
			$query = "UPDATE supplier_contact set supplier_ID = $id, supplier_cnum = $cnum1 where supplier_cnum = '$realcnum1'";
			mysqli_query($conn, $query);
			$query = "UPDATE supplier_contact set supplier_ID = $id, supplier_cnum = $cnum2 where supplier_cnum = '$realcnum2'";
			mysqli_query($conn, $query);
			if($cnum2==null ){
				$query = "delete from  supplier_contact  where supplier_cnum = '$realcnum2'";
				mysqli_query($conn, $query);
			}
			if($cnum1==null ){
				$query = "delete from  supplier_contact  where supplier_cnum = '$realcnum1'";
				mysqli_query($conn, $query);
			}
			mysqli_close($conn);
			header('Location: ../supplier.php');
			exit;
		}
	}
	
?>
<form action="./editsupplier.php" method="post">
	<!-- Use hidden input if you want to pass POST variables that are not inputted by user -->
	<input type="hidden" name="id" value=<?php echo  $_GET['id']; ?>>
	<?php
		$server = "localhost";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		
		$query = "select * from supplier where supplier_ID = ".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$orig = mysqli_fetch_assoc($result);
		$x=1;
		// Set original info of pet as default inputs
		echo "Supplier Name: <input type='text' name='supplier_name' value='".$orig['supplier_name']."'><br>";
		echo "Street Number: <input type='text' name='supplier_streetnum' value='".$orig['supplier_streetnum']."'><br>";
		echo "Baranggay: <input type='text' name='supplier_baranggay' value='".$orig['supplier_baranggay']."'><br>";
		echo "City: <input type='text' name='supplier_city' value='".$orig['supplier_city']."'><br>";
		echo "Province: <input type='text' name='supplier_province' value='".$orig['supplier_province']."'><br>";
		echo "Zip Code: <input type='tel'  pattern='[0-9]{1}[0-9]{3}' name='supplier_zipCode' value='".$orig['supplier_zipCode']."'><br>";
		$query = "select * from supplier_contact where supplier_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if (mysqli_num_rows($result) ==1){
            $row = mysqli_fetch_assoc($result);
           echo "Supplier Contact Number #1: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name='cnum1' value='0".$row['supplier_cnum']."'><br>";
           echo "<input type='hidden' name='cnum2' value=''>";
           echo "<input type='hidden' name='realcnum1' value='".$row['supplier_cnum']."'>";
           echo "<input type='hidden' name='realcnum2' value=''>";
        
		 }
        else{
            while($row = mysqli_fetch_assoc($result)){
            	$cnum='cnum'.$x;
            	$realcnum='realcnum'.$x;
                echo "Supplier Contact Number #".$x.": <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name='".$cnum."' value='0".$row['supplier_cnum']."'><br>";
           		echo "<input type='hidden' name='".$realcnum."' value='".$row['supplier_cnum']."'>";
                $x=$x+1;
            }
        }
        ?>
	<input type="submit" value="Edit Supplier info">
	<?php echo "<button type='button' onclick=\"location.href='../supplier.php'\" >Go back</button>"; ?>
</form>
        
	<?php
		$query = "select * from supplier_contact where supplier_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) ==0 or mysqli_num_rows($result) < 2){
        	echo "<hr><button onclick=\"location.href='../add/addsupplier_contact.php?id=" .$_GET['id']."'\">Add Contact For Supplier </button>";
        }
	?>
			</div>
			</div>
		</div>
	</section>
	<?php  } else{ header("Location: ../supplier.php");}?>
</body>
</html>