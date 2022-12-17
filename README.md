Анонимный форум
========================
Задание
------------------------
Разработать и реализовать клиент-серверную информационную систему, реализующую механизм CRUD.

Ход работы
------------------------

- Спроектировать пользовательский интерфейс
- Описать пользовательские сценарии работы
- Описать API сервера и хореографию
- Описать структуру базы данных
- Описать алгоритмы

#### [1. Пользовательский интерфейс](https://www.figma.com/proto/nNBpKeNMK8FiCJELsD5Zp6/Forum?node-id=1%3A2&scaling=min-zoom&page-id=0%3A1)
![Интерфейс](https://github.com/totomiPo/Forum/blob/main/img/Дизайн.png)

#### 2. Пользовательский сценарий работы
Пользователь попадает на главную страницу **index.php**. 
Вводит свой логин (ник) и любое текстовое сообщение, по желанию может добавить картинку, следует нажать при создании поста на кнопку *выбрать файл*. В случае корректного ввода данных, его сообщение появится на общей стене в обратном хронологическом порядке, сначала новые, затем старые публикации. 
Пользователи могут ставить лайки на понравившиеся записи или убирать их в противном случае. 
Также есть возможность изменить содержание записи. Для этого доступна у каждой записи кнопка *ИЗМЕНИТЬ*, при нажатии на которую пользователь переходит на **update.php**, где вносит правки в пост и вновь отправляет его.  
Есть возможность удалять записи. Для этого пользователь нажимает на кнопку *УДАЛИТЬ*, и соответствующая запись удаляется.

#### 3. API сервера и хореография
![Добавление](https://github.com/totomiPo/Forum/blob/main/img/Добавление%20-%20хореография.png)  

![Реакция](https://github.com/totomiPo/Forum/blob/main/img/Реакция%20-%20хореография.png)  

![Удаление](https://github.com/totomiPo/Forum/blob/main/img/Удаление%20-%20хореография.png)  


#### 4. Структура базы данных

 Таблица *post*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT  |  | NO | Автоматический идентификатор поста |
| **login** | VARCHAR | 100 | NO | Логин пользователя |
| **text** | TEXT |  | NO | Текст поста |
| **date** | VARCHAR | 255 | NO | Дата создания поста |
| **like** | INT | 11 | 0 | Количество лайков |
| **image** | VARCHAR | 500 | NO | Содержание картинки |

Таблица *likes*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT  |  | NO | Автоматический идентификатор лайка |
| **postid** | INT |  | NO | ID поста |

#### 5. Алгоритм
**Добавление записи**  
![Добавление](https://github.com/totomiPo/Forum/blob/main/img/Создание%20поста.png)  

**Удаление записи**  
![Удаление](https://github.com/totomiPo/Forum/blob/main/img/Удаление.png)  

**Обновление записи**  
![Обновление](https://github.com/totomiPo/Forum/blob/main/img/Изменение%20поста.png)  

**Реакция на запись**  
![Реакция](https://github.com/totomiPo/Forum/blob/main/img/Лайки.png)  


#### 6. HTTP запрос/ответ
**Запрос**  
POST 
http://line/post.php
Status: HTTP/1.1 302 Found
Request Headers
Accept	
text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
Content-Type	
multipart/form-data; boundary=----WebKitFormBoundaryrLqApbntyDF9f6ma
Upgrade-Insecure-Requests	
1
User-Agent	
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 YaBrowser/22.11.3.818 Yowser/2.5 Safari/537.36
Response Headers
Cache-Control	
no-store, no-cache, must-revalidate
Connection	
Keep-Alive
Content-Length	
40
Content-Type	
text/html; charset=UTF-8
Date	
Sat, 17 Dec 2022 20:07:36 GMT
Expires	
Thu, 19 Nov 1981 08:52:00 GMT
Keep-Alive	
timeout=120, max=1000
Location	
../index.php
Pragma	
no-cache
Server	
Apache  

**Ответ**
GET 
http://line/index.php
Status: HTTP/1.1 200 OK
Request Headers
Accept	
text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
Upgrade-Insecure-Requests	
1
User-Agent	
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 YaBrowser/22.11.3.818 Yowser/2.5 Safari/537.36
Response Headers
Connection	
Keep-Alive
Content-Type	
text/html; charset=UTF-8
Date	
Sat, 17 Dec 2022 20:07:36 GMT
Keep-Alive	
timeout=120, max=999
Server	
Apache
Transfer-Encoding	
chunked
#### 7. Значимые фрагменты кода

**Пагинация**
```php
$post = mysqli_query($connect, "SELECT * FROM post ORDER BY id DESC");
$posts = mysqli_fetch_all($post);
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
```

**Увеличение счётчика лайка**
```php
if (isset($_POST['liked'])) {
	$post_id = $_POST['postid'];
	$result = mysqli_query($connect, "SELECT * FROM post WHERE id = $post_id");
	$row = mysqli_fetch_array($result);
	$like = $row['likes'];
    if ($like < 0){
        $like = 0;
    }
	mysqli_query($connect, "INSERT INTO likes (postid) VALUES ($post_id)");
	mysqli_query($connect, "UPDATE post SET likes = $like + 1 WHERE id = $post_id");
	echo $like + 1;
	exit();
}
```

**Отправка данных нового поста**
```php
session_start();
require_once 'connect.php';

$post = $_POST['post'];
$login = $_POST['login'];
$date = date(" H : i : s d - m - Y ");
$path = 'uploads/'. time(). $_FILES['img']['name'];

move_uploaded_file($_FILES['img']['tmp_name'], $path);
if(!move_uploaded_file($_FILES['img']['tmp_name'], $path)){
    echo "Ошибка загрузки файла";
}

mysqli_query($connect, "INSERT INTO `post`(`id`, `login`, `text`, `time`, `image`)
            VALUES(NULL, '$login', '".addslashes($post)."', '$date', '$path')");
header('Location:../index.php');
```
Вывод
------------------------
В ходе выполнения лабораторной работы спроектировали и разработали систему клиент-сервер, реализующую механизм CRUD. Создан форум с базовыми воможностями взаимодействия с элементами страницы.
