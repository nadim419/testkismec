<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
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
    $student_id = $_POST['student_id'] ?? '';
    $student_ic = $_POST['student_ic'] ?? '';
    $student_name = $_POST['student_name'] ?? '';
    $student_gender = $_POST['student_gender'] ?? '';
    $student_race = $_POST['student_race'] ?? '';
    $other_race = $_POST['other_race'] ?? '';
    $student_phone_no = $_POST['student_phone_no'] ?? '';
    $student_home_no = $_POST['student_home_no'] ?? '';
    $student_email = $_POST['student_email'] ?? '';
    $student_addr = $_POST['student_addr'] ?? '';
    $student_state = $_POST['student_state'] ?? '';
    $student_batch_id = $_POST['student_batch_id'] ?? '';
    $student_reg_date = $_POST['student_reg_date'] ?? '';
    $student_status = $_POST['student_status'] ?? '';
    $student_category = $_POST['student_category'] ?? '';
    $student_sponsor = $_POST['student_sponsor'] ?? '';
    $student_father_name = $_POST['student_father_name'] ?? '';
    $student_father_phone = $_POST['student_father_phone'] ?? '';
    $student_father_addr = $_POST['student_father_addr'] ?? '';
    $student_mother_name = $_POST['student_mother_name'] ?? '';
    $student_mother_phone = $_POST['student_mother_phone'] ?? '';
    $student_mother_addr = $_POST['student_mother_addr'] ?? '';
    $student_note = $_POST['student_note'] ?? '';

    if($student_race === 'Others'){
        $student_race = $other_race;
    }

    // Update user details
    $stmt = $conn->prepare("UPDATE tblstudent SET 
    student_id = ?, 
    student_ic = ?, 
    student_name = ?, 
    student_gender = ?, 
    student_race = ?, 
    student_phone_no = ?, 
    student_home_no = ?, 
    student_email = ?, 
    student_addr = ?, 
    student_state = ?, 
    student_batch_id = ?, 
    student_reg_date = ?, 
    student_status = ?, 
    student_category = ?, 
    student_sponsor = ?, 
    student_father_name = ?, 
    student_father_phone = ?, 
    student_father_addr = ?, 
    student_mother_name = ?, 
    student_mother_phone = ?, 
    student_mother_addr = ?, 
    student_note = ? 
WHERE id = ?");

$stmt->bind_param("ssssssssssssssssssssssi", 
    $student_id, 
    $student_ic, 
    $student_name, 
    $student_gender, 
    $student_race, 
    $student_phone_no, 
    $student_home_no, 
    $student_email, 
    $student_addr, 
    $student_state, 
    $student_batch_id, 
    $student_reg_date, 
    $student_status, 
    $student_category, 
    $student_sponsor, 
    $student_father_name, 
    $student_father_phone, 
    $student_father_addr, 
    $student_mother_name, 
    $student_mother_phone, 
    $student_mother_addr, 
    $student_note, 
    $id);


    if ($stmt->execute()) {
        $update_success = true;
    } else {
        $error_message = "Failed to update user. Please try again.";
    }

    $stmt->close();
}

// Fetch user details
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT student_id, student_ic, student_name, student_gender, student_race, 
student_phone_no, student_home_no, student_email, student_addr, student_state, student_batch_id, student_reg_date, 
student_status, student_category, student_sponsor, student_father_name, student_father_phone, student_father_addr, 
student_mother_name,student_mother_phone, student_mother_addr, student_note FROM tblstudent WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<div>
    <?php if ($update_success): ?>
        <p>Student successfully updated!</p>
        <table>
            <tr>
                <td>Student ID:</td>
                <td><?php echo htmlspecialchars($student_id); ?></td>
            </tr>
            <tr>
                <td>IC:</td>
                <td><?php echo htmlspecialchars($student_ic); ?></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><?php echo htmlspecialchars($student_name); ?></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td><?php echo htmlspecialchars($student_gender); ?></td>
            </tr>
            <tr>
                <td>Race:</td>
                <td><?php echo htmlspecialchars($student_race); ?></td>
            </tr>
            <tr>
                <td>Phone No:</td>
                <td><?php echo htmlspecialchars($student_phone_no); ?></td>
            </tr>
            <tr>
                <td>Home No:</td>
                <td><?php echo htmlspecialchars($student_home_no); ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo htmlspecialchars($student_email); ?></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><?php echo htmlspecialchars($student_addr); ?></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><?php echo htmlspecialchars($student_state); ?></td>
            </tr>
            <tr>
                <td>Batch ID:</td>
                <td><?php echo htmlspecialchars($student_batch_id); ?></td>
            </tr>
            <tr>
                <td>Registration Date:</td>
                <td><?php echo htmlspecialchars($student_reg_date); ?></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td><?php echo htmlspecialchars($student_status); ?></td>
            </tr>
            <tr>
                <td>Category:</td>
                <td><?php echo htmlspecialchars($student_category); ?></td>
            </tr>
            <tr>
                <td>Sponsor:</td>
                <td><?php echo htmlspecialchars($student_sponsor); ?></td>
            </tr>
            <tr>
                <td>Father's Name:</td>
                <td><?php echo htmlspecialchars($student_father_name); ?></td>
            </tr>
            <tr>
                <td>Father's Phone:</td>
                <td><?php echo htmlspecialchars($student_father_phone); ?></td>
            </tr>
            <tr>
                <td>Father's Address:</td>
                <td><?php echo htmlspecialchars($student_father_addr); ?></td>
            </tr>
            <tr>
                <td>Mother's Name:</td>
                <td><?php echo htmlspecialchars($student_mother_name); ?></td>
            </tr>
            <tr>
                <td>Mother's Phone:</td>
                <td><?php echo htmlspecialchars($student_mother_phone); ?></td>
            </tr>
            <tr>
                <td>Mother's Address:</td>
                <td><?php echo htmlspecialchars($student_mother_addr); ?></td>
            </tr>
            <tr>
                <td>Note:</td>
                <td><?php echo htmlspecialchars($student_note); ?></td>
            </tr>
        </table>

    <?php else: ?>

    <?php if ($error_message): ?>
        <p><?php echo htmlspecialchars($error_message); ?></p>
        
        <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <h2>Edit Student</h2>
                <table>
                    <tr>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    </tr>

                    <tr>
                        <td>Student ID:</td>
                        <td><input type="text" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>" placeholder="Student ID" required></td>
                    </tr>

                    <tr>
                        <td>IC:</td>
                        <td><input type="text" name="student_ic" value="<?php echo htmlspecialchars($student['student_ic']); ?>" placeholder="IC" required></td>
                    </tr>

                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="student_name" value="<?php echo htmlspecialchars($student['student_name']); ?>" placeholder="Name" required></td>
                    </tr>

                    <tr>
                        <td>Gender:</td>
                        <td>
                            <select name="student_gender" required>
                                <option value="">Gender</option>
                                <option value="male" <?php echo ($student['student_gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo ($student['student_gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </td>                    
                    </tr>

                    <tr>
                        <td>Race:</td>
                        <td>
                            <select id="student_race" name="student_race" onchange="toggleOtherRaceField()">
                                <option value="Malay" <?php echo ($student['student_race'] === 'Malay') ? 'selected' : ''; ?>>Malay</option>
                                <option value="Chinese" <?php echo ($student['student_race'] === 'Chinese') ? 'selected' : ''; ?>>Chinese</option>
                                <option value="Indian" <?php echo ($student['student_race'] === 'Indian') ? 'selected' : ''; ?>>Indian</option>
                                <option value="Others" <?php echo ($student['student_race'] === 'Others') ? 'selected' : ''; ?>>Others</option>
                            </select>
                        
                            <input type="text" name="other_race" id="other_race" placeholder="Other race" style="display:none;">
                        </td>
                    </tr>

                    <tr>
                        <td>Phone No:</td>
                        <td><input type="text" name="student_phone_no" value="<?php echo htmlspecialchars($student['student_phone_no']); ?>" placeholder="Phone No" required></td>
                    </tr>

                    <tr>
                        <td>Home No:</td>
                        <td><input type="text" name="student_home_no" value="<?php echo htmlspecialchars($student['student_home_no']); ?>" placeholder="Home No" required></td>
                    </tr>

                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="student_email" value="<?php echo htmlspecialchars($student['student_email']); ?>" placeholder="Email" required></td>
                    </tr>

                    <tr>
                        <td>Address:</td>
                        <td><input type="text"  name="student_addr"  value="<?php echo htmlspecialchars($student['student_addr']); ?>" placeholder="Address" required></td>
                    </tr>

                    <tr>
                        <td>State:</td>
                        <td><input type="text" name="student_state" value="<?php echo htmlspecialchars($student['student_state']); ?>" placeholder="State" required></td>
                    </tr>

                    <tr>
                        <td>Batch ID:</td>
                        <td><input type="text" name="student_batch_id" value="<?php echo htmlspecialchars($student['student_batch_id']); ?>" placeholder="Batch ID" required></td>
                    </tr>

                    <tr>
                        <td>Registration Date:</td>
                        <td><input type="date" name="student_reg_date" value="<?php echo htmlspecialchars($student['student_reg_date']); ?>" placeholder="Registration Date" required></td>
                    </tr>

                    <tr>
                        <td>Status:</td>
                        <td><input type="text" name="student_status" value="<?php echo htmlspecialchars($student['student_status']); ?>" placeholder="Status" required></td>
                    </tr>

                    <tr>
                        <td>Category:</td>
                        <td><input type="text" name="student_category" value="<?php echo htmlspecialchars($student['student_category']); ?>" placeholder="Category" required></td>
                    </tr>

                    <tr>
                        <td>Sponsor:</td>
                        <td><input type="text" name="student_sponsor" value="<?php echo htmlspecialchars($student['student_sponsor']); ?>" placeholder="Sponsor" required></td>
                    </tr>

                    <tr>
                        <td>Father's Name:</td>
                        <td><input type="text" name="student_father_name" value="<?php echo htmlspecialchars($student['student_father_name']); ?>" placeholder="Father's Name" required></td>
                    </tr>

                    <tr>
                        <td>Father's Phone:</td>
                        <td><input type="text" name="student_father_phone" value="<?php echo htmlspecialchars($student['student_father_phone']); ?>" placeholder="Father's Phone" required></td>
                    </tr>

                    <tr>
                        <td>Father's Address:</td>
                        <td><input type="text"  name="student_father_addr" value="<?php echo htmlspecialchars($student['student_father_addr']); ?>" placeholder="Father's Address" required ></td>
                    </tr>

                    <tr>
                        <td>Mother's Name:</td>
                        <td><input type="text" name="student_mother_name" value="<?php echo htmlspecialchars($student['student_mother_name']); ?>" placeholder="Mother's Name" required></td>
                    </tr>

                    <tr>
                        <td>Mother's Phone:</td>
                        <td><input type="text" name="student_mother_phone" value="<?php echo htmlspecialchars($student['student_mother_phone']); ?>" placeholder="Mother's Phone" required></td>
                    </tr>

                    <tr>
                        <td>Mother's Address:</td>
                        <td><input type="text" name="student_mother_addr" value="<?php echo htmlspecialchars($student['student_mother_addr']); ?>" placeholder="Mother's Address" required></td>
                    </tr>

                    <tr>
                        <td>Note:</td>
                        <td><textarea name="student_note" placeholder="Note"><?php echo htmlspecialchars($student['student_note']); ?></textarea></td>
                    </tr>

                    <tr>
                        <td><button type="green" value="Update Student">Update</button></td>
                        <td><button type="red" formaction="list_student.php" formnovalidate>Cancel</button></td>

                    </tr>
                </table>

            </form>
    <?php endif; ?>
</div>

</body>
</html>