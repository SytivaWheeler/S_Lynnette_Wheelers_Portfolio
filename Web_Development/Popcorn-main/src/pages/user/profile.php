<?php
# Check if user isnt logged in or hasnt done profile_gen

session_start();
if (!isset($_SESSION['username'])) {
    header("Location:../sign_in_page.php");
}

if (!$_SESSION['profilebool']) {
    header("Location:../profile_gen.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Your Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
    <!-- CSS -->
    <link href="../../css/profile.css" rel="stylesheet">
</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <ul class="navbar-nav">
                 <!--Avatar -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                        <img src="../../images/img_avatar2.png" class="rounded-circle" height="22" alt="Avatar" loading="lazy" />
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="profile.php">My Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="watch_list.php">Watch List</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="fav_list.php">Favorites List</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../homepage.php">Home</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../../include_files/log_out.php">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>


    <!-- Profile -->
    <div class="profile">
        <div class="wrapper d-flex
            justify-content-center
            align-items-center
            flex-column">

            <h2>Profile</h2>
            <h4>You can check out or even update your profile info here! Keep in mind that not all attributes can be updated.</h4>

            <div>
                <!-- Error text boxes -->
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['error2'])) { ?>
                    <div class="alert alert-secondary" role="alert">
                        <?php echo htmlspecialchars($_GET['error2']); ?>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['succ'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($_GET['succ']); ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Form -->
            <form class="form" action="../../include_files/update.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input name="username" type="text" class="form-control form-control-lg" id="username" readonly placeholder=<?php if (isset($_SESSION['username'])) {echo $_SESSION['username'];} ?>>
                    <small id="usernamehelp" class="text-warning form-text">Sorry! You can't change your username!</small>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input name="email" type="email" class="form-control form-control-lg" id="email"  placeholder=<?php if (isset($_SESSION['email'])) {echo $_SESSION['email'];} ?>>
                </div>
                <div class="form-group">
                    <label for="f-name">First Name</label>
                    <input name="f-name" type="text" class="form-control form-control-lg" id="f-name"  placeholder=<?php if (isset($_SESSION['f-name'])) {echo $_SESSION['f-name'];} ?>>
                </div>
                <div class="form-group">
                    <label for="l-name">Last Name</label>
                    <input name="l-name" type="text" class="form-control form-control-lg" id="l-name"  placeholder=<?php if (isset($_SESSION['l-name'])) {echo $_SESSION['l-name'];} ?>>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input name="age" type="number" class="form-control form-control-lg" id="age"  placeholder=<?php if (isset($_SESSION['age'])) {echo $_SESSION['age'];} ?>>
                </div>
                <div class="text-center mt-4">
                    <button class="submit btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>