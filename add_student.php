<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Management</title>
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
    

    if ($student_id && $student_ic && $student_name && $student_gender && $student_race && $student_phone_no 
    && $student_home_no && $student_email && $student_addr && $student_state && $student_batch_id && $student_reg_date 
    && $student_status && $student_category && $student_sponsor && $student_father_name && $student_father_phone 
    && $student_father_addr && $student_mother_name && $student_mother_phone && $student_mother_addr&& $student_note) {
        $stmt = $conn->prepare("INSERT INTO tblstudent (
            student_id, 
            student_ic, 
            student_name, 
            student_gender, 
            student_race, 
            student_phone_no, 
            student_home_no, 
            student_email, 
            student_addr, 
            student_state, 
            student_batch_id, 
            student_reg_date, 
            student_status, 
            student_category, 
            student_sponsor, 
            student_father_name, 
            student_father_phone, 
            student_father_addr, 
            student_mother_name, 
            student_mother_phone, 
            student_mother_addr, 
            student_note
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");
    
        $stmt->bind_param("ssssssssssssssssssssss", 
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
            $student_note
        );
    
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
            <table>
                <tr>
                    <td><h2>Student ID:</h2></td>
                    <td><?php echo htmlspecialchars($student_id); ?>.</td>
                </tr>
                <tr>
                    <td><h2>IC:</h2></td>
                    <td><?php echo htmlspecialchars($student_ic); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Name:</h2></td>
                    <td><?php echo htmlspecialchars($student_name); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Gender:</h2></td>
                    <td><?php echo htmlspecialchars($student_gender); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Race:</h2></td>
                    <td><?php echo htmlspecialchars($student_race); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Phone No:</h2></td>
                    <td><?php echo htmlspecialchars($student_phone_no); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Home Phone No.:</h2></td>
                    <td><?php echo htmlspecialchars($student_home_no); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Email:</h2></td>
                    <td><?php echo htmlspecialchars($student_email); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Address:</h2></td>
                    <td><?php echo htmlspecialchars($student_addr); ?>.</td>
                </tr>
                <tr>
                    <td><h2>State:</h2></td>
                    <td><?php echo htmlspecialchars($student_state); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Batch ID:</h2></td>
                    <td><?php echo htmlspecialchars($student_batch_id); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Registration Date:</h2></td>
                    <td><?php echo htmlspecialchars($student_reg_date); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Status:</h2></td>
                    <td><?php echo htmlspecialchars($student_status); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Category:</h2></td>
                    <td><?php echo htmlspecialchars($student_category); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Sponsor:</h2></td>
                    <td><?php echo htmlspecialchars($student_sponsor); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Father's Name:</h2></td>
                    <td><?php echo htmlspecialchars($student_father_name); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Father's Phone:</h2></td>
                    <td><?php echo htmlspecialchars($student_father_phone); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Father's Address:</h2></td>
                    <td><?php echo htmlspecialchars($student_father_addr); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Mother's Name:</h2></td>
                    <td><?php echo htmlspecialchars($student_mother_name); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Mother's Phone No.:</h2></td>
                    <td><?php echo htmlspecialchars($student_mother_phone); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Mother's Address:</h2></td>
                    <td><?php echo htmlspecialchars($student_mother_addr); ?>.</td>
                </tr>
                <tr>
                    <td><h2>Note:</h2></td>
                    <td><?php echo htmlspecialchars($student_note); ?>.</td>
                </tr>
            </table>
        </div>
        <?php
    } else {
        ?>
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h2>Add Student</h2>
                <table>
                    <tr>
                        <td>Student ID:</td>
                        <td><input type="text" name="student_id" placeholder="Student ID" required></td>
                    </tr>
                    <tr>
                        <td>IC:</td>
                        <td><input type="text" name="student_ic" placeholder="IC" required></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="student_name" placeholder="Name" required></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                            <td>
                                <select name="student_gender" required>
                                    <option value="">Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </td>
                    </tr>
                    <tr>
                        <td>Race:</td>
                        <td>
                            <select name="student_race" id="student_race" required>
                                <option value="">Select Race</option>
                                <option value="malay">Malay</option>
                                <option value="chinese">Chinese</option>
                                <option value="indian">Indian</option>
                                <option value="Others">Others</option>
                            </select>
                            
                            <input type="text" name="other_race" id="other_race" placeholder="Other race" style="display:none;">
                        </td>
                    </tr>
                    <tr>
                        <td>Phone No:</td>
                        <td><input type="text" name="student_phone_no" placeholder="Phone No" required></td>
                    </tr>
                    <tr>
                        <td>Home Phone No:</td>
                        <td><input type="text" name="student_home_no" placeholder="Home No"></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="student_email" placeholder="Email" required></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><input type="text"  name="student_addr" placeholder="Address"></td>
                    </tr>
                    <tr>
                        <td>State:</td>
                        <td><input type="text" name="student_state" placeholder="State" required></td>
                    </tr>
                    <tr>
                        <td>Batch ID:</td>
                        <td><input type="text" name="student_batch_id" placeholder="Batch ID" required></td>
                    </tr>
                    <tr>
                        <td>Registration Date:</td>
                        <td><input type="date" name="student_reg_date" placeholder="Registration Date" required></td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>
                            <select name="student_status" required>
                                <option value="">Status</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td><input type="text" name="student_category" placeholder="Category" required></td>
                    </tr>
                    <tr>
                        <td>Sponsor:</td>
                        <td><input type="text" name="student_sponsor" placeholder="Sponsor" required></td>
                    </tr>
                    <tr>
                        <td>Father's Name:</td>
                        <td><input type="text" name="student_father_name" placeholder="Father's Name" required></td>
                    </tr>
                    <tr>
                        <td>Father's Phone No.:</td>
                        <td><input type="text" name="student_father_phone" placeholder="Father's Phone" required></td>
                    </tr>
                    <tr>
                        <td>Father's Address:</td>
                        <td><input type="text"  name="student_father_addr" placeholder="Father's Address"></textarea></td>
                    </tr>
                    <tr>
                        <td>Mother's Name:</td>
                        <td><input type="text" name="student_mother_name" placeholder="Mother's Name" required></td>
                    </tr>
                    <tr>
                        <td>Mother's Phone No.:</td>
                        <td><input type="text" name="student_mother_phone" placeholder="Mother's Phone" required></td>
                    </tr>
                    <tr>
                        <td>Mother's Address:</td>
                        <td><input type="text" name="student_mother_addr" placeholder="Mother's Address"></textarea></td>
                    </tr>
                    <tr>
                        <td>Note:</td>
                        <td><textarea name="student_note" placeholder="Note"></textarea></td>
                    </tr>
                    <tr>
                        <td><button type="green" type="submit" value="Add User">Register</td>
                        <td><button type="red" onclick="location.href='list_student.php'">Cancel</button></td>
                    </tr>
                </table>
            </form>
        </div>
    <?php
    }
    ?>
</body>
</html>