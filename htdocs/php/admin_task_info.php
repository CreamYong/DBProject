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
			$tname = $_GET[tname];
			$dbcon = mysql_connect("localhost", "root", "apmsetup");
			mysql_query("use dbdbdib");

			mysql_query("set session character_set_connection=utf8;");
			mysql_query("set session character_set_results=utf8;");
			mysql_query("set session character_set_client=utf8;");
		?>
		<div class="panel">

			<div class="cell" align="center">
				<h2>태스크 <?php echo $tname; ?> 정보</h2>
				<table class="tb_normal">
					<?php
						$query_get_info = "SELECT * FROM task WHERE TASK_NAME = '$tname'";
						$result = mysql_query($query_get_info);
						$row = mysql_fetch_row($result);
						$tbname = $row[1];
						$minInterval = $row[2];
						$explanation = $row[3];
						$scheme = $row[4];

						echo "<tr><th>테이블 이름</th><td>$tbname</td></tr>";
						echo "<tr><th>최소 업로드 주기</th><td class='even'>$minInterval</td></tr>";
						echo "<tr><th>설명</th><td>$explanation</td></tr>";
						echo "<tr><th>스키마</th><td class='even'>$scheme</td></tr>";

						$query_get_nr_of_seqs = "SELECT COUNT(*) FROM file_data_type AS F, ori_data_type AS O
							WHERE O.TYPE_ID = F.ORI_TYPE_ID
							AND O.TASK_NAME = '$tname'";
						$result = mysql_query($query_get_nr_of_seqs);
						$row = mysql_fetch_row($result);
						$nr_of_seqs = $row[0];

						$query_get_tbname = "SELECT TAB_NAME FROM task WHERE TASK_NAME = '$tname'";
						$result = mysql_query($query_get_tbname);
						$row = mysql_fetch_row($result);
						$tbname = $row[0];

						$query_get_nr_of_tuples = "SELECT COUNT(*) FROM `$tbname`";
						$result = mysql_query($query_get_nr_of_tuples);
						$row = mysql_fetch_row($result);
						$nr_of_tuples = $row[0];

						$query_get_stasks = "SELECT * FROM sub_task WHERE TASK_NAME = '$tname'";
						$result = mysql_query($query_get_stasks);
						$nr_of_stasks = mysql_num_rows($result);

						echo "<tr><th>제출된 파일 개수</th><td>$nr_of_seqs</td></tr>";
						echo "<tr><th>저장된 튜플 개수</th><td class='even'>$nr_of_tuples</td></tr>";
						echo "<tr><th>서브태스크 개수</th><td>$nr_of_stasks</td></tr>";
					?>
				</table>
			</div>

			<div class="cell" align="center">
				<h2>태스크 참여 제출자</h2>
				<table>
					<tr>
						<th>ID</th>
						<th>최초 제출 날짜</th>
						<th>평균 점수</th>
						<th>승인</th>
					</tr>
					<?php
						$i = 0;
						while($row = mysql_fetch_row($result)){
							if($i%2 == 0) $td = "<td>";
							else $td = "<td class='even'>";
							echo "<tr>";
							echo "$td$row[0]</td>";
							echo "$td$row[2]</td>";
							echo "$td$row[3]</td>";
							echo "$td$row[4]</td></tr>";
							$i++;
						}
					?>
				</table>
			</div>

			<div class="cell" align="center">
				<h2>원본 데이터 타입</h2>
				<?php
					$query_get_ori_types = "SELECT * FROM ori_data_type WHERE TASK_NAME = '$tname'";
					$result = mysql_query($query_get_ori_types);
					while($row = mysql_fetch_row($result)){
						echo "<table class='tb_normal'>";
						echo "<tr><th>타입 ID</th><td>$row[0]</td></tr>";
						echo "<tr><th>태스크 스키마</th><td class='even'>$row[1]</td></tr>";
						echo "<tr><th>태스크 매핑 스키마</th><td>$row[2]</td></tr>";
						echo "</table><br>";
					}
				?>
				
				<form id="gotoform" action="server_goto_main.php" method="post"></form>

				<br>
				<a class="btn" href="#" onclick="document.getElementById('gotoform').submit()"/>뒤로</a>
				<a class="btn" href="admin_add_oritype.php?t_name=<?php echo $tname; ?>">원본 데이터 타입 추가</a>
				<br><br>
			</div>

			<div class="cell" align="center">
				<h2>파일 목록</h2>
				<a href=download.php>aaaa</a>
			</div>
		</div>
	</body>
</html>