<?php
session_start();
?>
<!DOCTYPE html>
<!-- CUSTOMER DATABASE EDIT -->
<html>
<head>
<link rel="stylesheet" href="editemployees.css">
<title>Edit Manufacturer Information</title>
</head>
<body>
<?php if (isset($_SESSION["id"])){ $year=$_SESSION['taon']; ?>
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
				<h1>Welcome to Manufacturer Database</h1>
				<!-- <h2>Edit Info of Customer  <?php echo $_GET['id']; ?> -->
				<?php
					// Redirecto main if GET and POST variables are not s back tset
					if(!isset($_POST['id']) && !isset($_GET['id'])){
						header("Location: ./main.php");
						exit;
					}?></h2>
					<div class="formna">
			<?php
	if(isset($_POST["manu_name"])){
		// This part will only execute if $_POST variables are passed to this page
		$check = 1;		
        $id=$_POST['id'];
		$manu_name= $_POST['manu_name'];
		$manu_streetNum =$_POST['manu_streetNum'];
		$manu_baranggay=$_POST['manu_baranggay'];
		$manu_zipCode=$_POST['manu_zipCode'];
        $manu_city=$_POST['manu_city'];
        $manu_province=$_POST['manu_province'];
		$cnum1 =$_POST['cnum1'];
		$realcnum1 =$_POST['realcnum1'];
		$cnum2 =$_POST['cnum2'];
		$realcnum2 =$_POST['realcnum2'];
		if(!preg_match("/\d+/",$manu_streetNum)){
			$check = 0;
		}
		if(!preg_match("/\d+/",$manu_zipCode)){
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
			$query = "UPDATE manufacturer set manu_name = '$manu_name',manu_streetNum = '$manu_streetNum',manu_baranggay = '$manu_baranggay', manu_zipCode = $manu_zipCode, manu_city = '$manu_city' , manu_province = '$manu_province' where manu_ID = '$id'";
			
			mysqli_query($conn, $query);
			$query = "UPDATE manufacturer_contact set manu_ID = $id, manu_cnum = $cnum1 where manu_cnum = '$realcnum1'";
			mysqli_query($conn, $query);
			$query = "UPDATE manufacturer_contact set manu_ID = $id, manu_cnum = $cnum2 where manu_cnum = '$realcnum2'";
			mysqli_query($conn, $query);
			if($cnum2==null ){
				$query = "delete from  manufacturer_contact  where manu_cnum = '$realcnum2'";
				mysqli_query($conn, $query);
			}
			if($cnum1==null ){
				$query = "delete from  manufacturer_contact  where manu_cnum = '$realcnum1'";
				mysqli_query($conn, $query);
			}
			mysqli_close($conn);
			header('Location: ../manufacturer.php');
			exit;
		}
	}
	
?>
<form action="./editmanufacturer.php" method="post">
	<!-- Use hidden input if you want to pass POST variables that are not inputted by user -->
	<input type="hidden" name="id" value=<?php echo  $_GET['id']; ?>>
	<?php
		$server = "localhost";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		
		$query = "select * from manufacturer where manu_ID = ".$_GET['id'];
		$result = mysqli_query($conn,$query);
		$orig = mysqli_fetch_assoc($result);
		$x=1;
		// Set original info of pet as default inputs
		echo "Manufacturer Name: <input type='text' name='manu_name' value='".$orig['manu_name']."'><br>";
		echo "Street Number: <input type='text' name='manu_streetNum' value='".$orig['manu_streetNum']."'><br>";
		echo "Baranggay: <input type='text' name='manu_baranggay' value='".$orig['manu_baranggay']."'><br>";
		echo "City: <input type='text' name='manu_city' value='".$orig['manu_city']."'><br>";
		echo "Province: <input type='text' name='manu_province' value='".$orig['manu_province']."'><br>";
		echo "Zip Code: <input type='tel'  pattern='[0-9]{1}[0-9]{3}' name='manu_zipCode' value='".$orig['manu_zipCode']."'><br>";
		$query = "select * from manufacturer_contact where manu_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if (mysqli_num_rows($result) ==1){
            $row = mysqli_fetch_assoc($result);
           echo "Manufacturer Contact Number #1: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name='cnum1' value='0".$row['manu_cnum']."'><br>";
           echo "<input type='hidden' name='cnum2' value=''>";
           echo "<input type='hidden' name='realcnum1' value='".$row['manu_cnum']."'>";
           echo "<input type='hidden' name='realcnum2' value=''>";
        
		 }
        else{
            while($row = mysqli_fetch_assoc($result)){
            	$cnum='cnum'.$x;
            	$realcnum='realcnum'.$x;
                echo "Manufacturer Contact Number #".$x.": <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}' name='".$cnum."' value='0".$row['manu_cnum']."'><br>";
           		echo "<input type='hidden' name='".$realcnum."' value='".$row['manu_cnum']."'>";
                $x=$x+1;
            }
        }
        ?>
	<input type="submit" value="Edit Manufacturer info">
	<?php echo "<button type='button' onclick=\"location.href='../manufacturer.php'\" >Go back</button>"; ?>
</form>
        
	<?php
		$query = "select * from manufacturer_contact where manu_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) ==0 or mysqli_num_rows($result) < 2){
        	echo "<hr><button onclick=\"location.href='../add/addmanufacturer_contact.php?id=" .$_GET['id']."'\">Add Contact For Manufacturer </button>";
        }
	?>
			</div>
			</div>
		</div>
	</section>
	<?php  } else{ header("Location: ../manufacturer.php");}?>
</body>
</html>