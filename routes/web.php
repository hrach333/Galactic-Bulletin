<?php

$router->get('', 'HomeController@index');
$router->get('news/page/{page}', 'HomeController@index');
$router->get('news/more/{id}', 'NewsController@more');