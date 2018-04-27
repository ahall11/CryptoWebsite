<?php
	require __DIR__ . '/vendor/autoload.php';
	$dbopts = parse_url(getenv('DATABASE_URL'));
	$db = pg_connect(sprintf("host=%s dbname=%s user=%s password=%s", $dbopts["host"], ltrim($dbopts["path"], "/"), $dbopts["user"], $dbopts["pass"]));
?>
