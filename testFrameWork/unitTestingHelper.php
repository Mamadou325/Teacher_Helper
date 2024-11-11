<?php

function assertEqual($actual, $expected, $testName = '') {
    if ($actual === $expected) {
        print "   PASS: $testName\n";
    } else {
        print "   FAIL: $testName - Expected: " . var_export($expected, true) . ", Got: " . var_export($actual, true) . "\n";
    }
}


function assertTrue($condition, $testName = '') {
    if ($condition) {
        print "   PASS: $testName\n";
    } else {
        print "   FAIL: $testName - Expected true, got false\n";
    }
}


function assertArrayEqual($actual, $expected, $testName = '') {
    if ($actual === $expected) {
        print "   PASS: $testName\n";
    } else {
        print "   FAIL: $testName - Expected: " . json_encode($expected) . ", Got: " . json_encode($actual) . "\n";
    }
}


function assertThrows(callable $fn, $expectedException, $testName = '') {
    try {
        $fn();
        print "   FAIL: $testName - Expected exception of type $expectedException\n";
    } catch (Exception $e) {
        if (get_class($e) === $expectedException) {
            print "   PASS: $testName\n";
        } else {
            print "   FAIL: $testName - Expected exception of type $expectedException, got " . get_class($e) . "\n";
        }
    }
}

function captureOutput(callable $fn, ...$params) {
    ob_start();
    $fn(...$params);
    $output = ob_get_clean();
    return $output;
}


function assertHtmlContains($output, $expectedHtml, $testName = '') {
    if (strpos($output, $expectedHtml) !== false) {
        print "   PASS: $testName\n";
    } else {
        print "   FAIL: $testName - Expected HTML fragment: " . htmlspecialchars($expectedHtml) . "\n";
    }
}


function runTests() {
    $allFunctions = get_defined_functions()['user'];
    $functionsToRun = [];
    foreach ($allFunctions as $function) {
        if (strpos($function, 'test_') === 0) { 
            $details = new ReflectionFunction($function);
            $filenameParts = explode(DIRECTORY_SEPARATOR, $details->getFileName());
            $functionsToRun[$filenameParts[array_key_last($filenameParts)]][] = $function;
        }
    }
    foreach($functionsToRun as $fileName => $testFunctionsInFile) {
        $header = "\nTests from file '$fileName':\n";
        print $header . str_repeat('-', strlen($header)) . "\n";
        $passCount = 0;
        $failCount = 0;
        foreach ($testFunctionsInFile as $testFunction) {
            try {
                trim($testFunction());
                $passCount++;
            } catch (Throwable $e) {
                print "   FAIL: $testFunction got Exception: " . $e->getMessage() . "\n";
                $failCount++;
            }
        }
        print "\nPASS: $passCount / " .count($testFunctionsInFile). " FAIL: $failCount / " .count($testFunctionsInFile). "\n";
    }
}
