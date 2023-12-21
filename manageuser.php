<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./manageuser.css">
    <title>Manage Complains | Eco Enforce</title>
</head>
<body>
    <?php include('headerdash.html'); ?>
    <section class="manage-complaint-section">
        <h1>Manage Users</h1>

        <table>
            <?php 
            $data = array(
                array("001","Tim","time123@gmail.com"), 
                array("002","Jenna","jenna123@gmail.com"), 
                array("003","Hevin","hevin123@gmail.com"), 
                array("004","Nona","nona123@gmail.com"));

            echo "<tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th></th>
                <th></th>
            </tr>";

            foreach ($data as $x) {
                echo "<tr>
                    <td>$x[0]</td>
                    <td>$x[1]</td>
                    <td>$x[2]</td>
                    <td><button id=\"addrole\">Add Role</button></td>
                    <td><button id=\"delete\">Delete</button></td>
                </tr>";
            }
            ?>
        </table>
        
    </section>
    
</body>
</html>