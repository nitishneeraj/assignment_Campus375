<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

try {
    $stmt = $conn->query("SELECT * FROM students JOIN student_fees ON students.id = student_fees.student_id");
    $students = [];

    // Check if any students were fetched
    if ($stmt->num_rows > 0) {
        while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
            $students[] = $row;
        }
    }

    echo json_encode($students);

} catch (Exception $e) { 
    echo json_encode(['error' => $e->getMessage()]);
}
?>
