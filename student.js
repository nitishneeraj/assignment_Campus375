$(document).ready(function() {
    // Function to validate the form
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

    // Add more Fee sections
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

        // Prepare form data
        var formData = new FormData(this);

        // for (var pair of formData.entries()) {
        //     console.log(pair[0] + ': ' + pair[1]);
        // }

        // AJAX request to submit the form data
        $.ajax({
          type: "POST",
          url: "submit_student.php",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            console.log('Server Response:', response);
            alert('Form submitted successfully!');
             $('#studentForm')[0].reset();
          },
          error: function (xhr, status, error) {
            console.log("Error: " + error);
          },
        });
 



    });
});
