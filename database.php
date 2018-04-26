<?php
	require __DIR__ . '/vendor/autoload.php';
	$dotenv = new Dotenv\Dotenv(__DIR__);
	$dotenv->required(['DATABASE_URL']);
	$dbopts = parse_url(getenv('DATABASE_URL'));
	$dbopts["path"] = ltrim($dbopts["path"], "/");
	print_r ($dbopts);
	$dbopts["path"] = ltrim($dbopts["path"], "/");
	$dbopts["path"] = ltrim($dbopts["path"], "/");

	$db = pg_connect(sprintf(
	"host=%s dbname=%s user=%s password=%s",
	$dbopts["host"],
	$dbopts["user"],
	$dbopts["pass"],
	ltrim($dbopts["path"], "/")
	));

	// $db = pg_connect("host=10.0.0.86 dbname=crypto user=postgres password=8amlol");
?>
