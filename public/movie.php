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

$WebPage = new WebPage();
$title = $WebPage->escapeString($movie->getTitle());

$WebPage->setTitle($title);
$WebPage->appendCssUrl("css/style_movie.css");

$WebPage->appendContent(
    <<<HTML
<div class="header">
        <a href="index.php" class="home"><img src="img/page-daccueil.png"></a>
        <h1>Films - {$title}</h1>
    </div>
    <div class="film">

HTML
);

$release = $WebPage->escapeString($movie->getReleaseDate());
$origin = $WebPage->escapeString($movie->getOriginalTitle());
$tagLine = $WebPage->escapeString($movie->getTagline());
$overview = $WebPage->escapeString($movie->getOverview());

$html = <<<HTML
        <div class='film-info'>
            <div class="poster">
                <img src="image.php?imageId={$movie->getPosterId()}&type=m" alt="poster du film">
            </div>
            <div class="film-info-sub">
                <section class="title-date">
                    <section class="title">{$title}</section>
                    <section class="date">{$release}</section>
                </section>
                <section class="originalTitle">{$origin}</section>
                <section class="slogan">{$tagLine}</section>
                <section class="resume">{$overview}</section>
            </div>
        </div>

HTML;

$WebPage->appendContent($html);

$casting = PeopleCollection::findByMovieId($movieId);

foreach ($casting as $people) {
    $peopleId = $people->getId();

    $role = $WebPage->escapeString(Cast::getRoleById($movieId, $peopleId));
    $name = $WebPage->escapeString($people->getName());

    $html = <<<HTML
        <a href='people.php?peopleId={$peopleId}' class="acteur-info">
            <div class="picture">
                <img src="image.php?imageId={$people->getAvatarId()}&type=p" alt="photo de l'acteur">
            </div>
            <div class="acteur-info-sub">
                <section class="role">{$role}</section>
                <section class="name">{$name}</section>
            </div>
        </a>

HTML;

    $WebPage->appendContent($html);
}

$html = <<<HTML
    </div>

HTML;

$WebPage->appendContent($html);

$modification = WebPage::getLastModification();

$html = <<<HTML
    <div class="footer">
        <h1>Dernière Modification : {$modification}</h1>
    </div>

HTML;

$WebPage->appendContent($html);

$html = $WebPage->toHTML();

echo $html;
