<?php
// Include configuration file
require_once "configuration.php";

$username = '';
$password = ''; 
$confirm_password = "";
$username_error = "";
$password_error = "";
$confirm_password_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

if(empty(trim($_POST['username']))){
    $username_error = "You did not enter a username. Please try again.";
}
else{
    $sql = "SELECT id FROM users WHERE username = ?";

    $test_username = trim($_POST['username']);
    

    foreach ($db->query("SELECT * FROM users") as $row){
        if ($test_username == $row["username"]){
            $username_error = "This username is already taken.";
        }

    }

    if (!(empty($username_error))){
        $username = trim($_POST['username']);
    }
}
    // Validate Password
    if(empty(trim($_POST['password']))){
        $password_error = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_error = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }

    // Validate Confirm Password
    if (empty(trim($_POST["confirm_password"]))){
        $confirm_password_error = "Please confirm password.";
    }

    // Make sure Passwords Match
    else{
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_error) && empty($confirm_password_error) && ($password != $confirm_password)){
            $confirm_password_error = "Password did not match.";
        }
    }
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

       // Prepare an insert statement
       $insert_statement = $db->prepare("
        INSERT INTO users(username, password, date) 
        VALUES (:username, :password, NOW())
        ");

        $insert_statement->execute([
            'username' => $username,
            'password' => $password
        ]);
    }

         
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill out the following to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_error; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_error)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_error; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>








    












}


