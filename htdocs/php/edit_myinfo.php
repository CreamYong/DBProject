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

			if(isset($_SESSION[ses_id])) $user_id = $_SESSION[ses_id];
			else $user_id = "kks227";
			$get_info = "SELECT * FROM user WHERE USER_ID = '$user_id'";
			$result = mysql_query($get_info);
			$user_info = mysql_fetch_row($result);
		?>

		<div class="panel">

			<div class="cell" align="center">

				<h2>개인정보 수정</h2>

				<form id="myform" method="post" action="server_edit_myinfo.php">
					<table class="tb_normal">
						<tr> 
							<th>ID</th>
							<td><label>
								<input type ="text" name="user_id" value="<?php echo $user_info[0]; ?>" disabled="disabled"/>
							</label></td>
						</tr>
						<tr>
							<th>비밀번호</th>
							<td class="even"><label>
								<input type="password" id="user_pw" name="user_pw" value="<?php echo $user_info[1]; ?>">
							</label></td>
						</tr>
						<tr>
							<th>이름</th>
							<td><label>
								<input type="text" id="user_name" name="user_name" value="<?php echo $user_info[2]; ?>"/>
							</label></td>
						</tr>
						<tr>
							<th>성별</th>
							<td class="even"><label>
								<input type="radio" name="user_gender" value="M" <?php if(strcmp($user_info[3], "M") == 0) echo "checked" ?> />남
								<input type="radio" name="user_gender" value="F" <?php if(strcmp($user_info[3], "F") == 0) echo "checked" ?> />여
							</label></td>
						</tr>
						<tr>
							<th>전화번호</th>
							<td><label>
								<input type="tel" name="user_call" id="user_call" value="<?php echo $user_info[6]; ?>" style="ime-mode:disabled">
							</label></td>	
						</tr>
						<tr>
							<th>생일</th>
							<td class="even"><label>
								<input type="date" name="user_birth" id="user_birth" value="<?php echo $user_info[4]; ?>" style="ime-mode:disabled">
							</label></td>
						</tr>
						<tr>
							<th>주소</th>
							<td><label>
								<input name="user_address" value="<?php echo $user_info[5]; ?>" id="user_address" style="ime-mode:disabled">
							</label></td>					
						</tr>
					</table>
				</form>

				<form id="dropform" action="server_drop_out.php" method="post"></form>
				<form id="gotoform" action="server_goto_main.php" method="post"></form>

				<br><br>
				<a class="btn" href="#" onclick="document.getElementById('gotoform').submit()"/>뒤로</a>
				<a class="btn" href="#" onclick="document.getElementById('myform').submit()"/>수정</a>
				<a class="btn" href="#" onclick="document.getElementById('dropform').submit()"/>탈퇴</a>
				<br><br>

			</div>
		</div>

		<?php mysql_close(); ?>

	</body>
</html>