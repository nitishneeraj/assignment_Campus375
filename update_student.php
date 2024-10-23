<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['studentId'];
    $studentName = $_POST['studentName'];
    $mobileNumber = $_POST['mobileNumber'];
    $emailId = $_POST['emailId'];
    $adharNumber = $_POST['adharNumber'];
    $studentImage = null;

    if (isset($_FILES['studentImage']) && $_FILES['studentImage']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['studentImage']['tmp_name'];
        $fileName = $_FILES['studentImage']['name'];
        $fileSize = $_FILES['studentImage']['size'];
        $fileType = $_FILES['studentImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        //store the image
        $uploadFileDir = 'uploads/';
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension; 
        $dest_path = $uploadFileDir . $newFileName;

        // Move 
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $studentImage = $dest_path; 
        } else {
            echo "Error moving the uploaded file.";
            exit;
        }
    }


    $sql = "UPDATE students SET 
                name = ?, 
                mobile = ?, 
                email = ?, 
                aadhar = ? " . 
                ($studentImage ? ", image = '$studentImage'" : "") . 
            " WHERE id = ?";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($studentImage) {
        $stmt->bind_param("ssssi", $studentName, $mobileNumber, $emailId, $adharNumber, $studentId);
    } else {
        $stmt->bind_param("sssi", $studentName, $mobileNumber, $emailId, $adharNumber, $studentId);
    }

    
    if ($stmt->execute()) {
        echo "Student updated successfully!";
       header("Location: index.php");
        exit;
    } else {
        echo "Error updating student: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
