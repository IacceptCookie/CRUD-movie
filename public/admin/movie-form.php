<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Movie;
use Html\Form\MovieForm;
use Html\WebPage;

try {
    if (!(isset($_GET['movieId']))) {
        $movie = null;
        $title = "Ajout d'un nouveau film";
    } else {
        if (!(ctype_digit($_GET['movieId']))) {
            throw new ParameterException("Parameter movieId should be an integer");
        } else {
            $movieId = intval($_GET['movieId']);
            $movie = Movie::findById($movieId);
            $title = "Modification de {$movie->getTitle()}";
        }
    }

    $webPage = new WebPage();
    $title = $webPage->escapeString($title);
    $webPage->setTitle($title);

    $webPage->appendCssUrl("../css/style_form.css");

    $webPage->appendContent(
        <<<HTML
<div class="header">
        <h1>{$title}</h1>
    </div>
    <div class="form">

HTML
    );

    $form = new MovieForm($movie);
    $html = $form->getHtmlForm("movie-save.php");

    $webPage->appendContent($html);

    $modification = WebPage::getLastModification();
    $webPage->appendContent(
        <<<HTML
</div class="form">
    <div class="footer">
        <h1>Dernière modification : {$modification}</h1>
    </div>
HTML
    );

    $html = $webPage->toHTML();

    echo $html;
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
