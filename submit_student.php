<?php

include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['studentName'];
    $mobile = $_POST['mobileNumber'];
    $email = $_POST['emailId'];
    $aadhar = $_POST['adharNumber'];

    // print_r($name.'--'.$mobile.'----'.$email.'---'.$aadhar);die('-error-');

    // Handling file upload (Image)
    $image = '';
    if (isset($_FILES['studentImage']) && $_FILES['studentImage']['error'] === UPLOAD_ERR_OK) {
    $imageTmpPath = $_FILES['studentImage']['tmp_name'];
    $imageName = $_FILES['studentImage']['name'];
    $uploadDir = 'uploads/';
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); 
    }

    $imagePath = $uploadDir . basename($imageName);

    // Move 
    if (move_uploaded_file($imageTmpPath, $imagePath)) {
        $image = $imagePath;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Image upload failed']);
        exit();
    }
}


    // Insert student data into students table
    $stmt = $conn->prepare("INSERT INTO students (name, mobile, email, aadhar, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $mobile, $email, $aadhar, $image);

    if ($stmt->execute()) {
        $studentId = $stmt->insert_id;

        // Inserting fee data (multiple entries)
        if (!empty($_POST['feeGroup']) && !empty($_POST['feeHead'])) {
            $feeGroups = $_POST['feeGroup'];
            $feeHeads = $_POST['feeHead'];

            $feeStmt = $conn->prepare("INSERT INTO student_fees (student_id, fee_group, fee_head) VALUES (?, ?, ?)");

            for ($i = 0; $i < count($feeGroups); $i++) {
                $feeGroup = $feeGroups[$i];
                $feeHead = $feeHeads[$i];

                $feeStmt->bind_param("iss", $studentId, $feeGroup, $feeHead);
                $feeStmt->execute();
            }
            $feeStmt->close();
        }

        echo json_encode(['status' => 'success', 'message' => 'Student data saved successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save student data.']);
    }

    $stmt->close();
}

$conn->close();
?>
