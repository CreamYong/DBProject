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
		<div class="panel"><div class="cell" align="center">
			<h2>로그인</h2>
			<form id="myform" method="post" action="server_login.php">
				<table class="tb_normal">
					<tr>
						<th>ID</th>
						<td><input type="text" name="login_id"/><br/></td>
					</tr>
					<tr>
						<th>비밀번호</th>
						<td class="even"><input type="password" name="login_pw"/><br/></td>
					</tr>
				</table>
			</form>
			<br><br>
			<a class="btn" href="#" onclick="document.getElementById('myform').submit()"/>로그인</a>
			<a class="btn" href="sign.php">회원가입</a>
			<br><br>
		</div></div>
	</body>
</html>