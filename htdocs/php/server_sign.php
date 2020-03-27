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

	$query_register = "INSERT INTO user VALUES(
		'$_POST[user_id]',
		'$_POST[user_pw]',
		'$_POST[user_name]',
		'$_POST[user_gender]',
		'$_POST[user_birth]',
		'$_POST[user_address]',
		'$_POST[user_call]',
		'$_POST[user_role]')";

	if(mysql_query($query_register)){
		?><script>
			alert("회원가입에 성공했습니다!");
			location.href = 'index.php';
		</script><?php
	}
	else{
		?><script>
			alert("입력 정보가 잘못되었거나 존재하는 아이디입니다. 회원가입에 실패했습니다.");
			location.href = 'sign.php';
		</script><?php
	}

	mysql_close();
?>