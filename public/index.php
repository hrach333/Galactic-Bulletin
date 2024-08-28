<?php
require '../autoload.php';
$config = \Core\Config::getInstance();
$debug = $config->get('debug');
if ($debug) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// Определяем URI и запрашиваемый метод
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Убираем из URI лишнюю часть, если она есть
$publicPath = '/public';
if (strpos($uri, $publicPath) === 0) {
    $uri = substr($uri, strlen($publicPath));
}
//echo $uri;
// Проверка наличия файла в папке public
if ($uri !== '/' && file_exists($uri)) {
    require $uri;
    return false; // Возвращаем false, чтобы встроенный сервер PHP обработал файл как статический ресурс
}

//Статистическая функция которою можно вызвать везде, где это нужно
function asset($path) {
    $config = \Core\Config::getInstance();
    $domain = $config->get('app.domainNaime');
    return $domain . '/' . ltrim($path, '/');
}
// Инициализация роутера
$router = new Core\Router();

// Подключаем файл с маршрутами
require_once '../routes/web.php';



// Обработка текущего запроса
$uri = Core\Request::uri();
$method = Core\Request::method();

$router->direct($uri, $method);
