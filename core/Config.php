<?php

namespace Core;

class Config
{
    private static $instance = null;
    private $config = [];

    private function __construct()
    {
        // Загружаем конфигурацию при создании экземпляра
        $this->config = require '../config/config.php';
    }

    // Получаем единственный экземпляр Config
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Получаем значение из конфигурации по ключу (поддержка вложенных ключей)
    public function get($key = null, $default = null)
    {
        // Если ключ не указан, возвращаем весь конфигурационный массив
        if ($key === null) {
            return $this->config;
        }

        // Если ключ не содержит точки, вернем сразу значение по ключу
        if (!strpos($key, '.')) {
            return $this->config[$key] ?? $default;
        }

        // Разбиваем ключ по точке для поддержки вложенных структур
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $keyPart) {
            if (array_key_exists($keyPart, $value)) {
                $value = $value[$keyPart];
            } else {
                return $default;
            }
        }

        return $value;
    }
}
