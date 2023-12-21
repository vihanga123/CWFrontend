<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="./homedashboard.css">
    <title>Document</title>

</head>
<body>
    <?php include('headerdash.html'); ?>
    
    <div class="dashboard">
        <div class="left-container">
            <i class="uil uil-user-circle"></i>

            <ul>
                <li><a href="#"><i class="uil uil-th-large"></i> Dashboard</a></li>
                <li><a href="./manageuser.php"><i class="uil uil-user"></i> Manage Users</a></li>
                <li><a href="./managecomplaint.php"><i class="uil uil-edit"></i> Manage Complaints</a></li>
                <li><a href="./managecomplaintstatus.php"><i class="uil uil-newspaper"></i> Manage Complaints Status</a></li>
                <li><a href="./login.php"><i class="uil uil-signout"></i> Logout</a></li>
            </ul>
        </div>
        
        <div class="right-container">
            <h2>Environment Crime Complaint Management System</h2>
            
            <div class="grid-container">
                <div class="grid-item grid-one">
                    <h3><i class="uil uil-estate"></i> Welcome, Home</h3>
                    <p>Get Started!</p>
                </div>
                <div class="grid-item grid-two" >
                    <h3><i class="uil uil-users-alt"></i> Total Registered Users Count</h3>
                    <p id="totalUsersCount">Loading...</p>
                </div>
                <div class="grid-item grid-two" >
                    <h3><i class="uil uil-circle"></i> Pending Incident Count</h3>
                    <p id="pendingIncidentCount">Loading...</p>
                </div>
                <div class="grid-item grid-two">
                    <h3><i class="uil uil-user-check"></i> Total Registered Officers Count</h3>
                    <p id="totalOfficersCount">Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.html'); ?>

    <script>
if (sessionStorage.getItem("role") !== "ADMIN") {
    setTimeout(function() {
        window.location.href = "login.php";
    }, 100);
}
if (!sessionStorage.getItem("username")) {
    setTimeout(function() {
      window.location.href = "login.php";
    }, 100); 
  }
        // Make API calls and update HTML content
        async function fetchData(url, elementId) {
            try {
                const response = await fetch(url);
                const data = await response.json();
                const element = document.getElementById(elementId);
                if (element) {
                    element.innerHTML = `<p>${data}</p>`;
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // Update counts on page load
        document.addEventListener('DOMContentLoaded', () => {
            fetchData('http://localhost:8444/api/admin/total-users', 'totalUsersCount');
            fetchData('http://localhost:8444/api/admin/pending-incidents', 'pendingIncidentCount');
            fetchData('http://localhost:8444/api/admin/total-officers', 'totalOfficersCount');
        });
    </script>
</body>
</html>