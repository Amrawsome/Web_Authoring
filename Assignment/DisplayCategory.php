<?php
session_start();//session start to use an session variables
?>
<html>
<header>
<link rel="stylesheet"  href="style.css"/><!-- connecting the style sheet file to the html file  -->
<h1>LoveLibrary.com</h1><!-- What the web page is called -->
<p><?php echo $_SESSION["username"]; echo" Logged in"?></p><!-- Shows who is logged in -->
<ul>
	<h3><a href="Search.php">Search / </a> <a href="Show_Reserve.php">Reserved Books / </a> <a href="Logout.php">Logout</a></h3><!-- Navigation bar -->
</ul>
</header>
<body>
<h1>Category Results</H1>
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
if(empty($_SESSION['Cate'])){//checks if session variable Cate is empty
	header("Location: Search.php");//brings user to search page
} 
$results_per_page = 5;
$page = 1;
$CATEGORY = $_SESSION["Cate"];// sets Category to the session variable Cate
	if(isset($_GET["page"])){//see's if page in url is set 
		$page = $_GET["page"];//sets page variable to page num in url
	}
	else{
		$page =1;// sets page to 1
	}
	$start_from = ($page-1) * $results_per_page;//sets start for to the page variable number -1 multiplied by 5
	$sql2 ="SELECT * FROM books WHERE CategoryCode ='$CATEGORY' LIMIT $start_from, $results_per_page";/*sql query that finds all the 
	records related to the search and puts a limit on them of where the list will start and how many rows will be selected from that point*/
	$result = mysqli_query($conn, $sql2);//will run the sql staement in the database
	//displays colummns headings
	echo "<table border ='1'>";
	echo "<tr>";
	echo "<th>ISBN</th>";
	echo "<th>Book Title</th>";
	echo "<th>Author</th>";
	echo "<th>Edition</th>";
	echo "<th>Year Published</th>";
	echo "<th>CategoryCode</th>";
	echo "<th>Reserved Status</th>";
	echo "</tr>";
	//prints out the rows selected from the sql query
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr><td>";
		echo (htmlentities ($row["ISBN"]));
		echo "</td><td>";
		echo (htmlentities ($row["BookTitle"]));
		echo "</td><td>";		
		echo (htmlentities ($row["Author"])); 
		echo "</td><td>";
		echo (htmlentities ($row["Edition"]));
		echo "</td><td>";		
		echo (htmlentities ($row["Year"]));
		echo "</td><td>\n";
		echo (htmlentities ($row["CategoryCode"]));
		echo "</td><td>\n";
		echo (htmlentities ($row["Reserved"]));
		echo "</td><td>\n";
		echo('<a style="color:blue; text-decoration:underline;" 
		href="Reserve.php?id='.htmlentities($row['ISBN']).'">Reserve Book</a>');//adds the reserve book 
		//link at the end of the rows in the table
		echo ("</td></tr>\n");	
	}
		$page_query = "SELECT * FROM books WHERE CategoryCode ='$CATEGORY'";//sql query that selects all data from  the database 
		//where the category code matches the search
		$page_result = mysqli_query($conn, $page_query);//runs the sql query through the database
		$total_records = mysqli_num_rows($page_result);//gets the number of rows form the ran sql query
		$total_page = ceil($total_records/$results_per_page);//finds the number of pages needed by getting the number of all 
		//results and dividing it by 5 and ceil will round it up if its a fraction
		//for loop to print out the links to the number of pages needed
		for($i=1; $i<=$total_page; $i++){
			echo "<a style ='font-size:30px; color: black; text-decoration: underline; ' href='DisplayCategory.php?page=".$i."'>".$i."</a>&nbsp; ";
		}
		$conn->close();//closes connection to the database
?>
</body>
</html>