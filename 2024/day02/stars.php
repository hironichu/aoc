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
	$state = 0;
	$entries = count($report);
	for ($level = 0; $level < $entries; $level++) {
		$current = intval($report[$level]);
		
		if ($level < count($report) - 1) {
			$next = intval($report[$level + 1]);

			if ($current > $next) {
				if ($level !== 0 && $state !== 1) {
					return false ;
				}
				$state = 1;
				//
				$math = abs($current - $next);
				if ($math !== 0 && $math > 3) {
					return false;
				}
			}
			//
			if ($current < $next) {
				if ($level !== 0 && $state !== 2) {
					return false;
				}
				$state = 2;
				//
				$math = abs($next - $current);
				if ($math !== 0 && $math > 3) {
					return false;
				}
			}

			if ($current === $next) {
				return false;
			}

		}
	}
	return true;
}


$count = 0;

for ($report = 0; $report < count($output); $report++) {
	$state = 0;
	if (checkLevel($output[$report])) {
		$count++;
	}
}

echo $count;

fclose($file);

?>