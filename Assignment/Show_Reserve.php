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
if ($conn->connect_error) 
{
	die("Connection failed: " . $conn->connect_error);
}
if(empty($_SESSION['username'])){//checks if session variable username is empty
	header("Location: Login.php");//sends you back to login page
}
$SES = $_SESSION["username"];//sets $ses to the session variable username
$sql = "SELECT BookTitle , reservedbooks.ISBN, ReservedDate FROM books LEFT OUTER JOIN reservedbooks 
ON reservedbooks.ISBN = books.ISBN  WHERE UserName = '$SES'";/*sql query to get BookTitle from the 
books table and ISBN and reservedDate from the reserved books table using the $ses variable */
$result = mysqli_query($conn,$sql);//$results set to the results of the sql query
if ($result->num_rows > 0) {//checks that there is more than zero rows reusulting from the query
	echo "<H2> Reserved Books</H2>";//header above the results
	//prints the column headers	
	echo "<table border ='1'>";
	echo "<tr>";
	echo "<th>Book Title</th>";
	echo"<th>ISBN</th>";
	echo "<th>Date Book Reserved</th>";
	echo "</tr>";
	//prints out the rows selected from the sql query	
	while ($row = $result->fetch_assoc()) {
		echo "<tr><td>";
		echo (htmlentities ($row["BookTitle"]));
		echo "</td><td>";
		echo (htmlentities ($row["ISBN"]));
		echo "</td><td>";
		echo (htmlentities ($row["ReservedDate"])); 
		echo "</td><td>";
		echo('<a style="color:blue; text-decoration:underline;" href="Unreserve.php?id='.
		htmlentities($row["ISBN"]).'">Unreserve Book</a>');//adds the unreserve book link at the end of the rows in the table
		echo ("</td></tr>\n");
	} 
}
	else {
		echo "<h2>No Books Reserved</h2>";//what prints out if there are no reserved books
	}
	$conn->close();//closes the connection to he database
?>
</table>
</body>
<footer>
<ul>
	<h3>
		<a href="Search.php">Search / </a> <a href="Show_Reserve.php">Reserved Books / </a> <a href="Logout.php">Logout</a><!-- Footer Navigation bar -->
	</h3>
</ul>
</footer>
</html>