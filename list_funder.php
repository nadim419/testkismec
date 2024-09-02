<!DOCTYPE html>
<html lang="en">
<head>
    <title>Funder List</title>
</head>
<body>
<?php
include("head/header.php");
include("menu.php");
include("db.php");

$delete_success = false;
$error_message = '';
$search_query = $_POST['search_query'] ?? '';
$confirm_delete = $_GET['confirm_delete'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($confirm_delete === 'yes') {
        // Prepare and execute delete statement
        $stmt = $conn->prepare("DELETE FROM tblfunder WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $delete_success = true;
        } else {
            $error_message = "Failed to delete funder. Please try again.";
        }
        
        $stmt->close();
    }
}

// Fetch users
$stmt = $conn->prepare("SELECT id, funder, note FROM tblfunder WHERE funder LIKE ?");
$search_param = "%$search_query%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$funders = $stmt->get_result();
?>

    <div>
        <h2>Funder List</h2>
        <?php if (!isset($_GET['action']) || $_GET['action'] !== 'delete'): ?>
            <form method="post" action="">
                <input type="text" name="search_query" placeholder="Search funder..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="blue">Search</button>
                <button type="green" formaction="add_funder.php" formnovalidate>Add User</button>
            </form>
        <?php endif; ?>

        <?php if ($delete_success): ?>
            <p>Funder successfully deleted!</p>
            <meta http-equiv="refresh" content="2;url=list_funder.php">
            
        <?php elseif ($error_message): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>
        <?php elseif (isset($_GET['action']) && $_GET['action'] === 'delete' && !isset($_GET['confirm_delete'])): ?>
                <p>Are you sure you want to delete this funder?</p>
                <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($_GET['id']); ?>&confirm_delete=yes'">Yes, delete</button>
                <button type="blue" onclick="location.href='list_funder.php'">Cancel</button>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Funder</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($funder = $funders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($funder['id']); ?></td>
                        <td><?php echo htmlspecialchars($funder['funder']); ?></td>
                        <td><?php echo htmlspecialchars($funder['note']); ?></td>
                        <td>
                            <button type="green" onclick="location.href='edit_funder.php?id=<?php echo htmlspecialchars($funder['id']); ?>'">Edit</button>
                            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($funder['id']); ?>'">Delete</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <?php $stmt->close(); ?>
    </div>
</body>
</html>
