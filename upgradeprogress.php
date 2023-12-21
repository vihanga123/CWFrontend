<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./upgradeprogress.css">
    <title>Upgrade Progress | Eco Enforce</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <?php include('header.html'); ?>

    <section class="upgrade-progress-section">
        <h1>Upgrade Progress</h1>

        <div>
            <label for="complainid">Complaint ID:</label><br>
            <input type="text" id="complainid" name="complainid" disabled><br>
            <label for="complaint">Complaint:</label><br>
            <input type="text" id="complaint" name="complaint" disabled><br><br>
            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" disabled><br><br>
            <label for="ipstatus">Investigation Progress Status:</label><br>
            <select id="ipstatus" name="ipstatus">
                <option value="PENDING">PENDING</option>
                <option value="IN PROGRESS">IN PROGRESS</option>
                <option value="COMPLETED">COMPLETED</option>
            </select><br><br>
            <label for="photos">Photo:</label><br>            
            <input id=photos class="image-input" type="file" name="files[]" accept="image/gif, image/jpeg, image/png" multiple><br><br>

            <label for="timeframe">Time Frame:</label><br>
            <input type="text" id="timeframe" name="timeframe" placeholder='Enter Timeframe'><br><br>
            <label for="startdate">Start Date:</label><br>
            <input type="text" id="startdate" name="startdate" placeholder='Enter Date'><br><br>
            <label for="progress">Progress:</label><br>
            <input type="text" id="progress" name="progress" placeholder='Enter Progress (%)'><br><br>
            <label for="comment">Evidence Comment:</label><br>
            <textarea id="comment" name="comment" placeholder='Enter comment...' rows="5"></textarea><br><br>
            <label for="photos">Uploaded Photo:</label><br> 
            <div id="photos-container"></div>
            <input type="submit" value="Upgrade Progress" class="submit">
            
        </div>
    </section>
    <script>
        // Function to fetch incident details and populate the form
        function fetchAndPopulateIncidentDetails(incidentId) {
            // Replace 'API_ENDPOINT' with the actual endpoint of your API
            $.ajax({
                url: 'http://localhost:8444/api/incidents/' + incidentId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Populate form fields with the retrieved incident details
                    $('#complainid').val(data.incidentId);
                    $('#complaint').val(data.incident);
                    $('#location').val(data.location);
                    $('#ipstatus').val(data.status);
                    $('#timeframe').val(data.timeframe);
                    $('#startdate').val(data.startdate);
                    $('#progress').val(data.progress);
                    $('#comment').val(data.comment);
                    displayImage('http://localhost:8444/api/incidents/' + incidentId + '/image1');



                    // Add logic to handle photos, timeframe, and comment fields if needed
                },
                error: function(error) {
                    console.error('Error fetching incident details:', error);
                    // Handle errors if needed
                }
            });
        }

        // Function to extract incidentId from the URL query parameters
        function getIncidentIdFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('incidentId');
        }

        function validateForm() {
            // Validate Complaint ID (numeric, not empty)
            const complaintId = $('#complainid').val();
            if (!complaintId || isNaN(complaintId)) {
                alert('Please enter a valid Complaint ID.');
                return false;
            }

            // Validate Location (not empty)
            const location = $('#location').val();
            if (!location) {
                alert('Please enter a Location.');
                return false;
            }

            // Validate Time Frame (not empty)
            const timeframe = $('#timeframe').val();
            if (!timeframe) {
                alert('Please enter a Time Frame.');
                return false;
            }

            // Validate Start Date (not empty)
            const startDate = $('#startdate').val();
            if (!startDate) {
                alert('Please enter a Start Date.');
                return false;
            }

            // Validate Progress (numeric, between 0 and 100)
            const progress = $('#progress').val();
            if (!progress){
                alert('Please enter a valid Progress percentage (between 0 and 100).');
                return false;
            }
            const photosInput = $('#photos');
            if (!photosInput.val()) {
                alert('Please select an image.');
                return false;
            }


            // You can add more validations for other fields as needed

            // If all validations pass, submit the form
            submitForm();
            return true;
        }

        function submitForm(base64Image) {
            const incidentId = parseInt($('#complainid').val(), 10);
            const apiUrl = 'http://localhost:8444/api/incidents/incidentcomment';

            // Gather form data
            const formData = {
                incidentId: incidentId,
                location: $('#location').val(),
                status: $('#ipstatus').val(),
                timeframe: $('#timeframe').val(),
                startdate: $('#startdate').val(),
                progress: $('#progress').val(),
                comment: $('#comment').val(),
                image1: base64Image || null,
                // Add other fields as needed

                
                
            };

            // Send PUT request to update incident details
            $.ajax({
                url: apiUrl,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    console.log('Incident details updated successfully:', response); 
                    alert('Incident details updated successfully!');
                    window.location.reload(true);
                },
                error: function(error) {
                    console.error('Error updating incident details:', error);
                    // Handle errors if needed
                }
            });
            return false;
        }

        // Update the submit button to call validateForm() before submitting
        $(document).ready(function () {
    const incidentId = getIncidentIdFromUrl();
    if (incidentId) {
        fetchAndPopulateIncidentDetails(incidentId);
    }

    $('.submit').on('click', async function () {
        event.preventDefault();
        try {
            const base64Image = await getBase64Image();

            if (validateForm(base64Image)) {
                // If validation succeeds, construct and submit the form data
                submitForm(base64Image);
            }
        } catch (error) {
            console.error('Error getting base64 image:', error);
        }

        return false; // Prevent default form submission
    });
});
    function getBase64Image() {
    return new Promise((resolve, reject) => {
        const input = $('#photos')[0]; // Assuming your file input has an id of 'photos'

        // Check if a file is selected
        if (!input.files || !input.files[0]) {
            console.log('No photo selected.');
            resolve(null);
        }

        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            console.log('RESULT', reader.result);
            resolve(reader.result.split(',')[1]);
        };

        reader.onerror = function (error) {
            console.error('Error reading file:', error);
            reject(error);
        };

        reader.readAsDataURL(file);
    });
}
function displayImage(imageUrl) {
        // Create an image element and set its source to the provided URL
        const imageElement = $('<img>').attr('src', imageUrl);
        imageElement.addClass('thumbnail'); 

        // Append the image element to the photos container (adjust the selector based on your HTML structure)
        $('#photos-container').append(imageElement);
    }
    </script>

    <?php include('footer.html'); ?>
</body>

</html>