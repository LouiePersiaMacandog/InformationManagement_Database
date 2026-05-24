<?php
require_once '../includes/database.php';

$itemTypes = $conn->query("SELECT * FROM Item_Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = generateId('I', 'Rental_Item', 'item_id');
    $item_name = $_POST['item_name'];
    $item_type_id = $_POST['item_type_id'];
    $individual_cost = $_POST['individual_cost'];
    $total_stock = $_POST['total_stock'];
    
    $stmt = $conn->prepare("INSERT INTO Rental_Item VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $item_id, $item_name, $item_type_id, $individual_cost, $total_stock);
    
    if ($stmt->execute()) {
        $success = "Item added successfully! ID: $item_id";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item - Table & Chair Rental</title>
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
        }
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
        }
        .btn-save {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 500;
        }
        .btn-cancel {
            background: #6b7280;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-card">
            <h3 class="mb-4">
                <i class="fas fa-box text-info"></i> Add Item
            </h3>
            
            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">ITEM NAME</label>
                    <input type="text" name="item_name" class="form-control" placeholder="e.g., Monobloc Chair" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">TYPE</label>
                    <select name="item_type_id" class="form-select" required>
                        <option value="">Select Type</option>
                        <?php while($type = $itemTypes->fetch_assoc()): ?>
                            <option value="<?= $type['item_type_id'] ?>"><?= $type['type_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">COST PER DAY (₱)</label>
                    <input type="number" name="individual_cost" class="form-control" placeholder="0.00" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">TOTAL STOCK</label>
                    <input type="number" name="total_stock" class="form-control" placeholder="Quantity" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Save Item
                    </button>
                    <button type="button" class="btn-cancel" onclick="location.href='manage.php'">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>