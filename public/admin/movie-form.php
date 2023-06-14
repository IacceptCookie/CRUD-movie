<?php

declare(strict_types=1);


use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Movie;
use Html\Form\MovieForm;

try {
    if (!(isset($_GET['movieId']))) {
        $movie = null;
    } else {
        if (!(ctype_digit($_GET['movieId']))) {
            throw new ParameterException("Parameter artistId should be an integer");
        } else {
            $movieId = intval($_GET['movieId']);
            $movie = Movie::findById($movieId);
        }
    }

    $form = new MovieForm($movie);
    $html = $form->getHtmlForm("movie-save.php");

    echo $html;
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}