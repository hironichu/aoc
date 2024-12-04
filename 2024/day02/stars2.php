<?php

$delimiters = [' ', '\n', '\t'];
if ($argc != 2) {
	die("usage: php stars.php <input>\n");
}

$arg = @$argv[1] or die("Please provide an argument.\n");
$file = @fopen("./$arg", 'rb') or die("Error: The file $arg does not exist.\n");

$output = [];
while (($line = fgets($file)) !== false) {
	array_push($output, explode(" ", trim($line)));
}

function checkLevel(array $report) {	
	$isASC = true;
	$isDESC = true;
	$entries = count($report);
	
	for ($level = 1; $level < $entries; $level++) {

		$diff = intval($report[$level]) - intval($report[$level - 1]);

		if (abs($diff) < 1 || abs($diff) > 3) {
			return false;
		}

		if ($diff > 0) {

			$isDESC = false;
		}

		if ($diff < 0) {
			$isASC = false;
		}

	}

	return ($isASC || $isDESC);
}
function applyDampener(array &$report, int &$count) {
	$state = 0;
	$entries = count($report);
	
	for ($level = 0; $level < $entries; $level++) {
		$copy = $report;
		unset($copy[$level]);

		if (checkLevel(array_values($copy))) {
			$count++;
			break;
		}
	}
}

$count = 0;

for ($report = 0; $report < count($output); $report++) {
	$state = 0;
	if (checkLevel($output[$report])) {
		$count++;
		continue;
	}

	applyDampener($output[$report], $count);
}

echo $count;

fclose($file);

?>