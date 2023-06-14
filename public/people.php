<?php

declare(strict_types=1);

use Entity\Cast;
use Entity\Collection\MovieCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\People;
use Html\WebPage;

try {
    if (!(isset($_GET['peopleId']) and ctype_digit($_GET['peopleId']))) {
        throw new ParameterException("L'option saisie peopleId n'est pas valide");
    }
} catch (ParameterException) {
    header("HTTP/1.1 302 Found");
    header("Location: /index.php");
    exit();
}

$peopleId = intval($_GET['peopleId']);

try {
    $people = People::findById($peopleId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}

$WebPage = new WebPage();
$name = $WebPage->escapeString($people->getName());

$WebPage->setTitle($name);
$WebPage->appendCssUrl("css/style_people.css");

$WebPage->appendContent(
    <<<HTML
    <div class="header">
        <a href="index.php" class="home">
            <img src="img/page-daccueil.png" alt="home">
        </a>
        <h1>Films - {$name}</h1>
        <div class="empty"></div>
    </div>
    <div class="personne">

HTML
);

$place = $WebPage->escapeString($people->getPlaceOfBirth());
$birthday = $WebPage->escapeString($people->getBirthday());
$deathday = $WebPage->escapeString($people->getDeathday());
$biography = $WebPage->escapeString($people->getBiography());

$html = <<<HTML
        <div class='people-info'>
            <div class="avatar">
                <img src="image.php?imageId={$people->getAvatarId()}&type=p" alt="Avatar de l'acteur">
            </div>
            <div class="people-info-sub">
                <section class="name">
                    {$name}
                </section>
                <section class="place">
                    {$place}
                </section>
                <section class="birthday-deathday">
                    <section class="birthday">
                        {$birthday}
                    </section>
                    <section class="deathday">
                        {$deathday}
                    </section>
                </section>
                <section class="biography">
                    {$biography}
                </section>
            </div>
        </div>

HTML;

$WebPage->appendContent($html);

$apparitions = MovieCollection::findByPeopleId($peopleId);

foreach ($apparitions as $movie) {
    $movieId = $movie->getId();
    $titre = $WebPage->escapeString($movie->getTitle());
    $date = $WebPage->escapeString($movie->getReleaseDate());
    $role = $WebPage->escapeString(Cast::getRoleById($movieId, $peopleId));


    $html = <<<HTML
        <a href='movie.php?movieId={$movieId}' class="film-info">
            <div class="picture">
                <img src="image.php?imageId={$movie->getPosterId()}&type=m" alt="poster du film">
            </div>
            <div class="film-info-sub">
                <section class="title-date">
                    <section class="title">{$titre}</section>
                    <section class="date">{$date}</section>
                </section>
                <section class="role">{$role}</section>
            </div>
        </a>

HTML;
    $WebPage->appendContent($html);

}

$modification = WebPage::getLastModification();

$html = <<<HTML
    </div>
    <div class="footer">
        <h1>Dernière Modification : {$modification}</h1>
    </div>
HTML;
$WebPage->appendContent($html);


$html = $WebPage->toHTML();
echo($html);