<!Doctype html>
<head>
	<title>Status Posting</title>
	<!--link page with my CSS -->
	<link rel="stylesheet" type="text/css" href="mystyle.css">

</head>

	<body>

	<h1>Status Posting Form</h1>
	<form action = "poststatusprocess.php" method = "POST">
	
		<!--Creates box for use to input status code of length 5 -->
		<p>Status Code:
		<input type="text" maxlength="5" name="statusCode" /></p>
		
		<!--Creates a text area for user to write their status out -->
		<p>Status:</p>
		<textarea name="status" cols="100" rows="10"></textarea>
		
		<!--Creates 3 radio buttons to determine who you share the status with. Only 1 can be selected -->
		<p>Share:
		<input type="radio" name="share" value="public"/>Public
		<input type="radio" name="share" value="friends"/>Friends
		<input type="radio" name="share" value="onlyMe"/>OnlyMe
		</p>
		
		<!--Creats box to add the date. Auto set to the current systems date -->
		<p>Date:
		<?php
		$today = date("d/m/Y");?> 
		<input type="text" name="date" maxlength="10" value="<?php echo $today;?>">
		</p>
		
		<!--Creates checkboxes to let users add what permission they want to give out -->
		<p>Permission Type:
		<input type="checkbox" name="permission[]" value="Allow Like"/>Allow Like
		<input type="checkbox" name="permission[]" value="Allow Comments"/>Allow Comments
		<input type="checkbox" name="permission[]" value="Allow share"/>Allow share
		</p>
		
		<!--Creats two buttons one to post status and the other to clear all boxes -->
		<input type = "submit" value = "Post"/>
		<input type = "reset" value = "Reset"/>
		
		<!--A button to return to home page -->
		<p><a href="index.php" " class="button1" style="cursor:pointer;">Home</a></p>
	</form>

	</body>
</html>