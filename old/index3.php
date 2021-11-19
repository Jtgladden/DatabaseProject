<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<style>
		body {
			background-color: whitesmoke;
		}
	</style>
</head>

<body>
	<?php
		$statusMSG = '';
		$MSGClass = '';
		$name = '';
		$email = '';
		$subject = '';
		$message = '';
			
		if (isset($_POST['submit'])) {
			// Get the submited form data
			
			$name = $_POST['name'];
			$email = $_POST['email'];
			$subject = $_POST['subject'];
			$message = $_POST['message'];
		}
	?>
	<div class="row">
	<div class="col-lg-12 text-center">
	<div class="card">
	<div class="card-body">
		<form action="" method=post>
		<div class="form-group">
			<h4>Name</h4>
			<input class="form-control" type="text" name="name" placeholder="Your name" required="" />
			<h4>Email</h4>
			<input class="form-control" type="email" name="email" placeholder="Email@example.com" required="" />
			<h4>Subject</h4>
			<input class="form-control" type="text" name="subject" placeholder="Write subject" required="" />
			<h4>Message</h4>
			<textarea class="form-control" name="message" placeholder="Write message here" required=""></textarea>
			<br />
			<input class="btn btn-dark" type="submit" name="submit" value="submit" />
			</div>
		</form>
	</div>
	</div>
	</div>
	</div>
	
	<div>
		<?php
			if (isset($_POST['submit'])) {
				echo '<h3>name: ' . $name . '</h3>';
				echo '<h3>email: ' . $email . '</h3>';
				echo '<h3>subject: ' . $subject . '</h3>';
				echo '<h3>message: ' . $message . '</h3>';
			}
		?>
	</div>
</body>
</html>