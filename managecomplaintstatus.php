<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./managecomplaintstatus.css">
    <title>Manage Complain Status | Eco Enforce</title>
    <script>
        const role = sessionStorage.getItem('role');
        document.addEventListener('DOMContentLoaded', function () {
            fetch('http://localhost:8444/api/incidents/allinprogress?page=1&perPage=10', {
                headers: {
                    'Content-Type': 'application/json',
                    'role': role,
                }
            })
                .then(response => response.json())
                .then(data => {
                    populateTable(data.data);
                })
                .catch(error => console.error('Error fetching data:', error));

            function populateTable(data) {
                var table = document.querySelector('.manage-complaint-status-section table');

                // Create table header
                var headerRow = table.insertRow(0);
                var headers = ["Complaint ID", "Location", "Progress", "Photos", "Time Frame", "Comment", ""];
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
                    row.insertCell(1).innerHTML = incident.location;
                    row.insertCell(2).innerHTML = incident.status;
                    var photoCell = row.insertCell(3);
                    fetchPhoto(incident.incidentId, photoCell); // Fetch and display photo
                    row.insertCell(4).innerHTML = incident.timeframe;
                    row.insertCell(5).innerHTML = incident.comment;
                    var deleteButton = document.createElement('button');
                    deleteButton.innerHTML = 'Delete';
                    deleteButton.addEventListener('click', function () {
                        var confirmDelete = confirm('Are you sure you want to delete Complaint ID: ' + incident.incidentId + '?');
                        if (confirmDelete) {
                            deleteIncident(incident.incidentId);
                        }
                    });
                    row.insertCell(6).appendChild(deleteButton);
                }
            }

            function fetchPhoto(incidentId, photoCell) {
                fetch('http://localhost:8444/api/incidents/' + incidentId + '/image1')
                    .then(response => {
                        if (response.ok) {
                            return response.blob();
                        } else {
                            throw new Error('Network response was not ok');
                        }
                    })
                    .then(blob => {
                        const imageUrl = URL.createObjectURL(blob);
                        const img = document.createElement('img');
                        img.src = imageUrl;
                        img.alt = 'Photo';
                        photoCell.appendChild(img);
                    })
                    .catch(error => console.error('Error fetching photo:', error));
            }

            function deleteIncident(incidentId) {
                fetch('http://localhost:8444/api/admin/deleteincident/' + incidentId, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'role': role,
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            return response.text(); // Handling non-JSON response
                        } else {
                            throw new Error('Network response was not ok');
                        }
                    })
                    .then(data => {
                        alert('Complaint ID ' + incidentId + ' deleted successfully.');
                        location.reload(); // Reload the page
                    })
                    .catch(error => console.error('Error deleting incident:', error));
            }
        });
    </script>
</head>
<body>
    <?php include('headerdash.html'); ?>
    <section class="manage-complaint-status-section">
        <h1>Manage Complaint Status</h1>

        <table></table>
        
    </section>
    
</body>
</html>