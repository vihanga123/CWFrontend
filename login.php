<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <title>Login | Eco Enforce</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        sessionStorage.clear();

        function submitLoginForm() {
            // Get values from the form
            var username = $('#username').val();
            var password = $('#password').val();

            // Basic client-side validation
            if (!username || !password) {
                alert("Please enter both username and password.");
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'http://localhost:8444/api/users/login', true);
            xhr.withCredentials = true;
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        console.log("Login successful");

                        if (response && response.role) {
                            var role = response.role;
                            var username = response.username;

                            sessionStorage.setItem('role', role);
                            sessionStorage.setItem('username', username);

                            if (role === "ADMIN") {
                                window.location.href = "/homedashboard.php";
                            } else if (role === "USER") {
                                window.location.href = "/home.php";
                            } else if (role === "OFFICERFORESTRY" || role === "OFFICERWILDLIFE") {
                                window.location.href = "/viewcomplaint.php";
                            } else {
                                console.log("Unknown role: " + role);
                            }
                            console.log(response)
                        } else {
                            console.log("Invalid response format");
                        }
                        var headers = xhr.getAllResponseHeaders();
                        console.log("Response Headers:", headers);
                    } else {
                        console.error("Login failed: " + xhr.statusText);
                        alert("Login failed. Please check your credentials and try again.");
                    }
                }
            };

            var user = {
                "username": username,
                "password": password
            };

            xhr.send(JSON.stringify(user));

            event.preventDefault();
        }
    </script>
</head>
<body>
    <?php include('header.html'); ?>

    <div class="login-container">
        <div class="left-container">
            <img src="./images/Logo with background.png" alt="Login Image">
        </div>

        <div class="right-container">
            <h2>Login</h2>
            <p>Don't have an account? <a href="./register.php">Register</a></p>

            <form action="#" method="post">
                <label for="username" >Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </form>

            <button type="button" onclick="submitLoginForm()">Login</button>
        </div>
    </div>
</body>
</html>