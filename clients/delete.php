<?php
require_once '../includes/database.php';

// Get client_id from URL (GET method)
$client_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($client_id) {
    // Delete the client
    $sql = "DELETE FROM Client WHERE client_id = '$client_id'";
    if ($conn->query($sql)) {
        header("Location: list.php?success=Client deleted successfully");
        exit();
    } else {
        header("Location: list.php?error=Failed to delete client");
        exit();
    }
} else {
    header("Location: list.php?error=No client selected");
    exit();
}
?>