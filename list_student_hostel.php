<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Hostel List</title>
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
        $stmt = $conn->prepare("DELETE FROM tblhostel_details WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $delete_success = true;
        } else {
            $error_message = "Failed to delete student hostel record. Please try again.";
        }
        
        $stmt->close();
    }
}

// Fetch student-hostel records
$stmt = $conn->prepare("SELECT id, hostel_id, student_id, checkin_date, checkout_date, status, note FROM tblhostel_details WHERE student_id LIKE ?");
$search_param = "%$search_query%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$student_hostels = $stmt->get_result();
?>

    <div>
        <h2>Student Hostel List</h2>

        <?php if (!isset($_GET['action']) || $_GET['action'] !== 'delete'): ?>
            <form method="post" action="">
                <input type="text" name="search_query" placeholder="Search Student Hostel..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="blue">Search</button>
                <button type="green" formaction="add_student_hostel.php" formnovalidate>Add Student Hostel</button>
            </form>
        <?php endif; ?>

        <?php if ($delete_success): ?>
            <p>Student hostel record successfully deleted!</p>
            <meta http-equiv="refresh" content="2;url=list_student_hostel.php">

        <?php elseif ($error_message): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>

        <?php elseif (isset($_GET['action']) && $_GET['action'] === 'delete' && !isset($_GET['confirm_delete'])): ?>
            
            <p>Are you sure you want to delete this student hostel record?</p>
            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($_GET['id']); ?>&confirm_delete=yes'">Yes, delete</button>
            <button type="blue" onclick="location.href='list_student_hostel.php'">Cancel</button>

        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hostel ID</th>
                        <th>Student ID</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student_hostel = $student_hostels->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student_hostel['id']); ?></td>
                        <td><?php echo htmlspecialchars($student_hostel['hostel_id']); ?></td>
                        <td><?php echo htmlspecialchars($student_hostel['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($student_hostel['checkin_date']); ?></td>
                        <td><?php echo htmlspecialchars($student_hostel['checkout_date']); ?></td>
                        <td><?php echo htmlspecialchars($student_hostel['status']); ?></td>
                        <td><?php echo htmlspecialchars($student_hostel['note']); ?></td>
                        <td>
                            <button type="green" onclick="location.href='edit_student_hostel.php?id=<?php echo htmlspecialchars($student_hostel['id']); ?>'">Edit</button>
                            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($student_hostel['id']); ?>'">Delete</button>
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
