<!DOCTYPE html>
<html lang="en">
<head>
    <title>User List</title>
    <?php
    session_start();
    include("head/header.php");
    include("menu.php");
    include("db.php");
    include 'head/container.php';
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
        $stmt = $conn->prepare("DELETE FROM tbluser WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $delete_success = true;
        } else {
            $error_message = "Failed to delete user. Please try again.";
        }
        
        $stmt->close();
    }
}

// Fetch users
$stmt = $conn->prepare("SELECT id, nama_id, nama_penuh, level_id, note FROM tbluser WHERE nama_penuh LIKE ?");
$search_param = "%$search_query%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$users = $stmt->get_result();
?>

    <div>
        <h2>User List</h2>

        <?php if (!isset($_GET['action']) || $_GET['action'] !== 'delete'): ?>
            <form method="post" action="">
                <input type="text" name="search_query" placeholder="Search User..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="blue">Search</button>
                <button type="green" formaction="add_user.php" formnovalidate>Add User</button>
            </form>
        <?php endif; ?>

        <?php if ($delete_success): ?>
            <p>User successfully deleted!</p>
            <meta http-equiv="refresh" content="2;url=list_user.php">

        <?php elseif ($error_message): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>

        <?php elseif (isset($_GET['action']) && $_GET['action'] === 'delete' && !isset($_GET['confirm_delete'])): ?>
            
            <p>Are you sure you want to delete this User?</p>
            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($_GET['id']); ?>&confirm_delete=yes'">Yes, delete</button>
            <button type="blue" onclick="location.href='list_user.php'">Cancel</button>

        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Level</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['nama_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['nama_penuh']); ?></td>
                        <td><?php echo htmlspecialchars($user['level_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['note']); ?></td>
                        <td>
                            <button type="green" onclick="location.href='edit_user.php?id=<?php echo htmlspecialchars($user['id']); ?>'">Edit</button>
                            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($user['id']); ?>'">Delete</button>
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
