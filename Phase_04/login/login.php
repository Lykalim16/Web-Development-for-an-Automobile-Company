<?php
    session_start();
?>
<?php 
	$error = "invalid password";
	if(isset($_POST['submit'])){
		 if(empty($_POST['text']) || empty($_POST['password'])){
			$error = "Username or Password is Invalid";
			echo($_error);
		 }
		 else{
            $_SESSION["name"] = $_POST['name'];
            $_SESSION['last_login_timestamp'] = time();
         }
		 {
		 
		 $email=$_POST['text'];
		 $pass=$_POST['password'];
		 $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
		 $conn = mysqli_connect("localhost", "root", "");
		 
		 $db = mysqli_select_db($conn, "phase2");
		 
		 $query = mysqli_query($conn, "SELECT * FROM user WHERE  email='$email'");
		 
         $orig = mysqli_fetch_assoc($query);
         $name=$orig['firstname'];
		 $rows = mysqli_num_rows($query);
         if($email==$orig['email'] AND $email!="admin@toyota.car"){
            if (password_verify($pass, $orig['password'])) {
                $_SESSION["name"] = $name;
                $_SESSION["id"] = $orig['branchid'];
                $_SESSION["email"] = $orig['email'];
                $_SESSION["taon"] = date("Y");
                header("Location: ../employees/branches.php");
            }
         }
		 
         else if($_POST['text']==$orig['email'] and password_verify($pass, $orig['password'])){
                $_SESSION["name"] = $name;
                $_SESSION["id"] = $orig['branchid'];
                $_SESSION["email"] = $orig['email'];
                $_SESSION["taon"] = date("Y");
                header("Location: ../admin/adminapproval.php");
         }
		 else{
			header("Location: login.php");
		 }
		 mysqli_close($conn);
		 }
	}
    if(isset($_SESSION['id']) and isset($_SESSION["email"])){
        if( $_SESSION['email']!="admin@toyota.car"){
            header("Location: ../employees/branches.php");
        }
        else{
            header("Location: ../admin/adminapproval.php");
        }
    }
?>

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
.banner {
	width: 100%;
    height: calc(100vh - 100px);
	position: relative;
	top: 100px;
    background-image: url(../img/loginbanner.jpg);
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    display: table;
}
.login{
position: relative;
top: 50px;
font-family:ghino;
width:360px;
margin:50px auto;
border-radius:10px;
background-color: white;
border:2px solid #ccc;
padding:10px 40px 25px;
margin-top:70px; 
}
input[type=text], input[type=password]{
width:99%;
padding:10px;
margin-top:8px;
border:1px solid #ccc;
padding-left:5px;
font-size:16px; 
}
input[type=submit]{
width:100%;
background-color:#009;
color:#fff;
border:2px solid #06F;
padding:10px;
font-size:20px;
cursor:pointer;
border-radius:5px;
margin-bottom:15px; 
}
</style>
<!DOCTYPE html>
<html>
<head>
    <title>Log in</title>
</head>
<body>
<header>
        <div class="logo"><a href="../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
                <li><a href="../signup/signup.php">SIGN UP</a></li>
                <li><a href="login.php">LOG IN</a></li>
                <li><a href="../branches.html">BRANCHES</a></li>
            </ul>
        </nav>
    </header>

	<section class ="banner">
	<div class="login">
		<h1 align="center">Login</h1>
		<form action="" method="post" style="text-align:center;">
		<input type="text" placeholder="Email" id="email" name="text" required><br/><br/>
		<input type="password" placeholder="Password" id="pass" name="password" required><br/><br/>
		<input type="submit" value="Login" name="submit">
	</div>
	</section>
</body>
</html>


