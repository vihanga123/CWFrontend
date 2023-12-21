<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./register.css">
    <title>Register | Eco Enforce</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        sessionStorage.clear();

        function validateForm() {
            var username = $("#username").val();
            var password = $("#password").val();
            var email = $("#email_address").val();

            // Simple validation for username (non-empty)
            if (username.trim() === "") {
                alert("Please enter a username.");
                return false;
            }

            // Simple validation for password (non-empty)
            if (password.trim() === "") {
                alert("Please enter a password.");
                return false;
            }

            // Simple validation for email address
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            return true; // Form is valid
        }

        function submitRegisterForm() {
            if (validateForm()) {
                var username = $("#username").val();
                var password = $("#password").val();
                var email = $("#email_address").val();

                var user = {
                    username: username,
                    password: password,
                    email: email
                };

                $.ajax({
                    type: "POST",
                    contentType: "application/json",
                    url: "http://localhost:8444/api/users/register",
                    data: JSON.stringify(user),
                    dataType: 'text', // Expecting a plain text response
                    success: function (response) {
                        console.log("Registration response: " + response);
                        alert(response);

                        if (response.includes("successfully")) {
                            window.location.href = "/login.php";
                        }
                    },
                    error: function (error) {
                        console.log("Registration failed: " + error.responseText);
                    }
                });
            }
        }
    </script>
</head>
<body>
    <?php include('header.html'); ?>

    <div class="register-container">
        <div class="left-container">
            <img src="./images/Logo with background.png" alt="Login Image">
        </div>

        <div class="right-container">
            <h2>Register</h2>
            <p>Already have an account? <a href="./login.php">Login</a></p>

            <form action="#" method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <label for="email_address">Email Address</label>
                <input type="email" id="email_address" name="email_address" required>
            </form>

            <button type="button" onclick="submitRegisterForm()">Register</button>
        </div>
    </div>
</body>
</html>