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
			$dbcon = mysql_connect("localhost", "root", "apmsetup");
			mysql_query("use dbdbdib");

			mysql_query("set session character_set_connection=utf8;");
			mysql_query("set session character_set_results=utf8;");
			mysql_query("set session character_set_client=utf8;");
		?>

		<div class="panel">

			<div class="cell" align="center">
				<h2>태스크 목록</h2>
				<table class="tb_normal">
					<tr><th>이름</th></tr>
					<?php
						$query_get_tasks = "SELECT TASK_NAME FROM task";
						$result = mysql_query($query_get_tasks);
						$i = 0;
						while($row = mysql_fetch_row($result)){
							if($i%2 == 0) $td = "<td>";
							else $td = "<td class='even'>";
							echo "<tr>$td<a href='admin_task_info.php?tname=$row[0]'>$row[0]</a></td></tr>";
							$i++;
						}
					?>
				</table>

				<br><br>
				<a class="btn" href="add_task.php">태스크 만들기</a>
				<br><br>
			</div>

			<div class="cell" align="center">
				<h2>태스크 요청 승인</h2>
				<form id="myform" action="server_permit.php" method="post">
					<table class="tb_normal">
						<tr>
							<th>요청자 ID</th>
							<th>태스크 이름</th>
							<th>선택</th>
						</tr>
						<?php
							$query_get_waitings = "SELECT USER_ID, TASK_NAME FROM sub_task
								WHERE PERMISSION = 'NON'";
							$result = mysql_query($query_get_waitings);
							$cnt = 0;
							while($row = mysql_fetch_row($result)){
								$sub_id = $row[0];
								$tname = $row[1];
								if($cnt%2 == 0) $td = "<td>";
								else $td = "<td class='even'>";
								echo "<tr>$td$sub_id</td>$td$tname</td>";
								echo "$td<input type='checkbox' name=tasks[] value='$cnt'></td></tr>";
								$cnt++;
							}
						?>
					</table>
					<br>
					<input type="radio" name="pd" value="permit" checked>승인
					<input type="radio" name="pd" value="deny">거절
				</form>
				
				<form id="gotoform" action="server_goto_main.php" method="post"></form>

				<br><br>
				<a class="btn" href="#" onclick="document.getElementById('gotoform').submit()"/>뒤로</a>
				<a class="btn" href="#" onclick="document.getElementById('myform').submit()"/>승인/거절</a>
				<br><br>

			</div>

		</div>

		<?php mysql_close() ?>
	</body>
</html>