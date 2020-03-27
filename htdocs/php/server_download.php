<?php
	session_start();
?>
<!DOCTYPE HTML>
<?php

	echo $_SESSION[downloadable_fname] . "<br><br>";
	if(!file_exists($_SESSION[downloadable_fname])){
		?><script>
			alert("존재하지 않는 파일입니다.");
			location.href = 'ass_assess.php';
		</script><?php
		exit;
	}

	$filepath = $_SESSION[downloadable_fname];
	$filesize = filesize($filepath);
	$path_parts = pathinfo($filepath);
	$filename = $path_parts['basename'];
	$extension = $path_parts['extension'];
	 
	readfile($filepath);

?>
<script>
//	location.href = 'ass_assess.php';
</script>