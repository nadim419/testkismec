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
        $stmt = $conn->prepare("DELETE FROM tblstudent WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $delete_success = true;
        } else {
            $error_message = "Failed to delete student. Please try again.";
        }
        
        $stmt->close();
    }
}

// Check if details view is requested
if (isset($_GET['id']) && !isset($_GET['action'])) {
    $id = $_GET['id'];

    // Fetch student details with specific columns
    $stmt = $conn->prepare("SELECT id, student_id, student_ic, student_name, student_gender, student_race,
     student_phone_no, student_home_no, student_email, student_addr, student_state, student_batch_id, 
     student_reg_date, student_status, student_category, student_sponsor, student_father_name, student_father_phone, 
     student_father_addr, student_mother_name, student_mother_phone, student_mother_addr, student_note FROM tblstudent WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    ?>

    <div class="student-detail">
        <div>
            <h2>Student Details</h2>
            <table class="table student-details">
                <tr>
                    <th>Student ID</th>
                    <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                    <th>Name</th>
                    <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                </tr>
                <tr>
                    <th>Student IC</th>
                    <td><?php echo htmlspecialchars($student['student_ic']); ?></td>
                    <th>Gender</th>
                    <td><?php echo htmlspecialchars($student['student_gender']); ?></td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td><?php echo htmlspecialchars($student['student_phone_no']); ?></td>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($student['student_email']); ?></td>
                </tr>
                <tr>
                    <th>Race</th>
                    <td colspan="3"><?php echo htmlspecialchars($student['student_race']); ?></td>
                </tr>
            </table>

        </div>

        <div>
            <h2>Additional Information</h2>
            <table class="table additional-details">
                <tr>
                    <th>Batch</th>
                    <td><?php echo htmlspecialchars($student['student_batch_id']); ?></td>
                    <th>Status</th>
                    <td><?php echo htmlspecialchars($student['student_status']); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo htmlspecialchars($student['student_addr']); ?></td>
                    <th>State</th>
                    <td><?php echo htmlspecialchars($student['student_state']); ?></td>
                </tr>
                <tr>
                    <th>Registered Date</th>
                    <td><?php echo htmlspecialchars($student['student_reg_date']); ?></td>
                    <th>Category</th>
                    <td><?php echo htmlspecialchars($student['student_category']); ?></td>
                </tr>
                <tr>
                    <th>Sponsor</th>
                    <td colspan="3"><?php echo htmlspecialchars($student['student_sponsor']); ?></td>
                </tr>
            </table>

        </div>

        <div>
            <h2>Family Information</h2>
            <table class="table parent-details">
                <tr>
                    <th>Father Name</th>
                    <td><?php echo htmlspecialchars($student['student_father_name']); ?></td>
                    <th>Mother Name</th>
                    <td><?php echo htmlspecialchars($student['student_mother_name']); ?></td>
                </tr>
                <tr>
                    <th>Father Phone</th>
                    <td><?php echo htmlspecialchars($student['student_father_phone']); ?></td>
                    <th>Mother Phone</th>
                    <td><?php echo htmlspecialchars($student['student_mother_phone']); ?></td>
                </tr>
                <tr>
                    <th>Father Address</th>
                    <td><?php echo htmlspecialchars($student['student_father_addr']); ?></td>
                    <th>Mother Address</th>
                    <td><?php echo htmlspecialchars($student['student_mother_addr']); ?></td>
                </tr>
                <tr>
                    <th>Home Number</th>
                    <td><?php echo htmlspecialchars($student['student_home_no']); ?></td>
                    <th>Note</th>
                    <td><?php echo htmlspecialchars($student['student_note']); ?></td>
                </tr>
            </table>

        </div>
    </div>

    <?php
} else {
    // Fetch students for the trimmed list
    $stmt = $conn->prepare("SELECT id, student_id, student_ic, student_name, student_gender, student_race, student_phone_no FROM tblstudent WHERE student_name LIKE ?");
    $search_param = "%$search_query%";
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $students = $stmt->get_result();
    ?>

    <div>
        <h2>Student List</h2>

        <?php if (!isset($_GET['action']) || $_GET['action'] !== 'delete'): ?>
            <form method="post" action="">
                <input type="text" name="search_query" placeholder="Search Student Name..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="blue">Search</button>
                <button type="green" formaction="add_student.php" formnovalidate>Add User</button>
            </form>
        <?php endif; ?>

        <?php if ($delete_success): ?>
            <p>User successfully deleted!</p>
            <meta http-equiv="refresh" content="2;url=list_student.php">
        <?php elseif ($error_message): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>
        <?php elseif (isset($_GET['action']) && $_GET['action'] === 'delete' && !isset($_GET['confirm_delete'])): ?>
            <p>Are you sure you want to delete this student?</p>
            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($_GET['id']); ?>&confirm_delete=yes'">Yes, delete</button>
            <button type="blue" onclick="location.href='list_student.php'">Cancel</button>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Id</th>
                        <th>Student IC</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Race</th>
                        <th>Phone number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $students->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['id']); ?></td>
                        <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($student['student_ic']); ?></td>
                        <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['student_gender']); ?></td>
                        <td><?php echo htmlspecialchars($student['student_race']); ?></td>
                        <td><?php echo htmlspecialchars($student['student_phone_no']); ?></td>
                        <td>
                            <button type="green" onclick="location.href='edit_student.php?id=<?php echo htmlspecialchars($student['id']); ?>'">Edit</button>
                            <button type="red" onclick="location.href='?action=delete&id=<?php echo htmlspecialchars($student['id']); ?>'">Delete</button>
                            <button type="blue" onclick="location.href='list_student.php?id=<?php echo htmlspecialchars($student['id']); ?>'">Details</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif;
        $stmt->close(); ?>
    </div>
    <?php
}
?>
</body>
</html>
