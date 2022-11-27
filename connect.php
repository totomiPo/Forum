<?php

    $connect = mysqli_connect('localhost', 'root', '', 'newsfeed');

    if (!$connect) {
        die('Error connect to DataBase');
    }
