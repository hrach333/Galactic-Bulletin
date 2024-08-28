<?php

namespace App\Controllers;

use App\Models\News;
use Core\Controller;

class HomeController extends Controller
{



    public function index($page = 1)
    {


        $perPage = 4; // Количество записей на странице
        $newsModel = new News();
        $lastNews = $newsModel->getLastNews();
        $lastNews = $lastNews[0];
        // Получаем записи с учетом пагинации
        $news = $newsModel->paginate($page, $perPage);
        $title = $this->config->get('app.nameApp');
        // Получаем общее количество записей
        $totalNews = $newsModel->count();

        // Рассчитываем общее количество страниц
        $totalPages = ceil($totalNews / $perPage);
       // echo $this->config['app']['baseUrl'];
        // Передаем данные в вид
        $this->loadView('news', [
            'title' => $title,
            'news' => $news,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'lastNews' => $lastNews,
        ]);
    }

}