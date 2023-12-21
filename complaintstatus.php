<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./complaintstatus.css">
    <title>Complaint Status | Eco Enforce</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
    <?php include('header.html'); ?>

    <section class="complaint-status-section">
        <h1>Latest Complaint Status</h1>
        <div>
            <label for="complainid">Complaint ID:</label><br>
            <input type="text" id="complainid" name="complainid" disabled><br>
            <label for="complaint">Complaint:</label><br>
            <input type="text" id="complaint" name="complaint" disabled><br><br>
            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" disabled><br><br>
            <label for="ipstatus">Investigation Progress Status:</label><br>
            <select id="ipstatus" name="ipstatus" disabled>
                <option value="PENDING">PENDING</option>
                <option value="IN PROGRESS">IN PROGRESS</option>
                <option value="COMPLETED">COMPLETED</option>
            </select><br><br>
            <label for="photos">Photos:</label><br>            
            <input id=photos class="image-input" type="file" name="files[]" accept="image/gif, image/jpeg, image/png" multiple disabled><br><br>
            <label for="timeframe">Time Frame:</label><br>
            <input type="text" id="timeframe" name="timeframe" placeholder='N/A' disabled><br><br>
            <label for="startdate">Start Date:</label><br>
            <input type="text" id="startdate" name="startdate" placeholder='N/A' disabled><br><br>
            <label for="progress">Progress:</label><br>
            <input type="text" id="progress" name="progress" placeholder='N/A (%)' disabled><br><br>
            <label for="comment">Evidence Comment:</label><br>
            <textarea id="comment" name="comment" placeholder='N/A' rows="5" disabled></textarea><br><br>
            <label for="photos">Uploaded Photo:</label><br> 
            <div id="photos-container"></div>
        </div>
        <script>
    function fetchData() {
        const username = sessionStorage.getItem('username');

        // Replace 'API_ENDPOINT' with the actual endpoint of your API
        fetch('http://localhost:8444/api/incidents/status', {
            headers: {
                'Content-Type': 'application/json',
                'username': username, // Send officerType in the headers
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            const incidentData = data.data[0];
            if(incidentData.incidentId == null){
                alert('Please create a complaint before checking status');
                window.location.href = './home.php';
            }

            // Set values for text fields
            document.getElementById('complainid').value = incidentData.incidentId;
            document.getElementById('complaint').value = incidentData.incident;
            document.getElementById('location').value = incidentData.location;
            document.getElementById('ipstatus').value = incidentData.status;
            document.getElementById('timeframe').value = incidentData.timeframe;
            document.getElementById('startdate').value = incidentData.startDate;
            document.getElementById('progress').value = incidentData.progress;
            document.getElementById('comment').value = incidentData.comment;
            displayImage('http://localhost:8444/api/incidents/' + incidentData.incidentId + '/image1');

            // Handle photos separately (if applicable)
            // Assuming 'photos' is an array of file paths
            if (data.photos && data.photos.length > 0) {
                document.getElementById('photos').value = data.photos.join(', ');
            }

            // You can add additional logic here to handle other fields

        })
        .catch(error => console.error('Error fetching data:', error));

    }
    function displayImage(imageUrl) {
        // Create an image element and set its source to the provided URL
        const imageElement = $('<img>').attr('src', imageUrl);
        imageElement.addClass('thumbnail'); 

        // Append the image element to the photos container (adjust the selector based on your HTML structure)
        $('#photos-container').append(imageElement);
    }

    fetchData();
</script>
    </section>

    <?php include('footer.html'); ?>
</body>



</html>