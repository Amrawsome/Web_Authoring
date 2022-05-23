<?php
session_start();//session start to use an session variables
?>
<html>
<header>
<link rel="stylesheet"  href="style.css"/><!-- connecting the style sheet file to the html file  -->
<h1>LoveLibrary.com</h1><!-- What the web page is called -->
<p><?php echo $_SESSION["username"]; echo" Logged in"?></p><!-- Shows who is logged in -->
<ul>
	<h3><a href="Search.php">Search / </a> <a href="Show_Reserve.php">Reserved Books / </a> <a href="Logout.php">Logout</a> </h3><!-- Header Navigation bar -->
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
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
if(empty($_SESSION['username'])){//checks if session variable username is empty
	header("Location: Login.php");//sends you back to login page		
}
$ISBN = $conn -> real_escape_string($_GET['id']);//gets isbn from the url
$N = "N";// variable to use to find non reserved books in the sql statement
$sql2 = "SELECT Reserved FROM books WHERE ISBN ='$ISBN' AND Reserved ='$N'";
$result = mysqli_query($conn, $sql2);//runs sql query
if(mysqli_num_rows($result) == 1 ){//checks if there is one row in result of the query
	$ISBN = $conn -> real_escape_string($_GET['id']);//grabs the id from the url
	$sql3 = "Select BookTitle FROM books WHERE ISBN = '$ISBN'";//sql query to find booktitle where sql query matches
	$result2 = mysqli_query($conn, $sql3);//runs query
	while($row = mysqli_fetch_array($result2)){//while loop to print results form query 
		echo $row['BookTitle'];//prints book title
	}
	echo"&nbsp";//space
	$sql = "UPDATE books SET Reserved ='Y' WHERE ISBN = '$ISBN' ";//sql query to update the reserved section to Y where the isbn matches
	mysqli_query($conn, $sql);//runs the query
	echo 'Reserved - <a href="Search.php">Continue....</a>';//prints out that the book is reserved and the the link to continue back to the search page
	$DATE = strftime('%F');//sets $date to current date
	$SESS = $_SESSION["username"];//sets $sess to session variable username
	$sql1 ="INSERT INTO reservedbooks (ISBN, UserName, ReservedDate) VALUES ('$ISBN', '$SESS', '$DATE')";//sql query to insert 
	//the ISBN, username and reserved date into the reservedbook table
	$result = mysqli_query($conn, $sql1);//runs sql query
	return;//returns 
}
else{
	echo"<h2>Book Already Reserved</h2>";//this is whats printed if anything other than the success scenario happens
	echo "<br>";
	return;
}
$conn->close();//closes connection to the database
?>
</body>
</html>