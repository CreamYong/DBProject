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
		<?php
			$tname = $_GET[t_name];
			$dbcon = mysql_connect("localhost", "root", "apmsetup");
			mysql_query("use dbdbdib");

			mysql_query("set session character_set_connection=utf8;");
			mysql_query("set session character_set_results=utf8;");
			mysql_query("set session character_set_client=utf8;");
		?>
		<div class="panel">
			<div class="cell" align="center">
				<h2>원본 데이터 타입 추가</h2>
				<form id="myform" method="post" action="server_admin_add_oritype.php">
					<table class="tb_normal">
						<tr>
							<th>원본 데이터 타입 이름</th>
							<td><input type="text" name="task_odt_name"/><br></td>
						</tr>
						<tr>
							<th>원본 데이터 타입 스키마</th>
							<td class="even"><input type="text" name="task_odt_scheme"/><br></td>
						</tr>
						<tr>
							<th>원본 데이터 타입 매핑 스키마</th>
							<td><input type="text" name="task_odt_mapping"/><br></td>
						</tr>
						<input type="hidden" name="task_name" <?php echo "value='$tname';" ?>>
					</table>

				</form>
				
				<form id="gotoform" action="server_goto_main.php" method="post"></form>

				<br><br>
				<a class="btn" href="#" onclick="document.getElementById('gotoform').submit()"/>뒤로</a>
				<a class="btn" href="#" onclick="document.getElementById('myform').submit()">추가</a>
				<br><br>
			</div>
		</div>

		<?php mysql_close(); ?>
	</body>
</html>