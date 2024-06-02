<html>

<head>
    <title>Popcorn!: The movie referral site.</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS -->
    <link href="../css/sign_in.css" rel="stylesheet">
</head>

<body class="d-flex
            justify-content-center
            align-items-center
            vh-100
            flex-column">
    <div class="login">
        <h1 style="color:#fff;">POPCORN</h1>
        <div class="w-400 p-5 shadow rounded">
            <form method="POST" action="../include_files/sign_in.php">
                <div class="d-flex
                    justify-content-center
                    align-items-center
                    flex-column">
                    <h3 class="display-4 fs-1 text-center"> SIGN IN </h3>
                </div>
                <br />

                <?php if (isset($_GET['error'])) { ?>

                    <div class="alert alert-warning" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>

                <?php } ?>

                <div class="form-inp">
                    <label for="user" class="form-label">Username</label>
                    <input name="user" type="text" placeholder="Enter username" required />
                </div>
                <div class="form-inp">
                    <label for="pwd" class="form-label">Password</label>
                    <input name="pwd" type="password" placeholder="Enter password" required />
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <br />
                <br />
                <a href="create_account.php" style="color:#ffc828;">Create an account here!</a>
            </form>
        </div>
    </div>
</body>

</html>