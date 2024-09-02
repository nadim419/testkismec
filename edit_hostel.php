<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Hostel</title>
    <?php
    session_start();
    include("head/header.php");
    include("menu.php");
    include("db.php");
    ?>
</head>
<body>

<?php
$update_success = false;
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $hostel_id = $_POST['hostel_id'];
    $hostel_addr = $_POST['hostel_addr'];
    $hostel_owner = $_POST['hostel_owner'];
    $hostel_phoneno = $_POST['hostel_phoneno'];
    $hostel_type = $_POST['hostel_type'];
    $hostel_availability = $_POST['hostel_availability'];
    $hostel_status = $_POST['hostel_status'];
    $hostel_maxtotal = $_POST['hostel_maxtotal'];
    $note = $_POST['note'];

    // Update hostel details
    $stmt = $conn->prepare("UPDATE tblhostel SET hostel_id = ?, hostel_addr = ?, hostel_owner = ?, hostel_phoneno = ?, hostel_type = ?, hostel_availability = ?, hostel_status = ?, hostel_maxtotal = ?, note = ? WHERE id = ?");
    $stmt->bind_param("sssssssisi", $hostel_id, $hostel_addr, $hostel_owner, $hostel_phoneno, $hostel_type, $hostel_availability, $hostel_status, $hostel_maxtotal, $note, $id);

    if ($stmt->execute()) {
        $update_success = true;
    } else {
        $error_message = "Failed to update hostel. Please try again.";
    }

    $stmt->close();
}

// Fetch hostel details
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT hostel_id, hostel_addr, hostel_owner, hostel_phoneno, hostel_type, hostel_availability, hostel_status, hostel_maxtotal, note FROM tblhostel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$hostel = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>


<div>
    <h2>Edit Hostel</h2>
    <?php if ($update_success): ?>
        <p>Hostel successfully updated!</p>
        
        <table class="success-table">
            <tr>
                <td><strong>Hostel Id:</strong></td>
                <td><?php echo htmlspecialchars($hostel_id); ?></td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td><?php echo htmlspecialchars($hostel_addr); ?></td>
            </tr>
            <tr>
                <td><strong>Owner:</strong></td>
                <td><?php echo htmlspecialchars($hostel_owner); ?></td>
            </tr>
            <tr>
                <td><strong>Phone Number:</strong></td>
                <td><?php echo htmlspecialchars($hostel_phoneno); ?></td>
            </tr>
            <tr>
                <td><strong>Type:</strong></td>
                <td><?php echo htmlspecialchars($hostel_type); ?></td>
            </tr>
            <tr>
                <td><strong>Availability:</strong></td>
                <td><?php echo htmlspecialchars($hostel_availability); ?></td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td><?php echo htmlspecialchars($hostel_status); ?></td>
            </tr>
            <tr>
                <td><strong>Total Students:</strong></td>
                <td><?php echo htmlspecialchars($hostel_maxtotal); ?></td>
            </tr>
            <tr>
                <td><strong>Note:</strong></td>
                <td><?php echo htmlspecialchars($note); ?></td>
            </tr>
        </table>

    <?php else: ?>
        <?php if ($error_message): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <table>
                <tr>        
                    <td><input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"></td>
                </tr>

                <tr>
                    <td>Hostel Id</td>
                    <td><input type="text" name="hostel_id" value="<?php echo htmlspecialchars($hostel['hostel_id']); ?>" placeholder="Hostel Id" required></td>
                </tr>

                <tr>
                    <td>Address</td>
                    <td><input type="text" name="hostel_addr" value="<?php echo htmlspecialchars($hostel['hostel_addr']); ?>" placeholder="Address" required></td>
                </tr>

                <tr>
                    <td>Owner</td>
                    <td><input type="text" name="hostel_owner" value="<?php echo htmlspecialchars($hostel['hostel_owner']); ?>" placeholder="Owner" required></td>
                </tr>

                <tr>
                    <td>Phone Number</td>
                    <td><input type="text" name="hostel_phoneno" value="<?php echo htmlspecialchars($hostel['hostel_phoneno']); ?>" placeholder="Phone Number" required></td>
                </tr>

                <tr>
                    <td>Type</td>
                    <td><input type="text" name="hostel_type" value="<?php echo htmlspecialchars($hostel['hostel_type']); ?>" placeholder="Type" required></td>
                </tr>

                <tr>
                    <td>Availability</td>
                    <td><input type="text" name="hostel_availability" value="<?php echo htmlspecialchars($hostel['hostel_availability']); ?>" placeholder="Availability" required></td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td><input type="text" name="hostel_status" value="<?php echo htmlspecialchars($hostel['hostel_status']); ?>" placeholder="Status" required></td>
                </tr>

                <tr>
                    <td>Total Students</td>
                    <td><input type="text" name="hostel_maxtotal" value="<?php echo htmlspecialchars($hostel['hostel_maxtotal']); ?>" placeholder="Total Students" required></td>
                </tr>

                <tr>
                    <td>Note</td>
                    <td><textarea name="note" placeholder="Note"><?php echo htmlspecialchars($hostel['note']); ?></textarea></td>
                </tr>

                <td><button type="green" value="Update Batch">Update</td>
            </table>

        </form>
    <?php endif; ?>
</div>

</body>
</html>