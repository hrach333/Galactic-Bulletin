<?php
spl_autoload_register(function ($class) {
    // Разделяем пространство имен по слэшам
    $classPath = str_replace('\\', '/', $class);

    // Преобразуем путь: заменяем первую букву каждого сегмента на заглавную
    $classPathArray = explode('/', $classPath);
    $i = 1;
    foreach ($classPathArray as $key => $item) {
        if (count($classPathArray) > $i) {
            $classPathArray[$key] = lcfirst($item);
        }
        $i++;
    }
    $classPath = implode('/', $classPathArray);

    // Формируем полный путь к файлу
    $file = __DIR__ . '/' . $classPath . '.php';
    //echo $file;
    // Если файл существует, подключаем его
    if (file_exists($file)) {
        require_once $file;
    }
});
