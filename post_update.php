<?php

    session_start();
    require_once 'connect.php';

    $id = $_POST['id'];
    $post = $_POST['post'];
    $login = $_POST['login'];
    $date = date(" H : i : s d - m - Y ");

    mysqli_query($connect, "UPDATE `post` SET `login` = '$login', `text` = '$post', `time` = '$date' WHERE `post`.`id` = '$id'");
    header('Location:../index.php');
 ?>
