<?php
session_start();//session start to use an session variables
?>
<html>
<header>
<link rel="stylesheet"  href="style.css"/> <!-- connecting the style sheet file to the html file -->
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
//create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) 
{
	die("Connection failed: " . $conn->connect_error);
}
//if statement  to see if all inputs have been set
if (isset($_POST['UName']) && isset($_POST['Password']) && isset($_POST['FirstName']) 
&& isset($_POST['Surname']) && isset($_POST['AddressLine1']) && isset($_POST['AddressLine2']) 
&& isset($_POST['City']) && isset($_POST['TelephoneNum']) && isset($_POST['MobileNum']) ){
	//setting the variables to the inputs form the boxes 
	$UN = $conn -> real_escape_string($_POST['UName']);
	$Pass = $conn -> real_escape_string ($_POST['Password']);
	$ConPass = $conn -> real_escape_string ($_POST['ConfirmPassword']);
	$FN = $conn -> real_escape_string ($_POST['FirstName']);
	$SN = $conn -> real_escape_string ($_POST['Surname']);
	$ADL1 = $conn -> real_escape_string ($_POST['AddressLine1']);
	$ADL2 = $conn -> real_escape_string ($_POST['AddressLine2']);
	$CTY = $conn -> real_escape_string ($_POST['City']);
	$TN = $conn -> real_escape_string ($_POST['TelephoneNum']);
	$MN = $conn -> real_escape_string ($_POST['MobileNum']);
	$sql2 ="SELECT * FROM Users WHERE UserName ='$UN'";//sql query to find all data form rows with the username
	$res = mysqli_query($conn,$sql2);//runs sql query
	//checks to see if any inputs are empty
	if (empty($_POST['UName']) || empty($_POST['Password']) || empty($_POST['FirstName']) || 
	empty($_POST['Surname']) || empty($_POST['AddressLine1']) || empty($_POST['AddressLine2']) || 
	empty($_POST['City']) || empty($_POST['TelephoneNum']) || empty($_POST['MobileNum']) ){
	echo"<h2>Please Fill In All Sections</h2>";//prints out if one is empty
	}
	elseif(!ctype_alpha($FN)){//checks to see if firstname has anything other than letters in it
		echo("<h2>Please only enter letters in the First Name Section</h2>");//prints out if there is anything other than letters
	}
	elseif(!ctype_alpha($SN)){//checks to see if surname has anything other than letters in it
		echo("<h2>Please only enter letters in the Surname Section</h2>");//prints out if there is anything other than letters
	}
	elseif(mysqli_num_rows($res) > 0){//checks to see if the entered username is in the database already
		echo("<h2>User Name Already Taken</h2>");//prints out if username is already in database
	}
	elseif(strlen($Pass) !== 6){//makes sure password is six letters
		echo("<h2>Password Has To Be 6 Characters Long</h2>");//prints out if the password is not 6 characters
	}
	elseif ($Pass != $ConPass){	//makes sure the confirm password matches
		echo("<h2>Passwords Do Not Match</h2>");//prints out if confirm password matches
	}
	elseif ($TNLen = strlen((string)$TN) !== 10){// makes sure mobile numbers are longer than 10 digits 
		echo("<h2>Telephone Phone Number Must Be 10 Digits Long</h2>");//prints out if mobile phonenumber is not longer than 10 digits
	}
	elseif ($MNLen = strlen((string)$MN) !== 10){// makes sure mobile numbers are longer than 10 digits 
		echo("<h2>Mobile Phone Number Must Be 10 Digits Long</h2>");//prints out if mobile phonenumber is not longer than 10 digits
	}
	else{	
		//sql query to insert infomration into the database 
		$sql = "INSERT INTO Users (UserName, Password, FirstName, Surname, AddressLine1, AddressLine2, City, TelephoneNum, MobileNum) 
		VALUES ('$UN', '$Pass', '$FN', '$SN', '$ADL1', '$ADL2', '$CTY', '$TN', '$MN')";	
		//checks to see if the information went in	
		if ($conn->query($sql) === TRUE ) {?>
			<div class = "success">
				<!-- prints out to show success -->
				<p><?php echo "Successful Registration.<br>"; ?></p>
				<p><?php echo"Please Click The Link To Login."; ?></p>
				<?php echo'<h2><a href="Login.php">Login</a></h2>'; ?>
			</div>
	<?php
	}
	?>
	<?php
	}
	?>
	<?php
    }
	?>
	<?php
	$conn->close();//close database connection
?>
<!-- form used to make the input boxes and pass the information into the system -->
<form method="POST">
	<div class= "registration">
	<H1> Registration</H1>
	<h3>User Name:
		<input type="text" id="UName" name="UName">
	</h3>
	<h3>Password:
		<input type="text" id="Password" name="Password" ></input>
	</h3>
	<h3>Confirm Password:
		<input type="text" id="ConfirmPassword"  name="ConfirmPassword">
	</h3>
	<h3>First Name:
		<input type="text" id="FirstName" name="FirstName">
	</h3>
	<h3>Surname:
		<input type="text" id="Surname" name="Surname">
	</h3>
	<h3>Address Line 1:
		<input type="text" id="AddressLine1" name="AddressLine1">
	</h3>
	<h3>Address Line 2:
		<input type="text" id="AddressLine2" name="AddressLine2">
	</h3>
	<h3>City:
		<input type="text" id="City" name="City">
	</h3>
	<h3>Telephone Number:
		<input type="number" id="TelephoneNum" name="TelephoneNum">
	</h3>
	<h3>Mobile Number:
		<input type="number" id="MobileNum" name="MobileNum">
	</h3>
</div>
<div class = "regbut">
	<input type="submit"  value="Register"/> <input type ="reset" value="Clear"/> 
	<a href="Login.php">Cancel</a><!--buttons to submit and clear information and a link if you want to not register -->
</div>
</form>
</body>
<footer>
</footer>
</html>