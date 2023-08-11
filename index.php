<?php

function transliterate($string) {
  $translitTable = array(
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
    'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
    'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
    'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO',
    'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P',
    'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH',
    'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA'
  );

  $translitString = strtr($string, $translitTable);
  $translitString = preg_replace('/\s+/', '-', $translitString);
  $translitString = preg_replace('/[^a-zA-Z0-9\-]/', '', $translitString);
  $translitString = strtolower($translitString);

  return $translitString;
}

function read_article($filename) {
    $content = '';
    if (is_file($filename)) {
        $lines = file($filename);
        foreach ($lines as $line) {
            $content .= $line . '<br>';
        }
    } else {
        // Обработка ошибки
    }
    return $content;
}

function create_static_page($title, $content, $video_id, $image_url, $page_path) {
  
  $market = file_get_contents("market.php");
  $video_html = "";
    if ($video_id != null) {
        $video_html = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }
    $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<title>{$title}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Description" content="Статическая страница блога">
<meta name="Keywords" content="молодежь, книги,библиотека">
<link rel="stylesheet" href="https://www.schoolsw3.com/sw3css/4/sw3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
</head>
<body class="sw3-light-grey">

<!-- Контент страницы -->
<div class="sw3-content" style="max-width:1400px">
    
    <!-- Заголовок -->
    <header class="sw3-container sw3-center sw3-padding-32">
        <img src="../{$image_url}" alt="Post Image" style="width:40%">
        <h1><b>{$title}</b></h1>
    </header>

    <!-- Содержимое страницы -->
    <div class="sw3-container sw3-padding">
        {$video_html}  
        <p>{$content}</p>
        <p>{$market}</p>
    </div>

    <!-- Ссылка на главную страницу блога -->
    <div class="sw3-container sw3-padding">
        <p><a href="/" class="sw3-button sw3-padding-large sw3-white sw3-border"><b>Назад к блогу</b></a></p>
    </div>

</div>
<!-- Конец контента страницы -->

<br>
</div>

<!-- Footer -->
<footer class="sw3-container sw3-padding-32 sw3-grey">
<div class="sw3-row">
<div class="sw3-col m6 sw3-center">
<div class="sw3-card sw3-margin" style="text-align: center;">
 
</div>
</div>
<div class="sw3-col m6 sw3-center">
<p><a href="#" class="sw3-hover-opacity">Вверх</a></p>
</div>
</div>
</footer>

</body>
</html>
HTML;

    // Запись содержимого страницы в файл
    file_put_contents($page_path, $html);
}

function create_blog_post($title, $date, $content, $image_url, $video_id, $page_path) {
    $market = file_get_contents("market.php");
    $video_html = "";
    if ($video_id != null) {
        $video_html = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }
    $html = <<<HTML
<div class="sw3-card-4 sw3-margin sw3-white">
    <img src="{$image_url}" alt="Post Image" style="width:50%">
    <div class="sw3-container">
        <h3><b>{$title}</b></h3>
        <h5>{$date}</h5>
    </div>
    {$video_html}
    <div class="sw3-container">
        <p>{$content}</p>
        {$market}
        <div class="sw3-row">
            <div class="sw3-col m8 s12">
                <p><a href="{$page_path}" class="sw3-button sw3-padding-large sw3-white sw3-border"><b>Читать далее</b></a></p>
            </div>
            <div class="sw3-col m4 sw3-hide-small">
                <p><span class="sw3-padding-large sw3-right"><b>Комментарии</b> <span class="sw3-badge">0</span></span></p>
            </div>
        </div>
    </div>
</div>
HTML;

    // Создание статической страницы
    create_static_page($title, $content,$video_id, $image_url, $page_path);

    return $html;
}

function generate_posts_html($articles_dir, $images_dir, $ids_file, $pages_dir, $posts_per_page, $current_page) {
    $html = '';
    $image_counter = 1;
    $ids = file($ids_file, FILE_IGNORE_NEW_LINES);
    $id_index = 0;

    // Читаем все файлы статей
    $article_files = glob($articles_dir . '/*.txt');

    // Вычисляем общее количество страниц
    $total_posts = count($article_files);
    $total_pages = ceil($total_posts / $posts_per_page);

    // Проверяем и корректируем номер текущей страницы
    if ($current_page > $total_pages) {
        $current_page = $total_pages;
    }

    // Вычисляем индексы начальной и конечной статьи на текущей странице
    $start_index = ($current_page - 1) * $posts_per_page;
    $end_index = $start_index + $posts_per_page;
    $paginated_files = array_slice($article_files, $start_index, $end_index);

    foreach ($paginated_files as $article_file) {
        $content = read_article($article_file);
        if (!empty($content)) {
            $title = strtok($content, "\n");
            $date = date('F j, Y', filemtime($article_file));
            
            $transcribed_title = transliterate($title);
            $image_url = "{$images_dir}/{$image_counter}.jpg";
            $video_id = isset($ids[$id_index]) ? trim($ids[$id_index]) : null;
            $page_path = "pages/{$transcribed_title}.html";
            $html .= create_blog_post($title, $date, $content, $image_url, $video_id, $page_path);
            $image_counter++;

            $id_index++;
            if ($id_index >= count($ids)) {
                $id_index = 0;
            }
        }
    }

    // Генерируем ссылки пагинации
    $pagination_html = '';
    if ($total_pages > 1) {
        $pagination_html .= '<div class="sw3-container sw3-center">';
        $pagination_html .= '<div class="sw3-bar sw3-border">';
        $pagination_html .= '<a class="sw3-button" href="?page=1">First</a>';

        // Генерируем ссылку на предыдущую страницу
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            $pagination_html .= '<a class="sw3-button" href="?page=' . $prev_page . '">Previous</a>';
        }

        // Генерируем ссылки на страницы
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                $pagination_html .= '<a class="sw3-button sw3-black">' . $i . '</a>';
            } else {
                $pagination_html .= '<a class="sw3-button" href="?page=' . $i . '">' . $i . '</a>';
            }
        }

        // Генерируем ссылку на следующую страницу
        if ($current_page < $total_pages) {
            $next_page = $current_page + 1;
            $pagination_html .= '<a class="sw3-button" href="?page=' . $next_page . '">Next</a>';
        }

        $pagination_html .= '<a class="sw3-button" href="?page=' . $total_pages . '">Last</a>';
        $pagination_html .= '</div></div>';
    }

    return $html . $pagination_html;
}

$articles_dir = 'articles';
$images_dir = 'images';
$ids_file = 'ids.txt';
$pages_dir = 'pages';
$posts_per_page = 5; // Количество записей на странице
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Текущая страница

$posts_html = generate_posts_html($articles_dir, $images_dir, $ids_file, $pages_dir, $posts_per_page, $current_page);

$archive_dir = 'articles/archive';
if (!is_dir($archive_dir)) {
    mkdir($archive_dir);
}
$archive_html = '';
if ($handle = opendir($archive_dir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $month = date('F Y', strtotime($entry));
            $archive_html .= "<li><a href='{$archive_dir}/{$entry}'>{$month}</a></li>";
        }
    }
    closedir($handle);
}
include 'header.php';
$title_main = file_get_contents('title.txt');
  
$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<title>{$title_main}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Description" content="Блог">
<meta name="Keywords" content="молодежь, книги,библиотека">
<link rel="stylesheet" href="https://www.schoolsw3.com/sw3css/4/sw3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
</head>
<body class="sw3-light-grey">

<!-- sw3 - контент определяет контейнер для содержимого с фиксированным размером по центру, 
  и обнимает все содержание страницы, за исключением в этом примере футер -->
<div class="sw3-content" style="max-width:1400px">

    <!-- Заголовок -->

    <!-- Навигационная панель -->
    <div class="sw3-top">
        <div class="sw3-bar sw3-light-grey sw3-card">
            <a class="sw3-bar-item sw3-button sw3-padding-large sw3-hide-medium sw3-hide-large sw3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
            <a href="#" class="sw3-bar-item sw3-button sw3-padding-large">Home</a>
            <a href="#archive" class="sw3-bar-item sw3-button sw3-padding-large sw3-hide-small">Архив</a>
            <a href="#" class="sw3-bar-item sw3-button sw3-padding-large sw3-hide-small">О нас</a>
            <a href="#" class="sw3-bar-item sw3-button sw3-padding-large sw3-hide-small">Контакты</a>
        </div>
    </div>

    <!-- Мобильное меню -->
    <div id="navDemo" class="sw3-bar-block sw3-white sw3-hide sw3-hide-large sw3-hide-medium sw3-large">
        <a href="#archive" class="sw3-bar-item sw3-button sw3-padding-large">Архив</a>
        <a href="#" class="sw3-bar-item sw3-button sw3-padding-large">О нас</a>
        <a href="#" class="sw3-bar-item sw3-button sw3-padding-large">Контакты</a>
    </div>

    <!-- СЕТКА -->
    <div class="sw3-row">

        <!-- Записи в блоге -->
        <div class="sw3-col l8 s12">
            <!-- Записи блога -->
            {$posts_html}
        </div>

        <!-- Меню Информации -->
        <div class="sw3-col l4 s12">
            <div class="sw3-card sw3-margin">
                <div class="sw3-container sw3-padding">
                    <h4>Категории</h4>
                </div>
                <div class="sw3-container sw3-white">
                    <p><span class="sw3-tag sw3-red">Интервью</span></p>
                    <p><span class="sw3-tag sw3-blue">Технологии</span></p>
                    <p><span class="sw3-tag sw3-green">Дизайн</span></p>
                    <p><span class="sw3-tag sw3-yellow">Разное</span></p>
                </div>
            </div>
            <hr>

            <!-- Архивы -->
            <div class="sw3-card sw3-margin">
                <div class="sw3-container sw3-padding">
                    <h4>Архивы</h4>
                </div>
                <ul class="sw3-ul">
                    {$archive_html}
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Конец контента страницы -->

<br>

<!-- Footer -->
<footer class="sw3-container sw3-padding-32 sw3-grey">
    <div class="sw3-row">
        <div class="sw3-col m6 sw3-center">
            <div class="sw3-card sw3-margin" style="text-align: center;"></div>
        </div>
        <div class="sw3-col m6 sw3-center">
            <p><a href="#" class="sw3-hover-opacity">Вверх</a></p>
        </div>
    </div>
</footer>

<!-- Скрипт для мобильного меню -->
<script>
function myFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("sw3-show") == -1) {
        x.className += " sw3-show";
    } else {
        x.className = x.className.replace(" sw3-show", "");
    }
}
</script>

</body>
</html>
HTML;

echo $html;

?>
