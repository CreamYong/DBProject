<?php
	session_start();
?>
<meta charset="UTF-8">
<?php
	$checkList = $_POST[tasks];
	$checkCnt = count($checkList);
	$permit = (strcmp($_POST[pd], "permit") == 0);

	$dbcon = mysql_connect("localhost", "root", "apmsetup");
	mysql_query("use dbdbdib");

	mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
	mysql_query("set session character_set_client=utf8;");

	$query_get_waitings = "SELECT USER_ID, TASK_NAME FROM sub_task
		WHERE PERMISSION = 'NON'";
	$result = mysql_query($query_get_waitings);
	$i = 0;
	$lcnt = 0;
	while($row = mysql_fetch_row($result)){
		if($i == intval($checkList[$lcnt])){
			$sub_id = $row[0];
			$tname = $row[1];
			// permit
			if($permit){
				$query_pd = "UPDATE sub_task SET PERMISSION = 'ACC'
					WHERE USER_ID = '$sub_id' AND TASK_NAME = '$tname'";
			}
			// deny
			else{
				$query_pd = "DELETE FROM sub_task
					WHERE USER_ID = '$sub_id' AND TASK_NAME = '$tname'";
			}
			mysql_query($query_pd);

			$lcnt++;
			if($lcnt == $checkCnt) break;
		}
		$i++;
	}

	mysql_close();
?>
<script>
	alert("요청에 응답했습니다.");
	location.href = 'admin_task.php';
</script>