<?php

$delimiters = [' ', '\n', '\t'];
if ($argc != 2) {
	die("usage: php miracle.php <input.txt>\n");
}

$arg = @$argv[1] or die("Please provide an argument.\n");
$file = @fopen("./$arg", 'rb') or die("Error: The file $arg does not exist.\n");

$leftList = [];
$rightList = [];

while (($line = fgets($file)) !== false) {
	$elem = explode('   ', $line);
	array_push($leftList, intval($elem[0]));
	array_push($rightList, intval($elem[1]));
}

function c_count($number, $arr) {
	$count = 0;
	for ($i = 0; $i < count($arr); $i++) {
		if ($number === $arr[$i]) {
			$count++;
		}
	}
	return $count;
}

$length = count($leftList);

if ($length !== count($rightList)) {
	throw "Error the two list are not the same length";
}



$sum = 0;
$stored = [];

for ($i = 0; $i < $length; $i++) {
	for ($i = 0; $i < $length; $i++) {
		$count = c_count($leftList[$i], $rightList);
		array_push($stored, $leftList[$i] * $count);
	}
}

for ($i = 0; $i < $length; $i++) {
	$sum += $stored[$i];
}

echo $sum;

fclose($file);

?>