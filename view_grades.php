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
        // Connect to the database
        $dbc = mysqli_connect("localhost", "csc350", "xampp", "grading_tool");

        if (!$dbc) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = mysqli_query($dbc, "SELECT students.name, grades.finalGrade FROM students JOIN grades ON students.studentID = grades.studentID");

        // Display the grades
        if ($result) {
            // Display the grades
            while ($row = mysqli_fetch_assoc($result)) {
                print "<tr><td>{$row['name']}</td><td>{$row['finalGrade']}</td></tr>"; 
            }
        } else {
            print "<tr><td colspan='2'>No grades found.</td></tr>"; 
        }

        mysqli_close($dbc);
        ?>
    </table>
</body>
</html>
