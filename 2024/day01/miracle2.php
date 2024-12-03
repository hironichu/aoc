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
	$elem = array_filter(explode('   ', $line));
	array_push($leftList, intval($elem[0]));
	array_push($rightList, intval($elem[1]));
}

function c_min($arr) {
	$min = [$arr[0], 0];
	$length = count($arr);
	
	for ($i = 0; $i < $length; $i++) {
		if ($arr[$i] < $min[0]) {
			$min = [$arr[$i], $i];
		}
	}

	return $min;
}

if (count($leftList) !== count($rightList)) {
	throw "Error the two list are not the same length";
}

$length = count($leftList);
$tmp = 0;

$ordered1 = [];
$ordered2 = [];
$sum = 0;

for ($i = 0; $i < $length; $i++) {
	$minLeft = c_min($leftList);
	$minRight = c_min($rightList);
	
	$sum += abs($minLeft[0] - $minRight[0]);

	array_splice($leftList, $minLeft[1], 1);
	array_splice($rightList, $minRight[1], 1);
}

echo $sum;

fclose($file);

?>