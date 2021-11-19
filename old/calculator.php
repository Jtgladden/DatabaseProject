<?php
function calculator($num1 = 0, $num2 = 0, $operator = '+') {
	echo '<h3>num1: ' . $num1 . '</h3>';
		echo '<h3>num2: ' . $num2 . '</h3>';
		echo '<h3>operator: ' . $operator . '</h3>';
		
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
		
		echo '<h3>Solution: ' . $solution . '</h3>';
}
?>
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
		$num1 = '';
		$num2 = '';
		$operator = '';
			
		if (isset($_POST['submit'])) {
			// Get the submited form data
			
			$num1 = $_POST['num1'];
			$num2 = $_POST['num2'];
			$operator = $_POST['operator'];
			$solution = 0;
		}
	?>
	<div class="row">
	<div class="col-lg-12 text-center" style="padding: 40px;">
	<div class="card">
	<div class="card-body">
		<form action="" method=post>
		<div class="form-group">
			<h4>Input 1</h4>
			<input class="form-control" type="text" name="num1" placeholder="Number 1" required="" value="<?php echo $num1; ?>" />
			<h4>Input 2</h4>
			<input class="form-control" type="text" name="num2" placeholder="Number 2" required="" value="<?php echo $num2; ?>" />
			<br />
			<select class="form-control" name="operator">
				<option value="+" <?php if($operator == '+') { echo 'selected'; } ?>>Addition</option>
				<option value="-" <?php if($operator == '-') { echo 'selected'; } ?>>Subtraction</option>
				<option value="/" <?php if($operator == '/') { echo 'selected'; } ?>>Division</option>
				<option value="*" <?php if($operator == '*') { echo 'selected'; } ?>>Multiplication</option>
			</select>
			<hr />
			<input class="btn btn-outline-dark" type="submit" name="submit" value="submit" />
			</div>
		</form>
	</div>
	</div>
	</div>
	</div>
	
	<div>
		<?php
			if (isset($_POST['submit'])) {
				calculator($num1, $num2, $operator);
			}
		?>
	</div>
</body>
</html>