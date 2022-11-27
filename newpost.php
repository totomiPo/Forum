<?php
require_once 'connect.php';

 ?>

<!doctype html>
<html>
    <head>
        <title>Forum</title>
        <meta name="author" content="Daria Dubrovina">
        <meta charset="utf-8">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.google.com/specimen/Sarabun?selection.family=Rye&sidebar.open=&subset=latin&category=Serif,Sans+Serif&preview.size=32" rel="stylesheet">
        <link rel = "stylesheet" href="css/main.css">
    </head>
    <body>
        <h1>Tell me something</h1>
        <div class ="gl">
            <div class="form">
                <form action="post.php" method="POST" enctype="multipart/form-data">
                    <label>Login:</label><br>
                    <input type="text" class="login" name ="login"><br>
                    <textarea name="post"></textarea>
                    <br>
                    <input type="Submit" Value="Опубликовать" class="button">
                    <input type="reset" Value="Очистить" class="button">
                </form>
            </div>
            <h2>News Feed</h2>
            <div >
                <?php
                    $posts = mysqli_query($connect, "SELECT * FROM post ORDER BY id DESC LIMIT 15");
                    $posts = mysqli_fetch_all($posts);
                    foreach ($posts as $post) {
                        ?>
                        <div class="post">
                            <p class="user"><?= $post[1] ?></p>
                            <p class="text"><?= $post[2] ?></p>
                            <p style="margin-left: 45px; font-weight: bold;"><?= $post[3] ?></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
        </div>
    </body>
</html>
