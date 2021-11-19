<?php
	// Variables declared here
	global $magicColor;
	
	$textColor = 'whitesmoke';
	$backgroundColor = $magicColor;
	/*
	
	
	*/

?>

<style> 
	body {
		background-color: <?php echo $backgroundColor ?>;
		color: <?php echo $textColor ?>;
	}
	
	.transparent-input{
       background-color:transparent !important;
       border-width: 1px !important;
	   border-color: black;
    }
	
	.parent {
		display: flex;
		justify-content: center;
		align-items: center;
	}
	select {
		text-align: center;
		text-align-last: center;
		-moz-text-align-last: center;
	}
	
	
</style>
