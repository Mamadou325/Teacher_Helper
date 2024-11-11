<?php
include_once "../deploy/submit_grades.php";

// Test grade validation for both valid and invalid cases
function test_validate_grades() {
    // Valid grades
    $validGrades = [85, 90, 88, 92, 100];
    $result = validateGrades($validGrades);
    assertEqual($result, true, "Valid grades should pass validation");

    // Invalid grades
    $invalidGrades = [-5, 'abc', 20.5, 0, -10];
    $result = validateGrades($invalidGrades);
    $expectedError = "Error: All grades must be positive whole numbers.";
    assertEqual($result, $expectedError, "Invalid grades should fail validation");
}

// Test quiz average calculation, including edge cases
function test_calculate_quiz_average() {
    $quizzes = [80, 85, 90, 75, 95];
    sort($quizzes);
    array_shift($quizzes); // Remove lowest score
    $expectedAvg = array_sum($quizzes) / count($quizzes);
    $result = calculateQuizAverage($quizzes);
    assertEqual($result, $expectedAvg, "Quiz average calculation is correct");

    // Test when only one quiz score remains after dropping the lowest
    $quizzes = [80, 90, 100];
    $result = calculateQuizAverage($quizzes);
    assertEqual($result, 95, "Quiz average with only one remaining score is correct");
}

// Test final grade calculation
function test_calculate_final_grade() {
    $homework_avg = 90;
    $quiz_avg = 85;
    $midTerm = 88;
    $finalProject = 92;
    $expectedFinalGrade = round(($homework_avg * 0.2) + ($quiz_avg * 0.1) + ($midTerm * 0.3) + ($finalProject * 0.4));
    $result = calculateFinalGrade($homework_avg, $quiz_avg, $midTerm, $finalProject);
    assertEqual($result, $expectedFinalGrade, "Final grade calculation is correct");

    $result = calculateFinalGrade(0, 0, 0, 0); // All zeroes
    assertEqual($result, 0, "Final grade with zeroes is correct");

    $result = calculateFinalGrade(100, 100, 100, 100); // Perfect scores
    assertEqual($result, 100, "Final grade with perfect scores is correct");
}

// Test saving grades to the database, including failure cases
function test_save_grades_to_database() {
    // Simulate a successful database query
    $dbc = ['query' => function($sql) { return true; }];
    $result = saveGradesToDatabase($dbc, 123, [90, 85, 100, 88, 92], [80, 85, 90, 95, 100], 88, 92, 95);
    $expectedMessage = "Grades added successfully!";
    assertEqual($result, $expectedMessage, "Grades should be saved successfully");

    // Simulate a database query failure
    $dbc = ['query' => function($sql) { return false; }];
    $result = saveGradesToDatabase($dbc, 123, [90, 85, 100, 88, 92], [80, 85, 90, 95, 100], 88, 92, 95);
    assertTrue(strpos($result, "Error:") !== false, "Database failure should return an error message");
}

?>
