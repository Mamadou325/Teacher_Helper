<?php
include_once "../deploy/add_grades.php";
require_once 'TestFramework/unitTestingHelper.php';


function test_database_connection() {
    $dbc = mysqli_connect("localhost", "csc350", "xampp", "grading_tool");
    assertTrue($dbc !== false, "Database connection successful");
    mysqli_close($dbc);
}

function test_fetch_students() {
    $dbc = mysqli_connect("localhost", "csc350", "xampp", "grading_tool");
    $result = mysqli_query($dbc, "SELECT studentID, name FROM students");
    assertTrue($result !== false, "Fetch students query successful");
    assertTrue(mysqli_num_rows($result) > 0, "Students found in database");
    mysqli_close($dbc);
}

function test_generate_student_options() {
    $output = captureOutput(function() {
        $dbc = mysqli_connect("localhost", "csc350", "xampp", "grading_tool");
        $result = mysqli_query($dbc, "SELECT studentID, name FROM students");
        while ($row = mysqli_fetch_assoc($result)) {
            print "<option value='{$row['studentID']}'>{$row['name']}</option>";
        }
        mysqli_close($dbc);
    });
    assertHtmlContains($output, "<option value=", "Student options generated");
}

?>