<?php

namespace App\Helpers;

class DateHelper
{

    /**
     * Форматирует дату из формата БД в формат д.м.гггг.
     *
     * @param string $date Дата в формате Y-m-d или с временем (Y-m-d H:i:s)
     * @return string Отформатированная дата в виде д.м.гггг
     */
    public static function formatToDMY($date) {
        $dateObj = new \DateTime($date);
        return $dateObj->format('d.m.Y');
    }
}