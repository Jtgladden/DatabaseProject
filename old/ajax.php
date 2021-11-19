<?php
		$statusMSG = '';
		$MSGClass = '';
		$num1 = '';
		$num2 = '';
		$operator = '';
		/*	
		if (isset($_POST['submit'])) {
			// Get the submited form data
			
			$num1 = $_POST['num1'];
			$num2 = $_POST['num2'];
			$operator = $_POST['operator'];
			$solution = 0;
		}*/
?>
<?php
	if (isset($_GET['json'])) {
		if(isset($_POST['submit'])) {
			$num1 = $_POST['num1'];
			$num2 = $_POST['num2'];
			$operator = $_POST['operator'];
			$solution = 0;
			
			$myObj = new stdClass();
			$myObj->message = calculator($num1, $num2, $operator);
			echo json_encode($myObj);
		} else {
			
			//header('Content-Type: application/json; charset=utf-8');
			
			$myArray = array();
			$myObj = new stdClass();
			$myObj->ID = "+";
			$myObj->Name = 'addition';
			
			$myArray[]=$myObj;
			
			$myObj = new stdClass();
			$myObj->ID = "-";
			$myObj->Name = 'subtraction';
			
			$myArray[]=$myObj;
			
			$myObj = new stdClass();
			$myObj->ID = "/";
			$myObj->Name = 'Division';
			
			$myArray[]=$myObj;
			
			$myObj = new stdClass();
			$myObj->ID = "*";
			$myObj->Name = 'Multiplication';
			
			$myArray[]=$myObj;

			$myJSON = json_encode($myArray);

			echo $myJSON;
		}
		die;
	}
?>

<?php
function calculator($num1 = 0, $num2 = 0, $operator = '+') {
	$result = '';
	$result .= '<h3>num1: ' . $num1 . '</h3>';
		$result .= '<h3>num2: ' . $num2 . '</h3>';
		$result .= '<h3>operator: ' . $operator . '</h3>';
		
		switch($operator) {
			case '+': 
				$solution = $num1 + $num2;
				break;
			case '-': 
				$solution = $num1 - $num2;
				break;
			case '/':
				if($num2 == 0)
					$solution = 'Illegal division by 0';
				else
					$solution = $num1 / $num2;
				break;
			case '*':
				$solution = $num1 * $num2;
				break;
			default:
				$solution = 'Input Error';
				break;
		}
		
		$result .= '<h3>Solution: ' . $solution . '</h3>';
		
		return $result;
		
}
?>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<style>
		body {
			background-color: whitesmoke;
		}
	</style>
</head>

<body>
	
	<div class="row">
	<div class="col-lg-12 text-center" style="padding: 40px;">
	<div class="card">
	<div class="card-body">
		<form action="" method="post" id="form1">
		<div class="form-group">
			<h4>Input 1</h4>
			<input class="form-control" type="text" name="num1" placeholder="Number 1" required="" value="<?php echo $num1; ?>" />
			<h4>Input 2</h4>
			<input class="form-control" type="text" name="num2" placeholder="Number 2" required="" value="<?php echo $num2; ?>" />
			<br />
			<select class="form-control" name="operator" id="operator"> <?php /*
				<option value="+" <?php if($operator == '+') { echo 'selected'; } ?>>Addition</option>
				<option value="-" <?php if($operator == '-') { echo 'selected'; } ?>>Subtraction</option>
				<option value="/" <?php if($operator == '/') { echo 'selected'; } ?>>Division</option>
				<option value="*" <?php if($operator == '*') { echo 'selected'; } ?>>Multiplication</option>
				*/ ?>
			</select>
			<hr />
			<input class="btn btn-outline-dark" type="submit" name="submit" value="submit" />
			<input class="btn btn-outline-dark" type="button" name="updateList" onClick="updateSelect()" value="Update List" />
			</div>
		</form>
	</div>
	</div>
	</div>
	</div>
	
	<div id="resultDisplay"></div>
		<script type="text/javascript" language="javascript">
			function updateSelect() {
				let urlPath = 'ajax.php?json';
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
							$('#operator').empty()
							 $.each(data, function (index, value) {
								// APPEND OR INSERT DATA TO SELECT ELEMENT.
								$('#operator').append('<option value="' + value.ID + '">' + value.Name + '</option>');
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
					
				let urlPath = 'ajax.php?json';
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
							$('#resultDisplay').html(data.message);
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