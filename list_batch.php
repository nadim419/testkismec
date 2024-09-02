<!DOCTYPE html>
<html lang="en">
<head>
    <title>User List</title>
    <?php
    session_start();
    include("head/header.php");
    include("menu.php");
    include("db.php");
    ?>
</head>
<body>
<?php

$delete_success = false;
$error_message = '';
$search_query = $_POST['search_query'] ?? '';
$confirm_delete = $_GET['confirm_delete'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($confirm_delete === 'yes') {
        // Prepare and execute delete statement
        $stmt = $conn->prepare("DELETE FROM tblbatch WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $delete_success = true;
        } else {
            $error_message = "Failed to delete batch. Please try again.";
        }
        
        $stmt->close();
    }
}

// Fetch batchss
$stmt = $conn->prepare("SELECT id, batch_id, batch_name, program_code, start_date, end_date, batch_status, category, note FROM tblbatch WHERE batch_id LIKE ?");
$search_param = "%$search_query%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$batchs = $stmt->get_result();
?>

    <div>
        <h2>Batch List</h2>

        <?php if (!isset($_GET['action']) || $_GET['action'] !== 'delete'): ?>
            <form method="post" action="">
                <input type="text" name="search_query" placeholder="Use batch id to search ..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="blue" class="button blue">Search</button>
            </form>
        <?php endif; ?>

        <?php if ($delete_success): ?>
            <p>Batch successfully deleted!</p>
            <meta http-equiv="refresh" content="2;url=list_batch.php"> 

        <?php elseif ($error_message): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>

        <?php elseif (isset($_GET['action']) && $_GET['action'] === 'delete' && !isset($_GET['confirm_delete'])): ?>
            
            <p>Are you sure you want to delete this batch?</p>
            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($_GET['id']); ?>&confirm_delete=yes'">Yes, delete</button>
            <button type="blue" onclick="location.href='list_batch.php'">Cancel</button>

        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Batch Id</th>
                        <th>Batch Name</th>
                        <th>Program Code</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Batch Status</th>
                        <th>Category</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($batch = $batchs->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($batch['id']); ?></td>
                        <td><?php echo htmlspecialchars($batch['batch_id']); ?></td>
                        <td><?php echo htmlspecialchars($batch['batch_name']); ?></td>
                        <td><?php echo htmlspecialchars($batch['program_code']); ?></td>
                        <td><?php echo htmlspecialchars($batch['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($batch['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($batch['batch_status']); ?></td>
                        <td><?php echo htmlspecialchars($batch['category']); ?></td>
                        <td><?php echo htmlspecialchars($batch['note']); ?></td>
                        <td>
                            <button type="green" onclick="location.href='edit_batch.php?id=<?php echo htmlspecialchars($batch['id']); ?>'">Edit</button>
                            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($batch['id']); ?>'">Delete</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif;
        $stmt->close(); ?>
    </div>

</body>
</html>
