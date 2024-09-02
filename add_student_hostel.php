<!DOCTYPE html>
<html lang="en">
<head>
    <title>Batch Management - Add Student to Hostel</title>
    <?php
    session_start();
    include("db.php");
    include("head/header.php");
    include("menu.php");
    ?>
</head>
<body>
<?php

$add_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hostel_id = $_POST['hostel_id'] ?? '';
    $student_id = $_POST['student_id'] ?? '';
    $checkin_date = $_POST['checkin_date'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? '';
    $status = $_POST['status'] ?? '';
    $note = $_POST['note'] ?? '';

    if ($hostel_id && $student_id && $checkin_date && $status) {
        $stmt = $conn->prepare("INSERT INTO tblhostel_details (hostel_id, student_id, checkin_date, checkout_date, status, note) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $hostel_id, $student_id, $checkin_date, $checkout_date, $status, $note);

        if ($stmt->execute()) {
            $add_success = true;
        }

        $stmt->close();
    }
}

if ($add_success) {
    ?>
    <div>
        <div>
            <h2>Record Added Successfully!</h2>
        </div>
    </div>
    <table class="success-table">
        <tr>
            <td><h2>Hostel ID: </h2></td>
            <td><?php echo htmlspecialchars($hostel_id); ?>.</td>
        </tr>
        <tr>
            <td><h2>Student ID: </h2></td>
            <td><?php echo htmlspecialchars($student_id); ?>.</td>
        </tr>
        <tr>
            <td><h2>Check-In Date: </h2></td>
            <td><?php echo htmlspecialchars($checkin_date); ?>.</td>
        </tr>
        <tr>
            <td><h2>Check-Out Date: </h2></td>
            <td><?php echo htmlspecialchars($checkout_date); ?>.</td>
        </tr>
        <tr>
            <td><h2>Status: </h2></td>
            <td><?php echo htmlspecialchars($status); ?>.</td>
        </tr>
        <tr>
            <td><h2>Note: </h2></td>
            <td><?php echo htmlspecialchars($note); ?>.</td>
        </tr>
    </table>
    <?php
} else {
    ?>
    <div>
        <h2>Add Student to Hostel</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <table>
                <tr>
                    <td><label>Hostel ID:</label></td>
                    <td><input type="text" name="hostel_id" placeholder="Hostel ID" required></td>
                </tr>

                <tr>
                    <td><label>Student ID:</label></td>
                    <td><input type="text" name="student_id" placeholder="Student ID" required></td>
                </tr>

                <tr>
                    <td><label>Check-In Date:</label></td>
                    <td><input type="date" name="checkin_date" required></td>
                </tr>

                <tr>
                    <td><label>Check-Out Date:</label></td>
                    <td><input type="date" name="checkout_date"></td>
                </tr>

                <tr>
                    <td><label>Status:</label></td>
                    <td><input type="text" name="status" placeholder="Status" required></td>
                </tr>

                <tr>
                    <td><label>Note:</label></td>
                    <td><textarea name="note" placeholder="Note"></textarea></td>
                </tr>

                <td><button type="submit" value="Add Record">Register</td>
            </table>
        </form>
    </div>
    <?php
}
?>

</body>
</html>
