<!DOCTYPE html>
<html>
<head>
    <title>BMI Calculator</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <h1>BMI Calculator</h1>
    <form id="bmiForm">
        @csrf
        <div>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="20" max="120" required>
            <span class="error" id="ageError"></span>
        </div>
        <div>
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <span class="error" id="genderError"></span>
        </div>
        <div>
            <label for="height_feet">Height:</label>
            <input type="number" id="height_feet" name="height_feet" min="0" placeholder="Feet" required>
            <input type="number" id="height_inches" name="height_inches" min="0" max="11" placeholder="Inches" required>
            <span class="error" id="heightError"></span>
        </div>
        <div>
            <label for="weight">Weight (lbs):</label>
            <input type="number" id="weight" name="weight" step="0.1" required>
            <span class="error" id="weightError"></span>
        </div>
        <button type="submit">Calculate BMI</button>
    </form>
    <div id="result"></div>
    <div>
    <canvas id="bmiGauge" width="400" height="400"></canvas>
</div>
<div id="bmiResult"></div>
    
    <script>
        $(document).ready(function () {
            $('#bmiForm').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                // Clear previous errors and result
                $('.error').text('');
                $('#result').html('');

                // Get form data
                var formData = {
                    age: $('#age').val(),
                    gender: $('#gender').val(),
                    height_feet: $('#height_feet').val(),
                    height_inches: $('#height_inches').val(),
                    weight: $('#weight').val(),
                    _token: '{{ csrf_token() }}' // CSRF token
                };

                // Validate inputs
                let valid = true;

                if (formData.age < 20 || formData.age > 120) {
                    $('#ageError').text('Age must be between 20 and 120.');
                    valid = false;
                }

                if (!formData.gender) {
                    $('#genderError').text('Please select your gender.');
                    valid = false;
                }

                if (formData.height_feet == 0 && formData.height_inches == 0) {
                    $('#heightError').text('Please enter a valid height.');
                    valid = false;
                }

                if (formData.weight <= 0) {
                    $('#weightError').text('Please enter a valid weight.');
                    valid = false;
                }

                if (!valid) return;

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: '{{ route('bmi.calculate') }}',
                    data: formData,
                    success: function (response) {
                        // Display the result
                        $('#result').html(`
                            <h2>Your BMI Result</h2>
                            <p>Age: ${response.age}</p>
                            <p>Gender: ${response.gender}</p>
                            <p>Your BMI: ${response.bmi}</p>
                            <p>Category: ${response.category}</p>
                        `);
                    },
                    error: function (xhr) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
