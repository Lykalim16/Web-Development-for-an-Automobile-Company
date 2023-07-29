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
<!DOCTYPE html>
<html>
<head>
	<title>Branches </title>
</head>
<body>
    <?php $year=$_SESSION['taon']; ?>
	<header>
        <div class="logo"><a href="../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
			<li><a href="employee.php">EMPLOYEES</a></li>
                <li><a href="customer1.php">CUSTOMER</a></li>
                <li><div class='where'><a href="branches.php">BRANCHES</a></li></div>
                <?php echo "<li><a href='inventory.php?year=$year' >INVENTORY</a></li>"?>
                <?php echo "<li><a href='customer.php?year=$year' >SALES</a></li>"?>
                <?php echo "<li><a href='report.php?year=$year' >REPORT GENERATION</a></li>"?>
                <li><a href="../logout.php">LOG OUT</a></li>
                <li class="name">Hello, <?php echo $_SESSION['name'];?></li>
            </ul>
        </nav>
    </header>
    <?php if (isset($_SESSION["id"])){ ?>

    <section class="banner">
        <h1>Branch <?php echo $_SESSION['id']; ?> Details </h1>
    </section>

    <div class="center">
        <div class="employeeform">
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
        </div>
</div>
<?php } else{ header("Location: ../login/login.php");}?>

</body>
</html>