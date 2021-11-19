<?php 

	
	
	function html_head() {
		return '
			<head>
			<title>Style Page</title>

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
			
			.login-page {
				width: 60%;
				max-width: 400px;
				min-width: 200px;
				text-align: center;
			}
			
			.parent {
				display: flex;
				justify-content: center;
				align-items: center;
				background-color: darkgrey;
				
			}
			.topnav {
				background-image: linear-gradient(rgb(126 5 175) 3%, rgb(97 23 23) 97%);
			}
			
			.contentGrid > div {
				padding-right: 20px;
				float: left;
			}
			
			</style>
			</head>
			';
	}