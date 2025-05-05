<?php
class PythonCompiler {
    private $code;
    
    public function __construct($code) {
        $this->code = $code;
    }
    
    public function runTestCases($testCases) {
        $results = [];
        $passedCases = 0;
        
        foreach ($testCases as $testCase) {
            $input = $testCase['input'];
            $expectedOutput = trim($testCase['output']);
            
            // Create a temporary file for the Python code
            $tempFile = tempnam(sys_get_temp_dir(), 'python_code_');
            file_put_contents($tempFile, $this->code);
            
            // Create a temporary file for the input
            $inputFile = tempnam(sys_get_temp_dir(), 'python_input_');
            file_put_contents($inputFile, $input);
            
            // Prepare the command to run the Python code with input
            $command = "python3 " . escapeshellarg($tempFile) . " < " . escapeshellarg($inputFile) . " 2>&1";
            
            // Execute the command and capture output
            $output = shell_exec($command);
            $actualOutput = trim($output ?? '');
            
            // Clean up temporary files
            unlink($tempFile);
            unlink($inputFile);
            
            // Compare actual output with expected output
            $isCorrect = ($actualOutput === $expectedOutput);
            
            if ($isCorrect) {
                $passedCases++;
            }
            
            $results[] = [
                'input' => $input,
                'expected_output' => $expectedOutput,
                'actual_output' => $actualOutput,
                'is_correct' => $isCorrect
            ];
        }
        
        return [
            'total_cases' => count($testCases),
            'passed_cases' => $passedCases,
            'results' => $results
        ];
    }
}
?>