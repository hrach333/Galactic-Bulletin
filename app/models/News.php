<?php

namespace App\Models;
use Core\Model;
class News extends Model
{
    protected $table = 'news';

    public function paginate($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;

        return $this->query()
            ->orderBy('date', 'DESC')
            ->limit($perPage)
            ->offset($offset)
            ->execute();
    }
    public function getLastNews(){
        return $this->query()->orderBy('date', 'DESC')->limit(1)->execute();
    }
}