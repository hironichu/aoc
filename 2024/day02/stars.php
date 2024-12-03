<?php

$delimiters = [' ', '\n', '\t'];
if ($argc != 2) {
	die("usage: php stars.php <input>\n");
}

$arg = @$argv[1] or die("Please provide an argument.\n");
$file = @fopen("./$arg", 'rb') or die("Error: The file $arg does not exist.\n");

$output = [];
while (($line = fgets($file)) !== false) {
	array_push($output, [explode(" ", trim($line)), true]);
}

$safes = [];

function checkLevel(&$report) {	
	$state = 0;

	for ($level = 0; $level < count($report[0]); $level++) {
		$curr = intval($report[0][$level]);
		
		if ($level + 1 < count($report[0])) {
			
			if ($curr > intval($report[0][$level + 1])) {
				if ($level !== 0 && $state !== 1) {
					$report[1] = false;
					return false;
				}
				$state = 1;
				//
				$math = abs($curr - intval($report[0][$level + 1]));
				if ($math !== 0 && $math > 3) {
					$report[1] = false;
					return false;
				}
			}
			//
			if ($curr < intval($report[0][$level + 1])) {
				if ($level !== 0 && $state !== 2) {
					$report[1] = false;
					return false;
				}
				$state = 2;
				//
				$math = abs(intval($report[0][$level + 1]) - $curr);
				if ($math !== 0 && $math > 3) {
					$report[1] = false;
					return false;
				}
			}

			if ($curr === intval($report[0][$level + 1])) {
				$report[1] = false;
				return false;
			}

		}
	}
	return true;
}

for ($report = 0; $report < count($output); $report++) {
	
	$state = 0;
	$result = checkLevel($output[$report]);
	array_push($safes, $result);
}

$count = 0;

for ($result = 0; $result < count($safes); $result++) {
	if ($safes[$result]) {
		$count++;
	}
}

echo $count;

fclose($file);

?>