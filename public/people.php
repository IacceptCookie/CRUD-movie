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

$webPage = new WebPage();
$name = $webPage->escapeString($people->getName());

$webPage->setTitle($name);
$webPage->appendCssUrl("css/style_people.css");

$webPage->appendContent(
    <<<HTML
    <div class="header">
        <a href="index.php" class="home">
            <img src="img/homePage.png" alt="home">
        </a>
        <h1>Films - {$name}</h1>
        <div class="empty"></div>
    </div>
    <div class="people">

HTML
);

$place = $webPage->escapeString($people->getPlaceOfBirth());
$birthday = $webPage->escapeString($people->getBirthday());
$deathday = $webPage->escapeString($people->getDeathday());
$biography = $webPage->escapeString($people->getBiography());

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

$webPage->appendContent($html);

$filmography = MovieCollection::findByPeopleId($peopleId);

foreach ($filmography as $movie) {
    $movieId = $movie->getId();
    $titre = $webPage->escapeString($movie->getTitle());
    $date = $webPage->escapeString($movie->getReleaseDate());
    $role = $webPage->escapeString(Cast::getRoleById($movieId, $peopleId));


    $html = <<<HTML
        <a href='movie.php?movieId={$movieId}' class="movie-info">
            <div class="picture">
                <img src="image.php?imageId={$movie->getPosterId()}&type=m" alt="poster du film">
            </div>
            <div class="movie-info-sub">
                <section class="title-date">
                    <section class="title">{$titre}</section>
                    <section class="date">{$date}</section>
                </section>
                <section class="role">{$role}</section>
            </div>
        </a>

HTML;
    $webPage->appendContent($html);

}

$modification = WebPage::getLastModification();

$html = <<<HTML
    </div>
    <div class="footer">
        <h1>Dernière Modification : {$modification}</h1>
    </div>
HTML;
$webPage->appendContent($html);


$html = $webPage->toHTML();

echo $html;
