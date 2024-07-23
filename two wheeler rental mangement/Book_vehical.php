<?php
session_start();
include('config.php');
include('functions.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Calculate total cost (for simplicity, assume price_per_day is fixed)
    $vehicle = getVehicleById($vehicle_id);
    $price_per_day = $vehicle['price_per_day'];
    $total_cost = calculateTotalCost($start_date, $end_date, $price_per_day);

    // Book the vehicle
    bookVehicle($user_id, $vehicle_id, $start_date, $end_date, $total_cost);

    echo "Vehicle booked successfully.";
}

// Function to calculate total cost based on start and end date
function calculateTotalCost($start_date, $end_date, $price_per_day) {
    // Calculate number of days between start_date and end_date
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $interval = $start->diff($end);
    $days = $interval->days + 1; // include end date in count

    // Calculate total cost
    $total_cost = $days * $price_per_day;
    return $total_cost;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Vehicle</title>
</head>
<body>
    <h2>Book Vehicle</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="vehicle_id" value="<?php echo $_GET['vehicle_id']; ?>">

        <label>Start Date:</label><br>
        <input type="date" name="start_date" required><br><br>

        <label>End Date:</label><br>
        <input type="date" name="end_date" required><br><br>

        <input type="submit" value="Book">
    </form>
</body>
</html>
