<?php

// Include the db_connect.php file to access the getDatabaseConnection function
include('db_connect.php');

// Function to validate grades
function validateGrades($grades) {
    foreach ($grades as $input) {
        if (!is_numeric($input) || $input <= 0 || $input != intval($input)) {
            return "Error: All grades must be positive whole numbers. <br> <br>";
        }
    }
    return true;
}

// Function to calculate quiz average (after dropping the lowest score)
function calculateQuizAverage($quizzes) {
    sort($quizzes);  // Sort quizzes in ascending order
    array_shift($quizzes);  // Remove the lowest quiz
    return array_sum($quizzes) / count($quizzes);  // Return average of remaining quizzes
}

// Function to calculate homework average
function calculateHomeworkAverage($homeworkGrades) {
    return array_sum($homeworkGrades) / count($homeworkGrades);
}

// Function to calculate final grade
function calculateFinalGrade($homeworkAvg, $quizAvg, $midTerm, $finalProject) {
    return round(($homeworkAvg * 0.2) + ($quizAvg * 0.1) + ($midTerm * 0.3) + ($finalProject * 0.4));
}

// Function to save grades to the database
function saveGradesToDatabase($dbc, $studentID, $homework, $quizzes, $midTerm, $finalProject, $finalGrade) {
    $sql = "INSERT INTO grades (studentID, homework1, homework2, homework3, homework4, homework5, 
        quiz1, quiz2, quiz3, quiz4, quiz5, midTerm, finalProject, finalGrade)
        VALUES ('$studentID', '$homework[0]', '$homework[1]', '$homework[2]', '$homework[3]', '$homework[4]',
                '$quizzes[0]', '$quizzes[1]', '$quizzes[2]', '$quizzes[3]', '$quizzes[4]',
                '$midTerm', '$finalProject', '$finalGrade')";
    if ($dbc->query($sql) === TRUE) {
        return "Grades added successfully! <br> <br> ";
    } else {
        return "Error: " . $sql . "<br>" . $dbc->error;
    }
}

// Main code execution
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $studentID = $_POST['studentID'];
    $homework = [
        $_POST['homework1'], $_POST['homework2'], $_POST['homework3'], $_POST['homework4'], $_POST['homework5']
    ];
    $quizzes = [
        $_POST['quiz1'], $_POST['quiz2'], $_POST['quiz3'], $_POST['quiz4'], $_POST['quiz5']
    ];
    $midTerm = $_POST['midTerm'];
    $finalProject = $_POST['finalProject'];

    // Validate the grades
    $validationResult = validateGrades(array_merge($homework, $quizzes, [$midTerm, $finalProject]));
    if ($validationResult !== true) {
        print $validationResult;
        print "<a href='add_grades.php'> Go Back </a>";
        exit;  // Stop execution if there's an error
    }

    // Calculate averages and final grade
    $quizAvg = calculateQuizAverage($quizzes);
    $homeworkAvg = calculateHomeworkAverage($homework);
    $finalGrade = calculateFinalGrade($homeworkAvg, $quizAvg, $midTerm, $finalProject);

    // Save the grades to the database
    $dbc = getDatabaseConnection();
    $resultMessage = saveGradesToDatabase($dbc, $studentID, $homework, $quizzes, $midTerm, $finalProject, $finalGrade);

    // Output result
    print $resultMessage;
    print "<a href='view_grades.php'>View Final Grades</a>";

    mysqli_close($dbc);
}
?>
