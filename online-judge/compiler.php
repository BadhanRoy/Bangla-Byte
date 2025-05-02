<?php
class Compiler {
    private $code;
    private $input;
    private $workingDir = "submissions/";

    public function __construct($code, $input = '') {
        $this->code = $code;
        $this->input = $input;
    }

    public function compileAndRun() {
        $fileName = uniqid('code_');

        if (!file_exists($this->workingDir)) {
            mkdir($this->workingDir, 0777, true);
        }

        $sourceFile = $this->workingDir . $fileName . '.c';
        $binaryFile = $this->workingDir . $fileName . '.out';
        $inputFile = $this->workingDir . $fileName . '.in';

        // Save source code
        file_put_contents($sourceFile, $this->code);

        // Save input if exists
        if (!empty($this->input)) {
            file_put_contents($inputFile, $this->input);
        }

        // Compile
        $compileCmd = "gcc " . escapeshellarg($sourceFile) . " -o " . escapeshellarg($binaryFile) . " 2>&1";
        $compileOutput = shell_exec($compileCmd);

        if (!empty($compileOutput)) {
            // Compilation Error
            return [
                'status' => 'Compilation Error',
                'output' => $compileOutput
            ];
        }

        // Run
        if (!empty($this->input)) {
            $runCmd = escapeshellarg($binaryFile) . " < " . escapeshellarg($inputFile) . " 2>&1";
        } else {
            $runCmd = escapeshellarg($binaryFile) . " 2>&1";
        }
        $runOutput = shell_exec($runCmd);

        return [
            'status' => 'Success',
            'output' => trim($runOutput)
        ];
    }
}
?>