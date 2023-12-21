<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./selectcomplaint.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Select Complaint | Eco Enforce</title>
    
</head>

<body>    
    <section>
        <?php include('header.html'); ?>
        <h1>Select Complaint</h1>

        <div id="incidentButtonsContainer"></div>

    </section>

    <?php include('footer.html'); ?>

    <script>

        var info;
        // Function to set button text with the icon
        function setButtonText(buttonId, buttonText) {
            var button = document.getElementById(buttonId);
            button.innerHTML = '<i class="uil uil-invoice"></i> ' + buttonText;
        }

        // Function to fetch data from the API
        function fetchData() {
            const role = sessionStorage.getItem('role');
            info = (role === 'OFFICERWILDLIFE') ? "Wild Life Incident" : "Forestry Incident";
                

            // Replace 'API_ENDPOINT' with the actual endpoint of your API
            fetch('http://localhost:8444/api/incidents/all?page=1&perPage=20', {
                headers: {
                    'Content-Type': 'application/json',
                    'role': role, // Send officerType in the headers
                }
            })
            .then(response => response.json())
            .then(data => {
                createButtons(data.data);
            })
            .catch(error => console.error('Error fetching data:', error));
        }
        // Function to create buttons based on incident data
        function createButtons(incidents) {
            var buttonsContainer = document.getElementById('incidentButtonsContainer');

            incidents.forEach(function(incident,index) {
                var button = document.createElement('button');
                button.id = 'button_' + incident.incidentId; // Unique ID for each button
                button.textContent = (index + 1) + ' - ' + info + ' - ' + incident.name;                
                // Add click event listener if needed
                button.addEventListener('click', function() {
                    // Handle button click, you can use incident data here
                    console.log('Button clicked for incident ID: ' + incident.incidentId);
                    navigateToIncidentDetails(incident.incidentId);
                });

                // Append button to the container
                buttonsContainer.appendChild(button);
            });
        }
        function navigateToIncidentDetails(incidentId) {
        // Redirect to http://localhost/upgradeprogress.php with the incident ID as a query parameter
        window.location.href = 'http://localhost/upgradeprogress.php?incidentId=' + incidentId;
    }


        // Fetch data and create buttons on page load
        fetchData();

    </script>
</body>
</html>