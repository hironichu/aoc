<?php

$delimiters = [' ', '\n', '\t'];
if ($argc != 2) {
	die("usage: php stars.php <input>\n");
}

$arg = @$argv[1] or die("Please provide an argument.\n");
$file = @fopen("./$arg", 'rb') or die("Error: The file $arg does not exist.\n");

while (($line = fgets($file)) !== false) {
	//
	//
}


fclose($file);

?>