<!DOCTYPE html>
<html lang="en">

<head>
    <title>Funder Management</title>
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
        $funder = $_POST['funder'] ?? '';
        $note = $_POST['note'] ?? '';

        if ($funder && $note) {
            $stmt = $conn->prepare("INSERT INTO tblfunder (funder, note) VALUES (?, ?)");
            $stmt->bind_param("ss", $funder, $note);

            if ($stmt->execute()) {
                $add_success = true;
            }

            $stmt->close();
        }
    }

    if ($add_success) {
    ?>
        <div>
            <h2>Thank you!</h2>
            <table class="success-table">
                <tr>
                    <td><h2>Funder:</h2></td>
                    <td><?php echo htmlspecialchars($funder); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Note:</h2></td>
                    <td><?php echo htmlspecialchars($note); ?>.</td>
                </tr>
            </table>
        </div>
    <?php
    } else {
    ?>
        <div>
            <h2>Add Funder</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <table>
                    <tr>
                        <td>Funder:</td>
                        <td><input type="text" name="funder" placeholder="Funder" required></td>
                    </tr>
                    <tr>
                        <td>Note:</td>
                        <td><textarea name="note" placeholder="Note"></textarea></td>
                    </tr>
                    <tr>
                        <td><button type="green" value="Add Funder">Register</td>
                        <td><button type="red" formaction="list_funder.php" formnovalidate>Cancel</button></td>
                </table>
            </form>
        </div>
    <?php
    }
    ?>

</body>
</html>