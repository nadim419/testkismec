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
        $stmt = $conn->prepare("DELETE FROM tblhostel WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $delete_success = true;
        } else {
            $error_message = "Failed to delete hostel. Please try again.";
        }
        
        $stmt->close();
    }
}

// Fetch hostels
$stmt = $conn->prepare("SELECT id, hostel_id, hostel_addr, hostel_owner, hostel_phoneno, hostel_type, hostel_availability, hostel_status, hostel_maxtotal, note FROM tblhostel WHERE hostel_id LIKE ?");
$search_param = "%$search_query%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$hostels = $stmt->get_result();
?>

    <div>
        <h2>Hostel List</h2>

        <?php if (!isset($_GET['action']) || $_GET['action'] !== 'delete'): ?>
            <form method="post" action="">
                <input type="text" name="search_query" placeholder="Use hostel id to search ..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="blue" class="button blue">Search</button>
            </form>
        <?php endif; ?>

        <?php if ($delete_success): ?>
            <p>Hostel successfully deleted!</p>
            <meta http-equiv="refresh" content="2;url=list_hostel.php"> 

        <?php elseif ($error_message): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>

        <?php elseif (isset($_GET['action']) && $_GET['action'] === 'delete' && !isset($_GET['confirm_delete'])): ?>
            
            <p>Are you sure you want to delete this hostel?</p>
            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($_GET['id']); ?>&confirm_delete=yes'">Yes, delete</button>
            <button type="blue" onclick="location.href='list_hostel.php'">Cancel</button>

        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Hostel Id</th>
                        <th>Address</th>
                        <th>Owner</th>
                        <th>Phone Number</th>
                        <th>Type</th>
                        <th>Availability</th>
                        <th>Status</th>
                        <th>Total Students</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($hostel = $hostels->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hostel['id']); ?></td>
                        <td><?php echo htmlspecialchars($hostel['hostel_id']); ?></td>
                        <td><?php echo htmlspecialchars($hostel['hostel_addr']); ?></td>
                        <td><?php echo htmlspecialchars($hostel['hostel_owner']); ?></td>
                        <td><?php echo htmlspecialchars($hostel['hostel_phoneno']); ?></td>
                        <td><?php echo htmlspecialchars($hostel['hostel_type']); ?></td>
                        <td><?php echo htmlspecialchars($hostel['hostel_availability']); ?></td>
                        <td><?php echo htmlspecialchars($hostel['hostel_status']); ?></td>
                        <td><?php echo htmlspecialchars($hostel['hostel_maxtotal']); ?></td>
                        <td><?php echo htmlspecialchars($hostel['note']); ?></td>
                        <td>
                            <button type="green" onclick="location.href='edit_hostel.php?id=<?php echo htmlspecialchars($hostel['id']); ?>'">Edit</button>
                            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($hostel['id']); ?>'">Delete</button>
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
