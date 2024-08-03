<!DOCTYPE html>
<html>
<head>
    <title>BMI Result</title>
</head>
<body>
    <h1>Your BMI Result</h1>
    <p>Age: {{ $age }}</p>
    <p>Gender: {{ $gender }}</p>
    <p>Your BMI: {{ $bmi }}</p>
    <p>Category: {{ $category }}</p>
    <a href="{{ route('bmi.form') }}">Calculate Again</a>
</body>
</html>
