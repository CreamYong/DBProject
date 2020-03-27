<?php
	session_start();
?>
<meta charset="UTF-8">
<?php
	$dbcon = mysql_connect("localhost", "root", "apmsetup");
	$con = mysql_query("use dbdbdib");

	mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
	mysql_query("set session character_set_client=utf8;");

	if(isset($_SESSION[ses_id])){
		$user_id = $_SESSION[ses_id];
		$query_drop_out = "DELETE FROM user WHERE USER_ID = '$user_id'";
		mysql_query($query_drop_out);
	}

	mysql_close();
	session_destroy();
?>
<script>
	alert("탈퇴했습니다.");
	location.href = 'login.php';
</script>