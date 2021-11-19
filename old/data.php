<?php
	$statusMSG = '';
	$MSGClass = '';
	$name = '';
	$email = '';
	$subject = '';
	$message = '';
		
	if (isset($_GET['submit'])) {
		// Get the submited form data
		
		$name = $_GET['name'];
		$email = $_GET['email'];
		$subject = $_GET['subject'];
		$message = $_GET['message'];
	}
?>
<html>
<head>
</head>
<body>
	
	<div>
		<?php
			if (isset($_GET['submit'])) {
				echo '<h3>name: ' . $name . '</h3>';
				echo '<h3>email: ' . $email . '</h3>';
				echo '<h3>subject: ' . $subject . '</h3>';
				echo '<h3>message: ' . $message . '</h3>';
			}
		?>
	</div>
</body>
</html>