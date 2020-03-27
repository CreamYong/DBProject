<meta charset="UTF-8">

<?php
	session_start();
	$dbcon = mysql_connect("localhost", "root", "apmsetup");
    mysql_query("use dbdbdib");

	mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
	mysql_query("set session character_set_client=utf8;");

	$login_id = $_POST[login_id];
	$login_pw = $_POST[login_pw];

	$query_find_id = "SELECT * FROM user WHERE USER_ID = '$login_id'";
	$result = mysql_query($query_find_id);
//	echo mysql_error($dbcon) . "<br/>";
	if(mysql_num_rows($result) == 0){
		// no matching id
		?><script>
			alert("없는 ID입니다.");
			location.href = "login.php";
		</script><?php
		exit;
	}

	$query_match = "SELECT ROLE FROM user WHERE USER_ID = '$login_id' AND PASSWD = '$login_pw'";
	$result = mysql_query($query_match);
	if(mysql_num_rows($result) == 0){
		// no matching
		?><script>
			alert("ID와 비밀번호가 맞지 않습니다.");
			location.href = "login.php";
		</script><?php
		exit;
	}

	$row = mysql_fetch_row($result);

	$_SESSION[ses_id] = $login_id;
	$_SESSION[ses_pw] = $login_pw;
	$_SESSION[ses_role] = $row[0];
	
	// admin
/*	if(strcmp($_SESSION[ses_role], "ADMIN") == 0){
		?><script>
			alert("환영합니다! 당신은 관리자입니다.");
			location.href = "admin_main.php";
		</script><?php
	}
	// sub
	else if(strcmp($_SESSION[ses_role], "SUB") == 0){
		?><script>
			alert("환영합니다! 당신은 제출자입니다.");
			location.href = "sub_main.php";
		</script><?php
	}
	// ass
	else{
		?><script>
			alert("환영합니다! 당신은 평가자입니다.");
			location.href = "ass_main.php";
		</script><?php
	}*/
	?>
	<script>
		location.href = "main.php";
	</script>

	mysql_close();
?>