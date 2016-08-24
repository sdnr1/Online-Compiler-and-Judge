<?php

$cpp_code = "sample.cpp"; // required
$program = "sample";
$stderr_file = $program . "_STDERR.txt";
$input_file = "input.txt"; // required
$sample_output = "output.txt";
$output_file = "generated_output.txt";
$program_execution_time_limit = 2000000; // time in microseconds
$online_judge_mode = false; // should be true if program output is to be judged
$display_output = true;
$custom_judge = false; // should be true if a custom script for output validation purpose is being used

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
	echo "</pre>";
	exit;
}

// Execute code
pclose(popen("start /B ${program} < ${input_file} > ${output_file} 2> ${stderr_file}", "r"));
usleep($program_execution_time_limit);

$str = exec("taskkill /F /IM ${program}.exe 2>&1");
$str = explode(":", $str)[0];

// Check if program exceeded time limit
if($str == "SUCCESS")
{
	echo "Time Limit Exceeded";
	exit;
}

// Check for runtime error
if(file_exists($stderr_file) && filesize($stderr_file) != 0)
{
	echo "Runtime Error:<br><br><pre>";
	print_r(file_get_contents($stderr_file));
	echo "</pre>";
	exit;
}

// Jugde output if judge mode is enabled
if($online_judge_mode)
{
	// Check generated output with sample output
	if($custom_program_validator)
	{
		// Run custom output validator here
	}
	else
	{
		if(compareFiles($sample_output, $output_file))
			echo "Result : Correct Answer<br>";
		else
			echo "Result : Wrong Answer<br>";
	}
}

// Display output if output display is enabled
if($display_output)
{
	echo "Program output:<br><pre>";
	print_r(file_get_contents($output_file));
	echo "</pre>";
	if($online_judge_mode)
	{
		echo "<br>Sample output:<br><pre>";
		print_r(file_get_contents($sample_output));
		echo "</pre>";
	}
}

?>
