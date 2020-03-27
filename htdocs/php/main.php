
<?php
	session_start();
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<html>
	<head>
		<title>디비디비팀</title>
		<script>
			function showTasks(){
				var selectTag = document.getElementById("select_view");
				var selectValue = selectTag.value;

				// view all tasks
				if(selectValue == "view_all"){
					document.location.href="sub_main.php?view=0";
				}
				// view only permitted tasks
				else{
					document.location.href="sub_main.php?view=1";
				}
			}
		</script>
		<link rel="stylesheet" type="text/css" href="../css/basic.css">
	</head>
	<body>
		<?php
			$user_id = $_SESSION[ses_id];
			$user_role = $_SESSION[ses_role];

			$dbcon = mysql_connect("localhost", "root", "apmsetup");
			mysql_query("use dbdbdib");

			mysql_query("set session character_set_connection=utf8;");
			mysql_query("set session character_set_results=utf8;");
			mysql_query("set session character_set_client=utf8;");

			if(strcmp($user_role, "ADMIN")==0){
		?>

		<div class="panel">

			<div class="cell" align="center">
				<p>ID: <?php echo $user_id; ?></p>
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
		<?php } 
		else if(strcmp($user_role, "ASS")==0){ ?>
		<div class="panel">

			<div class="cell" align="center">
				<p>ID: <?php echo $user_id; ?></p>
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
		<?php }
		else{ ?>
		<div class="panel">

			<div class="cell" align="center">
				<p>ID: <?php echo $user_id; ?></p>
				<br>
				<a class="btn" href="edit_myinfo.php">개인정보수정</a>
				<a class="btn" href="server_logout.php">로그아웃</a>
				<br><br>
			</div>

			<div class="cell" align="center">
				<form id="myform" method="post" action="server_ask_permission.php">
					<h2>태스크 목록</h2>
					태스크 보기
					<select id="select_view" onchange="showTasks()">
						<option value="view_all">전체</option>
						<option value="view_permitted" <?php if($viewOption==1) echo "selected"; ?> >승인받음</option>
					</select>
					<br><br>

					<?php

						$content = "";

						if($viewOption == 0){
							$query_get_tasks = "(
									SELECT T1.TASK_NAME, T1.EXPLANATION, T1.SCHEME_QUERY, S1.PERMISSION
									FROM task AS T1, sub_task AS S1
									WHERE T1.TASK_NAME = S1.TASK_NAME
									AND S1.USER_ID = '$sub_id'
								) UNION (
									SELECT T2.TASK_NAME, T2.EXPLANATION, T2.SCHEME_QUERY, 'NOT ASKED' AS PERMISSION
									FROM task AS T2
									WHERE T2.TASK_NAME NOT IN (
										SELECT S2.TASK_NAME FROM sub_task AS S2
										WHERE S2.USER_ID = '$sub_id'
									)
								)";
						}
						else{
							$query_get_tasks = "SELECT T.TASK_NAME, T.EXPLANATION, T.SCHEME_QUERY, S.PERMISSION
								FROM task AS T, sub_task AS S
								WHERE T.TASK_NAME = S.TASK_NAME
								AND S.PERMISSION = 'ACC'
								AND S.USER_ID = '$sub_id'";
						}

						$result = mysql_query($query_get_tasks);
						while($row = mysql_fetch_row($result)){
							$tname = $row[0];
							$explanation = $row[1];
							$scheme = $row[2];
							$permission = $row[3];
							$notAsked = (strcmp($permission, "NOT ASKED") == 0);
							$permitted = (strcmp($permission, "ACC") == 0);
							$content .= "<p>
								<table class='tb_normal'>
									<tr>
										<th>이름</th>
										<th>설명</th>
										<th>스키마</th>
										<th>승인 여부</th>
									</tr><tr>
										<td>$tname</td>
										<td>$explanation</td>
										<td>$scheme</td>
										<td>$permission</td>
									</tr>";

							if($notAsked){
								$content .= "<tr><td class='even' colspan='4'>
										<input type='checkbox' name='ask[]' value='$tname'> 이 태스크의 권한 요청
									</td></tr>";
							}
							else if($permitted){
								$content .= "<tr><td class='even' colspan='4'>
										<a href='sub_submit.php?tname=$tname'>파일 제출</a>
									</td></tr>";
							}

							$content .= "</table></p>";
						}

						echo $content;



						$query_get_nr_of_files = "SELECT COUNT(*) FROM file_data_type
							WHERE SUB_ID = '$sub_id'";
						$result = mysql_query($query_get_nr_of_files);
						$row = mysql_fetch_row($result);
						$nr_of_files = $row[0];

						$query_get_nr_of_tuples = "SELECT SUM(NUM_TUPLE) FROM file_data_type
							WHERE SUB_ID = '$sub_id'
							AND PNP = '1'";
						$result = mysql_query($query_get_nr_of_tuples);
						$row = mysql_fetch_row($result);
						$nr_of_tuples = $row[0];
					?>

					<br>
					<a class="btn" href="#" onclick="document.getElementById('myform').submit()"/>권한 요청</a>
					<br><br>
				</form>
			</div>

			<div class="cell" align="center">
				<h2>나의 제출 현황</h2>
				<table class="tb_normal">
					<tr>
						<th>제출한 파일 수</th>
						<td><?php echo $nr_of_files; ?></td>
					</tr>
					<tr>
						<th>태스크 데이터 테이블에 제출된 튜플 수</th>
						<td class="even"><?php echo $nr_of_tuples; ?></td>
					</tr>
				</table>
				<br>
			</div>
		</div>
		<?php }
		mysql_close(); ?>
	</body>
</html>