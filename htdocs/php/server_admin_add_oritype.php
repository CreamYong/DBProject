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

	$tname = $_POST[task_name];
	$oname = $_POST[task_odt_name];
	$oscheme_temp = $_POST[task_odt_scheme];
	$omapping = $_POST[task_odt_mapping];

	$oscheme = implode(" text, ", explode(",", $oscheme_temp)) . " text";

	$query3 = "INSERT INTO `ori_data_type` 
		VALUE('$oname', '$oscheme', '$omapping', '$tname')";

	$con = mysql_query($query3);

	mysql_close();
?>
<script> 
	alert("원본 데이터 타입을 추가했습니다."); 
	<?php echo "location.href='admin_task_info.php?tname=$tname'" ?>;
</script>