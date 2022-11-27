<?php

    session_start();
    require_once 'connect.php';

    $post = $_POST['post'];
    $login = $_POST['login'];
    $date = date(" H : i : s d - m - Y ");

    mysqli_query($connect, "INSERT INTO `post`(`id`, `login`, `text`, `time`)
                VALUES(NULL, '$login', '".addslashes($post)."', '$date')");
    header('Location:../index.php');
 ?>
