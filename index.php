<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management CRUD</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>


<div class="container mt-5">

    <h1 class="mb-4">Student Management</h1>
     <div class="d-flex justify-content-end mb-1"> 
        <a class="btn btn-primary" href="add.php">Add Student</a>
    </div>
    <table id="studentsTable" class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Aadhar</th>
                <th>Fee Group</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

    <script>
         $(document).ready(function() {
            fetchStudents();

            // Fetch all students
            function fetchStudents() {
                $.ajax({
                    type: "GET",
                    url: "read_students.php",
                    success: function(response) {
                        //console.log(response);
                        var students = JSON.parse(response);
                        //alert(students);
                        var rows = '';
                        students.forEach(function(student) {
                            rows += `
                                <tr>
                                    <td>${student.id}</td>
                                    <td><img src="${student.image}" alt="${student.name}" style="width: 50px; height: 50px;" class="img-fluid rounded-circle"></td>
                                    <td>${student.name}</td>
                                    <td>${student.mobile}</td>
                                    <td>${student.email}</td>
                                    <td>${student.aadhar}</td>
                                    <td>${student.fee_group ? student.fee_group : '0.00'}</td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" href="student_edit.php?id=${student.id}">Edit</a>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="${student.id}">Delete</button>
                                    </td>
                                </tr>`;
                        });
                        $('#studentsTable tbody').html(rows);
                    }
                });
            }

             // Delete student
            $(document).on('click', '.delete-btn', function() {
                var studentId = $(this).data('id');
                if (confirm('Are you sure you want to delete this student?')) {
                    $.ajax({
                         type: "POST",
                        url: "delete_student.php",                      
                        data: { id: studentId },
                        success: function(response) {
                            console.log(response);
                            alert(response.message);
                            fetchStudents();
                        }
                    });
                }
            });

        });
    </script>
</body>
</html>
