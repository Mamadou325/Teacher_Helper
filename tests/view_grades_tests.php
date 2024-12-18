<?php
include_once "../deploy/view_grades.php"; 
require_once 'TestFramework/unitTestingHelper.php';

// Test function to check if final grades can be fetched from the database
function test_fetch_final_grades() {
    // Simulate the code in view_grades.php to ensure the database query runs correctly
    $dbc = mysqli_connect("localhost", "csc350", "xampp", "grading_tool");
    $result = mysqli_query($dbc, "SELECT students.name, grades.finalGrade FROM students JOIN grades ON students.studentID = grades.studentID");
    
    // Test that the query ran successfully
    assertTrue($result !== false, "Fetch final grades query successful");
    
    assertTrue(mysqli_num_rows($result) > 0, "Final grades found in database");
    
    mysqli_close($dbc);
}

// Test function to check if the grade table is being generated correctly
function test_generate_grade_table() {
    // Capture the output generated by including the view_grades.php file
    $output = captureOutput(function() {
        include_once "../deploy/view_grades.php"; 
    });

    // Check if the table rows are being correctly generated
    assertHtmlContains($output, "<tr><td>", "Grade table rows should be generated");

    assertHtmlContains($output, "No grades found.", "No grades message should be displayed if no records exist");
}

?>
