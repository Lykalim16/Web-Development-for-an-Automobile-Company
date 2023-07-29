<?php
session_start();
?>
<?php
	if(isset($_POST["name"])){
		// This part will only execute if $_POST variables are passed to this page
		$check = 1;		
		$name= $_POST['name'];
		$streetnum =$_POST['streetnum'];
		$brgy=$_POST['brgy'];
		$zip=$_POST['zip'];
		$id=$_POST['id'];
		$city= $_POST['city'];
		$province =$_POST['province'];
		$cnum1 =$_POST['cnum1'];
		$realcnum1 =$_POST['realcnum1'];
		$cnum2 =$_POST['cnum2'];
		$realcnum2 =$_POST['realcnum2'];
		if(!preg_match("/^[a-zA-Z ]+$/",$province)){
			$check = 0;
		}
		if(!preg_match("/\d+/",$streetnum)){
			$check = 0;
		}
		if(!preg_match("/\d+/",$zip)){
			$check = 0;
		}
		if($check == 0){ 
			alerting("One or more input is invalid",$id);
		}
		else{
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));
			if($cnum1!=null ){
				if($cnum1!=$realcnum1){
					$query3 = "select * from branch_contact  where branch_cnum = $cnum1";
					$result3 = mysqli_query($conn,$query3);
					if (mysqli_num_rows($result3) != 0) {
						alerting("Contact Number Already Exist",$id);
					}
					else{
						$query = "UPDATE branch set branch_name = '$name', branch_streetNum = $streetnum, branch_baranggay = '$brgy' , branch_zipCode = '$zip', branch_city = '$city', branch_province = '$province' where branch_ID = '$id'";
						mysqli_query($conn, $query);

						$query = "UPDATE branch_contact set branch_ID = $id, branch_cnum = $cnum1 where branch_cnum = '$realcnum1'";
						mysqli_query($conn, $query);
					}
				}
				else{
					$query = "UPDATE branch set branch_name = '$name', branch_streetNum = $streetnum, branch_baranggay = '$brgy' , branch_zipCode = '$zip', branch_city = '$city', branch_province = '$province' where branch_ID = '$id'";
						mysqli_query($conn, $query);
				}

			}
			else{
				$query = "UPDATE branch set branch_name = '$name', branch_streetNum = $streetnum, branch_baranggay = '$brgy' , branch_zipCode = '$zip', branch_city = '$city', branch_province = '$province' where branch_ID = '$id'";
						mysqli_query($conn, $query);
			}
			if($cnum2!=null ){
				if($cnum2!=$realcnum2){
					$query3 = "select * from branch_contact where branch_cnum = $cnum2";
					$result3 = mysqli_query($conn,$query3);
					if (mysqli_num_rows($result3) != 0) {
						alerting("Contact Number Already Exist",$id);
					}
					else{
						$query = "UPDATE branch set branch_name = '$name', branch_streetNum = $streetnum, branch_baranggay = '$brgy' , branch_zipCode = '$zip', branch_city = '$city', branch_province = '$province' where branch_ID = '$id'";
						mysqli_query($conn, $query);
						$query = "UPDATE branch_contact set branch_ID = $id, branch_cnum = $cnum2 where branch_cnum = '$realcnum2'";
						mysqli_query($conn, $query);				
					}
				}
				else{
					$query = "UPDATE branch set branch_name = '$name', branch_streetNum = $streetnum, branch_baranggay = '$brgy' , branch_zipCode = '$zip', branch_city = '$city', branch_province = '$province' where branch_ID = '$id'";
						mysqli_query($conn, $query);
				}
			}
			else{
				
				$query = "delete from  branch_contact  where branch_cnum = '$realcnum2'";
				mysqli_query($conn, $query);
				$query = "UPDATE branch set branch_name = '$name', branch_streetNum = $streetnum, branch_baranggay = '$brgy' , branch_zipCode = '$zip', branch_city = '$city', branch_province = '$province' where branch_ID = '$id'";
						mysqli_query($conn, $query);
			}
			mysqli_close($conn);
			 echo "<script>";
   			echo "location='../branches.php'";
    		echo "</script>";
			exit;
		}
	}
	
		function alerting($message,$id) {
	    	echo "<script>";
   			echo "alert('$message'); ";
   			echo "location='./editbranches.php?id=$id';";
    		echo "</script>";
	}
	
?>
<!DOCTYPE html>
<!-- BRANCH DATABASE EDIT -->
<html>
<head>
<link rel="stylesheet" href="editemployees.css">
<title>Edit Branch Information</title>
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
				<h1>Welcome to Branches Database</h1>
				<h2>Edit Branch Info for Branch <?php echo $_SESSION["id"]; ?>
				
					<div class="formna">
					
<form action="./editbranches.php" method="post">
	<!-- Use hidden input if you want to pass POST variables that are not inputted by user -->
	<input type="hidden" name="id" value=<?php echo  $_SESSION["id"]; ?>>
	<?php
		$server = "localhost";
		$user = "root";
		$pass = "";
		$db = "phase2";
		$conn = mysqli_connect($server, $user, $pass, $db);
		if(!$conn) die(mysqli_error($conn));
		
		// Get original info of pet 
		$query = "select * from branch where branch_ID = ". $_SESSION["id"];
		$result = mysqli_query($conn,$query);
		$orig = mysqli_fetch_assoc($result);
		$x=1;
		// Set original info of pet as default inputs
		echo "Branch Name: <input type='text' name='name' value='".$orig['branch_name']."' required><br>";
		echo "Branch Street Number: <input type='text' name='streetnum' value='".$orig['branch_streetNum']."' required><br>";
		echo "Branch Baranggay: <input type='text' name='brgy' value='".$orig['branch_baranggay']."' required><br>";
		echo "Branch City: <input type='text' name='city' value='".$orig['branch_city']."' required><br>";
		echo "Branch Province: <input type='text' name='province' value='".$orig['branch_province']."' required><br>";
		echo "Branch Zip Code: <input type='tel'  pattern='[0-9]{1}[0-9]{3}' name='zip' value='".$orig['branch_zipCode']."' required><br>";
		$query = "select * from branch_contact where branch_id = ". $_SESSION["id"];
        $result = mysqli_query($conn,$query);
        if (mysqli_num_rows($result) ==1){
            $row = mysqli_fetch_assoc($result);
           echo "Branch Contact Number #1: <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}'  name='cnum1' value='0".$row['branch_cnum']."' required><br>";
           echo "<p style='color: red' id='message3'></p>";
           echo "<input type='hidden' name='cnum2' value=''>";
           echo "<input type='hidden' name='realcnum1' value='".$row['branch_cnum']."'>";
           echo "<input type='hidden' name='realcnum2' value=''>";
        
		 }
        else{
            while($row = mysqli_fetch_assoc($result)){
            	$cnum='cnum'.$x;
            	$realcnum='realcnum'.$x;
            	$num='num'.$x;
                echo "Branch Contact Number #".$x.": <input type='tel' pattern='[0]{1}[9]{1}[0-9]{9}'  name='".$cnum."' id='".$num."'  value='0".$row['branch_cnum']."'><br>";
           		echo "<input type='hidden' name='".$realcnum."' value='".$row['branch_cnum']."'>";
                $x=$x+1;
            }
        }
           		echo "<p style='color: red' id='message3'></p>";
        ?>
	<input type="submit" id="submit" value="Edit Branch info" >
	<button type="button" onclick="location.href='../branches.php'" >Go back</button>
</form>
<?php
		$query = "select * from branch_contact where branch_ID = ".$_GET['id'];
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) ==0 or mysqli_num_rows($result) < 2){
        	echo "<hr><button onclick=\"location.href='../add/addbranch_contact.php?id=" .$_GET['id']."'\">Add Branch Contact </button>";
        }
	?>
					</div>
			</div>
		</div>
	</section>
	
<?php } else{ header("Location: ../employees.php");}?>
</body>
</html>