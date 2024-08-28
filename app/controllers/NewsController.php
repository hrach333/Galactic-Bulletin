<?php

namespace App\Controllers;

use App\Models\News;
use Core\Controller;

class NewsController extends Controller
{

    public function more($id) {
        $news = new News();
        $item = $news->find($id);
        //print_r($item);
        $lastNews = $news->getLastNews();
        $lastNews = $lastNews[0];
        $title = $item['title'] . ' - ' . $this->config->get('app.domainNaime');
        $this->loadView('more',[
            'title' => $title,
            'titleForNews' => $item['title'],
            'announce' => $item['announce'],
            'date' => $item['date'],
            'content' => $item['content'],
            'image' => $item['image'],
            'lastNews' => $lastNews
        ]);
    }
}