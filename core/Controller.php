<?php

namespace Core;

class Controller {

    protected $config;
    public function __construct()
    {
        $this->config = require '../config/config.php';
    }
    /**
     * Метод для загрузки представления.
     *
     * @param string $view Имя файла представления.
     * @param array $data Массив данных, которые будут доступны в представлении.
     * @return void
     */
    protected function loadView($view, $data = []) {
        extract($data); // Извлекает элементы массива в переменные
        ob_start();
        require_once "../app/views/{$view}.php";
        $content = ob_get_clean();
        echo $content;
    }

    /**
     * Метод для редиректа на другую страницу.
     *
     * @param string $url URL для перенаправления.
     * @return void
     */
    protected function redirect($url) {
        header("Location: /$url");
        exit;
    }

    /**
     * Метод для получения данных запроса POST.
     *
     * @param string $key Ключ данных запроса.
     * @param mixed $default Значение по умолчанию, если ключ не найден.
     * @return mixed Данные запроса или значение по умолчанию.
     */
    protected function input($key, $default = null) {
        return $_POST[$key] ?? $default;
    }

    /**
     * Метод для установки сессионного сообщения.
     *
     * @param string $key Ключ сообщения.
     * @param string $message Текст сообщения.
     * @return void
     */
    protected function setFlash($key, $message) {
        $_SESSION[$key] = $message;
    }

    /**
     * Метод для получения сессионного сообщения.
     *
     * @param string $key Ключ сообщения.
     * @return string|null Текст сообщения или null, если ключ не найден.
     */
    protected function getFlash($key) {
        $message = $_SESSION[$key] ?? null;
        if ($message) {
            unset($_SESSION[$key]);
        }
        return $message;
    }
}
