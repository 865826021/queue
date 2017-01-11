<?php
	if (isset($_GET['param']) && $_GET['param']!=null) {
		var_dump($_GET['params']);
	}else{
		echo time();
	}
?>