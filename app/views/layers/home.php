<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title?></title>
    <link type="text/css" rel="stylesheet" href="<?=asset('css/style.css?date=28-24')?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
<div class="logo">
    <div><img src="<?=asset('img/logo.png')?>" alt=""></div>
    <div class="logo-text">Галактический вестник</div>
</div>
<div class="header">
    <div class="background">
        <div class="info">
            <img src="<?=asset('images/'. $lastNews['image'])?>" alt="<?=$lastNews['title']?>" style="width: 100%; z-index: -100">
            <h1><?=$lastNews['title']?></h1>
            <?=$lastNews['announce']?>
        </div>
    </div>
</div>
<div class="content">
    <?=$content?>
</div>
<div class="footer">
    <p>© 2023 — 2412 «Галактический вестник»</p>
</div>
</body>
</html>
