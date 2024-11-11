<?php
// Function to fetch student grades
function fetchStudentGrades($dbc) {
    $grades = [];
    $result = mysqli_query($dbc, "SELECT students.name, grades.finalGrade FROM students JOIN grades ON students.studentID = grades.studentID");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $grades[] = $row;
        }
    }
    return $grades;
}

// Function to render the grades table
function renderGradesTable($grades) {
    if (empty($grades)) {
        return "<tr><td colspan='2'>No grades found.</td></tr>";
    }

    $output = '';
    foreach ($grades as $row) {
        $output .= "<tr><td>{$row['name']}</td><td>{$row['finalGrade']}</td></tr>";
    }
    return $output;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Final Grades</title>
</head>
<body>
    <h1>Final Grades for All Students</h1>
    <table border="1">
        <tr>
            <th>Student Name</th>
            <th>Final Grade</th>
        </tr>
        <?php
        include('db_connect.php');
        $dbc = getDatabaseConnection();
        if (!$dbc) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $grades = fetchStudentGrades($dbc);
        print renderGradesTable($grades);
        mysqli_close($dbc);
        ?>
    </table>
</body>
</html>
