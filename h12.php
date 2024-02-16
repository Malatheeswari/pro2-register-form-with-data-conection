


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 400px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #FFC0CB; /* Baby Pink color */
        }


        .error {
            color: red;
            margin-top: 5px;
        }

        .error-border {
            border: 1px solid red;
        }

        input[type="submit"] {
            background-color: blue;
            border: 1px solid #0000FF;
            color: white;
            cursor: pointer;
        }

        input[type="reset"] {
            background-color: yellow;
            border: 1px solid #FFFF00;
            color: black;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Registration Form</h2>
        <form id="registrationForm" action="" method="post">
            <div class="form-group">
                <label for="fullName">fullName</label>
                <input type="text" id="fullName" name="fullName" >
                <span class="error" id="fullNameError"></span>
            </div>

            <div class="form-group">
                <label for="userName">userName</label>
                <input type="text" id="userName" name="userName">
                <span class="error" id="userNameError"></span>
            </div>

            <div class="form-group">
                <label for="email">email</label>
                <input type="text" id="email" name="email">
                <span class="error" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="phoneNumber">phoneNumber</label>
                <input type="text" id="phoneNumber" name="phoneNumber">
                <span class="error" id="phoneNumberError"></span>
            </div>

            <div class="form-group">
                <label for="password">password</label>
                <input type="password" id="password" name="password">
                <span class="error" id="passwordError"></span>
            </div>

            <div class="form-group">
                <label for="confirmPassword">confirmPassword</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
                <span class="error" id="confirmPasswordError"></span>
            </div>

            <div class="form-group">
                <input type="checkbox" id="termsAndConditions" name="termsAndConditions">
                <label for="termsAndConditions">I agree to the Terms and Conditions</label>
                <span class="error" id="termsAndConditionsError"></span>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </div>
        </form>
    </div>

    <?php
    // Database connection details
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "registration";

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to sanitize user inputs
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname = sanitize_input($_POST["fullName"]);
        $username = sanitize_input($_POST["userName"]);
        $email = sanitize_input($_POST["email"]);
        $phonenumber = sanitize_input($_POST["phoneNumber"]);
        $password = sanitize_input($_POST["password"]);
        

            // Insert user data into the database
           $sql = "INSERT INTO users (fullName, userName, email, phoneNumber, password) VALUES ('$fullname', '$username', '$email', '$phonenumber', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Close the database connection
        $conn->close();
    ?>


    <script>
        document.getElementById("registrationForm").addEventListener("submit", function (event) {
            let valid = true;

            function setError(element, errorMessage) {
                element.classList.add('error-border');
                element.nextElementSibling.textContent = errorMessage;
            }

            function clearError(element) {
                element.classList.remove('error-border');
                element.nextElementSibling.textContent = "";
            }

            // Full Name validation
            let fullName = document.getElementById("fullName");
            let fullNameError = document.getElementById("fullNameError");
            if (fullName.value.trim() === "") {
                setError(fullName, "Full Name is required");
                valid = false;
            } else {
                clearError(fullName);
            }

            // User Name validation
            let userName = document.getElementById("userName");
            let userNameError = document.getElementById("userNameError");
            if (userName.value.trim() === "") {
                setError(userName, "User Name is required");
                valid = false;
            } else {
                clearError(userName);
            }

            // Email validation
            let email = document.getElementById("email");
            let emailError = document.getElementById("emailError");
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (email.value.trim() === "" || !emailPattern.test(email.value)) {
                setError(email, "Enter a valid email address");
                valid = false;
            } else {
                clearError(email);
            }

            // Phone Number validation
            let phoneNumber = document.getElementById("phoneNumber");
            let phoneNumberError = document.getElementById("phoneNumberError");
            const phonePattern = /^\d{10}$/;
            if (phoneNumber.value.trim() === "" || !phonePattern.test(phoneNumber.value)) {
                setError(phoneNumber, "Enter a valid phone number (10 digits)");
                valid = false;
            } else {
                clearError(phoneNumber);
            }

            // Password validation
            let password = document.getElementById("password");
            let passwordError = document.getElementById("passwordError");
            if (password.value.length < 6) {
                setError(password, "Password must be at least 6 characters");
                valid = false;
            } else {
                clearError(password);
            }

            // Confirm Password validation
            let confirmPassword = document.getElementById("confirmPassword");
            let confirmPasswordError = document.getElementById("confirmPasswordError");
            if (confirmPassword.value.trim() === "") {
                setError(confirmPassword, "Confirm Password is required");
                valid = false;
            } else if (confirmPassword.value !== password.value) {
                setError(confirmPassword, "Passwords do not match");
                valid = false;
            } else {
                clearError(confirmPassword);
            }

            // Terms and Conditions validation
            let termsAndConditions = document.getElementById("termsAndConditions");
            let termsAndConditionsError = document.getElementById("termsAndConditionsError");
            if (!termsAndConditions.checked) {
                setError(termsAndConditions, "You must agree to the Terms and Conditions");
                valid = false;
            } else {
                clearError(termsAndConditions);
            }

            if (!valid) {
                event.preventDefault(); // Prevent form submission if there are validation errors
            }
        });
    </script>
</body>
</html>
