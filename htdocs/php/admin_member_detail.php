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

			$user_id = $_GET[user_id];
			$user_role = $_GET[user_role];
		?>

		<div class="panel">

			<div class="cell" align="center">
				<h2>회원 상세 정보</h2>

				<?php
					echo "ID: ".$user_id."<br>";
					echo "역할: ".$user_role."<br>";
					////////////// sub
					if($user_role == "SUB"){
						$query_get_tasks = "SELECT * FROM sub_task WHERE USER_ID = '$user_id'";
						$result = mysql_query($query_get_tasks);
				?>

				<br><br><br>참여한 태스크 목록<br><br>
				<table class="tb_normal">
					<tr>
						<th>태스크 이름</th>
						<th>최초 제출 날짜</th>
						<th>평균 점수</th>
						<th>승인 여부</th>
					</tr>

				<?php
					$i = 0;
					while($row = mysql_fetch_row($result)){
						if($i%2 == 0) $td = "<td>";
						else $td = "<td class='even'>";
						echo "<tr>";
						echo "$td$row[1]</td>";
						echo "$td$row[2]</td>";
						echo "$td$row[3]</td>";
						echo "$td$row[4]</td>";
						echo "</tr>";
						$i++;
					}
				?>

				</table>
				<br><br><br>제출한 파일 목록<br><br>
				<table>
					<tr>
						<th>태스크 이름</th>
						<th>제출 날짜</th>
						<th>P/NP</th>
					</tr>

				<?php
					$query_get_seqs = "SELECT O.TASK_NAME, F.SUBMIT_DATE, F.PNP
						FROM file_data_type AS F, ori_data_type AS O
						WHERE F.SUB_ID = '$user_id'
						AND F.ORI_TYPE_ID = O.TYPE_ID";
					$result = mysql_query($query_get_seqs);
					$i = 0;
					while ($row = mysql_fetch_row($result)){
						if($i%2 == 0) $td = "<td>";
						else $td = "<td class='even'>";
						$tname = $row[0];
						$sdate = $row[1];
						if(strcmp($row[2], "1")==0) $pnp = "P";
						else if(strcmp($row[2], "0")==0) $pnp = "NP";
						else $pnp = "-";
						echo "<tr>";
						echo "$td$tname</td>";
						echo "$td$sdate</td>";
						echo "$td$pnp</td>";
						echo "</tr>";
						$i++;
					}
					echo "</table>";
				}
					
					/////////////////// ass
					else if($user_role == "ASS"){
						$query_get_dones = "SELECT O.TASK_NAME, F.SUB_ID, F.ASS_SCORE, F.PNP
							FROM file_data_type AS F, ori_data_type AS O
							WHERE F.ASS_ID = '$user_id'
							AND F.PNP IS NOT NULL
							AND F.ORI_TYPE_ID = O.TYPE_ID";
						$result = mysql_query($query_get_dones);
				?>

					<br><br><br>평가한 데이터들<br><br>
					<table class="tb_normal">
						<tr>
							<th>태스크 이름</th>
							<th>제출자 ID</th>
							<th>평가 점수</th>
							<th>P/NP</th>
						</tr>

				<?php
						$i = 0;
						while($row = mysql_fetch_row($result)){
							if($i%2 == 0) $td = "<td>";
							else $td = "<td class='even'>";
							$tname = $row[0];
							$sid = $row[1];
							$score = $row[2];
							if(strcmp($row[3], "1")==0) $pnp = "P";
							else if(strcmp($row[3], "0")==0) $pnp = "NP";
							echo "<tr>";
							echo "$td$tname</td>";
							echo "$td$sid</td>";
							echo "$td$score</td>";
							echo "$td$pnp</td>";
							echo "<tr>";
							$i++;
						}
				?>

					</table>
					<br><br><br>미평가 데이터들<br><br>
					<table class="tb_normal">
						<tr>
							<th>태스크 이름</th>
							<th>제출자 ID</th>
						</tr>
				<?php
						$query_get_not_dones = "SELECT O.TASK_NAME, F.SUB_ID
								FROM file_data_type AS F, ori_data_type AS O
								WHERE F.ASS_ID = '$user_id'
								AND F.PNP IS NULL
								AND F.ORI_TYPE_ID = O.TYPE_ID";
						$result = mysql_query($query_get_not_dones);
						$i = 0;
						while($row = mysql_fetch_row($result)) {
							if($i%2 == 0) $td = "<td>";
							else $td = "<td class='even'>";
							$tname = $row[0];
							$sid = $row[1];
							echo "<tr>";
							echo "$td$tname</td>";
							echo "$td$sid</td>";
							echo "<tr>";
							$i++;
						}
						echo "</tr></table>";
					}
					///////////////// admin
					else{
						echo "<br><br><br>관리자입니다.<br><br>";
					}
				?>

				<br><br>
				<a class="btn" href="admin_member.php"/>뒤로</a>
				<br><br>

			</div>

		</div>

		<?php mysql_close(); ?>
	</body>
</html>