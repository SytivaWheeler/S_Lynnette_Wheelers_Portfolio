<!DOCTYPE html>

<head>
    <title>Welcome to Popcorn!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
    <link href="css/index.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation Bar / Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="main">
            <div class="container-fluid">
                <a id="Popcorn!" href="#">POPCORN!</a>
                <div class="d-flex align-items-center">
                    <form action="pages/sign_in_page.php">
                        <button id="sign_in">Sign in</button>
                    </form>
                    <form action="pages/create_account.php">
                        <button id="create_acc">Create an Account!</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="main container">
        <h1 class="w3-center">Welcome to Popcorn!</h1>
        <h4>
            Popcorn is a website that allows you to keep track of movies you either want to or
            have already watched across many popular streaming services such as HBO max, Disney+
            and Netflix! If you are already familiar with our site, just click the sign in button.
            Otherwise, create an acccount and get started! Both buttons are in the top right corner
            of this page.
        </h4>
    </div>
    <div class="main">
        <img id="logo" src="images/movie.jpg">
    </div>

</body>

</html>