<?php

declare(strict_types=1);

use Entity\Cast;
use Entity\Collection\PeopleCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Movie;
use Html\WebPage;

try {
    if (!(isset($_GET['movieId']) and ctype_digit($_GET['movieId']))) {
        throw new ParameterException("L'option saisie movieId n'est pas valide");
    }
} catch (ParameterException) {
    header("HTTP/1.1 302 Found");
    header("Location: /index.php");
    exit();
}

$movieId = intval($_GET['movieId']);

try {
    $movie = Movie::findById($movieId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}

$webPage = new WebPage();
$title = $webPage->escapeString($movie->getTitle());

$webPage->setTitle($title);
$webPage->appendCssUrl("css/style_movie.css");

$webPage->appendContent(
    <<<HTML
<div class="header">
        <a href="index.php" class="home">
            <img src="img/homePage.png" alt="home">
        </a>
        <h1>Films - {$title}</h1>
        <div class="empty"></div>
    </div>
    <div class="movie">
        <div class="interact">
            <a href="admin/movie-form.php?movieId={$movieId}">Modifier</a>
            <a href="admin/movie-delete.php?movieId={$movieId}">Supprimer</a>
        </div>

HTML
);

$release = $webPage->escapeString($movie->getReleaseDate());
$origin = $webPage->escapeString($movie->getOriginalTitle());
$tagline = $webPage->escapeString($movie->getTagline());
$overview = $webPage->escapeString($movie->getOverview());

$html = <<<HTML
        <div class='movie-info'>
            <div class="poster">
                <img src="image.php?imageId={$movie->getPosterId()}&type=m" alt="poster du film">
            </div>
            <div class="movie-info-sub">
                <section class="title-date">
                    <section class="title">{$title}</section>
                    <section class="date">{$release}</section>
                </section>
                <section class="originalTitle">{$origin}</section>
                <section class="slogan">{$tagline}</section>
                <section class="resume">{$overview}</section>
            </div>
        </div>

HTML;

$webPage->appendContent($html);

$casting = PeopleCollection::findByMovieId($movieId);

foreach ($casting as $people) {
    $peopleId = $people->getId();

    $role = $webPage->escapeString(Cast::getRoleById($movieId, $peopleId));
    $name = $webPage->escapeString($people->getName());

    $html = <<<HTML
        <a href='people.php?peopleId={$peopleId}' class="people-info">
            <div class="picture">
                <img src="image.php?imageId={$people->getAvatarId()}&type=p" alt="photo de l'acteur">
            </div>
            <div class="people-info-sub">
                <section class="role">{$role}</section>
                <section class="name">{$name}</section>
            </div>
        </a>

HTML;

    $webPage->appendContent($html);
}

$html = <<<HTML
    </div>

HTML;

$webPage->appendContent($html);

$modification = WebPage::getLastModification();

$html = <<<HTML
    <div class="footer">
        <h1>Dernière Modification : {$modification}</h1>
    </div>

HTML;

$webPage->appendContent($html);

$html = $webPage->toHTML();

echo $html;
