<?php 
	require_once 'db.php';
	require_once 'functions.php';

	$statusMSG = '';
	$MSGClass = '';
	$firstName = '';
	$lastName = '';
	$email = '';
		
	if (isset($_POST['submit'])) {
		// Get the submited form data
		
		$firstName = $_POST['nameFirst'];
		$lastName = $_POST['nameLast'];
		$email = $_POST['email'];
	}	

	//createDB($conn, 'colors');
	
	//createTable($conn, 'users');
	/*
	sqlQuery($conn, "INSERT INTO users (firstname, lastname, email)
					VALUES ('John', 'Doe', 'john@example.com')");
	*/
	/*
	echo sqlInsert($conn, "INSERT INTO users (firstname, lastname, email)
					VALUES ('Jarom', 'Gladden', 'jarom@example.com')");
	
	
	//preparedInsert($conn);
	
	$sql = "SELECT id, firstname, lastname FROM users";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		}
	} else {
		echo "0 results";
	}
	*/
	
	if (isset($_GET['json'])) {
		if(isset($_POST['submit'])) {
			$array = array();
			$array['firstName'] = $firstName;
			$array['lastName'] = $lastName;
			$array['email'] = $email;
			$message = '<h3>First Name: ' . $firstName . '</h3>' .
			 '<h3>Last Name: ' . $lastName . '</h3>' .
			 '<h3>email: ' . $email . '</h3>';
	
			$array['message'] = $message;
			$id = sqlInsert($conn, "INSERT INTO users (firstname, lastname, email)
				VALUES ('$firstName', '$lastName', '$email')");
			$array['id'] = $id;
			echo json_encode($array);
		} else {
			

			//$myJSON = json_encode($myArray);

			//echo $myJSON;
		}
		die;
	}
?>
<html>
<head>
	<title>Jarom's Table Test</title>
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	
	<style>
		th, td {
			padding: 15px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
	</style>
</head>
<body>
	<div class="row">
	<div class="col-lg-12 text-center">
	<div class="card">
	<div class="card-body">
		<form id="form1" action="" method="post">
		<div class="form-group">
			<h4>Frist Name</h4>
			<input class="form-control" type="text" name="nameFirst" placeholder="First name" required="" />
			<h4>Last Name</h4>
			<input class="form-control" type="text" name="nameLast" placeholder="Last name" required="" />
			<h4>Email</h4>
			<input class="form-control" type="email" name="email" placeholder="Email@example.com" required="" />
			<input class="btn btn-dark" type="submit" name="submit" value="submit" />
			</div>
		</form>
	</div>
	</div>
	</div>
	</div>
	
	<div id="dataEntered">
	</div>
	
	<h2>Table: </h2>
	<table id="table1">
		<tr>
			<th>ID</th>
			<th>FirstName</th>
			<th>LastName</th>
			<th>Email</th>
		</tr>
		<?php /*
		<tr>
			<td>Jarom</td>
			<td>Gladden</td>
			<td>gladden@jarom.ink</td>
			*/
			$sql = "SELECT id, firstname, lastname, email FROM users";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
					echo 
						'<tr>' . PHP_EOL .
						'  <td>'.$row["id"].'</td>' . PHP_EOL .
						'  <td>'.$row["firstname"].'</td>' . PHP_EOL .
						'  <td>'.$row["lastname"].'</td>' .PHP_EOL .
						'  <td>'.$row["email"].'</td>' . PHP_EOL .
						'</tr>' . PHP_EOL;
				}
			} else {
				//echo "0 results";
			}
		
		//</tr>
		?>
	</table>
	
		<script type="text/javascript" language="javascript">
			$('#form1').on('submit',function(e) {
				e.preventDefault();
				let submitter_btn = $(e.originalEvent.submitter);
					
				let urlPath = 'index.php?json';
				let form = document.getElementById('form1');
				let formData = new FormData(form);
				formData.append('submit', 'value');
				$.ajax({
						cache: false,
						type: 'POST',
						url: urlPath,
						dataType: "json",
						data: formData,
						processData: false,
						contentType: false,
						beforeSend: function() {
							
						},
						success: function(data) {
							console.log('success 5: ' + JSON.stringify(data));
							console.log(data.message);
							$('#dataEntered').html(data.message);
							
							$('#table1').append('<tr><td>' + data.id + '</td><td>' + data.firstName + '</td><td>' + data.lastName + '</td><td>' + data.email + '</td></tr>');
						},
						error: function(jqXHR, testStatus, errorThrown) {
							console.log('error: ' + errorThrown);
						},
						fail: function(response) {
							console.log('Failure: ' + response);
						},
						complete: function(data) {
							
						}
				
				});
			});
		</script>
</body>
</html>

<?php 
	$conn->close();
	//echo "Connection has been closed";
?>
