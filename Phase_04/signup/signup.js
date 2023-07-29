function check_pass() {
	var x = document.getElementById('pass1').value;
	var y = document.getElementById('pass2').value;
	var re = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
	let z = re.test(x);
    if (z==true){
    	if(x==y){
    		document.getElementById('submit').disabled = false;
	    	document.getElementById("message1").innerHTML = ""; 
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
   
