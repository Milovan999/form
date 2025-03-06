<?php

include('config/db_conn.php');

$fname = $lname = $email = $password = '';

$errors = array('fname' => '', 'lname' => '', 'email' => '', 'password' => '', 'empty' => '');

if (isset($_POST['submit'])) {

    if (empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['email']) || empty($_POST['password'])) {
        $errors['empty'] = 'All fields are required! <br>';
    }
    if (empty($_POST['fname'])) {
        $errors['fname'] = 'First name is required <br>';
    } else {
        $fname = $_POST['fname'];

        if (strlen($fname) <= 3) $errors['fname'] = 'First name must be greater than 3 letters <br>';
        else if (!preg_match('/^[a-zA-Z\s]+$/', $fname)) {
            $errors['fname'] = 'Name must be letters and spaces only <br/>';
        }
    }

    if (empty($_POST['lname'])) {
        $errors['lname'] = 'Last name is required <br/>';
    } else {
        $lname = $_POST['lname'];
        if (strlen($lname) <= 3) {
            $errors['lname'] = 'Last name must be greater than 3 letters <br/>';
        } else if (!preg_match('/^[a-zA-Z\s]+$/', $lname)) {
            $errors['lname'] = 'Last name must be letters and spaces only <br/>';
        }
    }

    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required! <br/>';
    } else {
        $email = $_POST['email'];

        if (strlen($email) <= 5) {
            $errors['email'] = 'Email must be greater than 6 charachers<br/>';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email adress!<br/>';
        }
    }

    //Check password
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required! <br/>';
    } else {
        $password = $_POST['password'];

        if (strlen($password) <= 6) {
            $errors['password'] = 'Password must be greater than 5 charachers<br/>';
        } else if (!preg_match("#[0-9]+#", $password)) {
            $errors['password'] = 'Your Password Must Contain At Least 1 Number!';
        } else if (!preg_match("#[A-Z]+#", $password)) {
            $errors['password'] = 'Your Password Must Contain At Least 1 Capital Letter!';
        } else if (!preg_match("#[a-z]+#", $password)) {
            $errors['password'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
        } else if (!preg_match("#[\W]+#", $password)) {
            $errors['password'] = "Your Password Must Contain At Least 1 Special Character!";
        }
    }

    if (empty(array_filter($errors))) {
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (firstName,lastName,email,password) VALUES ('$fname','$lname','$email','$hash_password')";

        if (mysqli_query($conn, $sql)) {
            header('Location:home.php');
            exit();
        } else {
            echo 'Query error' . mysqli_error($conn);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <div>Register</div>
    <form action="index.php" method="POST">
        <div><?php echo $errors['empty']; ?></div>
        <div>
            <label>First name:</label><br>
            <input type="text" name="fname" class="input-field" value="<?php echo htmlspecialchars($fname); ?>" placeholder="First name">
            <div><?php echo $errors['fname']; ?></div>
        </div>
        <div>
            <label>Last name:</label><br>
            <input type="text" name="lname" class="input-field" value="<?php echo htmlspecialchars($lname); ?>" placeholder="Last name">
            <div><?php echo $errors['lname']; ?></div>
        </div>
        <div>
            <label>Email:</label><br>
            <input type="email" name="email" class="input-field" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email">
            <div><?php echo $errors['email'] ?></div>
        </div>
        <div>
            <label>Password:</label><br>
            <input type="password" name="password" class="input-field" value="<?php echo htmlspecialchars($password); ?>" placeholder="Password">
            <div><?php echo $errors['password'] ?></div>
        </div>
        <input type="submit" value="Submit" name="submit" />

    </form>
</body>

</html>