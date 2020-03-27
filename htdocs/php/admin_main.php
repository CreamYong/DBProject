
<?php
	session_start();
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<html>
	<head>
		<title>디비디비팀</title>
		<link rel="stylesheet" type="text/css" href="../css/basic.css">
	</head>
	<body>
		<?php
			$admin_id = $_SESSION[ses_id];
		?>

		<div class="panel">

			<div class="cell" align="center">
				<p>ID: <?php echo $admin_id; ?></p>
				<br>
				<a class="btn" href="edit_myinfo.php">개인정보수정</a>
				<a class="btn" href="server_logout.php">로그아웃</a>
				<br><br>
			</div>

			<div class="cell" align="center">
				<br>
				<a class="btn" href="admin_task.php">태스크 관리</a>
				<a class="btn" href="admin_member.php">회원 관리</a>
				<br><br>
			</div>

		</div>
	</body>
</html>