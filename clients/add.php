<?php
require_once '../includes/database.php';

$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM Client";
if ($search) {
    $sql .= " WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR contact LIKE '%$search%'";
}
$sql .= " ORDER BY client_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List - Table & Chair Rental</title>
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
            padding: 10px 20px;
        }
        .table {
            margin-top: 20px;
        }
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #e0e0e0;
            font-weight: 600;
        }
        .badge-active {
            background: #10b981;
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="page-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-users text-primary"></i> Client List</h3>
                <a href="add.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Client
                </a>
            </div>
            
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search clients by name, ID, or contact...">
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="clientTableBody">
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['client_id'] ?></td>
                            <td><?= htmlspecialchars($row['first_name']) ?></td>
                            <td><?= htmlspecialchars($row['last_name']) ?></td>
                            <td><?= htmlspecialchars($row['contact']) ?></td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['client_id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete.php?id=<?= $row['client_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this client?')">
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
    
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let search = this.value.toLowerCase();
            let rows = document.querySelectorAll('#clientTableBody tr');
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        });
    </script>
</body>
</html>