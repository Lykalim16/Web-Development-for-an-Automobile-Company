<?php
session_start();
if (isset($_SESSION["name"])) {
    // only if user is logged in perform this check
    if ((time() - $_SESSION['last_login_timestamp']) > 900) {
      header("location:../logout.php");
      exit;
    } else {
      $_SESSION['last_login_timestamp'] = time();
    }
  }
?>
<?php
if (isset($_POST["year"])){
    header('Location: inventory.php?year=' .$_POST["year"]);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inventory Database</title>
</head>
<body>
<?php $year=$_SESSION['taon']; ?>
	

    <?php if (isset($_SESSION["id"])){ 
        $date=$_GET['year'];
        $_SESSION['year']=$_GET['year'];
    ?><header>
       <div class="logo"><a href="../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
                <li><a href="adminapproval.php">REQUESTS</a></li>
                <li><a href="employee.php">EMPLOYEES</a></li>
                <?php echo "<li><a href='customer.php?year=$year' >CUSTOMER</a></li>"?>
                <li><a href="branches.php">BRANCHES</a></li>
                <li><a href="supplier.php">SUPPLIER</a></li>
                <li><a href="cars.php">CARS</a></li>
                <li><a href="manufacturer.php">MANUFACTURER</a></li>
                <?php echo "<li><a href='sales.php?year=$year' >SALES</a></li>"?>
                <?php echo "<li><div class='where'><a href='inventory.php?year=$year' >INVENTORY</a></li></div>"?>
                <?php echo "<li><a href='report.php?year=$year' >REPORT </a></li>"?>
                <li><a href="../logout.php">LOG OUT</a></li>
            </ul>
        </nav>
    </header>

	<section class="banner">
        <h1>Inventory</h1>
    </section>
		<div class="center">
			<div class="employeeform">
            <div class="yearchoice">
                <form action="./inventory.php" method="post">
                Inventory For Year: <select name="year" onchange="this.form.submit()">
                <?php 
                    echo "<option value='".$date."'>".$date."</option>";
                for($i = 2019 ; $i <= date('Y'); $i++){
                    if($i==$date){
                        echo "<option value='$i' disabled>$i</option>";
                    }else{
                        echo "<option value='$i'>$i</option>";
                    }
                }
                ?>
            </div>
            </select> 
        </form>
        <?php
        $server = "localhost:3306";
        $user = "root";
        $pass = "";
        $db = "phase2";
        $conn = mysqli_connect($server, $user, $pass, $db);
        if(!$conn) die(mysqli_error($conn));
        $query="select * from branch";
   		$results = mysqli_query($conn,$query);
    
	    if(mysqli_num_rows($results) > 0){
	        while($rows = mysqli_fetch_assoc($results)){
	        	$brid=$rows['branch_ID'];
		        $query = "select * from automobile natural join automobile_specs natural join tracks natural join has_inventory natural join branch where branch_id =$brid and in_year=$date order by vehi_identi_num";
		        $result = mysqli_query($conn,$query);
		        $pesosign = "₱";
		        if(mysqli_num_rows($result) > 0){
                    echo "<h1 style='font-size:20px';>Branch ". $rows['branch_ID']."</h1>";
		            echo "<table>
		            <tr>
		                <th> Vehicle ID</th>
		                <th> Vehicle Name</th>
		                <th>  Stock</th>
		                <th> Sold</th>
		                <th> Remaining <br>Quantity</th>
		                <th> Price</th>
		                <th> Sales</th>
		                <th> Edit</th>
		                <th> Delete</th>
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
                        $inid=$row['in_ID'];
                        $carid = $row['vehi_identi_num'];
                        $year = $row['in_year'];
		                echo "<td><button onclick=\"location.href='./edit/editinventory.php?id=" .$row['vehi_identi_num']."&branch=" .$row['branch_ID']."&year=" .$date."'\">Edit</button></td>
                        
                        <td><button onclick=\"ConfirmDelete($inid,$carid,$year);\">Delete</button></td></tr>";

		            }echo "</table>";
		        }
	        }
	    }
                
            
	    ?> <br>
        <div class="bit">
			<button class="add" onclick="location.href='./add/addinventory.php'">Add New Inventory</button>
			</div>
		</div>
			</div>
		</div>
    <?php } else{ header("Location: ../login/login.php");}?>

    <script>
    function ConfirmDelete($inid,$carid,$year){
        if(confirm("Are you sure you want to delete?")){
            var x = $inid;
            var y = $carid;
            var z = $year;
            alert("Deleted");
            location.href="./delete/deletesales.php?id="+ x + "&car=" + y + "&year=" + z;

        }
    }
</script>
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