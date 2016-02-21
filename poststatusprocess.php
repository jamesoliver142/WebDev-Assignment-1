<!DOCTYPE html>

<html>
	<head>
		<!-- The web page title-->
		<title>Post Status</title>
		<link rel="stylesheet" type="text/css" href="mystyle.css">	
	</head>
	<body>
		<?php 
			// variables to hold the information users submit
			$statusCode =$_POST["statusCode"]; 
			$status =$_POST["status"]; 
			$date =$_POST["date"]; 
			$stringLength = strlen($statusCode);  
			$day = substr($date, 0,-8); 
			$month = substr($date, 3,-5); 
			$year = substr($date, 6); 
			$permissions = ""; 
			
			// variable to hold users permissions
			if(!empty($_POST["permission"])) { 
				$permission =$_POST["permission"]; 
			}
			// Variable to hold users share selection
			if(!empty($_POST["share"])){ 
				$share =$_POST["share"]; 
			}else{ 
				$share = NULL; 
			}

			// Checks if code starts with an S
			function codeStartsWithS($sCode){ 
				if ($sCode[0] == "S"){ 
					return TRUE; 
				}
			}
			// Checks status code has 5 characters
			function codeLength($codeLength){ 
				if (strlen($codeLength) == 5){ 
					return TRUE; 
				}	 
			}
			// checks that only numerical values come after S
			function numbersAfterS($sCode){ 
				if(preg_match("/^[0-9]+$/",substr($sCode, 1))){ 
					return TRUE; 
				}
			}
			// Checks that the status has correct characters
			function correctChars($sCode){ 
				if(preg_match('/^[!?\.\,a-z0-9 ]+$/i', $sCode)){ 
					return TRUE; 
				}
			} 
			// Checks if status is empty
			function statusNotEmpty($sCode){ 
				if(!$sCode == ''){ 
					return TRUE;
				}
			} 
			// Checks that date is entered correctly
			function correctDate($d,$m,$y){ 
				if (checkdate($m, $d, $y) == 1){ 
					return TRUE; 
				}
			}
			
			// Checks that the status code is available.
			function codeAvailability($RowsReturned){ 
				if ($RowsReturned > 0){ 
					return FALSE; 
				} 
				else { 
					return TRUE;
				} 
			} 
			
			// Checks how many permissions users has selected and adds it to a variable
			if(!empty($permission)){ 
				$num = count($permission); 
				for($i=0; $i < $num; $i++){      
 	  				$permissions = $permissions." ".$permission[$i].", "; 
				} 
			} 
			
			//Connects to the database
			require_once ("settings1.php"); 			
			$sqlTable= "statusTable"; 			
			$conn =@mysqli_connect($host, $user, $pswd, $dbnm) or die( " Unable to connect to server ");   
			mysql_select_db($sqlTable); 
			
			// Creates the table
			$table = "CREATE TABLE IF NOT EXISTS statusTable
			( 
				Status_Code VARCHAR(5) NOT NULL,  
				PRIMARY KEY(Status_Code), 
				Status VARCHAR(40) NOT NULL, 
				Share VARCHAR(7), 
				Date DATE NOT NULL, 
				Permission_Type VARCHAR(42) 
			)"; 

			// Checks if above statement fails.
			if (!@mysqli_query($conn, $table)){ 
				echo "An error has occurred. Table not created."; 
			} 
 			
			// Variables to determine if status code is available
			$code = "SELECT Status_Code FROM ".$sqlTable." WHERE Status_Code='".$statusCode."'"; 
			$searchQuery =@mysqli_query($conn, $code); 
			$numRows =@mysqli_num_rows($searchQuery); 
			
			// Checks that user has input everything correctly and is able to post their status.
			if((codeStartsWithS($statusCode) == TRUE) && 
			   (codeLength($statusCode) == TRUE) && 
			   (numbersAfterS($statusCode) == TRUE) && 
			   (correctChars($status) == TRUE) && 
			   (correctDate($day,$month,$year) == TRUE) &&
               (statusNotEmpty($status) == TRUE) &&			   
			   (codeAvailability($numRows) == TRUE)){ 
				echo "<p>Thanks. Your post has been added to the database.</p>";
								
				// Inserts users post into the database 
				$insertQuery = "insert into $sqlTable" 
						 ."(Status_Code, Status, Share, Date, Permission_Type)" 
                         ." values " 
   						 ."('$statusCode','$status', '$share', '$year-$month-$day','$permissions')";
				$tableResult = mysqli_query($conn, $insertQuery); 
			} 
			else { 
				// Message to alert user that post must start with a capital S
				if(codeStartsWithS($statusCode) == FALSE){ 
					echo "<p>Error: The status code must begin with a capital S.<br> Please try again. </p>";
				} 
				// Message to alert user that the status must be 5 chars in length
				if(codeLength($statusCode) == FALSE){ 
					echo "<p>Error: Code must have 5 characters.<br> Please try again. ";
				}
				// Message to alert user that Numbers must follow the S
				if(numbersAfterS($statusCode) == FALSE){ 
					echo "<p>Error: Four numbers must follow the S. <br> Please try again. </p>";
				}
				// Message to alert user that they have invalid characters
				if(correctChars($status) == FALSE){ 
					echo "<p>Error: Your status contains invalid characters. <br> Please try again. </p>";
				} 
				// Message to alert the user that they have input an invalid date
				if(correctDate($day,$month,$year) == FALSE){ 
					echo "<p>Error: Invalid date. <br> Please try again. </p>";
				}
				// Message to alert the user that the status box is blank
				if(statusNotEmpty($status) == FALSE){ 
					echo "<p>Error: Status cannot be empty. <br> Please try again. </p>";
				}
				// Message to alert the user that the status code is already taken.
				if(codeAvailability($numRows) == FALSE){ 
					echo "<p>Error: This status code already exists. <br> Please try again. </p>";
				} 
			} 		
			
			mysqli_close($conn); 
			?>
			<!-- Button to return to the home page. -->
			<p><a href="index.php" " class="button1" style="cursor:pointer;">Home</a></p>
	</body>

</html>