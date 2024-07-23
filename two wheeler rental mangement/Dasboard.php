<?php
session_start();
include('config.php');
include('functions.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$vehicles = getAvailableVehicles();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Available Vehicles</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <h3>Available Vehicles</h3>
    <table border="1">
        <tr>
            <th>Vehicle Name</th>
            <th>Vehicle Type</th>
            <th>Price per Day</th>
            <th>Action</th>
        </tr>
        <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <td><?php echo $vehicle['vehicle_name']; ?></td>
                <td><?php echo $vehicle['vehicle_type']; ?></td>
                <td><?php echo $vehicle['price_per_day']; ?></td>
                <td><a href="book_vehicle.php?vehicle_id=<?php echo $vehicle['vehicle_id']; ?>">Book</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
