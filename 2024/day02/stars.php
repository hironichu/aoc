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


function checkLevel(&$report) {	
	$state = 0;
	$entries = count($report[0]);
	for ($level = 0; $level < $entries; $level++) {
		$current = intval($report[0][$level]);
		
		if ($level < $entries - 1) {
			$next = intval($report[0][$level + 1]);

			if ($current > $next) {
				if ($level !== 0 && $state !== 1) {
					$report[1] = false;
					return;
				}
				$state = 1;
				//
				$math = abs($current - $next);
				if ($math !== 0 && $math > 3) {
					$report[1] = false;
					return;
				}
			}
			//
			if ($current < $next) {
				if ($level !== 0 && $state !== 2) {
					$report[1] = false;
					return;
				}
				$state = 2;
				//
				$math = abs($next - $current);
				if ($math !== 0 && $math > 3) {
					$report[1] = false;
					return;
				}
			}

			if ($current === $next) {
				$report[1] = false;
				return;
			}

		}
	}
	return true;
}

for ($report = 0; $report < count($output); $report++) {
	$state = 0;
	checkLevel($output[$report]);
}

$count = 0;

for ($result = 0; $result < count($output); $result++) {
	if ($output[$result][1]) {
		$count++;
	}
}

echo $count;

fclose($file);

?>