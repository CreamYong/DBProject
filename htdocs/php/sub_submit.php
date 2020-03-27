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

				<h2>파일 제출</h2>

				<form id="myform" action="server_submit.php" method="post" enctype="multipart/form-data">
					<table class="tb_normal">
						<tr>
							<th>기한 시작</th>
							<td><input type="date" name="term_start"></td>
						</tr>
						<tr>
							<th>기한 끝</th>
							<td class="even"><input type="date" name="term_end"></td>
						</tr>
						<tr>
							<th>회차</th>
							<td><input type="input" name="phase"></td>
						</tr>
						<tr>
							<th>파일</th>
							<td class="even"><input type="file" name="file_to_upload"></td>
						</tr>
						<tr>
							<th>원본 데이터 타입</th>
							<td>
							    <?php
							    	// check log-in
							    	if(!isset($_SESSION[ses_id])){
									    ?>
										<script>
											alert("not logged in");
										//	location.href = 'login.php';
										</script>
										<?php
									}

							        // db connect
								    $dbcon = mysql_connect("localhost", "root", "apmsetup");
								    mysql_query("use dbdbdib");

									mysql_query("set session character_set_connection=utf8;");
									mysql_query("set session character_set_results=utf8;");
									mysql_query("set session character_set_client=utf8;");

								    $tname = $_GET[tname];

								    // get table name of corresponding task
								    $query_get_task_table_name = "SELECT TAB_NAME FROM task WHERE '$tname' = TASK_NAME";
								    $result_task_table_name = mysql_query($query_get_task_table_name);
								    $row = mysql_fetch_row($result_task_table_name);
								    $tbname = $row[0];

								    echo "<input type=\"hidden\" name=\"task_name\" value=\"$tname\">";
								    echo "<input type=\"hidden\" name=\"task_tb\" value=\"$tbname\">";

								    // get ori_types and construct select tag
								    echo "<select name=\"ori_type_name\">";
								    $query_get_ori_types = "SELECT TYPE_ID FROM ori_data_type WHERE TASK_NAME = '$tname'";
								    $result_ori_types = mysql_query($query_get_ori_types);
								    for($counter = 0; $row = mysql_fetch_row($result_ori_types); $counter++){
								    	foreach($row as $key => $value){
								    		echo "<option value=\"$value\">$value</option>";
								    	}
									}
								    echo "</select>";

								    mysql_close();
							    ?>
							</td>
						</tr>
					</table>
				</form>
				
				<form id="gotoform" action="server_goto_main.php" method="post"></form>

				<br><br>
				<a class="btn" href="#" onclick="document.getElementById('gotoform').submit()"/>뒤로</a>
				<a class="btn" href="#" onclick="document.getElementById('myform').submit()"/>제출</a>
				<br><br>

			</div>
		</div>

	</body>
</html>