<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu</title>
    <?php include("head/header.php"); ?> 
</head>
<body>   
    <nav>
        
        <div class="menu-bar">
            <?php //if( $_SESSION['user_level']>=1 and  $_SESSION['user_level']<=99){ ?>
                <div class="menu-container">
                    <div class="menu">User</div>
                    <div class="submenu">
                        <a href="add_user.php">Add User</a>
                        <a href="list_user.php">List User</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
            <?php// } ?>

            <?php //if( $_SESSION['user_level']>=100 and  $_SESSION['user_level']<=199){ ?>
                <div class="menu-container">
                    <div class="menu">Funder</div>
                    <div class="submenu">
                        <a href="add_funder.php">Add funder</a>
                        <a href="list_funder.php">List funder</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
            <?php// } ?>

            <?php //if( $_SESSION['user_level']>=200 and  $_SESSION['user_level']<=299){ ?>
                <div class="menu-container">
                    <div class="menu">Student</div>
                    <div class="submenu">
                        <a href="add_student.php">Add student</a>
                        <a href="list_student.php">List student</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
            <?php// } ?>

            <?php //if( $_SESSION['user_level']>=300 and  $_SESSION['user_level']<=399){ ?>
                <div class="menu-container">
                    <div class="menu">Batch</div>
                    <div class="submenu">
                        <a href="add_batch.php">Add batch</a>
                        <a href="list_batch.php">List batch</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
            <?php //} ?>

            <?php //if( $_SESSION['user_level']>=300 and  $_SESSION['user_level']<=399){ ?>
                <div class="menu-container">
                    <div class="menu">Hostel</div>
                    <div class="submenu">
                        <a href="add_hostel.php">Add hostel</a>
                        <a href="list_hostel.php">List hostel</a>
                        <a href="add_student_hostel.php">Student to hostel</a>
                        <a href="list_student_hostel.php">Student Hostel List</a>
                    </div>
                </div>
            <?php //} ?>
        </div>
    </nav>
</body>
</html>
