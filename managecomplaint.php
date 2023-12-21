<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./managecomplaint.css">
    <title>Manage Complaints | Eco Enforce</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('http://localhost:8444/api/incidents/all?page=1&perPage=10', {
                headers: {
                    'Content-Type': 'application/json',
                    'role': role, // Send officerType in the headers
                }
            })
                .then(response => response.json())
                .then(data => {
                    populateTable(data.data);
                })
                .catch(error => console.error('Error fetching data:', error));

            function populateTable(data) {
                var table = document.getElementById('complaint-table');

                // Create table header
                var headerRow = table.insertRow(0);
                var headers = ["Complaint ID", "Complaint Name", "Date", "Location", "Description", ""];
                for (var i = 0; i < headers.length; i++) {
                    var th = document.createElement('th');
                    th.innerHTML = headers[i];
                    headerRow.appendChild(th);
                }

                // Populate table rows
                for (var i = 0; i < data.length; i++) {
                    var incident = data[i];
                    var row = table.insertRow(i + 1);
                    row.insertCell(0).innerHTML = incident.incidentId;
                    row.insertCell(1).innerHTML = incident.name;
                    row.insertCell(2).innerHTML = incident.createdAt;
                    row.insertCell(3).innerHTML = incident.location;
                    row.insertCell(4).innerHTML = incident.incident;
                    var deleteButton = createDeleteButton(incident);
                    row.insertCell(5).appendChild(deleteButton);
                }
            }

            function createDeleteButton(incident) {
                var button = document.createElement('button');
                button.innerHTML = 'Delete';
                button.addEventListener('click', function () {
                    var confirmDelete = confirm('Are you sure you want to delete Complaint ID: ' + incident.incidentId + '?');
                    if (confirmDelete) {
                        deleteIncident(incident.incidentId);
                    }
                });
                return button;
            }

            function deleteIncident(incidentId) {
                fetch('http://localhost:8444/api/admin/deleteincident/' + incidentId, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'role': role, // Send officerType in the headers
                    },
                })
                .then(response => response.json())
                .then(data => {
                    alert('Complaint ID ' + incidentId + ' deleted successfully.');
                    location.reload(); // Reload the page
                })
                location.reload();
            }
        });
    </script>
</head>
<body>
    <?php include('headerdash.html'); ?>
    <section class="manage-complaint-section">
        <h1>Manage Complaints</h1>

        <table id="complaint-table"></table>
        
    </section>
</body>
</html>