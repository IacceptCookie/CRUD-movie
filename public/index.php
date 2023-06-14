<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Collection\MovieCollection;
use Html\WebPage;

$WebPage = new WebPage();
$WebPage->setTitle("Films");
$WebPage->appendCssUrl("css/style_index.css");


$films = MovieCollection::findAll();

$WebPage->appendContent(
    <<<HTML
    <div class="header">
            <a href="index.php" class="home"><img src="img/page-daccueil.png"></a>
            <h1>Films</h1>
        </div>
        <div class="films">

HTML
);



foreach ($films as $film) {
    $id = $film->getId();
    $imageId = $film->getPosterId();

    $titre = "{$film->getTitle()}";
    $protectTitle =$WebPage->escapeString($titre);

    $html = <<<HTML
            <a href='movie.php?movieId={$id}' class='film'>
                <section class="poster">
                    <img src='image.php?imageId={$imageId}&type=m' alt='poster de film'>
                </section>
                <section class="title">
                    {$protectTitle}
                </section>
            </a>

HTML;
    $WebPage->appendContent($html);
}

$modification = $WebPage->getLastModification();

$html = <<<HTML
        </div>
        <div class='footer'>
            <h1>Dernière modification : {$modification}</h1>
        </div>
HTML;

$WebPage->appendContent($html);

echo $WebPage->toHTML();
