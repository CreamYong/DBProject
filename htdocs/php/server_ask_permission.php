<?php
	session_start();
?>
<meta charset="UTF-8">
<?php
	$checkList = $_POST[ask];
	$checkCnt = count($checkList);
	$sub_id = $_SESSION[ses_id];

    $dbcon = mysql_connect("localhost", "root", "apmsetup");
    mysql_query("use dbdbdib");

	mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
	mysql_query("set session character_set_client=utf8;");

	for($i = 0; $i < $checkCnt; $i++){
		$tname = $checkList[$i];
		$query_ask_permission = "INSERT INTO sub_task(USER_ID, TASK_NAME) 
			VALUES('$sub_id', '$tname')";
		mysql_query($query_ask_permission);
	}

	mysql_close();
?>

<script>
	alert('태스크 권한을 요청했습니다.');
	location.href = 'sub_main.php';
</script>