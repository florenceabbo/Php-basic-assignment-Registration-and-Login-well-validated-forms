<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Registration Form</title>
    <link rel="stylesheet" href="register.css">
	
	<link
	href="https://fonts.googleapis.com/css2? 
	family=Ubuntu+Mono&display=swap" 
	rel="stylesheet">
    
</head>
<body>

<?php
// initializing an empty array to store validation errors
$errors = array();

// Database connection parameters having variables to store the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration";

// Created connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Checking if there was an error in database connection, then terminates the script
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Checking if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $name = $_POST['name']; // Retieves the name submitted
    //Checks if the name wasn't provided then displays error
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    // Validate email
    $email = $_POST['email'];
     //Checks if the email wasn't provided then displays error
    if (empty($email)) {
        $errors[] = "Email is required";
    // Using the !filter_var function to validate the email value
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Validate password
    $password = $_POST['password'];
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // Validate confirm password
    $confirmPassword = $_POST['confirm_password'];
    if (empty($confirmPassword)) {
        $errors[] = "Confirm Password is required";
    } elseif ($confirmPassword !== $password) {
        $errors[] = "Passwords do not match";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        // Set parameters and execute
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password before storing

        if ($stmt->execute()) {
            echo "<h2>Registration Successful!</h2>";
            echo "<p>Name: $name</p>";
            echo "<p>Email: $email</p>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // If there are errors, display them
        echo "<h2>Error occurred:</h2>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}

// Close connection
$conn->close();
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name"><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br><br>

    <label for="confirm_password">Confirm Password:</label><br>
    <input type="password" id="confirm_password" name="confirm_password"><br><br>

    <input type="submit" value="Register">
    <button name="submit">submit</button>
</form>

</body>
</html>