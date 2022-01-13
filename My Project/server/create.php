<?php

require_once "../config.php";


$name = $address = $salary = $password = $email = "";
$name_err = $address_err = $salary_err = $password_err = $email_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }


    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    $input_password = trim($_POST["password"]);
    if (empty($input_address)) {
        $address_err = "Please enter an password.";
    } else {
        $password = $input_password;
    }

    $input_email = trim($_POST["email"]);
    if (empty($input_address)) {
        $address_err = "Please enter an email.";
    } else {
        $email = $input_email;
    }


    $input_salary = trim($_POST["salary"]);
    if (empty($input_salary)) {
        $salary_err = "Please enter the salary amount.";
    } elseif (!ctype_digit($input_salary)) {
        $salary_err = "Please enter a positive integer value.";
    } else {
        $salary = $input_salary;
    }


    if (empty($name_err) && empty($address_err) && empty($salary_err) &&  empty($password_err) &&  empty($email_err)) {

        $sql = "INSERT INTO employees (name, address, salary,email,password) VALUES (?, ?, ?,?,?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary, $param_password, $param_email);

            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_password = $password;
            $param_email = $email;


            if (mysqli_stmt_execute($stmt)) {

                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }


        mysqli_stmt_close($stmt);
    }


    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $paasword; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>