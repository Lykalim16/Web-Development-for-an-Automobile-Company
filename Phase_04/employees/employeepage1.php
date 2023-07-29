<?php
session_start();
?>
<style type="text/css">
	* {
    margin: 0;
    padding: 0;
    text-decoration: none;
}
@font-face {
  font-family: Ghino;
  src: url(../ghino/Guintype\ \ GhinoBlack.otf);
}
@font-face {
    font-family: Ghino-light;
    src: url(../ghino/Guintype\ \ GhinoLight.otf);
}
@font-face {
    font-family: Ghino-bold;
    src: url(../ghino/Guintype\ \ GhinoExtrabold.otf);
}
@font-face {
    font-family: Ghino-boldItalic;
    src: url(../ghino/Guintype\ \ GhinoBoldtalic.otf);
}
/* Header styling */
main {
    padding-top: 100px;
}
html, body {
    max-width: 100%;
    overflow-x: hidden;
    margin-left: -10px;
}
header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color: white;
    opacity: calc(80%);
    width: 100%;
    height: 100px;
    z-index: 10000;
}
header .logo {
    font-family: 'Ghino', serif;
    font-size: 40px;
    display: block;
    margin: 0 auto;
    text-align: center;
}
header .logo a {
    color: black;
    padding: 20px 0;
}
header nav ul {
    display: block;
    margin: 0 auto;
    width: fit-content;
}
header nav ul li {
    margin-top: 15px;
    display: inline-block;
    float: left;
    list-style: none;
    padding: 0 16px;
}
header nav ul li a {
    color: black;
    opacity: calc(100%);
    font-family: 'Ghino', sans-serif;
    font-size: 15px;
    display: block;
    margin: 0 auto;
    text-align: center;
    font-weight: bold;
}
/* Desktop-header styling */
@media only screen and (min-width: 1000px) {
    header .logo {
        margin: 31px 0;
        text-align: left;
        line-height: 40px;
        padding: 0 20px 0 40px;
        border-right: 3px solid black;
        float: left;
    }
    header nav ul {   
        margin-left: 20px;
        float: left;
    }
    header nav ul li:hover {   
        background-color:  #D0D0D0;
        border-radius: 10%;
    }
    header nav ul li a {
        line-height: 72px;
    }
    header nav ul li a:hover {
        font-size: 17px;
        color: rgb(133, 6, 6);
    }
}

.background {
    width: 100%;
    height: calc(100vh - 100px);
    background-image: url(../img/jj.jpeg);
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    display: table;
    overflow: hidden;
}
	body{
		font-family: roboto-thin;
        
	}
	#center{
		margin: auto;
		width: 90%;
		text-align: center;
		position: relative;
		top: 100px;

	}
    .background h1{
        font-family: 'Ghino-light';
    }
	th{
		background-color: rgb(148, 181, 246);
		border: 1px solid black;
		padding: 7pt;
		margin: auto;
		border-collapse: collapse;
		text-align: center;
        font-size: 10px;
	}
	table,  td {
	  border: 1px solid black;
      background-color: white;
	  padding: 7pt;
	  margin: auto;
	  border-collapse: collapse;
	  text-align: center;
      font-size: 10px;
	}
	h1,h2{
		text-align: center;
	}
	.add{
		padding: 15px;
        font-size: 10px;
	  	text-align: center;
	  	border: 1px solid black;
	}
	.emp{
		font-size:15px;
	}
</style>

<!DOCTYPE html>
<html>
<head>
<title>Edit Branch Information</title>
</head>
<body>
<header>
        <div class="logo"><a href="#">TOYOTA</a></div>
        <nav>
            <ul>
                <li><a href="#">My Profile</a></li>
                <li><a href="employeepage1.php">Branch Info</a></li>
                <li><a href="#">Report</a></li>
                <li><a href="#">Log Out</a></li>
            </ul>
        </nav>
    </header>

<div id="center">
	<section class="background">
    <h1>Branch <?php echo $_SESSION['id']; ?> Details </h1>
<?php
	$server = "localhost";
    $user = "root";
    $pass = "";
    $db = "phase2";
    $conn = mysqli_connect($server, $user, $pass, $db);
    if(!$conn) die(mysqli_error($conn));
    $query = "select * from branch where branch_id =". $_SESSION["id"];
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) > 0){
        echo "<table>
        <tr>
            <th> ID</th>
            <th> Name</th>
            <th> Street Number</th>
            <th> Baranggay</th>
            <th> City</th>
            <th> Province</th>
            <th> Zip Code</th>
            <th colspan='2'> Contact Num</th>
            <th>Edit</th>
        </tr>";
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>".$row['branch_ID']."</td>
            <td>".$row['branch_name']." </td>
            <td>".$row['branch_streetNum']." </td>
            <td>".$row['branch_baranggay']." </td>
            <td>".$row['branch_city']." </td>
            <td>".$row['branch_province']." </td> 
            <td>".$row['branch_zipCode']." </td>
            ";
        
        $query = "select * from branch_contact where branch_id = ". $_SESSION["id"];
        $result = mysqli_query($conn,$query);
        if (mysqli_num_rows($result) ==1){
            $row = mysqli_fetch_assoc($result);
            echo "<td>".$row['branch_cnum']."</td>
            <td></td>";
            ;
        }elseif(mysqli_num_rows($result) ==0){
	        	 echo "<td></td>
	            <td></td>";
	        }
        else{
            while($row = mysqli_fetch_assoc($result)){
                echo "<td>".$row['branch_cnum']."</td>";
            }
        }echo "<td><button onclick=\"location.href='./edit/editbranches.php?id=". $_SESSION["id"]."'\">Edit</button></td></tr></table>";}
    }

?>
<br>
<br>
<h1>Employee</h1>
<?php 
	$query = "select * from employee natural join branch natural join works where branch_id =". $_SESSION["id"];
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) > 0){
        echo "<table>
        <tr>
        	<th>Employee ID</th>
        	<th> First Name</th>
        	<th> Middle Name</th>
        	<th> Last Name</th>
			<th> Street Number</th>
			<th> Baranggay</th>
			<th> City</th>
			<th> Province</th>
			<th> Zip Code</th>
            <th colspan='2'> Contact Num</th>
  			<th>Edit</th>
			<th>Delete</th>
		</tr>";
        while($row = mysqli_fetch_assoc($result)){
			echo "<tr><td>".$row['em_ID']."</td>
			<td>".$row['em_fname']."</td>
			<td>".$row['em_mname']."</td>
			<td>".$row['em_lname']."</td>
			<td>".$row['em_streetNum']."</td>
			<td>".$row['em_baranggay']."</td>
			<td>".$row['em_city']."</td>
			<td>".$row['em_province']."</td>
			<td>".$row['em_zipCode']."</td>";
        
	        $query = "select * from employee_contact where em_ID = ".$row["em_ID"];
	        $result2 = mysqli_query($conn,$query);
	        if (mysqli_num_rows($result2) ==1){
	            $row2 = mysqli_fetch_assoc($result2);
	            echo "<td>".$row2['em_cnum']."</td>
	            <td></td>";
	           
	        }elseif(mysqli_num_rows($result2) ==0){
	        	 echo "<td></td>
	            <td></td>";
	        }
	        else{
	            while($row2 = mysqli_fetch_assoc($result2)){
	                echo "<td>".$row2['em_cnum']."</td>";
	            }
	        }
	        echo "<td><button onclick=\"location.href='./edit/editemployees.php?id=" .$row['em_ID']."'\">Edit</button></td>
	        	<td><button onclick=\"location.href='./delete/deleteemployee.php?id=".$row['em_ID']."'\">Delete</button></td></tr>";
    	}
    }
		echo "</table>";

?><br><button class="add" onclick="location.href='./add/addemployee.php'">Add New Employee</button>

<br>
<br>
<h1>Customer</h1>
<?php 
	$query = "select * from customer natural join branch natural join buys_at where branch_id =". $_SESSION["id"];
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) > 0){
        echo "<table>
        <tr>
        	<th>Employee ID</th>
        	<th> First Name</th>
        	<th> Middle Name</th>
        	<th> Last Name</th>
			<th> Street Number</th>
			<th> Baranggay</th>
			<th> City</th>
			<th> Province</th>
			<th> Zip Code</th>
            <th colspan='2'> Contact Num</th>
  			<th>Edit</th>
			<th>Delete</th>
		</tr>";
        while($row = mysqli_fetch_assoc($result)){
			echo "<tr><td>".$row['cus_ID']."</td>
			<td>".$row['cus_fname']."</td>
			<td>".$row['cus_mname']."</td>
			<td>".$row['cus_lname']."</td>
			<td>".$row['cus_streetNum']."</td>
			<td>".$row['cus_baranggay']."</td>
			<td>".$row['cus_city']."</td>
			<td>".$row['cus_province']."</td>
			<td>".$row['cus_zipCode']."</td>";
        
	        $query = "select * from customer_contact where cus_ID = ".$row["cus_ID"];
	        $result2 = mysqli_query($conn,$query);
	        if (mysqli_num_rows($result2) ==1){
	            $row2 = mysqli_fetch_assoc($result2);
	            echo "<td>".$row2['cus_cnum']."</td>
	            <td></td>";
	           
	        }elseif(mysqli_num_rows($result2) ==0){
	        	 echo "<td></td>
	            <td></td>";
	        }
	        else{
	            while($row2 = mysqli_fetch_assoc($result2)){
	                echo "<td>".$row2['cus_cnum']."</td>";
	            }
	        }
	        echo "<td><button onclick=\"location.href='./edit/editcustomers.php?id=" .$row['cus_ID']."'\">Edit</button></td>
	        	<td><button onclick=\"location.href='./delete/deletecustomer.php?id=".$row['cus_ID']."'\">Delete</button></td></tr>";
    	}
    }
		echo "</table>";

?><br><button class="add" onclick="location.href='./add/addcustomer.php'">Add New Customer</button>
<br>
    <br>
<h1>Inventory</h>
<?php 
	$query = "select * from automobile natural join automobile_specs natural join tracks natural join has_inventory natural join branch where branch_id =". $_SESSION["id"];
    $result = mysqli_query($conn,$query);
    $pesosign = "₱";
    if(mysqli_num_rows($result) > 0){
        echo "<table>
        <tr>
        	<th> Vehicle ID</th>
        	<th> Vehicle Name</th>
            <th>  Stock</th>
            <th> Sold</th>
            <th> Remaining Quantity</th>
            <th> Price</th>
            <th> Sales</th>
        	<th> Edit</th>
		</tr>";
        while($row = mysqli_fetch_assoc($result)){
            $pr=$pesosign.  $row['automobile_price'];
            $pr2=$pesosign.  $row['in_sales'];
			echo "<tr><td>".$row['vehi_identi_num']."</td>
			<td>".$row['automobile_modelname']."</td>
            <td>".$row['in_stock']."</td>
            <td>".$row['in_solditems']."</td>
			<td>".$row['in_quantity']."</td>
            <td>" .$pr."</td><td>" .$pr2."</td>";
	        echo "<td><button onclick=\"location.href='./edit/editinventory.php?id=" .$row['vehi_identi_num']."'\">Edit</button></td></tr>";
    	}
    }
		echo "</table>";

?><br><button class="add" onclick="location.href='./add/addcustomer.php'">Add New Customer</button>

    </section>

</div>
</body>
</html>