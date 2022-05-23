<?php
session_start();//starts the sessions to take in session variables
?>
<html>
<header>
<link rel="stylesheet"  href="style.css"/><!-- connecting the style sheet file to the html file  -->
<h1>LoveLibrary.com</h1><!-- What the web page is called -->
<ul>
	<h3><a href="Login.php">Login / </a> <a href="Registration.php"> Registration</a></h3><!-- Header Navigation bar -->
</ul>
</header>
<body>
<?php
//connection credentials
$servername= "localhost";
$username = "root";
$password = "";
$dbname= "bookdb";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) 
{
	die("Connection failed: " . $conn->connect_error);
}
if(isset($_POST['UName']) && isset($_POST['Password'])){//checks if there is input in password and username section
	$UN = $conn -> real_escape_string($_POST['UName']);//sets $un to the input in the username input box from the form
	$Pass = $conn -> real_escape_string ($_POST['Password']);//sets $pass to the input in the password input bow from the form
	$sql1 ="SELECT UserName FROM users WHERE UserName ='$UN' AND Password = '$Pass'";//sql query to get the username and password where $un and $pass matches
	$result1 = mysqli_query($conn,$sql1);//runs the sql query
	$count = mysqli_num_rows($result1);//counts the nuumber of rows form the queru
	if ($count == 1 ){//checks if there is one row
		header("Location:Search.php");//sends the user to the search page
	}
	else{
		echo"<h2>Invalid Username Or Password</h2>";// if anything is wrong print this
	}
	$_SESSION["username"] = "$UN";//set session variable username
}

$conn->close();//closes database conection
?>
<!-- form to display the login section-->
<form method="POST">
	<div class="login-container">
	<H1>Login</H1>
	<h3>User Name:
		<input type="text" id="UName" name="UName"></input>
	</h3>
	<h3>Password:
		<input type="password" id="Password" name="Password" ></input>
	</h3>
		<input type ="reset" value="Clear"/> <input type="submit"  value="Login"/>
	<a href="Registration.php">Not A User Register Here!</a>
	</div>

</form>
</body>
<footer>
</footer>
</html>