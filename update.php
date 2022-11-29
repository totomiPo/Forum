<?php

    session_start();
    require_once 'connect.php';

    $post_id = $_GET['id'];
    $post = mysqli_query($connect, "SELECT * FROM post WHERE id = $post_id ");
    $post = mysqli_fetch_assoc($post); //представление строки из бд в виде массива

?>

<!DOCTYPE html>
<html>
    <head>
	<title>Forum</title>
    <meta name="author" content="Daria Dubrovina">
    <meta charset="utf-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.google.com/specimen/Sarabun?selection.family=Rye&sidebar.open=&subset=latin&category=Serif,Sans+Serif&preview.size=32" rel="stylesheet">
    <link rel = "stylesheet" href="app/css/main.css">
</head>
<body>
    <h1>Update post</h1>

    <div class ="gl">

        <div class="form">
            <form action="post_update.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?=$post['id']?>">
                <label>Login:</label><br>
                <input type="text" class="login" name ="login" value="<?=$post['login']?>"><br>
                <textarea name="post"><?=$post['text']?></textarea>
                <br>
                <input type="Submit" Value="Изменить" class="button">
                <input type="reset" Value="Очистить" class="button">
            </form>
        </div>

    </div>
</body>
</html>
