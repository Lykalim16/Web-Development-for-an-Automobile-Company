<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Supplier Database</title>
</head>
<body><?php $year=$_SESSION['taon']; ?>
    <?php if (isset($_SESSION["id"])){ 
    ?>
<header>
        <div class="logo"><a href="../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
               <li><a href="adminapproval.php">REQUESTS</a></li>
                <li><a href="employee.php">EMPLOYEES</a></li>
                <?php echo "<li><a href='customer.php?year=$year' >CUSTOMER</a></li>"?>
                <li><a href="branches.php">BRANCHES</a></li>
                <li><div class="where"><a href="supplier.php">SUPPLIER</a></li></div>
                <li><a href="cars.php">CARS</a></li>
                <li><a href="manufacturer.php">MANUFACTURER</a></li>
                <?php echo "<li><a href='sales.php?year=$year' >SALES</a></li>"?>
                <?php echo "<li><a href='inventory.php?year=$year' >INVENTORY</a></li>"?>
                <?php echo "<li><a href='report.php?year=$year' >REPORT </a></li>"?>
                <li><a href="../logout.php">LOG OUT</a></li>
            </ul>
        </nav>
    </header>

    <div class="banner">
        <h1>List of Suppliers</h1>
    </div>
    <div class="center">
        <div class="employeeform">
        <?php
                $server = "localhost:3306";
                $user = "root";
                $pass = "";
                $db = "phase2";
                $conn = mysqli_connect($server, $user, $pass, $db);
                if(!$conn) die(mysqli_error($conn));
                
                $query = "select * from supplier order by supplier_ID";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result) > 0){
                    echo "<table>
                    <tr><th>Supplier ID</th><th>Supplier Name</th>
                    <th>Supplier Street Number</th><th>Supplier Baranggay</th><th>Supplier Zip Code</th><th>Supplier City</th><th>Supplier Province</th><th>Edit</th></tr>";
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr><td>".$row['supplier_ID']."</td>
                        <td>".$row['supplier_name']."</td>
                        <td>".$row['supplier_streetnum']."</td>
                        <td>".$row['supplier_baranggay']."</td>
                        <td>".$row['supplier_zipCode']."</td>
                        <td>".$row['supplier_city']."</td>
                        <td>".$row['supplier_province']."</td>
                        <td><button onclick=\"location.href='./edit/editsupplier.php?id=".$row['supplier_ID']."'\">Edit</button></td></tr>";
                    }
                    echo "</table>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>



<style>
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
    font-size: 25px;
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
    font-size: 13px;
    display: block;
    margin: 0 auto;
    text-align: center;
    font-weight: bold;
}
.name {
    font-family: 'Ghino', serif;
    font-size: 30px;
    position: relative;
    top: 10px;
    left: 20px;
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
.banner {
	width: 100%;
    height: calc(100vh - 300px);
	position: relative;
	top: 100px;
    background-image: url(../img/blabla.jpg);
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    display: table;
}
.yearchoice {
    font-family: 'Ghino-bold', serif;
    font-size: 20px;
    text-align: center;  
    position: relative;
    top: 10px;
    left: 35px;
}
select {
    border-radius:20px;
	padding: 8px;
  	text-align: center;
  	border: 3px solid black;
    font-size: 10px;
}
.banner h1{
    font-size: 75px;
    color: black;
    text-shadow: 6px 6px 14px white;
    font-weight: 600;
    letter-spacing: 2px;
    font-family: 'Ghino-bold';
    position: relative;
    top: 100px;
}
.center{
width: 100%;
position: relative;
top: 150px;
background-image: url(../img/gbg.jpg);
background-repeat: no-repeat;
background-position: center;
background-size: cover;
display: table;
font-family:'Ghino-light';
border-radius:40px;
}
th{
	background-color: rgb(148, 181, 246);
	border: 2px solid black;
	padding: 7pt;
	border-collapse: collapse;
	text-align: center;
    font-size: 10px;
}
table,  td {
  border: 2px solid black;
  padding: 7pt;
  margin: auto;
  border-collapse: collapse;
  text-align: center;
  font-size: 10px;
  background-color: white;
}
h1,h2{
	text-align: center;
    font-size: 10px;
}
button{
    border-radius:20px;
	padding: 15px;
  	text-align: center;
  	border: 3px solid black;
    font-size: 10px;
}
button:hover {
    background-color: white;
    color: #7C0A02;
    border: #7C0A02 solid 3px;
    border-radius:20px;
}
.emp{
	font-size:15px;
}
.bit {
    text-align: center;
    position: relative;
    top: 20px;
}

.where a{
    color: black;
    text-shadow: 2px 2px 4px #000000;
}
</style>