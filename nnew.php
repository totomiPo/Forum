<?php
    require_once 'connect.php';


    $post = mysqli_query($connect, "SELECT * FROM post ORDER BY id DESC");
    $posts = mysqli_fetch_all($posts);

    $total = count($posts); // кол-во постов
    $per_page = 5; // кол-во постов на одну страницу
    $count_page = ceil( $total / $per_page ); // кол-во страниц
    $page = $_GET['page']??1; // определение страницы по GET запросу
    $page = (int)$page;

    if(!$page || $page < 1){
        $page = 1;
    } else if ($page > $count_page) {
        $page = $count_page;
    }

    $start = ($page - 1) * $per_page; // начало распечатки элементов постранично

    if (isset($_POST['liked'])) {
		$postid = $_POST['postid'];
		$result = mysqli_query($connect, "SELECT * FROM post WHERE id=$postid");
		$row = mysqli_fetch_array($result);
		$n = $row['likes'];

		mysqli_query($connect, "INSERT INTO likes (postid) VALUES ($postid)");
		mysqli_query($connect, "UPDATE post SET likes = $n+1 WHERE id = $postid");

		echo $n+1;
		exit();
	}

    $posts = mysqli_query($connect, "SELECT * FROM post");
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
            <div>

                <?php while ($row = mysqli_fetch_array($posts)) {
                    $posts = array_slice($posts, $start, $per_page);
                    foreach ($posts as $post) {
                        $results = mysqli_query($connect, "SELECT * FROM likes WHERE postid = ".$row['id']."");
                        if (mysqli_num_rows($results) == 1 ): ?>
                        <div class="post">
                            <p class="user"><?= $post[1] ?></p>
                            <p class="text"><?= $post[2] ?></p>
                            <p style="margin-left: 45px; font-weight: bold;"><?= $post[3] ?></p>
						<!-- user already likes post -->
						    <span class="unlike fa fa-thumbs-up" data-id="<?php echo $row['id']; ?>"></span>
						    <span class="like hide fa fa-thumbs-o-up" data-id="<?php echo $row['id']; ?>"></span>
				  <?php else: ?>
						<!-- user has not yet liked post -->
						    <span class="like fa fa-thumbs-o-up" data-id="<?php echo $row['id']; ?>"></span>
						    <span class="unlike hide fa fa-thumbs-up" data-id="<?php echo $row['id']; ?>"></span>
				  <?php endif ?>
					    <span class="likes_count"><?php echo $row['likes']; ?> likes</span>

                            </div>
                        <?php
                    }
                }
                    ?>
            </div>
            <CENTER>
            <?php
                for ($i = 1; $i <= $count_page; $i++){
                    ?>
                    <a style="font-weight: bold"
                    href='?page=<?=$i?>'><?=$i?></a>
                    <?php
                }
                ?>
            </CENTER>
        </div>
        <script src="/js/jquery.min.js"></script>
        <script>
	       $(document).ready(function(){
		   $('.like').on('click', function(){
			var postid = $(this).data('id');
			    $post = $(this);

			$.ajax({
				url: 'index.php',
				type: 'post',
				data: {
					'liked': 1,
					'postid': postid
				},
				success: function(response){
					$post.parent().find('span.likes_count').text(response + " likes");
					$post.addClass('hide');
					$post.siblings().removeClass('hide');
				}
			});
		});
	});
    </script>
    </body>
</html>
