<?php ob_start()?>
<h1>Новости</h1>
<div class="container">
    <?php $i = 0; ?>
    <?php foreach ($news as $item):?>
        <div class="news" id="news-<?=$i++?>">
            <div class="date"><?=\App\Helpers\DateHelper::formatToDMY($item['date'])?></div>
            <h2><?=$item['title']?></h2>
            <div class="announce">
                <?=$item['announce']?>
            </div>
            <a href="<?="/news/more/{$item['id']}"?>" class="button-more">ПОДРОБНЕЕ <i>&#8594;</i></a>
        </div>
    <?php endforeach;?>
</div>
<div class="paginate">
    <ul>
        <?php
        // Определяем начальную и конечную страницы для отображения
        $start = max(1, $currentPage - 1); // Стартовая страница
        $end = min($totalPages, $start + 2); // Конечная страница (три страницы)

        // Если находимся на последней странице или на предпоследней, корректируем начальную страницу
        if ($currentPage >= $totalPages - 1) {
            $start = max(1, $totalPages - 2);
            $end = $totalPages;
        }

        // Выводим три страницы
        for ($i = $start; $i <= $end; $i++): ?>
            <li <?= $i == $currentPage ? 'class="active"' : '' ?>><a href="/news/page/<?= $i ?>" ><?= $i ?></a></li>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <li id="next-page"><a href="/news/page/<?= $currentPage + 1 ?>">&#8594;</a></li>
        <?php endif; ?>
    </ul>
</div>
<?php $content = ob_get_clean()?>
<?php require 'layers/home.php'?>
