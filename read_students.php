<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

try {
    // Prepare and execute the query
    //$stmt = $conn->query("SELECT * FROM students");
    $stmt = $conn->query("SELECT * FROM students JOIN student_fees ON students.id = student_fees.student_id");

    
    // Initialize an empty array to hold student data
    $students = [];

    // Check if any students were fetched
    if ($stmt->num_rows > 0) {
        while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
            // Add each row to the students array
            $students[] = $row;
        }
    }

    // Return JSON response
    echo json_encode($students);

} catch (Exception $e) { // Changed from PDOException to Exception for mysqli
    // Return an error response in JSON format
    echo json_encode(['error' => $e->getMessage()]);
}
?>
