<?php
	$magicColor = 'whitesmoke';
	

	if (isset($_GET['json'])) {
		if(isset($_POST['submit'])) {
			$magicColor = $_POST['magicColors'];
			
			$myObj = new stdClass();
			$myObj->message = $magicColor;
			echo json_encode($myObj);
		} else {
			
			//header('Content-Type: application/json; charset=utf-8');
			
				$myArray = array();
			$myObj = new stdClass();
			$myObj->ID = "Lavender";
			$myObj->Name = 'Lavender';
			
			$myArray[] = $myObj;
			
			$myObj = new stdClass();
			$myObj->ID = "LemonChiffon";
			$myObj->Name = 'Lemon Chiffon';
			
			$myArray[] = $myObj;
			
			$myObj = new stdClass();
			$myObj->ID = "LightBlue";
			$myObj->Name = 'Light Blue';
			
			$myArray[] = $myObj;
			
			$myObj = new stdClass();
			$myObj->ID = "LightCoral";
			$myObj->Name = 'Light Coral';
		
			$myArray[] = $myObj;
			
			$myJSON = json_encode($myArray);
			
			echo $myJSON;
		}
		die;
	}
?>


<html>
<head>
	<title>Magic Colors</title>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	
	<?php include 'style.php'; ?>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
</head>

<body class="parent">
	
		<div class="form-group">
		<form action="" method="post" id="form1">
		
			<select class="form-control transparent-input" name="magicColors" id="magicColors"></select>
			<input class="btn btn-outline-dark" type="submit" name="submit" value="submit" />
			<input class="btn btn-outline-dark" type="button" name="updateList" onClick="updateSelect()" value="Update List" />
		</form>
		</div>
	
	<div id="resultDisplay"></div>
		<script type="text/javascript" language="javascript">
			function updateSelect() {
				let urlPath = 'magicColor.php?json';
				let formData = new FormData();
				formData.append('json', 'value');
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
							console.log('success: ' + data);
							$('#magicColors').empty()
							 $.each(data, function (index, value) {
								// APPEND OR INSERT DATA TO SELECT ELEMENT.
								$('#magicColors').append('<option value="' + value.ID + '">' + value.Name + '</option>');
								console.log(value.ID, value.Name);
							});
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
			}
			
			$('#form1').on('submit',function(e) {
				e.preventDefault();
				let submitter_btn = $(e.originalEvent.submitter);
					
				let urlPath = 'magicColor.php?json';
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
							//$('#resultDisplay').html(data.message);
							
							$('body').css('background', data.message);
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