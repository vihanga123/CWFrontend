<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./manageuser.css">
    <title>Manage Users | Eco Enforce</title>
    <style>
        /* Style for the custom dialog box */
        .custom-dialog {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        /* Style for the overlay background */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Style for the close button */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('http://localhost:8444/api/admin/users?page=1&perPage=20', {
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
                var table = document.querySelector('.manage-complaint-section table');

                // Create table header
                var headerRow = table.insertRow(0);
                var headers = ["User ID", "Username", "Email", "Role", "", ""];
                for (var i = 0; i < headers.length; i++) {
                    var th = document.createElement('th');
                    th.innerHTML = headers[i];
                    headerRow.appendChild(th);
                }

                // Populate table rows
                for (var i = 0; i < data.length; i++) {
                    var user = data[i];
                    var row = table.insertRow(i + 1);
                    row.insertCell(0).innerHTML = user.userid;
                    row.insertCell(1).innerHTML = user.username;
                    row.insertCell(2).innerHTML = user.email;
                    row.insertCell(3).innerHTML = user.role; // New Role column
                    var addRoleButton = document.createElement('button');
                    addRoleButton.innerHTML = 'Add Role';
                    // Use a closure to capture the correct user ID and role
                    addRoleButton.addEventListener('click', (function(userId, currentRole) {
                        return function() {
                            showAddRoleDialog(userId, currentRole);
                        };
                    })(user.userid, user.role));
                    row.insertCell(4).appendChild(addRoleButton);

                    var deleteButton = document.createElement('button');
                    deleteButton.innerHTML = 'Delete';
                    // Use a closure to capture the correct user ID
                    deleteButton.addEventListener('click', (function(userId) {
                        return function() {
                            confirmAndDeleteUser(userId);
                        };
                    })(user.userid));
                    row.insertCell(5).appendChild(deleteButton);
                }
            }

            function showAddRoleDialog(userId, currentRole) {
                var dialog = document.querySelector('.custom-dialog');
                var overlay = document.querySelector('.overlay');
                var selectRole = document.getElementById('selectRole');
                var closeBtn = document.querySelector('.close-btn');

                // Set the current role as the default option
                selectRole.value = currentRole;

                // Show the dialog and overlay
                dialog.style.display = 'block';
                overlay.style.display = 'block';

                // Close the dialog on clicking the close button
                closeBtn.addEventListener('click', function() {
                    dialog.style.display = 'none';
                    overlay.style.display = 'none';
                });

                // Close the dialog on clicking outside the dialog
                overlay.addEventListener('click', function() {
                    dialog.style.display = 'none';
                    overlay.style.display = 'none';
                });

                // Handle the update role button click
                document.getElementById('updateRoleBtn').addEventListener('click', function() {
                    var newRole = selectRole.value;

                    // Send a PUT request to update the role
                    fetch('http://localhost:8444/api/admin/userupdate', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'role': role,
                        },
                        body: JSON.stringify({
                            id: userId,
                            role: newRole,
                        }),
                    })
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            } else {
                                throw new Error('Network response was not ok');
                            }
                        })
                        .then(data => {
                            alert('New role for User ID ' + userId + ' is set to: ' + newRole);
                            location.reload();
                            dialog.style.display = 'none';
                            overlay.style.display = 'none';
                        })
                        .catch(error => console.error('Error updating role:', error));
                });
            }

            function confirmAndDeleteUser(userId) {
                var userConfirmation = window.confirm('Are you sure you want to delete this user?');
                if (userConfirmation) {
                    deleteUser(userId);
                }
            }

            function deleteUser(userId) {
                // Send a DELETE request to delete the user
                fetch(`http://localhost:8444/api/admin/deleteuser/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'role': role,
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            throw new Error('Network response was not ok');
                        }
                    })
                    .then(data => {
                        alert('User ID ' + userId + ' has been deleted.');
                        location.reload();
                    })
                    location.reload();
            }
        });
    </script>
</head>
<body>
    <?php include('headerdash.html'); ?>
    <section class="manage-complaint-section">
        <h1>Manage Users</h1>

        <table></table>

        <!-- Custom dialog box -->
        <div class="custom-dialog">
            <span class="close-btn">&times;</span>
            <h2>Update User Role</h2>
            <label for="selectRole">Select Role:</label>
            <select id="selectRole">
                <option value="OFFICERWILDLIFE">Wild Life Operator</option>
                <option value="OFFICERFORESTRY">Forestry Operator</option>
                <option value="ADMIN">Admin</option>
                <option value="USER">User</option>
            </select>
            <button id="updateRoleBtn">Update Role</button>
        </div>

        <!-- Overlay background -->
        <div class="overlay"></div>
        
    </section>
    
</body>
</html>