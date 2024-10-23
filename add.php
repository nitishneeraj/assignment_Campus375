<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Student Registration Form</h2>
        <div class="d-flex justify-content-end mb-1"> 
            <a class="btn btn-dark" href="index.php">Back</a>
        </div>
        <form id="studentForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="studentName">Student Name</label>
                <input type="text" class="form-control" id="studentName" name="studentName">
            </div>
            <div class="form-group">
                <label for="mobileNumber">Mobile Number</label>
                <input type="text" class="form-control" id="mobileNumber" name="mobileNumber">
            </div>
            <div class="form-group">
                <label for="emailId">Email Id</label>
                <input type="email" class="form-control" id="emailId" name="emailId">
            </div>
            <div class="form-group">
                <label for="adharNumber">Adhar Number</label>
                <input type="text" class="form-control" id="adharNumber" name="adharNumber">
            </div>
            <div class="form-group">
                <label for="studentImage">Student Image</label>
                <input type="file" class="form-control-file" id="studentImage" name="studentImage">
            </div>
            <h4>Student Fees</h4>
            <div id="feeSection">
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
                            <button type="button" class="btn btn-success add-more">Add More</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script src="student.js"></script>
</body>
</html>
