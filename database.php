<?php
		// $db = pg_connect("host=ec2-54-83-204-6.compute-1.amazonaws.com dbname=d6isj2vtbas9mb user=omlzkasubunfgk password=17713e4e401705421e1b1c66c3864834f09515f3583d9a46cb25cdfbd0be5661");
	require __DIR__ . '/vendor/autoload.php';
	$dbopts = parse_url(getenv('DATABASE_URL'));
	// print_r ($dbopts);
	print $dbopts["host"];
	print $dbopts["user"];
	print $dbopts["pass"];
	print ltrim($dbopts["path"], "/");
	$db = pg_connect(sprintf("host=%s dbname=%s user=%s password=%s", $dbopts["host"], ltrim($dbopts["path"], "/"), $dbopts["user"], $dbopts["pass"]));
?>
