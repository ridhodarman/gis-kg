<?php

	$host = "ec2-54-235-67-106.compute-1.amazonaws.com";
	$user = "scehnwetxoamzm";
	$pass = "075d5ceeef1b9c73d0830b65e30b44530d136ba1b0ec42a2bc6fd43f0019b8a7";
	$port = "5432";
	$dbname = "d80cvv3nckfpri";
	$conn = pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$pass) or die("Gagal");

?>
