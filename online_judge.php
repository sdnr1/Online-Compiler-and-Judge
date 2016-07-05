<?php

$cpp_code = "sample.cpp"; // required
$program = "sample";
$stderr_file = $program . "_STDERR.txt";
$input_file = "input.txt"; // required
$sample_output = "output.txt"; // required
$output_file = "generated_output.txt";
$program_execution_time_limit = 2000000; // time in microseconds

// Check if cpp_code, input_file and sample_output exist
if(!file_exists($cpp_code) || !file_exists($input_file) || !file_exists($sample_output))
{
    echo "Required files are missing.";
    exit;
}

// Function to compare generated output with sample output
function compareFiles($file_a, $file_b)
{
	if(filesize($file_a) != filesize($file_b))
		return false;
	$fp_a = fopen($file_a, 'rb');
	$fp_b = fopen($file_b, 'rb');
	while(($b = fread($fp_a, 4096)) != false)
	{
		$b_b = fread($fp_b, 4096);
		if($b !== $b_b)
		{
			fclose($fp_a);
			fclose($fp_b);
			return false;
		}
	}
	fclose($fp_a);
	fclose($fp_b);
	return true;
}

// Complie code
exec("g++ ${cpp_code} -o ${program} 2>&1", $str);

// Check for compilation error
if(!empty($str))
{
	echo "Compilation Error:<br><br><pre>";
	print_r($str);
	exit;
}

// Execute code
pclose(popen("start /B ${program} < ${input_file} > ${output_file} 2> ${stderr_file}", "r"));
usleep($program_execution_time_limit);

// Check if Host OS in Windows
if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
{
	$str = exec("taskkill /F /IM ${program}.exe 2>&1");
	$str = explode(":", $str)[0];

	// Check if program exceeded time limit
	if($str == "SUCCESS")
	{
		echo "Time Limit Exceeded";
		exit;
	}
}
else
{
	$str = exec("pgrep ${program}");
	exec("kill ${str}");
	
	// Check if program exceeded time limit
	if($str != "")
	{
		echo "Time Limit Exceeded";
		exit;
	}
}

// Check for runtime error
if(file_exists($stderr_file) && filesize($stderr_file) != 0)
{
	echo "Runtime Error:<br><br><pre>";
	print_r(file_get_contents($stderr_file));
	exit;
}

// Check generated output with sample output
if(compareFiles($sample_output, $output_file))
	echo "Correct Answer";
else
	echo "Wrong Answer";

?>
