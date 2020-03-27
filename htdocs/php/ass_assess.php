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
		    $con = mysql_query("use dbdbdib");

			mysql_query("set session character_set_connection=utf8;");
			mysql_query("set session character_set_results=utf8;");
			mysql_query("set session character_set_client=utf8;");

		    $ass_id = $_SESSION[ses_id];

		    

		    $query_check_given_file = "SELECT SSID, SUB_ID, STORED_FILE_NAME FROM file_data_type
		    	WHERE ASS_ID = '$ass_id' AND ASS_STATE = '0'";
		    $result = mysql_query($query_check_given_file);
		    // there are some files that given to user and not assessed yet
		    if(mysql_num_rows($result) > 0){
		    	$row = mysql_fetch_row($result);
		    	$ssid = $row[0];
		    	$sub_id = $row[1];
		    	$fname = trim($row[2]);
	            $fbname = basename($fname);
		    }
		    else{
		    	?><script>
		    		alert("평가할 파일이 없습니다.");
					location.href = 'ass_main.php';
		    	</script><?php
		    }
		?>

		<div class="panel">
			<div class="cell" align="center">

				<h2>파일 평가</h2>

				<form id="myform" action="server_assess.php" method="post" enctype="multipart/form-data">
					<table class="tb_normal">
						<tr>
							<th>파일명</th>
							<td><a href='<?php echo $fname; ?>' target="_blank"><?php echo $fbname ?></a></td>
						</tr>
						<tr>
						    <th>점수(0~10)</th>
						    <td class="even"><input type="number" name="score" min="0" max="10" value="0"></td>
						</tr>
						<tr>
						    <th>P/NP</th>
						    <td>
							    <input type="radio" name="pnp" value="1" checked>P<br>
							    <input type="radio" name="pnp" value="0">NP
							</td>
						</tr>
					</table>

			    	<input type="hidden" name="ssid" value='<?php echo $ssid; ?>'>
			    	<input type="hidden" name="sub_id" value='<?php echo $sub_id; ?>'>
			    	<input type="hidden" name="fname" value='<?php echo $fname; ?>'>
				</form>

				<form id="gotoform" action="server_goto_main.php" method="post"></form>

				<br><br>
				<a class="btn" href="#" onclick="document.getElementById('gotoform').submit()"/>뒤로</a>
				<a class="btn" href="#" onclick="document.getElementById('myform').submit()"/>평가</a>
				<br><br>

			</div>
		</div>

		<?php mysql_close(); ?>

	</body>
</html>