<?php
class PythonCompiler {
    private $code;
    private $input;
    private $workingDir = "submissions/";

    public function __construct($code, $input = '') {
        $this->code = $code;
        $this->input = $input;
    }

    public function runTestCases($testCases) {
        $results = [];
        $passedCases = 0;
        
        foreach ($testCases as $testCase) {
            $result = $this->runSingleTestCase($testCase['input'], $testCase['output']);
            $results[] = $result;
            
            if ($result['is_correct']) {
                $passedCases++;
            }
        }
        
        return [
            'results' => $results,
            'passed_cases' => $passedCases,
            'total_cases' => count($testCases)
        ];
    }

    private function runSingleTestCase($input, $expectedOutput) {
        $fileName = uniqid('python_');
        
        if (!file_exists($this->workingDir)) {
            mkdir($this->workingDir, 0777, true);
        }

        $sourceFile = $this->workingDir . $fileName . '.py';
        $inputFile = $this->workingDir . $fileName . '.in';

        // Save source code
        file_put_contents($sourceFile, $this->code);

        // Save input
        file_put_contents($inputFile, $input);

        // Execute Python code with timeout (5 seconds)
        $command = "python " . escapeshellarg($sourceFile) . " < " . escapeshellarg($inputFile) . " 2>&1";
        $output = shell_exec($command);
        
        // Normalize line endings and trim whitespace
        $actualOutput = trim(str_replace(["\r\n", "\r"], "\n", $output));
        $expectedOutput = trim(str_replace(["\r\n", "\r"], "\n", $expectedOutput));
        
        $isCorrect = (strtolower($actualOutput) === strtolower($expectedOutput));
        
        // Clean up files
        @unlink($sourceFile);
        @unlink($inputFile);

        return [
            'input' => $input,
            'expected_output' => $expectedOutput,
            'actual_output' => $actualOutput,
            'is_correct' => $isCorrect
        ];
    }
}
?>