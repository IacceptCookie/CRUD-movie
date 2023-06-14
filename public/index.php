<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Collection\GenreCollection;
use Entity\Collection\MovieCollection;
use Entity\Genre;
use Html\WebPage;

$WebPage = new WebPage();
$WebPage->setTitle("Films");
$WebPage->appendCssUrl("css/style_index.css");



$WebPage->appendContent(
    <<<HTML
    <div class="header">
            <a href="index.php" class="home"><img src="img/page-daccueil.png"></a>
            <h1>Films</h1>
        
       

HTML
);

if (isset($_GET['genre']) && $_GET['genre'] !== '') {
    $genreId = (int)$_GET['genre'];
    $films = MovieCollection::findByGenreId($genreId);

    //$title = " - {$genre->getName()}";
}
else {
    $films = MovieCollection::findAll();
    $title = '';
}

$WebPage->appendContent(
    <<<HTML
    <div class="filter">
        <form action="index.php" method="get">
            <select name="genre">
                <option value="">Tous les genres</option>
HTML
);

$genres = GenreCollection::findAll();

foreach ($genres as $genre) {
    $WebPage->appendContent("<option value='{$genre->getId()}'>{$WebPage->escapeString($genre->getName())}</option>");
}

$WebPage->appendContent(<<<HTML
            </select>
            <input type="submit" value="Valider">
        </form>
    </div>
    </div>
    <div class="films">

HTML);


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
