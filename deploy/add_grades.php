<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Grades</title>
</head>
<body>
    <h1>Add Grades for Students</h1>
    <form action = "submit_grades.php" method="POST">
        <label for = "studentID"> Select Student: </label>
        <select name = "studentID" id = "studentID">

            <?php
            // Include the db_connect.php file to access the getDatabaseConnection function
            include('db_connect.php');

            // Connect to the database using the function
            $dbc = getDatabaseConnection();

            // Check the connection
            if (!$dbc) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Perform the query to fetch students
            $result = mysqli_query($dbc, "SELECT studentID, name FROM students");

            // Check if the query was successful
            if ($result) {
                // Fetch and display each student
                while ($row = mysqli_fetch_assoc($result)) {
                    print "<option value='{$row['studentID']}'>{$row['name']}</option>";
                }
            } else {
                print "<option value=''>No students found</option>";
            }

            // Close the connection
            mysqli_close($dbc);
            ?>

        </select><br><br>

        <label for="homework1"> Homework 1: </label><input type="text" name="homework1" required><br>
        <label for="homework2"> Homework 2: </label><input type="text" name="homework2" required><br>
        <label for="homework3"> Homework 3: </label><input type="text" name="homework3" required><br>
        <label for="homework4"> Homework 4: </label><input type="text" name="homework4" required><br>
        <label for="homework5"> Homework 5: </label><input type="text" name="homework5" required><br><br>

        <label for="quiz1"> Quiz 1: </label><input type="text" name="quiz1" required><br>
        <label for="quiz2"> Quiz 2: </label><input type="text" name="quiz2" required><br>
        <label for="quiz3"> Quiz 3: </label><input type="text" name="quiz3" required><br>
        <label for="quiz4"> Quiz 4: </label><input type="text" name="quiz4" required><br>
        <label for="quiz5"> Quiz 5: </label><input type="text" name="quiz5" required><br><br>

        <label for="midterm"> Midterm: </label><input type="text" name="midTerm" required> <br> <br>
        <label for="final_project"> Final Project: </label><input type="text" name="finalProject" required><br><br>

        <button type="submit">Submit Grades</button>
    </form>
</body>
</html>