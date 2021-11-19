<?php 
	session_start();
	
	require_once 'inc/db.php';
	require_once 'inc/functions.php';
	require_once 'inc/functions.security.php';
	require_once 'inc/functions.mysql.php';
	
	if (isset($_GET['json'])) {
		if (isset($_POST['logOff'])) {
			$response = array();
			$response['status'] = 0;
			$response['message'] = '';
			unset($_SESSION['sessionID']);
			session_destroy();
			
			$response['status'] = 1;
			
			echo json_encode($response);
			die;
		} elseif(isset($_POST['action'])) {
			$response = array();
			$response['status'] = 0;
			$response['message'] = '';
			
			if($_POST['action'] == 'addRole') {
				
				$name = $_POST['name'];
				$type = $_POST['type'];
				
				$sql = "INSERT INTO `roles`
						(
							`name`,
							`type`
						) VALUES (
							'$name',
							'$type'
						);";
				$id = sqlInsert($conn, $sql);
				if($id > 0) {
					$response['status'] = 1;
				}
			}elseif($_POST['action'] == 'approveRole') {
				$rpID = $_POST['id'];
				$sql = "SELECT `roles`.`id` AS `role`,
						`sec_users`.`id` AS `user`
						FROM `roles_pending`
				INNER JOIN `roles` ON `roles`.`id` = `roles_pending`.`role_id`
				INNER JOIN `sec_users` ON `sec_users`.`id` = `roles_pending`.`user_id`
				WHERE `roles_pending`.`id` = $rpID";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
						$role = $row['role'];
						$user = $row['user'];
					}
				}
				$id = $_POST['id'];
				
				$sql = "INSERT INTO `colors`.`roles_active`
						(
						`role_id`,
						`user_id`
						)
						VALUES
						(
						$role,
						$user
						)";
				$id = sqlInsert($conn, $sql);
				
				if($id > 0) {
					$response['status'] = 1;
				}
				$sql = "DELETE FROM `roles_pending` WHERE `id` = $rpID";
				$id = sqlInsert($conn, $sql);
				
				if($id > 0) {
					$response['status'] = 1;
				}
			} elseif($_POST['action'] == 'requestRole') {
				
				$name = $_POST['name'];
				
				$sql = "INSERT INTO `colors`.`roles_pending`
						(
						`role_id`,
						`user_id`
						)
						VALUES
						(
						'$name',
						".$_SESSION['sessionID']."
						);
						";
				$id = sqlInsert($conn, $sql);
				if($id > 0) {
					$response['status'] = 1;
				}
			} elseif($_POST['action'] == 'deleteRole') {
				$rpID = $_POST['id'];
				
				$sql = "DELETE FROM `roles_active` WHERE `id` = $rpID";
				$id = sqlInsert($conn, $sql);
				
				if($id > 0) {
					$response['status'] = 1;
				}
			} elseif($_POST['action'] == 'activeRoles') {
				
				$sql = "SELECT `name`, `roles_active`.`id` AS `button`, `type`
				FROM `roles_active`
				INNER JOIN `roles` ON `roles`.`id` = `roles_active`.`role_id`
				WHERE user_id = ".$_SESSION['sessionID'];
				$result = $conn->query($sql);
				$json = array();
				$html = '';
				if ($result->num_rows > 0) {
					$html = '<table><tr><th>role name</th></tr>';
					// output data of each row
					while($row = $result->fetch_assoc()) {
						//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
						$html .= 
							'<tr>' . PHP_EOL .
							'  <td>'.$row["name"].'</td>' . PHP_EOL .
							'</tr>' . PHP_EOL;
							$row['button'] = '<input class="btn btn-sm btn-danger" type="button" value="Delete" onClick="modalAdd(\'delete\',\''.$row['button'].'\')" />';
							switch($row['type']) {
								case 0:
									$row['type'] = "Electronic";
									break;
								case 1:
									$row['type'] = "Physical";
									break;
								default:
									$row['type'] = "Row unknown";
									break;
									
							}
							$json[] = $row;
					}
					$html .= '</table>';
					//$response['message'] = $html;
					$response['message'] = $json;
					$response['status'] = 1;
				} else {
					//echo "0 results";
				}
			}  elseif($_POST['action'] == 'pendingRoles') {
				
				$sql = "SELECT `roles`.`name`,
								`roles_pending`.`id` AS `button`,
								`roles`.`type`,
								`sec_users`.`displayName`
								FROM `roles_pending`
				INNER JOIN `roles` ON `roles`.`id` = `roles_pending`.`role_id`
				INNER JOIN `sec_users` ON `sec_users`.`id` = `roles_pending`.`user_id`
				-- WHERE user_id = ".$_SESSION['sessionID'];
				$result = $conn->query($sql);
				$json = array();
				$html = '';
				if ($result->num_rows > 0) {
					$html = '<table><tr><th>role name</th></tr>';
					// output data of each row
					while($row = $result->fetch_assoc()) {
						//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
						$html .= 
							'<tr>' . PHP_EOL .
							'  <td>'.$row["name"].'</td>' . PHP_EOL .
							'</tr>' . PHP_EOL;
							$row['button'] = '<input class="btn btn-sm btn-success" type="button" value="Approve" onClick="modalAdd(\'approve\',\''.$row['button'].'\')" />';
							switch($row['type']) {
								case 0:
									$row['type'] = "Electronic";
									break;
								case 1:
									$row['type'] = "Physical";
									break;
								default:
									$row['type'] = "Row unknown";
									break;
									
							}
							$json[] = $row;
					}
					$html .= '</table>';
					//$response['message'] = $html;
					$response['message'] = $json;
					$response['status'] = 1;
				} else {
					//echo "0 results";
				}
			} elseif($_POST['action'] == 'modal') {
				if(isset($_POST['type']) && isset($_POST['userID'])) {
					$userID = $_POST['userID'];
					if($_POST['type'] == 'addRole') {
						$response['status'] = 1;
						$response['message'] = '<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<form>
							  <div class="form-group">
								<label for="roleName" class="col-form-label">Role to add: </label>
								<input type="text" class="form-control" id="roleName">
							  </div>
							  <div class="form-group">
								<label for="roleType" class="col-form-label">Role Type:</label>
								<select class="form-control" id="roleType">
									<option value="0">Electronic</option>
									<option value="1">Physical</option>
								</select>
							  </div>
							</form>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" onClick="addRole()">Add Role</button>
						  </div>
						</div>
					  </div>
					</div>';
					} elseif($_POST['type'] == 'requestRole') {
						$response['status'] = 1;
						$message = '<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Request Role</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<form>
							  <div class="form-group">
								<label for="roleType" class="col-form-label">Role to Request:</label>
								<select class="form-control" id="roleSelection">';
									$sql = "SELECT 
												`roles`.`id`, `name`, `type`, `user_id`
											FROM
												`roles`
													LEFT JOIN
												`roles_active` ON `roles`.`id` = `roles_active`.`role_id`
													AND `roles_active`.`user_id` = $userID
											WHERE
												`user_id` IS NULL";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
										// output data of each row
										while($row = $result->fetch_assoc()) {
											$message .= '<option value="'.$row['id'].'">'.$row['name']."</option>";
										}
									}
									/*
									<option value="0">Electronic</option>
									<option value="1">Physical</option>
									*/
									
									$message .= '
								</select>
							  </div>
							</form>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" onClick="requestRole()">Request Role</button>
						  </div>
						</div>
					  </div>
					</div>';
					$response['message'] = $message;
					} elseif($_POST['type'] == 'revokeRole') {
						$response['status'] = 1;
						$message = '<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Revoke Role</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<form>
							  <div class="form-group">
								<label for="roleType" class="col-form-label">Role to revoke:</label>
								<select class="form-control" id="roleType">';
									$sql = "SELECT 
												`roles`.`id`, `name`, `type`, `user_id`
											FROM
												`roles`
													LEFT JOIN
												`roles_active` ON `roles`.`id` = `roles_active`.`role_id`
											WHERE
												`user_id` = $userID";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
										// output data of each row
										while($row = $result->fetch_assoc()) {
											$message .= '<option value="'.$row['id'].'">'.$row['name']."</option>";
										}
									}
									$message .= '
								</select>
							  </div>
							</form>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" onClick="addRole()">Add Role</button>
						  </div>
						</div>
					  </div>
					</div>';
					$response['message'] = $message;
					} elseif($_POST['type'] == 'approve' && isset($_POST['action2'])) {
						$role = "";
						$user = "";
						$rpID = $_POST['action2'];
						$sql = "SELECT `roles`.`name`,
								`roles_pending`.`id` AS `button`,
								`roles`.`type`,
								`sec_users`.`displayName`
								FROM `roles_pending`
						INNER JOIN `roles` ON `roles`.`id` = `roles_pending`.`role_id`
						INNER JOIN `sec_users` ON `sec_users`.`id` = `roles_pending`.`user_id`
						WHERE `roles_pending`.`id` = $rpID";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
								$role = $row['name'];
								$user = $row['displayName'];
							}
						}
						$response['status'] = 1;
						$message = '<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Approve Role</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<form>
							  <div class="form-group">
								<h6> Are you sure you would like to approve the role <strong>'.$role.'</strong> for <strong>'.$user.'</strong>?</h6>
							  </div>
							</form>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" onClick="approveRole('.$rpID.')">Approve Role</button>'." <script>
					function approveRole(rpID) {
						console.log('aproving...');
						let urlPath = 'index.php?json';
						let formData = new FormData();
						formData.append('action', 'approveRole');
						formData.append('id', rpID);
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
					} </script>
					".'
						  </div>
						</div>
					  </div>
					</div>';
					$response['message'] = $message;
					} elseif($_POST['type'] == 'delete' && isset($_POST['action2'])) {
						$role = "";
						$user = "";
						$rpID = $_POST['action2'];
						$sql = "SELECT `roles`.`name`,
								`roles`.`type`,
								`sec_users`.`displayName`
								FROM `roles_active`
						INNER JOIN `roles` ON `roles`.`id` = `roles_active`.`role_id`
						INNER JOIN `sec_users` ON `sec_users`.`id` = `roles_active`.`user_id`
						WHERE `roles_active`.`id` = $rpID";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
								$role = $row['name'];
								$user = $row['displayName'];
							}
						}
						$response['status'] = 1;
						$message = '<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Revoke Role</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<form>
							  <div class="form-group">
								<h6> Are you sure you would like to revoke the role <strong>'.$role.'</strong> for <strong>'.$user.'</strong>?</h6>
							  </div>
							</form>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" onClick="deleteRole('.$rpID.')">Revoke Role</button>'." <script>
					function deleteRole(rpID) {
						console.log('aproving...');
						let urlPath = 'index.php?json';
						let formData = new FormData();
						formData.append('action', 'deleteRole');
						formData.append('id', rpID);
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
					} </script>
					".'
						  </div>
						</div>
					  </div>
					</div>';
					$response['message'] = $message;
					}
				}
			}
			
			
			
			echo json_encode($response);
			die;
		}
		
	}
	
	$errorMsg = "";
	//$validUser = $_SESSION['login'] === true;
	$validUser = false;
	if (isset($_SESSION['login']) && $_SESSION['login']) {
		$validUser = true;
	} elseif (isset($_POST['submit'])) {
		$response = array();
		$response['status'] = 0;
		$response['message'] = '';
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		//$validUser = $_POST['username'] == 'admin' && $_POST['password'] == 'password';
		if (check_login($conn, $username, $password)) {
			$validUser = true;
		}
		if (!$validUser) 
			$response['message'] = 'Invalid username or password.';
		else {
			$_SESSION['login'] = true;
			$response['status'] = 1;
			$response['message'] = 'Login Successful';
		}
		echo json_encode($response);
		
		die;
	}
	if ($validUser) {
		//echo page();
		page();
		//session_destroy();
	}
	else {
		echo login_page();
	}	
	$conn->close();
	//echo "Connection has been closed";
?>
