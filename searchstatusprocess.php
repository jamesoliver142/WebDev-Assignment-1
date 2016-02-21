<!DOCTYPE html>
 
<html>

        <title>Status Information</title>
		<!--link page with my CSS -->
		<link rel="stylesheet" type="text/css" href="mystyle.css">
    </head>
    <body>
        <h1>Status Information</h1>
        <?php
				
		//connect to the database
		require_once ("settings1.php");     
        $conn =@mysqli_connect($host, $user, $pswd, $dbnm) or die ( "Unable to connect ");
        mysql_select_db("statusTable");	

		//used to alert user that no status matched their search
		$numRows = 0;
		
		//the sql statements to search for a particular status
		$searchStatus =$_GET["searchStatus"];
		$searchQuery = "SELECT * FROM statusTable WHERE Status LIKE '%$searchStatus%'"; 
		$resultSearch =@mysqli_query($conn, $searchQuery);
		
		
		//displays the Code, Status, Date, Shares, and permission of the Status found.
        while($row =@mysqli_fetch_array($resultSearch)){
			++$numRows;
            echo "Status Code: ".$row['Status_Code']."</p>";
            echo "<p>Status: ".$row['Status']."<br/>";
            echo "<p>Share: ".$row['Share']."<br/>";
            echo "Date Posted: ".date("F d, Y",strtotime($row['Date']))."<br/>";
            echo "Permission: ".$row['Permission_Type']."</p><br/>";		
        }
		
		// Checks if a status was found other wise displays error message
		if($numRows == 0) {
			echo "ERROR: Status was not found!<br/>";
		}

        // Closes the database
        mysqli_close($conn);
        ?>
		
		<!-- Link button to return to home page -->
		<p><a href="index.php" " class="button1" style="cursor:pointer;">Home</a></p>
		
		</body>

</html>
