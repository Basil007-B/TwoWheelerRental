<?php
include('config.php');

function getAvailableVehicles() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM Vehicles WHERE availability = 1");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getVehicleById($vehicle_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Vehicles WHERE vehicle_id = :vehicle_id");
    $stmt->bindParam(':vehicle_id', $vehicle_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function bookVehicle($user_id, $vehicle_id, $start_date, $end_date, $total_cost) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Bookings (user_id, vehicle_id, start_date, end_date, total_cost) VALUES (:user_id, :vehicle_id, :start_date, :end_date, :total_cost)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':vehicle_id', $vehicle_id);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':total_cost', $total_cost);
    $stmt->execute();

    // Update vehicle availability
    $stmt = $conn->prepare("UPDATE Vehicles SET availability = 0 WHERE vehicle_id = :vehicle_id");
    $stmt->bindParam(':vehicle_id', $vehicle_id);
    $stmt->execute();
}
?>
