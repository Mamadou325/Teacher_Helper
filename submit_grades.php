<?php
$dbc = mysqli_connect("localhost", "csc350", "xampp", "grading_tool"); // Connect to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Get form data
$studentID = $_POST['studentID'];
$homework1 = $_POST['homework1'];
$homework2 = $_POST['homework2'];
$homework3 = $_POST['homework3'];
$homework4 = $_POST['homework4'];
$homework5 = $_POST['homework5'];
$quiz1 = $_POST['quiz1'];
$quiz2 = $_POST['quiz2'];
$quiz3 = $_POST['quiz3'];
$quiz4 = $_POST['quiz4'];
$quiz5 = $_POST['quiz5'];
$midTerm = $_POST['midTerm'];
$finalProject = $_POST['finalProject'];

 // Validate that all inputs are positive whole numbers
 $inputs = [$homework1, $homework2, $homework3, $homework4, $homework5, 
 $quiz1, $quiz2, $quiz3, $quiz4, $quiz5, 
 $midTerm, $finalProject];

 // Check if the input is numeric, positive, and a whole number
foreach ($inputs as $input) {
    if (!is_numeric($input) || $input <= 0 || $input != intval($input)) {       
        print "Error: All grades must be positive whole numbers. <br> <br> ";
        print "<a href='add_grades.php'> Go Back </a>";
    exit;  // Stop execution if there's an error
   }
 }

// Drop the lowest quiz score and calculate quiz average
$quizzes = [$quiz1, $quiz2, $quiz3, $quiz4, $quiz5];
sort($quizzes);  // Sort quizzes in ascending order
array_shift($quizzes);  // Remove the lowest quiz
$quiz_avg = array_sum($quizzes) / 4;

// Calculate homework average
$homework_avg = ($homework1 + $homework2 + $homework3 + $homework4 + $homework5) / 5;

// Calculate final grade using weights
$finalGrade = ($homework_avg * 0.2) + ($quiz_avg * 0.1) + ($midTerm * 0.3) + ($finalProject * 0.4);
$finalGrade = round($finalGrade);  // Round to nearest whole number

// Insert grades into the database
$sql = "INSERT INTO grades (studentID, homework1, homework2, homework3, homework4, homework5, 
        quiz1, quiz2, quiz3, quiz4, quiz5, midTerm, finalProject, finalGrade)
        VALUES ('$studentID', '$homework1', '$homework2', '$homework3', '$homework4', '$homework5', 
        '$quiz1', '$quiz2', '$quiz3', '$quiz4', '$quiz5', '$midTerm', '$finalProject', '$finalGrade')";

if ($dbc->query($sql) === TRUE) {
    print "Grades added successfully! <br> <br>";
    print "<a href='view_grades.php'>View Final Grades</a>";
} else {
    print "Error: " . $sql . "<br>" . $dbc->error;
}

mysqli_close($dbc);
}
?>
