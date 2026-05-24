<?php
require_once '../includes/database.php';

$items = $conn->query("
    SELECT ri.*, it.type_name 
    FROM Rental_Item ri
    LEFT JOIN Item_Type it ON ri.item_type_id = it.item_type_id
    ORDER BY ri.item_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items - Table & Chair Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background: #f0f2f5; }
        .page-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
        }
        .table thead th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .stock-badge {
            background: #e5e7eb;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .low-stock {
            background: #fee2e2;
            color: #ef4444;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="page-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-boxes text-info"></i> Inventory Management</h3>
                <a href="add_item.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Item
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Type</th>
                            <th>Cost/Day</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($item = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?= $item['item_id'] ?></td>
                            <td><?= htmlspecialchars($item['item_name']) ?></td>
                            <td><?= $item['type_name'] ?? 'Uncategorized' ?></td>
                            <td>₱<?= number_format($item['individual_cost'], 2) ?></td>
                            <td>
                                <span class="stock-badge <?= $item['total_stock'] < 5 ? 'low-stock' : '' ?>">
                                    <?= $item['total_stock'] ?> units
                                </span>
                            </td>
                            <td>
                                <a href="edit_item.php?id=<?= $item['item_id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_item.php?id=<?= $item['item_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <a href="../index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>