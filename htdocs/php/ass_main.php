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

			$ass_id = $_SESSION[ses_id];
		?>

		<div class="panel">

			<div class="cell" align="center">
				<p>ID: <?php echo $ass_id; ?></p>
				<br>
				<a class="btn" href="edit_myinfo.php">개인정보수정</a>
				<a class="btn" href="server_logout.php">로그아웃</a>
				<br><br>
			</div>

			<div class="cell" align="center">
				<h2>할당된 파싱 시퀀스 파일 목록</h2>

				<table class="tb_normal">
					<tr>
						<th>제출자</th>
						<th>태스크</th>
						<th>회차</th>
						<th>평가여부</th>
						<th>점수</th>
						<th>P/NP</th>
					</tr>

					<?php
						$query_get_seqs = "SELECT F.SUB_ID, O.TASK_NAME, F.NUMBER, F.ASS_STATE, F.ASS_SCORE, F.PNP
							FROM file_data_type AS F, ori_data_type AS O
							WHERE F.ORI_TYPE_ID = O.TYPE_ID
							AND F.ASS_ID = '$ass_id'
							ORDER BY F.ASS_STATE DESC";
						$result = mysql_query($query_get_seqs);
						$i = 0;
						while($row = mysql_fetch_row($result)){
							$sub_id = $row[0];
							$tname = $row[1];
							$num = $row[2];
							if(strcmp($row[3], "1") == 0) $state = "DONE";
							else $state = "NOT DONE";
							$score = $row[4];
							if(strcmp($row[5], "1") == 0) $pnp = "P";
							else if(strcmp($row[5], "0") == 0) $pnp = "NP";
							else $pnp = "-";

							if($i%2 == 0) $td = "<td>";
							else $td = "<td class='even'>";
							echo "<tr>
									$td$sub_id</td>
									$td$tname</td>
									$td$num</td>
									$td$state</td>
									$td$score</td>
									$td$pnp</td>
								</tr>";
							$i++;
						}
					?>

				</table>

				<br><br>
				<a class="btn" href="ass_assess.php">주어진 파일 평가</a>
				<br><br>
			</div>
		</div>
		<?php mysql_close() ?>
	</body>
</html>