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
		<div class="panel">
			<div class="cell" align="center">
				<h2>태스크 추가</h2>
				<form id="myform" method="post" action="server_add_task.php">
					<table class="tb_normal">
						<tr>
							<th>태스크 이름</th>
							<td><input type="text" name="task_name"/><br></td>
						</tr>
						<tr>
							<th>설명</th>
							<td class="even"><input type="text" name="task_description"/><br></td>
						</tr>
						<tr>
							<th>태스크 테이블 이름</th>
							<td><input type="text" name="task_tdt_name"/><br></td>
						</tr>
						<tr>
							<th>태스크 테이블 타입 스키마</th>
							<td class="even"><input type="text" name="task_tdt_scheme"/><br></td>
						</tr>
						<tr>
							<th>원본 데이터 타입 이름</th>
							<td><input type="text" name="task_odt_name"/><br></td>
						</tr>
						<tr>
							<th>원본 데이터 타입 스키마</th>
							<td class="even"><input type="text" name="task_odt_scheme"/><br></td>
						</tr>
						<tr>
							<th>원본 데이터 타입 매핑</th>
							<td><input type="text" name="task_odt_mapping"/><br></td>
						</tr>
						<tr>
							<th>최소 제출 주기</th>
							<td class="even"><input type="text" name="task_time_period"/><br></td>
						</tr>	
					</table>
				</form>

				<form id="gotoform" action="server_goto_main.php" method="post"></form>

				<br><br>
				<a class="btn" href="#" onclick="document.getElementById('gotoform').submit()"/>뒤로</a>
				<a class="btn" href="#" onclick="document.getElementById('myform').submit()"/>추가</a>
				<br><br>
			</div>
		</div>
	</body>
</html>