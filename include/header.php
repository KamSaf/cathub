<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a href="home.php" class="navbar-brand">CatHub 🐱</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href='about.php'>About</a></li>
                <?php
                    session_start();
                    if ($_SESSION['logged']){
                        echo "
                            <li class='nav-item'><a class='nav-link' href='user_posts.php?user={$_SESSION['logged_user']['id']}'>My posts</a></li>
                            <li style='margin-left: 10px;' class='nav-item'><a class='nav-link active' href='new_post.php'><b>New post +</b></a></li>
                        ";
                    }
                ?>
            </ul>
            <form method="GET" action="home.php">
                <?php
                    $navbar_auth = '';
                    if ($_SESSION['logged']){
                        $navbar_auth .= "<a class='navbar-brand'>Hello, {$_SESSION['logged_user']['username']}!</a>";
                        $navbar_auth .= '<button name="logout" style="margin-left: 20px;" class="btn btn-outline-light" href="login.php" >Log out <i class="bi bi-lock"></i></i></button>';
                    }
                    else
                        $navbar_auth .= '<a style="margin-left: 20px;" class="btn btn-outline-light" href="login.php" >Log in <i class="bi bi-unlock"></i></i></a>';
                    echo $navbar_auth;

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