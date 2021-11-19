<?php

function login_page() {
	$html = '<html>';
	$html .= html_head();
	$html .= '<body class="parent">';
	$html .= '<div class="card card-body login-page">  
					<form id="login" action="" method="post">
						<h4>Username</h4>
						<input class="form-control" type="text" name="username" placeholder="username" required="" />
						<h4>Password</h4>
						<input class="form-control" type="password" name="password" placeholder="password" required="" />
						<hr />
						<input class="btn btn-primary" type="submit" name="submit" value="Login" />
					</form>
					<div id="message"></div>
			</div>';
	$html .= "<script type=\"text/javascript\" language=\"javascript\">
			$('#login').on('submit',function(e) {
				e.preventDefault();
				let submitter_btn = $(e.originalEvent.submitter);
					
				let urlPath = 'index.php?json';
				let form = document.getElementById('login');
				let formData = new FormData(form);
				formData.append('submit', 'value');
				$.ajax({
						cache: false,
						type: 'POST',
						url: urlPath,
						dataType: 'json',
						data: formData,
						processData: false,
						contentType: false,
						beforeSend: function() {
							/*$('#login').css('opacity', 0.5).fadeIn(300, function() {
								$('#red').css('zIndex', 10000');
							}); */
							
							$('#login').fadeOut(300);
						},
						success: function(data) {
							if (data.status == 1) {
								$('#message').html(data.message);
								location.reload();
							} else {
								$('#message').html(data.message);
								$('#login')[0].reset();
								$('#login').fadeIn(300);
							}
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
		</script>";
	
	$html .= '</body>';
	$html .= '</html>';
	
	return $html;
	
}

function page() {
	$html = '<html>' .
	html_head() .
	'<body>' .
	        '<div class="topnav">
				<input class="btn btn-primary" type="button" value="Log Out" onClick="logOff()" />
			</div>
			<div class="contentGrid">
				<div>
					<div id="activeRoles"></div>
					<input class="btn btn-sm btn-secondary" type="button" value="Refresh Active Roles" onClick="tableRefresh(\'activeRoles\')" />
				</div>
				<div id="actions">
					<button type="button" class="btn btn-primary" onClick="modalAdd(\'addRole\')">Add new role</button>
					<button type="button" class="btn btn-primary" onClick="modalAdd(\'requestRole\')">Request new role</button>
					<button type="button" class="btn btn-primary" onClick="modalAdd(\'revokeRole\')">Revoke role</button>
				</div>
				<div>
					<div id="pendingRoles"></div>
					<input class="btn btn-sm btn-secondary" type="button" value="Refresh Pending Roles" onClick="tableRefresh(\'pendingRoles\')" />
				</div>
			</div>
			<div id="placeholder"></div>
			';
	$html .= "<script type=\"text/javascript\" language=\"javascript\">
			function logOff() {
				let urlPath = 'index.php?json';
				let formData = new FormData();
				formData.append('logOff', '');
				$.ajax({
						cache: false,
						type: 'POST',
						url: urlPath,
						dataType: 'json',
						data: formData,
						processData: false,
						contentType: false,
						success: function(data) {
							if (data.status == 1) {
								location.reload();
							} else {
								$('#message').html(data.message);
							}
						},
						error: function(jqXHR, testStatus, errorThrown) {
							console.log('error: ' + errorThrown);
						},
						fail: function(response) {
							console.log('Failure: ' + response);
						}
				});
			};
			
			function sleep(ms) {
				const date = Date.now();
				let currentDate = null;
				do {
					currentDate = Date.now();
				} while (currentDate - date < ms);
				
			}
			
			function tableRefresh(table) {
				let urlPath = 'index.php?json';
				let formData = new FormData();
				formData.append('action', table);
				$.ajax({
						cache: false,
						type: 'POST',
						url: urlPath,
						dataType: 'json',
						data: formData,
						processData: false,
						contentType: false,
						beforeSend: function() {
							$('#' + table).html('<h3>Refreshing Data</h3>');
						},
						success: function(data) {
							if (data.status == 1) {
								sleep(1000);
								//$('#' + table).html(data.message);
								console.log(data);
								
								let tableData = '<table><tr><th>Action</th><th>role name</th>';
								if (table == 'pendingRoles') {
									tableData += '<th>display name</th>';
								}
								tableData += '<th>role type</th></tr>';
								
								$.each(data.message, function(i, item) {
									console.log(item.name);
									tableData += '<tr>';
									tableData += '<td>' + item.button + '</td>';
									tableData += '<td>' + item.name + '</td>';
									if (table == 'pendingRoles') {
										tableData += '<td>' + item.displayName + '</td>';
									}
									tableData += '<td>' + item.type + '</td>';
									tableData += '</tr>';
								});
								tableData += '</table>';
								$('#' + table).html(tableData);
								

							} else {
								$('#' + table).html(data.message);
							}
						},
						error: function(jqXHR, testStatus, errorThrown) {
							console.log('error: ' + errorThrown);
						},
						fail: function(response) {
							console.log('Failure: ' + response);
						}
				});
			}
			
			
			function addRole() {
				let urlPath = 'index.php?json';
				let formData = new FormData();
				formData.append('action', 'addRole');
				formData.append('name', $('#roleName').val());
				formData.append('type', $('#roleType').val());
				$.ajax({
						cache: false,
						type: 'POST',
						url: urlPath,
						dataType: 'json',
						data: formData,
						processData: false,
						contentType: false,
						success: function(data) {
							if(data.status=1) {
								refreshTables();
								hideModal();
							}
						},
						error: function(jqXHR, testStatus, errorThrown) {
							console.log('error: ' + errorThrown);
						},
						fail: function(response) {
							console.log('Failure: ' + response);
						}
				});
			}
			
			function requestRole() {
				let urlPath = 'index.php?json';
				let formData = new FormData();
				formData.append('action', 'requestRole');
				formData.append('name', $('#roleSelection').val());
				$.ajax({
						cache: false,
						type: 'POST',
						url: urlPath,
						dataType: 'json',
						data: formData,
						processData: false,
						contentType: false,
						success: function(data) {
							if(data.status=1) {
								refreshTables();
								hideModal();
							}
						},
						error: function(jqXHR, testStatus, errorThrown) {
							console.log('error: ' + errorThrown);
						},
						fail: function(response) {
							console.log('Failure: ' + response);
						}
				});
			}
			
			function modalAdd(type, action2) {
				let urlPath = 'index.php?json';
				let formData = new FormData();
				formData.append('action', 'modal');
				formData.append('type', type);
				if (typeof action2 !== 'undefined') {
					formData.append('action2', action2);
				}
				formData.append('userID', ".$_SESSION['sessionID'].");
				$.ajax({
						cache: false,
						type: 'POST',
						url: urlPath,
						dataType: 'json',
						data: formData,
						processData: false,
						contentType: false,
						success: function(data) {
							if(data.status=1) {
								console.log('Adding new modal');
								 $('#placeholder').html(data.message);
								 showModal();
							}
						},
						error: function(jqXHR, testStatus, errorThrown) {
							console.log('error: ' + errorThrown);
						},
						fail: function(response) {
							console.log('Failure: ' + response);
						}
				});
			}
			
			function showModal() {
				$('#exampleModal').modal('show');
			}
			
			function hideModal() {
				$('#exampleModal').modal('hide');
				$('#placeholder').html('');

			}
			
			function refreshTables() {
				tableRefresh('activeRoles');
				tableRefresh('pendingRoles');
			}
			
			$(document).ready(function() {
				refreshTables();
			});
			
		</script>";
		
	$html .= '</body>' .
	'</html>';
	
	echo $html;

}
