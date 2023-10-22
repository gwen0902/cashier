<?php
	session_start();
	setcookie("id", $r['id_user'], time()+3600);
    setcookie("key",hash('sha256',$r['username']), time()+3600);
	session_destroy();
	header('location: index.php');
?> 