<!DOCTYPE html>
<html>

<head>
    <title>Create your account!</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- CSS -->
    <link href="../css/create_account.css" rel="stylesheet">

</head>


<body class="d-flex
            justify-content-center
            align-items-center
            vh-100
            flex-column">
    <div class="login">
        <h1>Create Your Account</h1>
        <p>Enter your email, then create a username and password. Then you will be redirected to the sign in page.</p>

        <?php if (isset($_GET['error'])) { ?>

            <div class="alert alert-warning" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>

        <?php } ?>

        <form action="../include_files/acc_create.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" name="email" type="email" placeholder="Enter email" required />
            </div>
            <div class="form-group">
                <label for="user">Username:</label>
                <input class="form-control" name="user" type="text" placeholder="Enter username" required />
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input class="form-control" name="pwd" type="password" placeholder="Enter password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase, one lowercase letter, and 8 or more characters" required />
            </div>
            <div class="form-group">
                <input type="submit" value="Create Account" name="Submit">
            </div>
        </form>

        <p>Already have an account? <a href="sign_in_page.php" style="color:#ffc828;">sign in here!</a></p>
    </div>
</body>

</html>