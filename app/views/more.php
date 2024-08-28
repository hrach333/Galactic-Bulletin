<?php ob_start()?>
<div class="breadcrumbs">Главная / <?=$titleForNews?></div>
<h1><?=$titleForNews?></h1>
<div class="container">
        <div class="news-horizontal">
            <div class="row">
            <div>
                <div class="date"><?=\App\Helpers\DateHelper::formatToDMY($date)?></div>
                <h2 class="announce"><?=$announce?></h2>
                <div class="news-text"><?=$content?></div>
            </div>
            <img src="<?=asset('images/'.$image)?>">
            </div>
        </div>

    <a href="/" class="button-home" style="margin-bottom: 15px"><i>&#8592;</i> НАЗАД К НОВОСТЯМ </a>
</div>

<?php $content = ob_get_clean()?>
<?php require 'layers/home.php'?>
