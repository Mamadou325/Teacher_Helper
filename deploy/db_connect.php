<?php
function getDatabaseConnection() {
    return mysqli_connect('localhost', 'csc350', 'xampp', 'grading_tool');
}
?>