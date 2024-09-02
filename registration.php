<!DOCTYPE html>
<html lang="en">
<head>
    <title>KISMEC</title>
</head>
<body>

 <?php 
 session_start();
 include("db.php");
 include("head/header.php");
 //include("menu.php");
 ?>

<link rel="stylesheet" href="head/login.css">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_id = $_POST['nama_id'];
    $password_id = $_POST['password_id'];
    $nama_penuh = $_POST['nama_penuh'];
    $level_id = $_POST['level_id'];
    $note = $_POST['note'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO tbluser (nama_id, password_id, nama_penuh, level_id, note) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama_id, $password_id, $nama_penuh, $level_id, $note);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<h2>Registration successful!</h2>";
    } else {
        echo "<h2>Error: " . $stmt->error . "</h2>";
    }

    $stmt->close();
    $conn->close();
}
?>

<h2>Registration</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table>
        <tr>
            <td><label for="nama_id">Username:</td>
            <td><input type="text" id="nama_id" name="nama_id" required></td>
        </tr>
        <tr>
            <td><label for="password_id">Password:</td>
            <td><input type="password" id="password_id" name="password_id" required></td>
        </tr>
        <tr>
            <td><label for="nama_penuh">Full Name:</td>
            <td><input type="text" id="nama_penuh" name="nama_penuh" required></td>
        </tr>
        <tr>
            <td><label for="level_id">Level:</td>
            <td><input type="text" id="level_id" name="level_id" required></td>
        </tr>
        <tr>
            <td><label for="note">Note:</td>
            <td><textarea id="note" name="note"></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Register</button></td>
        </tr>
    </table>
</form>


</body>
</html>