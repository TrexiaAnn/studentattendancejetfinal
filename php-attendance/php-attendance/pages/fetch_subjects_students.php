<?php
// Include the necessary files and classes
require_once('db-connect.php');

// Check if the class ID is received
if(isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];

    // Fetch subjects and students enrolled in the specified class from the database
    // Modify this query according to your database schema
    $sql = "SELECT * FROM subjects WHERE class_id = $class_id"; // Example query, replace with your actual query
    $result = $conn->query($sql);

    // Initialize HTML variable to store the result
    $html = '';

    // Check if there are any subjects found
    if ($result->num_rows > 0) {
        // Loop through each subject
        while ($row = $result->fetch_assoc()) {
            $subject_name = $row['subject_name'];
            // Fetch students enrolled in this subject
            // Modify this query according to your database schema
            $student_sql = "SELECT * FROM students WHERE subject_id = $subject_id"; // Example query, replace with your actual query
            $student_result = $conn->query($student_sql);

            // Display the subject name
            $html .= "<h4>$subject_name</h4>";

            // Check if there are any students enrolled in this subject
            if ($student_result->num_rows > 0) {
                // Display the list of students
                $html .= "<ul>";
                while ($student_row = $student_result->fetch_assoc()) {
                    $student_name = $student_row['student_name'];
                    $html .= "<li>$student_name</li>";
                }
                $html .= "</ul>";
            } else {
                $html .= "<p>No students enrolled in this subject.</p>";
            }
        }
    } else {
        $html = "<p>No subjects found for this class.</p>";
    }

    // Echo the HTML response
    echo $html;
} else {
    echo "<p>Class ID not provided.</p>";
}
?>
