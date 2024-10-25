CREATE DATABASE grading_tool;

USE grading_tool;

CREATE TABLE students (
    studentID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Create the grades table
CREATE TABLE grades (
    gradeID INT AUTO_INCREMENT PRIMARY KEY,
    studentID INT,
    homework1 DECIMAL(5, 2),
    homework2 DECIMAL(5, 2),
    homework3 DECIMAL(5, 2),
    homework4 DECIMAL(5, 2),
    homework5 DECIMAL(5, 2),
    quiz1 DECIMAL(5, 2),
    quiz2 DECIMAL(5, 2),
    quiz3 DECIMAL(5, 2),
    quiz4 DECIMAL(5, 2),
    quiz5 DECIMAL(5, 2),
    midTerm DECIMAL(5, 2),
    finalProject DECIMAL(5, 2),
    finalGrade DECIMAL(5, 2),
    FOREIGN KEY (studentID) REFERENCES students(studentID)
);

-- Insert a fixed number of students
INSERT INTO students (name, email) VALUES ('John Doe', 'johndoe@bmcc.cuny.edu'), ('Jane Smith', 'janesmith@bmcc.cuny.edu'), ('Alice Johnson', 'alicejohnson@bmcc.cuny.edu'), 
('Bob Brown', 'bobbrown@bmcc.cuny.edu');