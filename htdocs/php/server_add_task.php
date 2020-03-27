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
	$tbname = $_POST[task_tdt_name];
	$period = $_POST[task_time_period];
	$description = $_POST[task_description];
	$scheme = "PRESENTOR varchar(15), " . $_POST[task_tdt_scheme];

	$oname = $_POST[task_odt_name];
	$oscheme = $_POST[task_odt_scheme];
	$omapping = $_POST[task_odt_mapping];

	$query = "INSERT INTO task 
		VALUES('$tname', '$tbname', '$period', '$description', '$scheme')";
	
	$query2 = "CREATE TABLE `$tbname` ( $scheme ) CHARSET = utf8";

	$query3 = "INSERT INTO ori_data_type 
		VALUES('$oname', '$oscheme', '$omapping', '$tname')";

	$con = mysql_query($query);

	echo mysql_error();

	$con = mysql_query($query2);

	echo mysql_error();

	$con = mysql_query($query3);

	echo mysql_error();

	mysql_close();
?>
<script>
	alert("태스크를 추가했습니다.");
    location.href = "admin_main.php";
</script>