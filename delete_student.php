<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");        
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Student deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error deleting record']);
        }

        $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
