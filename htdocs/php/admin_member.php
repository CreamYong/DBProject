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

			$query_select = "SELECT U.USER_ID, U.PASSWD, U.USER_NAME, U.GENDER, U.BIRTH, U.ROLE
				FROM user AS U";
			$search = 0;

			// id
			if(isset($_POST[search_id]) && strlen($_POST[search_id]) > 0){
				$sid = $_POST[search_id];
				if($search == 0) $query_select .= " WHERE ";
				else $query_select .= " AND ";
				$search++;
				$query_select .= "U.USER_ID = '$sid'";
			}

			// gender
			if(isset($_POST[search_gender]) && strlen($_POST[search_gender]) > 0){
				$sgender = $_POST[search_gender];
				if($search == 0) $query_select .= " WHERE ";
				else $query_select .= " AND ";
				$search++;
				$query_select .= "U.GENDER = '$sgender'";
			}
			
			// role
			if(isset($_POST[search_role]) && strlen($_POST[search_role]) > 0){
				$srole = $_POST[search_role];
				if($search == 0) $query_select .= " WHERE ";
				else $query_select .= " AND ";
				$search++;
				$query_select .= "U.ROLE = '$srole'";
			}
			
			// task
			if(isset($_POST[search_task]) && strlen($_POST[search_task]) > 0){
				$stask = $_POST[search_task];
				if($search == 0) $query_select .= " WHERE ";
				else $query_select .= " AND ";
				$search++;
				$query_select .= "U.USER_ID IN (
						SELECT S.USER_ID FROM sub_task AS S
						WHERE S.TASK_NAME = '$stask'
						AND S.PERMISSION = 'ACC'
					)";
			}

			$result = mysql_query($query_select);
		?>

		<div class="panel">

			<div class="cell" align="center">
				<h2>회원 목록</h2>

				<table class="tb_normal">
					<tr>
						<th>ID</th>
						<th>비밀번호</th>
						<th>이름</th>
						<th>성별</th>
						<th>생년월일</th>
						<th>역할</th>
						<th>자세히...</th>
					</tr>
				<?php
					$i = 0;
					while($row = mysql_fetch_row($result)){
						if($i%2 == 0) $td = "<td>";
						else $td = "<td class='even'>";
						echo "<tr>";
						echo "$td$row[0]</td>";
						echo "$td$row[1]</td>";
						echo "$td$row[2]</td>";
						echo "$td$row[3]</td>";
						echo "$td$row[4]</td>";
						echo "$td$row[5]</td>";
						echo "$td<a href=\"admin_member_detail.php?user_id=$row[0]&user_role=$row[5]\">Detail</a></td>";
						echo "</tr>";
						$i++;
					}
				?>
				</table>

				<br>

				<form id="myform" action="admin_member.php" method="post">
					<table class="tb_normal">
						<tr>
							<th>ID</th><td><input name="search_id"></td>
						</tr>
						<tr>
							<th>성별</th><td class="even"><input name="search_gender"></td>
						</tr>
						<tr>
							<th>역할</th><td class="even"><input name="search_role"></td>
						</tr>
						<tr>
							<th>참여 태스크(승인)</th><td><input name="search_task"></td>
						</tr>
					</table>
				</form>
				
				<form id="gotoform" action="server_goto_main.php" method="post"></form>

				<br><br>
				<a class="btn" href="#" onclick="document.getElementById('gotoform').submit()"/>뒤로</a>
				<a class="btn" href="#" onclick="document.getElementById('myform').submit()"/>검색</a>

				<br><br>

			</div>
		</div>

		<?php mysql_close(); ?>

	</body>
</html>