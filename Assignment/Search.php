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
		<a href="Search.php">Search / </a> <a href="Show_Reserve.php">Reserved Books / </a> <a href="Logout.php">Logout</a><!-- Header Navigation bar --> 
	</h3>
</ul>
</header>
<body>
<!-- dropdown menu form to take in the category code -->
<form method="POST">
	<div class = "Cate">
		<h3>Category/Genre:
		<select id="CategoryCode" name="CategoryCode"></h3><!-- box to hold dropdown selected option -->
			<!-- drop down search options -->
			<option value = ''></option>
			<option value = 001>Health</option>
			<option value = 002>Business</option>
			<option value = 003>Biography</option>
			<option value = 004>Technology</option>
			<option value = 005>Travel</option>
			<option value = 006>Self-Help</option>
			<option value = 007>Cookery</option>
			<option value = 008>Fiction</option>
		</select>
	</div>
	<div class = "catsearch">
		<input type="Submit" value="Search"><!-- button to submit input -->
	</div>
</form>
<!-- form to take in the input for the search bar -->
<form method="POST">
	<div class = "search">
		<h3>Search:
			<input type="text" placeholder="Search for BookTitle or Author" id="Search" name="Search">
		</h3><!-- box to take search input-->
	</div>
	<div class = "searchbut">
		<input type="submit" value="Search"/><!-- button to submit input -->
	</div>
</form>

<?php
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
if (isset($_POST['CategoryCode'])){//checks if category input box has sommething submitted
	$CC = $conn -> real_escape_string($_POST['CategoryCode']);//sets $cc to the category code
	$sql2 ="SELECT * FROM books WHERE CategoryCode ='$CC'";//sql query to select all information from the books table where the category code matches
	$result = mysqli_query($conn, $sql2);//runs the sql query
	if ($result->num_rows > 0) {//checks that the sql results has more than zero rows
		$_SESSION["Cate"] = "$CC";//sets session variable cate
		header("Location: DisplayCategory.php");//sends the user to the category display page
	}
	else{
		echo"<h2> No Results Plese Try Something Else </h2>";
	}
	}

if (isset($_POST['Search'])){//checks is search input  box has something submitted
	$S = $conn -> real_escape_string($_POST['Search']);//sets $s to the submitted value form the search input box
	$sql3 ="SELECT * FROM books WHERE BookTitle LIKE '%$S%' OR Author LIKE '%$S%'";//sql query to select all data from books 
	//where the search input matches data in the database
	$result = mysqli_query($conn, $sql3);//runs the sql query
	if ($result->num_rows > 0) {//checks if number of rows is less than zero	
		$_SESSION["search"] = "$S";//sets session variable to the search bar input
		header("Location: DisplaySearch.php?=");//sends the user to the searc display page	
	}	
	else{
		echo"<h2> No Results Plese Try Something Else </h2>";
	}
	}

$conn->close();//closes connection to database
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