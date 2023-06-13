<?php

declare(strict_types=1);
require_once '../vendor/autoload.php';
use Database\MyPdo;
use Entity\Collection\MovieCollection;
use Html\WebPage;

$WebPage = new WebPage();
$WebPage->setTitle("Films");
$WebPage->appendCssUrl("css/style_index.css");



$films = MovieCollection::findAll();

$WebPage->appendContent(
    <<<HTML
<div class="header"><h1>Films</h1></div>
    <div class="film">
HTML
);



foreach ($films as $film) {
    $WebPage->appendContent("\n");
    $WebPage->appendContent("<div class='poster'>");

    $id = $film->getId();
    $image = 'img/movie.png';
    $imageId = $film->getPosterId();

    $WebPage->appendContent("<img src='image.php?imageId={$imageId}' alt='poster de film'>");
    $WebPage->appendContent("{$film->getTitle()}");
    $WebPage->appendContent("</div>");



}
$WebPage->appendContent("</div>");

$modif = $WebPage->getLastModification();
$WebPage->appendContent("<div class='footer'>");
$WebPage->appendContent("<h3>{$modif}</h3>");
$WebPage->appendContent("</div>");


echo $WebPage->toHTML();
