<?php
/**
 * LAPTOP 1 - API to get drivers for sending to Laptop 2
 * This endpoint returns all drivers in the format needed for Laptop 2
 */

header('Content-Type: application/json');

try {
    // Database connection
    $conn = new mysqli("10.119.240.136", "root", "", "byahero_db");
    
    if ($conn->connect_error) {
        echo json_encode([
            'success' => false,
            'message' => 'Database connection failed: ' . $conn->connect_error,
            'drivers' => []
        ]);
        exit;
    }
    
    // Handle GET request - Return drivers
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_drivers') {
        // Query to get driver data
        $sql = "SELECT 
                    id,
                    CONCAT('DRV', LPAD(id, 4, '0')) as driver_id,
                    name,
                    license_number,
                    contact_number,
                    status
                FROM drivers 
                ORDER BY created_at DESC";
        
        $result = $conn->query($sql);
        
        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Query error: ' . $conn->error,
                'drivers' => []
            ]);
            exit;
        }
        
        $drivers = [];
        while ($row = $result->fetch_assoc()) {
            $drivers[] = [
                'id' => (int)$row['id'],
                'driver_id' => $row['driver_id'],
                'name' => $row['name'],
                'license_number' => $row['license_number'],
                'contact_number' => $row['contact_number'],
                'status' => $row['status']
            ];
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Retrieved ' . count($drivers) . ' drivers',
            'drivers' => $drivers,
            'count' => count($drivers)
        ]);
        exit;
    }
    
    // Handle POST request - Send drivers to Laptop 2
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'send_drivers') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            exit;
        }
        
        // Get Laptop 2 IP from config or parameter
        $laptop2_ip = $_GET['laptop2_ip'] ?? (getenv('LAPTOP2_IP') ?: '192.168.1.5');
        $laptop2_url = "http://" . $laptop2_ip . "/driver_profile.php?action=receive_drivers";
        
        // Send to Laptop 2
        $json_data = json_encode($data);
        
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => $json_data,
                'timeout' => 10
            ]
        ]);
        
        $response = @file_get_contents($laptop2_url, false, $context);
        
        if ($response === false) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to send to Laptop 2 at ' . $laptop2_url
            ]);
            exit;
        }
        
        $result = json_decode($response, true);
        echo json_encode($result);
        exit;
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage()
    ]);
}

?>
