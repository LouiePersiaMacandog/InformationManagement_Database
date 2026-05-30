<?php
require_once '../includes/database.php';

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact = $_POST['contact'];
    $location = $_POST['location'];
    
    $sql = "UPDATE Client SET first_name=?, last_name=?, contact=?, location=? WHERE client_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $contact, $location, $client_id);
    
    if ($stmt->execute()) {
        header("Location: list.php?success=Client updated successfully");
        exit();
    } else {
        $error = "Error updating client: " . $conn->error;
    }
}

// Get client data for editing
$client_id = $_GET['id'] ?? '';
if ($client_id) {
    $result = $conn->query("SELECT * FROM Client WHERE client_id = '$client_id'");
    $client = $result->fetch_assoc();
    if (!$client) {
        header("Location: list.php?error=Client not found");
        exit();
    }
} else {
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client - Table & Chair Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background: #f0f2f5; }
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            max-width: 550px;
            margin: 0 auto;
            margin-top: 50px;
        }
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.1);
        }
        .btn-update {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
        }
        .btn-cancel {
            background: #6b7280;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
        }
        .btn-cancel:hover {
            background: #4b5563;
            color: white;
        }
        .btn-update:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            color: white;
        }
        .alert {
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h3 class="mb-4">
                <i class="fas fa-edit text-warning"></i> Edit Client
            </h3>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <input type="hidden" name="client_id" value="<?= $client['client_id'] ?>">
                
                <div class="mb-3">
                    <label class="form-label">FIRST NAME</label>
                    <input type="text" name="first_name" class="form-control" 
                           value="<?= htmlspecialchars($client['first_name']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">LAST NAME</label>
                    <input type="text" name="last_name" class="form-control" 
                           value="<?= htmlspecialchars($client['last_name']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">CONTACT NUMBER</label>
                    <input type="text" name="contact" class="form-control" 
                           value="<?= htmlspecialchars($client['contact']) ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">LOCATION</label>
                    <input type="text" name="location" class="form-control" 
                           value="<?= htmlspecialchars($client['location']) ?>">
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-update">
                        <i class="fas fa-save"></i> Update Client
                    </button>
                    <a href="list.php" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>