<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand">CatHub 🐱</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href='home.php'>Home</a></li>
                <li class="nav-item"><a class="nav-link" href='about.php'>About</a></li>
            </ul>
            <form method="GET" action="home.php">
                <?php
                    session_start();
                    if ($_SESSION['logged']){
                        echo "<a class='navbar-brand'>Hello, {$_SESSION['logged_user']['username']}!</a>";
                        echo '<button name="logout" style="margin-left: 20px;" class="btn btn-outline-light" href="login.php" >Log out <i class="bi bi-lock"></i></i></button>';
                    }
                    else
                        echo '<a style="margin-left: 20px;" class="btn btn-outline-light" href="login.php" >Log in <i class="bi bi-unlock"></i></i></a>';


                    if (isset($_GET['logout'])) {
                        session_destroy();
                        header("Location: login.php");
                        exit;
                    }
                ?>
            </form>
        </div>
    </div>
</nav>