<?php

declare(strict_types=1);
require_once '../vendor/autoload.php';
use Database\MyPdo;
use Entity\Collection\MovieCollection;
use Html\WebPage;

$WebPage = new WebPage();
$WebPage->setTitle("Films");
MyPDO::setConfiguration('mysql:host=mysql;dbname=phil0105_movie;charset=utf8', 'phil0105', 'phpphil0105php');


$films = MovieCollection::findAll();

$WebPage->appendContent(
    <<<HTML
<div class="header"><h1>Films</h1></div>
    <div class="film">
HTML
);



foreach ($films as $film) {
    $WebPage->appendContent("\n");
    $WebPage->appendContent("<div class='poster{$film->getId()}'>");
    $id = $film->getId();
    $image = 'img/movie.png';

    $WebPage->appendContent("<img src='img/movie.png' alt='poster de film'>");
    $WebPage->appendContent("{$film->getTitle()}");
    $WebPage->appendContent("</div>");



}
$WebPage->appendContent("</div>");
echo $WebPage->toHTML();


