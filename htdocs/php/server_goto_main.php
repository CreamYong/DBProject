<?php
	session_start();
?>
<meta charset="UTF-8">
<?php
	if(!isset($_SESSION[ses_role])){
		?><script>
			location.href = "login.php";
		</script><?php
	}/*
	// admin
	else if(strcmp($_SESSION[ses_role], "ADMIN") == 0){
		?><script>
			location.href = "admin_main.php";
		</script><?php
	}
	// sub
	else if(strcmp($_SESSION[ses_role], "SUB") == 0){
		?><script>
			location.href = "sub_main.php";
		</script><?php
	}
	// ass
	else{
		?><script>
			location.href = "ass_main.php";
		</script><?php
	}*/
	else{
		?><script>
			location.href="main.php";
		</script><?php
	}
?>