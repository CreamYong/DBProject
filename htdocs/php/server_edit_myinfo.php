<?php
	session_start();
?>
<meta charset="UTF-8">
<?php
	$dbcon = mysql_connect("localhost", "root", "apmsetup");
	mysql_query("use dbdbdib");

	mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
	mysql_query("set session character_set_client=utf8;");

	$id = $_SESSION[ses_id];
	$pw = $_POST[user_pw];
	$name = $_POST[user_name];
	$gender = $_POST[user_gender];
	$birth = $_POST[user_birth];
	$addr = $_POST[user_address];
	$call = $_POST[user_call];

	$query_modify_info = "UPDATE user
					SET PASSWD = '$pw',
						USER_NAME = '$name',
						GENDER = '$gender',
						BIRTH = '$birth',
						ADDR = '$addr',
						PHONE = '$call'
					WHERE USER_ID = '$id'";

	mysql_query($query_modify_info);
	echo mysql_error();
	
	mysql_close();
?>
<script>
	alert("개인정보가 수정되었습니다.");
	location.href = "edit_myinfo.php";
</script>