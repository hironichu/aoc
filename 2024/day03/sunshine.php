<?php

$delimiters = [' ', '\n', '\t'];
if ($argc != 2) {
	die("usage: php sunshine.php <input>\n");
}

$arg = @$argv[1] or die("Please provide an argument.\n");
$file = @fopen("./$arg", 'rb') or die("Error: The file $arg does not exist.\n");

$output = [];

while (($line = fgets($file)) !== false) {
	array_push($output, $line);
}

$concat = join($output);

$start = 0;
$firstoff = strpos($concat, "mul(", $start);
$lastoff = strpos($concat, ")", $firstoff);
$store = [];
while ($firstoff) {
	$result = "";
	if ($lastoff - $firstoff > 11) {
		$firstoff = strpos($concat, "mul(", $start++);
		$lastoff = strpos($concat, ")", $firstoff);
		continue;
	}

	for ($index = $firstoff + 4; $index < $lastoff; $index++) {
		$result .= $concat[$index];
	}
	array_push($store, $result);
	$start = $lastoff;
	$firstoff = strpos($concat, "mul(", $start);
	$lastoff = strpos($concat, ")", $firstoff);
}

$sum = 0;
foreach ($store as $mul) {
	$values = explode(",", $mul);
	if (count($values) > 1) {
		$sum += intval($values[0]) * intval($values[1]);
	}
}

echo $sum;


fclose($file);
