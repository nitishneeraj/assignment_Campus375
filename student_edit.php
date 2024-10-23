<?php
include 'db.php';

$id = $_REQUEST['id'];

$sql = "SELECT * FROM students JOIN student_fees ON students.id = student_fees.student_id WHERE students.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$student = []; 
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc(); 
} else {
    echo "No student found!";
    exit; 
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Student Details</h2>
        <div class="d-flex justify-content-end mb-1"> 
            <a class="btn btn-dark" href="index.php">Back</a>
        </div>
        <form id="studentForm" enctype="multipart/form-data" method="post">
            <input type="hidden" id="studentId" name="studentId" value="<?php echo $student['id']; ?>"> 
            
            <div class="form-group">
                <label for="studentName">Student Name</label>
                <input type="text" class="form-control" id="studentName" name="studentName" value="<?php echo $student['name']; ?>">
            </div>

            <div class="form-group">
                <label for="mobileNumber">Mobile Number</label>
                <input type="text" class="form-control" id="mobileNumber" name="mobileNumber" value="<?php echo $student['mobile']; ?>">
            </div>

            <div class="form-group">
                <label for="emailId">Email Id</label>
                <input type="email" class="form-control" id="emailId" name="emailId" value="<?php echo $student['email']; ?>">
            </div>

            <div class="form-group">
                <label for="adharNumber">Aadhar Number</label>
                <input type="text" class="form-control" id="adharNumber" name="adharNumber" value="<?php echo $student['aadhar']; ?>">
            </div>

            <div class="form-group">
                <label for="studentImage">Student Image</label>
                <input type="file" class="form-control-file" id="studentImage" name="studentImage">
                <img src="<?php echo $student['image']; ?>" alt="Student Image" width="100">
            </div>

            <h4>Student Fees</h4>
            <div id="feeSection">
                <div class="fee-group form-group">
                    <div class="row">
                        <div class="col-md-5">
                            <label>Fee Group</label>
                            <select class="form-control feeGroup" name="feeGroup[]">
                                <option value="Term-1" <?php echo ($student['fee_group'] == 'Term-1') ? 'selected' : ''; ?>>Term-1</option>
                                <option value="Term-2" <?php echo ($student['fee_group'] == 'Term-2') ? 'selected' : ''; ?>>Term-2</option>
                                <option value="Term-3" <?php echo ($student['fee_group'] == 'Term-3') ? 'selected' : ''; ?>>Term-3</option>
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label>Fee Head</label>
                            <select class="form-control feeHead" name="feeHead[]">
                                <option value="Admission Fee" <?php echo ($student['fee_head'] == 'Admission Fee') ? 'selected' : ''; ?>>Admission Fee</option>
                                <option value="Hostel Fee" <?php echo ($student['fee_head'] == 'Hostel Fee') ? 'selected' : ''; ?>>Hostel Fee</option>
                                <option value="Sport Fee" <?php echo ($student['fee_head'] == 'Sport Fee') ? 'selected' : ''; ?>>Sport Fee</option>
                                <option value="Music Fee" <?php echo ($student['fee_head'] == 'Music Fee') ? 'selected' : ''; ?>>Music Fee</option>
                            </select>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-success add-more">Add More</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            function validateForm() {
                var isValid = true;

                // Validate Student Name
                if ($('#studentName').val().trim() === '') {
                    alert('Student Name is required.');
                    isValid = false;
                }

                // Validate Mobile Number (10 digits)
                if (!/^\d{10}$/.test($('#mobileNumber').val())) {
                    alert('Enter a valid 10-digit Mobile Number.');
                    isValid = false;
                }

                // Validate Email Id
                var email = $('#emailId').val().trim();
                if (email === '' || !/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
                    alert('Enter a valid Email Id.');
                    isValid = false;
                }

                // Validate Aadhar Number (12 digits)
                if (!/^\d{12}$/.test($('#adharNumber').val())) {
                    alert('Enter a valid 12-digit Aadhar Number.');
                    isValid = false;
                }

                // Validate Image 
                if ($('#studentImage').get(0).files.length === 0) {
                    alert('Student Image is required.');
                    isValid = false;
                }

                // Validate Fee Groups and Fee Heads
                $('.feeGroup').each(function() {
                    if ($(this).val() === '') {
                        alert('Please select a Fee Group.');
                        isValid = false;
                    }
                });

                $('.feeHead').each(function() {
                    if ($(this).val() === '') {
                        alert('Please select a Fee Head.');
                        isValid = false;
                    }
                });

                return isValid;
            }

            $(document).on('click', '.add-more', function() {
                var newFeeSection = `
                <div class="fee-group form-group">
                    <div class="row">
                        <div class="col-md-5">
                            <label>Fee Group</label>
                            <select class="form-control feeGroup" name="feeGroup[]">
                                <option value="">Select Fee Group</option>
                                <option value="Term-1">Term-1</option>
                                <option value="Term-2">Term-2</option>
                                <option value="Term-3">Term-3</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label>Fee Head</label>
                            <select class="form-control feeHead" name="feeHead[]">
                                <option value="">Select Fee Head</option>
                                <option value="Admission Fee">Admission Fee</option>
                                <option value="Hostel Fee">Hostel Fee</option>
                                <option value="Sport Fee">Sport Fee</option>
                                <option value="Music Fee">Music Fee</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove">Remove</button>
                        </div>
                    </div>
                </div>`;
                $('#feeSection').append(newFeeSection);
            });

            // Remove Fee Section
            $(document).on('click', '.remove', function() {
                $(this).closest('.fee-group').remove();
            });

            // Form submission using AJAX
            $('#studentForm').on('submit', function(e) {
                e.preventDefault();

                // Validate form before submission
                if (!validateForm()) {
                    return;
                }

                var formData = new FormData(this);

                // for (var pair of formData.entries()) {
                //     console.log(pair[0] + ': ' + pair[1]);
                // }

                $.ajax({
                    type: "POST",
                    url: "update_student.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('Server Response:', response);
                        alert('Form submitted successfully!');
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error);
                    },
                });
            });
        });
    </script>
</body>
</html>
