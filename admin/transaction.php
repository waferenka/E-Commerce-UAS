<?php
// Koneksi ke database
require('../php/php.php');

// Handle DELETE request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM transactions WHERE transaction_id = $id");
}

// Fetch data from database
$query = "
    SELECT 
        t.transaction_id,
        u.nama AS name,
        t.order_id,
        t.transaction_status,
        t.gross_amount,
        ss.status_pengiriman AS shipping_status,
        t.payment_time,
        t.update_time,
        t.item_details
    FROM transactions t
    LEFT JOIN tbluser u ON t.user_id = u.id
    LEFT JOIN shipping_detail sd ON t.order_id = sd.order_id
    LEFT JOIN shipping_status ss ON sd.status_pengiriman = ss.id
";

$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }

    .btn {
        padding: 5px 10px;
        text-decoration: none;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-delete {
        color: red;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Transaction Management</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Order ID</th>
                    <th>Transaction Status</th>
                    <th>Gross Amount</th>
                    <th>Shipping Status</th>
                    <th>Payment Time</th>
                    <th>Update Time</th>
                    <th>Item Details</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['order_id']) ?></td>
                    <td><?= htmlspecialchars($row['transaction_status']) ?></td>
                    <td><?= htmlspecialchars($row['gross_amount']) ?></td>
                    <td><?= htmlspecialchars($row['shipping_status']) ?></td>
                    <td><?= htmlspecialchars($row['payment_time']) ?></td>
                    <td><?= htmlspecialchars($row['update_time']) ?></td>
                    <td><?= htmlspecialchars($row['item_details']) ?></td>
                    <td>
                        <a class="btn btn-delete" href="?delete=<?= $row['transaction_id'] ?>"
                            onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
<?php
$conn->close();
?>