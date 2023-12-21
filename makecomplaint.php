<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./makecomplaint.css">
    <title>Make a Complaint | Eco Enforce</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function submitComplaint() {
            // Validate form inputs
            var name = document.getElementById("name").value;
            var description = document.getElementById("complaint-description").value;
            var category = document.getElementById("category").value;
            var location = document.getElementById("location").value;

            if (name.trim() === "") {
                alert("Please enter your name.");
                return;
            }

            if (description.trim() === "") {
                alert("Please enter a complaint description.");
                return;
            }

            if (category === "0") {
                alert("Please select a complaint type.");
                return;
            }

            if (location.trim() === "") {
                alert("Please enter the location.");
                return;
            }

            // Continue with AJAX request if all validations pass
            var username = sessionStorage.getItem('username');
            var incidentTypeId = parseInt(category, 10);

            var data = {
                "username": username,
                "name": name,
                "incident": description,
                "incidentTypeId": incidentTypeId,
                "location": location
            };

            $.ajax({
                type: "POST",
                contentType: "application/json",
                url: "http://localhost:8444/api/incidents/save",
                data: JSON.stringify(data),
                dataType: 'text',
                success: function (response) {
                    console.log("Registration response: " + response);
                    alert("You have successfully created the complaint");

                    if (response.includes("successfully")) {
                        console.log("Successfully submitted complaint");
                    }
                },
                error: function (error) {
                    console.log("Complaint failed: " + error.responseText);
                }
            });
        }
    </script>
</head>
<body>
    <?php include('header.html'); ?>

    <section class="complaint-section">
        <img src="./images/pexels-pixabay-40896.jpg" alt="About Us Image">
        <div class="image-text-overlay">
            <h1>Make a Complaint</h1>

            <div class="complaint-form">
                <input type="text" id="name" name="name" placeholder="Your Name" class="name-input">

                <textarea id="complaint-description" name="complaint-description" placeholder="Complaint Description" class="complaint-description"></textarea>

                <div class="additional-options">
                    <select name="category" id="category">
                        <option value="0">Select Type</option>
                        <option value="1">Wildlife Crime</option>
                        <option value="2">Forestry Crime</option>
                    </select>

                    <input type="text" id="location" name="location" placeholder="Location" class="location-input">

                    <button type="button" onclick="submitComplaint()">Make A Complaint</button>
                </div>
            </div>
        </div>
    </section>

    <section class="additional-section">
        <p>Complaints submitted through this website undergo processing and may be directed to the responsible wildlife and forest conservation institutions for potential investigation. The initiation of any investigation based on a filed complaint is at the discretion of the wildlife and forest conservation institutions receiving the information.</p>
        <button type="button">Check Status of a Complaint</button>
    </section>

    <?php include('footer.html'); ?>
</body>
</html>