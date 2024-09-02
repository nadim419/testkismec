<!DOCTYPE html>
<html lang="en">
<head>
    <title>Batch Management</title>
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
    $hostel_addr = $_POST['hostel_addr'] ?? '';
    $hostel_owner = $_POST['hostel_owner'] ?? '';
    $hostel_phoneno = $_POST['hostel_phoneno'] ?? '';
    $hostel_type = $_POST['hostel_type'] ?? '';
    $hostel_availability = $_POST['hostel_availability'] ?? '';
    $hostel_status = $_POST['hostel_status'] ?? '';
    $hostel_maxtotal = $_POST['hostel_maxtotal'] ?? '';
    $note = $_POST['note'] ?? '';


    if ($hostel_id && $hostel_addr &&  $hostel_owner && $hostel_phoneno && $hostel_type && $hostel_availability && $hostel_status && $hostel_maxtotal && $note) {
        $stmt = $conn->prepare("INSERT INTO tblhostel (hostel_id, hostel_addr, hostel_owner, hostel_phoneno, hostel_type, hostel_availability, 
        hostel_status, hostel_maxtotal, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssis", $hostel_id, $hostel_addr, $hostel_owner, $hostel_phoneno, $hostel_type, $hostel_availability, $hostel_status, $hostel_maxtotal, $note);

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
            <h2>Thank you!</h2>
        </div>
    </div>
    <table class="success-table">
        <tr>
            <td><h2>Hostel Id: </h2></td>
            <td><?php echo htmlspecialchars($hostel_id); ?>.</td>
        </tr>
        <tr>
            <td><h2>Address: </h2></td>
            <td><?php echo htmlspecialchars($hostel_addr); ?>.</td>
        </tr>
        <tr>
            <td><h2>Owner: </h2></td>
            <td><?php echo htmlspecialchars($hostel_owner); ?>.</td>
        </tr>
        <tr>
            <td><h2>Phone Number: </h2></td>
            <td><?php echo htmlspecialchars($hostel_phoneno); ?>.</td>
        </tr>
        <tr>
            <td><h2>Type: </h2></td>
            <td><?php echo htmlspecialchars($hostel_type); ?>.</td>
        </tr>
        <tr>
            <td><h2>Availability: </h2></td>
            <td><?php echo htmlspecialchars($hostel_availability); ?>.</td>
        </tr>
        <tr>
            <td><h2>Status: </h2></td>
            <td><?php echo htmlspecialchars($hostel_status); ?>.</td>
        </tr>
        <tr>
            <td><h2>Total Students: </h2></td>
            <td><?php echo htmlspecialchars($hostel_maxtotal); ?>.</td>
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
        <h2>Add Hostel</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <table>
                <tr>
                    <td><label>Hostel Id:</label></td>
                    <td><input type="text" name="hostel_id" placeholder="Hostel Id" required></td>
                </tr>

                <tr>
                    <td><label>Address:</label></td>
                    <td><input type="text" name="hostel_addr" placeholder="Address" required></td>
                </tr>

                <tr>
                    <td><label>Owner:</label></td>
                    <td><input type="text" name="hostel_owner" placeholder="Owner" required></td>
                </tr>

                <tr>
                    <td><label>Phone Number:</label></td>
                    <td><input type="text" name="hostel_phoneno" placeholder="Phone Number" required></td>
                </tr>

                <tr>
                    <td><label>Type:</label></td>
                    <td><input type="text" name="hostel_type" placeholder="Type" required></td>
                </tr>

                <tr>
                    <td><label>Availability:</label></td>
                    <td><input type="text" name="hostel_availability" placeholder="Availability" required></td>
                </tr>

                <tr>
                    <td><label>Status:</label></td>
                    <td><input type="text" name="hostel_status" placeholder="Status" required></td>
                </tr>

                <tr>
                    <td><label>Total Students:</label></td>
                    <td><input type="text" name="hostel_maxtotal" placeholder="Total Students" required></td>
                </tr>

                <tr>
                    <td><label>Note:</label></td>
                    <td><textarea name="note" placeholder="Note"></textarea></td>
                </tr>

                <td><button type="green" value="Add Hostel">Register</td>
            </table>
        </form>
    </div>
    <?php
    }
    ?>

</body>
</html>