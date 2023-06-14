<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Collection\GenreCollection;
use Entity\Collection\MovieCollection;
use Entity\Genre;
use Html\WebPage;

$webPage = new WebPage();
$webPage->setTitle("Films");
$webPage->appendCssUrl("css/style_index.css");



$webPage->appendContent(
    <<<HTML
    <div class="header">
            <a href="index.php" class="home">
                <img src="img/homePage.png" alt="home">
            </a>
            <h1>Films</h1>

HTML
);

if (isset($_GET['genre']) && $_GET['genre'] !== '') {
    $genreId = (int)$_GET['genre'];
    $movies = MovieCollection::findByGenreId($genreId);
    //$genre = Genre::findById($genreId);
    //$webPage->setTitle("Films - {$genre->getName()}");
} else {
    $movies = MovieCollection::findAll();
}

$webPage->appendContent(
    <<<HTML
            <div class="filter">
                <form action="index.php" method="get">
                    <select name="genre">
                        <option value="">Tous les genres</option>

HTML
);

$genres = GenreCollection::findAll();

foreach ($genres as $genre) {
    $webPage->appendContent(
        <<<HTML
<option value='{$genre->getId()}'>{$webPage->escapeString($genre->getName())}</option>

HTML
    );
}

$webPage->appendContent(<<<HTML
                    </select>
                    <input type="submit" value="Valider">
                </form>
            </div>

HTML);

$webPage->appendContent(
    <<<HTML
        </div>
        <div class="movies">
            <div class="append">
                <a href="admin/movie-form.php">Ajouter</a>
            </div>

HTML
);


foreach ($movies as $movie) {
    $movieId = $movie->getId();
    $imageId = $movie->getPosterId();

    $title = "{$movie->getTitle()}";
    $protectedTitle =$webPage->escapeString($title);

    $html = <<<HTML
            <a href='movie.php?movieId={$movieId}' class='movie'>
                <section class="poster">
                    <img src='image.php?imageId={$imageId}&type=m' alt='poster de film'>
                </section>
                <section class="title">
                    {$protectedTitle}
                </section>
            </a>

HTML;
    $webPage->appendContent($html);
}

$modification = $webPage->getLastModification();

$html = <<<HTML
        </div>
        <div class='footer'>
            <h1>Dernière modification : {$modification}</h1>
        </div>
HTML;

$webPage->appendContent($html);

echo $webPage->toHTML();
