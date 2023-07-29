

<!DOCTYPE html>
<html>
<head>
	<title>Sign-Up</title>
	<!-- Additional Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100&family=Cormorant+Garamond:wght@300&family=Josefin+Sans:wght@100&family=Libre+Baskerville&family=Playfair+Display&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" href="signup.css">
	<!-- Javascript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
</head>
<body>
	<?php 
		if (isset($_POST['submit'])){
			$fname=$_POST['fname'];
			$mname=$_POST['mname'];
			$lname=$_POST['lname'];
			$branch=$_POST['branch'];
			$email=$_POST['email'];
			$pass1=$_POST['pass1'];
			$kontact=$_POST['kontact'];
			$hashed_password = password_hash($pass1, PASSWORD_DEFAULT);
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "phase2";
			$conn = mysqli_connect($server, $user, $pass, $db);			
			$query = "select * from temp_user where email = '$email'";
			$result = mysqli_query($conn,$query);
			if (mysqli_num_rows($result) != 0) {
				function_alert("Email Already Exist");
			}
			else{
				$query2 = "select * from user  where email = '$email'";
				$result2 = mysqli_query($conn,$query2);
				if (mysqli_num_rows($result2) != 0) {
					function_alert("Email Already Exist");
				}
				else{
					$query3 = "select * from temp_user  where contactnum = $kontact";
					$result3 = mysqli_query($conn,$query3);
					if (mysqli_num_rows($result3) != 0) {
						function_alert("Contact Number Already Exist");
					}
					else{
						$query4 = "select * from user  where contactnum = $kontact";
						$result4 = mysqli_query($conn,$query4);
						if (mysqli_num_rows($result4) != 0) {
							function_alert("Contact Number Already Exist");
						}
						else{
							$insertion="INSERT INTO temp_user 
							VALUES (null,'$fname','$mname','$lname',$kontact,'$email',$branch,'$hashed_password')";
							mysqli_query($conn, $insertion);
							function_alert("Account Created, Please wait for account validation");
						}
					}
				}
			}
		}
		function function_alert($message) {
		    echo "<script>alert('$message');</script>";
		}
	?>
	<header>
        <div class="logo"><a href="../mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
                <li><a href="signup.php">SIGN UP</a></li>
                <li><a href="../login/login.php">LOG IN</a></li>
                <li><a href="../branches.html">BRANCHES</a></li>
            </ul>
        </nav>
    </header>

	<section class = "signupbanner">
	<div class="signupform">
		<form action="signup.php" method="POST">
			<h2 style="font-size: 200%;text-align: center;">Create Employee Account</h2><hr>
			<input type="text" name="fname" class="fname" placeholder="First Name" required>
			 <input type="text" name="mname" class="mname" placeholder="Middle Initial" >
			<input type="text" name="lname" class="fname" placeholder="Last Name" required>
			<input type="text" name="email" id="email" class="email" placeholder="Email Address" onchange='check_email();' required>  <?php
				$server = "localhost:3306";
				$user = "root";
				$pass = "";
				$db = "phase2";
				$conn = mysqli_connect($server, $user, $pass, $db);
				if(!$conn) die(mysqli_error($conn));
				$query = "select branch_ID from branch";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<select name='branch'  class='branch' required><option value='' disabled selected>Branch</option>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<option value='".$row['branch_ID']."'>"
						.$row['branch_ID']."</option>";
					}
					echo "</select>";
				}
				mysqli_close($conn);
			?>
			 <br>
			 
			<input type="number" name="kontact" class="contact" id="num" placeholder="Contact Number - 09" onchange='check_num();' required> <br>
			<input type="password" name="pass1" id="pass1" class="contact" placeholder="Password"   onchange='check_pass();'/><br>
			<input type="password"  name="pass2" id="pass2" class="contact" placeholder="Confirm Password"    onchange='check_pass();' /><br>
			<p style="color: red" id="message1"></p>
			<p style="color: red" id="message2"></p>
			<p style="color: red" id="message3"></p>
			<button type="submit" name="submit"id="submit" disabled >Sign Up</button>
			<p>Already have an account? <a href="../login/login.php"> Sign In</a> </p>
		</form>
	</div>
	</section>
	<br>
	<script>
		function check_pass() {
			var x = document.getElementById('pass1').value;
			var y = document.getElementById('pass2').value;
			var re = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
			let z = re.test(x);
		    if (z==true){
		    	if(x==y){
			    	document.getElementById("message1").innerHTML = ""; 
			    	submitbutton();
			    } 
			    else {
			        document.getElementById('submit').disabled = true;
			        document.getElementById("message1").innerHTML = "**Password does not match";  
		    	}
		    }
		    else{
			    document.getElementById('submit').disabled = true;
		    	document.getElementById("message1").innerHTML = "**Password must be atleast 8 character long, must contain atleast 1 symbol, a capital letter, a small letter and a number";  
		    }  
		}	 
		function check_email() {
			var x = document.getElementById('email').value;
			var re = /^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})*$/;
			let z = re.test(x);
		    if (z==true){
		    	document.getElementById("message2").innerHTML = ""; 
		    	submitbutton();
			   
		    }
		    else{
			    document.getElementById('submit').disabled = true;
		    	document.getElementById("message2").innerHTML = "**Enter a Valid email Address";  
		    }  
		}	
		function check_num() {
			var x = document.getElementById('num').value;
		    if ((x>=09000000000) && (x<=09999999999) ){
		    	document.getElementById("message3").innerHTML = ""; 
		    	submitbutton();
			   
		    }
		    else{
			    document.getElementById('submit').disabled = true;
		    	document.getElementById("message3").innerHTML = "**Enter a Valid Number";  
		    }  
		}	
		function submitbutton(){
			var x = document.getElementById('email').value;
			var re2 = /^([a-z0-9_\.\+-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
			let z = re2.test(x);
			var h = document.getElementById('pass1').value;
			var k = document.getElementById('pass2').value;
			var re = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
			let y = re.test(h);
			var c = document.getElementById('num').value;
			if (z==true && y==true && (c>=09000000000) && (c<=09999999999)) {
		    	document.getElementById('submit').disabled = false;
			}
			else{
			    document.getElementById('submit').disabled = true;
			}
		}
	</script>
</body>
</html>