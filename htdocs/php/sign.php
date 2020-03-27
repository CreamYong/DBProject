<?php
	session_start();
?>
<!DOCTYPE HTML>
<meta charset="UTF-8">
<html>
	<head>
		<title>디비디비팀</title>
		<link rel="stylesheet" type="text/css" href="../css/basic.css">
		</head>
	<body>
		<div class="panel"><div class="cell" align="center">
			<h2>회원가입</h2>
			<form id="myform" method="post" action="server_sign.php">
				<table>
					<tbody>
						<tr> 
							<th>ID</th>
							<td><label>
								<input type ="text" name="user_id" autofocus />
							</label></td>
						</tr>
						<tr>
							<th>비밀번호</th>
							<td class="even"><label>
								<input type="password" name="user_pw">
							</label></td>
						</tr>
						<tr>
							<th>이름</th>
							<td><label>
								<input type="text" name="user_name" />
							</label></td>
						</tr>
						<tr>
							<th>성별</th>
							<td class="even"><label>
								<input type="radio" name="user_gender" value="M" checked/>남
								<input type="radio" name="user_gender" value="F"/>여
							</label></td>
						</tr>
						<tr>
							<th>전화번호</th>
							<td><label>
								<input type="tel" name="user_call" style="ime-mode:disabled">
							</label></td>
						</tr>
						<tr>
							<th>생일</th>
							<td class="even"><label>
								<input type="date" name="user_birth" style="ime-mode:disabled">
							</label></td>
						</tr>
						<tr>
							<th>주소</th>
							<td><label>
								<input name="user_address" style="ime-mode:disabled" >
							</label></td>
						</tr>
						<tr>
							<th>역할</th>
							<td class="even"><label>
								<input type="radio" name="user_role" value="SUB" checked/>제출자
								<input type="radio" name="user_role" value="ASS"/>평가자
							</label></td>
						</tr>
					</tbody>
				</table>
				<br><br>
				<a class="btn" href="#" onclick="document.getElementById('myform').submit()"/>회원가입</a>
				<br><br>
			</form>
		</div></div>
	</body>
</html>