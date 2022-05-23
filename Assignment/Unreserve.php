<?php
session_start();//session start to use an session variables
?>
<html>
<header>
<link rel="stylesheet"  href="style.css"/><!-- connecting the style sheet file to the html file  -->
<h1>LoveLibrary.com</h1><!-- What the web page is called -->
<p><?php echo $_SESSION["username"]; echo" Logged in"?></p><!-- Shows who is logged in -->
<ul>
	<h3>
		<a href="Search.php">Search / </a> <a href="Show_Reserve.php">Reserved Books / </a> <a href="Logout.php">Logout</a><!-- Navigation bar --> 
	</h3>
</ul>
</header>
<body>
<?php
//Connection credentials
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
if(empty($_SESSION['username'])){//making sure the user is logged in
	header("Location: Login.php");//sends you back to login page		
}
$ISBN = $conn -> real_escape_string($_GET['id']);//getting the id that was passed in the url
$Y = "Y";// variable to use to find reserved books in the sql statement
$sql2 = "SELECT Reserved FROM books WHERE ISBN ='$ISBN' AND Reserved ='$Y'";//sql query to find the the resevred book 
//using the ISBN and the variable for reserved
$result = mysqli_query($conn, $sql2);//runnin the sql statement in the database
if(mysqli_num_rows($result) == 1 ){//seeing if the number of results is equal to one to proceed 
	$sql = "UPDATE books SET Reserved ='N' WHERE ISBN = '$ISBN' ";//sql query that updates the book to not reserved in the database
	mysqli_query($conn,$sql);//run the sql statement
	echo 'Book Unreserved - <a style="color:blue" href="Show_Reserve.php">Continue....</a>';//shows the the book has been 
	//unreserved and links back to show pag
	$sql1 ="DELETE FROM reservedbooks WHERE ISBN ='$ISBN'";//sql query that will delete the row where the ISBN matches
	mysqli_query($conn, $sql1);//runs the sql statement to delete the row
}
//prints out error in the case something goes wrong
else{
	echo"<h1>Error<h1>";
	return;
}
$conn->close();//closes connection to database
?>
</body>
</html>